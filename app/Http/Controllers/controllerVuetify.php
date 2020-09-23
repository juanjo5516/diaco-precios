<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\designTemplate;
use Illuminate\Support\Facades\DB;
use App\Transformers\dataTable;
use Carbon\Carbon;
use App\Models\vaciadocba;
use League\Fractal;
use Illuminate\Support\Collection;
use App\Transformers\reportTransformer;

class controllerVuetify extends Controller
{
    public function reportDesign(){
        return view('vuetify.report.design');
    }

    public function getDepartament(){
        $departament = Departamento::all();
        return response()->json($departament,200);
    }

    public function design_template(){
        return view('vuetify.report.index');
    }

    public function addDesignTemplate(Request $request){
      

        try {
            DB::beginTransaction();
            $TIMESTAMP = Carbon::now();
            $valor = sizeof($request->Dproducto);

            for ($i=0; $i < $valor; $i++) {

                $design = new designTemplate;

                $design->idProducto = $request->Dproducto[$i]['codeProducto'];
                $design->idTipoVerificacion  = $request->type;
                $design->idCategoria  = $request->category;
                $design->idMedida  = $request->Dproducto[$i]['codeMedida'];
                $design->created_at = $TIMESTAMP;
                $design->save();

            }
            DB::commit();
            return response()->json('success', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
        
    }

    public function movile_app(){
        $departments = DB::SELECT('exec VerifyActiveDepartments');
        $coordenadas = DB::SELECT('EXEC department_coordinates');
        $coordenadas = collect($coordenadas);

        
        foreach ($coordenadas as $sedes_producto) {
            $data = DB::SELECT('exec sp_productos_cba :sede',['sede' => $sedes_producto->code]);
            $nivel3[] = [
                "code"          =>  $sedes_producto->code,
                "name"          =>  $sedes_producto->name,
                'latitude'      =>  $sedes_producto->latitut,
                'longitude'     =>  $sedes_producto->longitud,
                'departamento'  =>  $sedes_producto->codigo_departamento,
                "categories"    =>  $data
            ];
        }

        
        $branchData = collect($nivel3);
        

        foreach ($departments as $union) {
            $data = $branchData->where('departamento','=',$union->code);
            $response[] = [
                "code"      =>  $union->code,
                "name"      =>  $union->name,
                "sedes"     =>  $data
            ]; 
        }
       
        return fractal()
            ->collection($response)
            ->transformWith(new DataDepartamento()) 
            ->includeCharacters()
            ->toArray();
        
    }

    function array_unique2($a)
    {
        $n = array();
        foreach ($a as $k=>$v) if (!in_array($v,$n))$n[$k]=$v;
        return $n;
    }


    public function getReportData(Request $request){
        if($request->db == "Actual"){
            if($request->departament == "" && $request->municipio == "" && $request->type == "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == ""){
                $response = DB::select("SELECT 
                dmcba.nombreMercado as mercado,
                dpcba.nombre AS producto,
                dm.nombre AS medida, 
                CONCAT('Q ',CONVERT(decimal(18,2),avg(dvcba.precioProducto))) as precio
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    GROUP BY dmcba.nombreMercado, dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre");

                $filter = DB::select("SELECT distinct
                dmcba.nombreMercado as mercado
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
            
                ");
                
                $filter_name = array();
                $branchData = collect($response);
                foreach ($filter as $row) {
                    $data = $branchData->where('mercado','=', $row->mercado);
                                array_push($filter_name,[
                                    'name' =>$row->mercado,
                                    'items' => $data
                                ]);
                }
                
                $uom = fractal()->collection($filter_name)->transformWith(new reportTransformer())->includeCharacters()->toJson();
                return $uom;
            }else if($request->departament != "" && $request->municipio == "" && $request->type == "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == "" ){

                $response = DB::select("SELECT 
                dmcba.nombreMercado as mercado,
                dpcba.nombre AS producto,
                dm.nombre AS medida, 
                CONCAT('Q ',CONVERT(decimal(18,2),avg(dvcba.precioProducto))) as precio
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dmcba.departamento_id = '".$request->departament."'
                    GROUP BY dmcba.nombreMercado, dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre
                ");

                $filter = DB::select("SELECT distinct
                dmcba.nombreMercado as mercado
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dmcba.departamento_id = '".$request->departament."'

                ");

                $filter_name = array();
                $branchData = collect($response);
                foreach ($filter as $row) {
                    $data = $branchData->where('mercado','=', $row->mercado);
                                array_push($filter_name,[
                                    'name' =>$row->mercado,
                                    'items' => $data
                                ]);
                }

                $uom = fractal()->collection($filter_name)->transformWith(new reportTransformer())->includeCharacters()->toJson();
                return $uom;
            }else if($request->departament != "" && $request->municipio != "" && $request->type == "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == "" ){
                $response = DB::select("SELECT 
                dmcba.nombreMercado as mercado,
                dpcba.nombre AS producto,
                dm.nombre AS medida, 
                CONCAT('Q ',CONVERT(decimal(18,2),avg(dvcba.precioProducto))) as precio
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dmcba.departamento_id = '".$request->departament."' and dmcba.municipio_id = '".$request->municipio."'
                    GROUP BY dmcba.nombreMercado, dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre
                ");


                $filter = DB::select("SELECT distinct
                dmcba.nombreMercado as mercado
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dmcba.departamento_id = '".$request->departament."' and dmcba.municipio_id = '".$request->municipio."'

                ");

                $filter_name = array();
                $branchData = collect($response);
                foreach ($filter as $row) {
                    $data = $branchData->where('mercado','=', $row->mercado);
                                array_push($filter_name,[
                                    'name' =>$row->mercado,
                                    'items' => $data
                                ]);
                }

                $uom = fractal()->collection($filter_name)->transformWith(new reportTransformer())->includeCharacters()->toJson();
                return $uom;

            }else if($request->departament != "" && $request->municipio != "" && $request->type != "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == "" ){

                $response = DB::select("SELECT 
                dmcba.nombreMercado as mercado,
                dpcba.nombre AS producto,
                dm.nombre AS medida, 
                CONCAT('Q ',CONVERT(decimal(18,2),avg(dvcba.precioProducto))) as precio
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dmcba.departamento_id = '".$request->departament."' and dmcba.municipio_id = '".$request->municipio."' and dvcba.tipoVerificacion = '".$request->type."'
                    GROUP BY dmcba.nombreMercado, dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre
                ");
                

                $filter = DB::select("SELECT distinct
                dmcba.nombreMercado as mercado
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dmcba.departamento_id = '".$request->departament."' and dmcba.municipio_id = '".$request->municipio."' and dvcba.tipoVerificacion = '".$request->type."'

                ");

                $filter_name = array();
                $branchData = collect($response);
                foreach ($filter as $row) {
                    $data = $branchData->where('mercado','=', $row->mercado);
                                array_push($filter_name,[
                                    'name' =>$row->mercado,
                                    'items' => $data
                                ]);
                }

                $uom = fractal()->collection($filter_name)->transformWith(new reportTransformer())->includeCharacters()->toJson();
                return $uom;
            }else if($request->departament != "" && $request->municipio != "" && $request->type != "" && $request->category != "" && $request->fInitial == "" && $request->fFinal == "" ){

                $response = DB::select("SELECT 
                dmcba.nombreMercado as mercado,
                dpcba.nombre AS producto,
                dm.nombre AS medida, 
                CONCAT('Q ',CONVERT(decimal(18,2),avg(dvcba.precioProducto))) as precio
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dmcba.departamento_id = '".$request->departament."' and dmcba.municipio_id = '".$request->municipio."' and dvcba.tipoVerificacion = '".$request->type."' and
                    dapc.idCategoria = '".$request->category."'
                    GROUP BY dmcba.nombreMercado, dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre
                ");
                
                $filter = DB::select("SELECT distinct
                dmcba.nombreMercado as mercado
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dmcba.departamento_id = '".$request->departament."' and dmcba.municipio_id = '".$request->municipio."' and dvcba.tipoVerificacion = '".$request->type."' and
                    dapc.idCategoria = '".$request->category."'

                ");

                $filter_name = array();
                $branchData = collect($response);
                foreach ($filter as $row) {
                    $data = $branchData->where('mercado','=', $row->mercado);
                                array_push($filter_name,[
                                    'name' =>$row->mercado,
                                    'items' => $data
                                ]);
                }

                $uom = fractal()->collection($filter_name)->transformWith(new reportTransformer())->includeCharacters()->toJson();
                return $uom;
            }else if($request->departament != "" && $request->municipio != "" && $request->type != "" && $request->category != "" && $request->fInitial != "" && $request->fFinal != "" ){

                $response = DB::select("SELECT 
                dmcba.nombreMercado as mercado,
                dpcba.nombre AS producto,
                dm.nombre AS medida, 
                CONCAT('Q ',CONVERT(decimal(18,2),avg(dvcba.precioProducto))) as precio
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dmcba.departamento_id = '".$request->departament."' and dmcba.municipio_id = '".$request->municipio."' and dvcba.tipoVerificacion = '".$request->type."' and
                    dapc.idCategoria = '".$request->category."' and  convert(varchar,dvcba.created_at,5) BETWEEN '".$request->fInitial."' AND '".$request->fFinal."'
                    GROUP BY dmcba.nombreMercado, dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre
                ");
                
                
                $filter = DB::select("SELECT distinct
                dmcba.nombreMercado as mercado
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dmcba.departamento_id = '".$request->departament."' and dmcba.municipio_id = '".$request->municipio."' and dvcba.tipoVerificacion = '".$request->type."' and
                    dapc.idCategoria = '".$request->category."' and  convert(varchar,dvcba.created_at,5) BETWEEN '".$request->fInitial."' AND '".$request->fFinal."'

                ");

                $filter_name = array();
                $branchData = collect($response);
                foreach ($filter as $row) {
                    $data = $branchData->where('mercado','=', $row->mercado);
                                array_push($filter_name,[
                                    'name' =>$row->mercado,
                                    'items' => $data
                                ]);
                }

                $uom = fractal()->collection($filter_name)->transformWith(new reportTransformer())->includeCharacters()->toJson();
                return $uom;
            }
        }
        if ($request->db == "Anterior") {
            if($request->departament == "" && $request->municipio == "" && $request->type == "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == ""){
                
                $response = DB::select("SELECT 
                                dmcba.nombreMercado AS mercado,
                                dpcba.nombre AS producto,
                                dm.nombre AS medida, 
                                CONCAT('Q ',CONVERT(decimal(18,2),avg(dapc.precioProducto))) as precio
                                FROM diaco_vaciadocba dapc
                                    INNER JOIN diaco_asignarsedecba dast
                                        ON dast.correlativo = dapc.Ncorrelativo
                                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                                    INNER JOIN diaco_mercadocba dmcba ON dapc.idLugarVisita = dmcba.idMercado
                                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida   
                                    GROUP BY dmcba.nombreMercado, dpcba.nombre, dm.nombre
                                    ");

                $filter = DB::select("SELECT DISTINCT
                dmcba.nombreMercado AS mercado
                FROM diaco_vaciadocba dapc
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dapc.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dapc.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida   
                    GROUP BY dmcba.nombreMercado, dpcba.nombre, dm.nombre

                ");

                $filter_name = array();
                $branchData = collect($response);
                foreach ($filter as $row) {
                    $data = $branchData->where('mercado','=', $row->mercado);
                                array_push($filter_name,[
                                    'name' =>$row->mercado,
                                    'items' => $data
                                ]);
                }

                $uom = fractal()->collection($filter_name)->transformWith(new reportTransformer())->includeCharacters()->toJson();
                return $uom;

            }else if($request->departament != "" && $request->municipio == "" && $request->type == "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == ""){

                $response = DB::select("SELECT 
                                dmcba.nombreMercado AS mercado,
                                dpcba.nombre AS producto,
                                dm.nombre AS medida, 
                                CONCAT('Q ',CONVERT(decimal(18,2),avg(dapc.precioProducto))) as precio
                                FROM diaco_vaciadocba dapc
                                    INNER JOIN diaco_asignarsedecba dast
                                        ON dast.correlativo = dapc.Ncorrelativo
                                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                                    INNER JOIN diaco_mercadocba dmcba ON dapc.idLugarVisita = dmcba.idMercado
                                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida  
                                    WHERE dmcba.departamento_id = '".$request->departament."' 
                                    GROUP BY dmcba.nombreMercado, dpcba.nombre, dm.nombre
                                    ");

                $filter = DB::select("SELECT DISTINCT
                dmcba.nombreMercado AS mercado
                FROM diaco_vaciadocba dapc
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dapc.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dapc.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida   
                    WHERE dmcba.departamento_id = '".$request->departament."'
                    GROUP BY dmcba.nombreMercado, dpcba.nombre, dm.nombre

                ");

                $filter_name = array();
                $branchData = collect($response);
                foreach ($filter as $row) {
                    $data = $branchData->where('mercado','=', $row->mercado);
                                array_push($filter_name,[
                                    'name' =>$row->mercado,
                                    'items' => $data
                                ]);
                }

                // $uom = fractal()->collection($filter_name)->transformWith(new reportTransformer())->includeCharacters()->toJson();
                $uom = fractal()->collection($filter_name)->transformWith(new reportTransformer())->includeCharacters()->toArray();
                // return $uom;
                return response()->json($uom,200);

                
            }else if($request->departament != "" && $request->municipio != "" && $request->type == "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == "" ){

                $response = DB::select("SELECT 
                                dmcba.nombreMercado AS mercado,
                                dpcba.nombre AS producto,
                                dm.nombre AS medida, 
                                CONCAT('Q ',CONVERT(decimal(18,2),avg(dapc.precioProducto))) as precio
                                FROM diaco_vaciadocba dapc
                                    INNER JOIN diaco_asignarsedecba dast
                                        ON dast.correlativo = dapc.Ncorrelativo
                                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                                    INNER JOIN diaco_mercadocba dmcba ON dapc.idLugarVisita = dmcba.idMercado
                                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida  
                                    WHERE dmcba.departamento_id = '".$request->departament."'  and dmcba.municipio_id = '".$request->municipio."'
                                    GROUP BY dmcba.nombreMercado, dpcba.nombre, dm.nombre
                                    ");

                $filter = DB::select("SELECT DISTINCT
                dmcba.nombreMercado AS mercado
                FROM diaco_vaciadocba dapc
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dapc.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dapc.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida   
                    WHERE dmcba.departamento_id = '".$request->departament."' and dmcba.municipio_id = '".$request->municipio."'
                    GROUP BY dmcba.nombreMercado, dpcba.nombre, dm.nombre

                ");

                $filter_name = array();
                $branchData = collect($response);
                foreach ($filter as $row) {
                    $data = $branchData->where('mercado','=', $row->mercado);
                                array_push($filter_name,[
                                    'name' =>$row->mercado,
                                    'items' => $data
                                ]);
                }

                $uom = fractal()->collection($filter_name)->transformWith(new reportTransformer())->includeCharacters()->toJson();
                return $uom;

                

            }else if($request->departament != "" && $request->municipio != "" && $request->type != "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == ""){
                $response = DB::select("SELECT 
                                dmcba.nombreMercado AS mercado,
                                dpcba.nombre AS producto,
                                dm.nombre AS medida, 
                                CONCAT('Q ',CONVERT(decimal(18,2),avg(dapc.precioProducto))) as precio
                                FROM diaco_vaciadocba dapc
                                    INNER JOIN diaco_asignarsedecba dast
                                        ON dast.correlativo = dapc.Ncorrelativo
                                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                                    INNER JOIN diaco_mercadocba dmcba ON dapc.idLugarVisita = dmcba.idMercado
                                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida  
                                    WHERE dmcba.departamento_id = '".$request->departament."'  and dmcba.municipio_id = '".$request->municipio."'  and dapc.tipoVerificacion = '".$request->type."'
                                    GROUP BY dmcba.nombreMercado, dpcba.nombre, dm.nombre
                                    ");

                $filter = DB::select("SELECT DISTINCT
                dmcba.nombreMercado AS mercado
                FROM diaco_vaciadocba dapc
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dapc.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dapc.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida   
                    WHERE dmcba.departamento_id = '".$request->departament."' and dmcba.municipio_id = '".$request->municipio."'  and dapc.tipoVerificacion = '".$request->type."'
                    GROUP BY dmcba.nombreMercado, dpcba.nombre, dm.nombre

                ");

                $filter_name = array();
                $branchData = collect($response);
                foreach ($filter as $row) {
                    $data = $branchData->where('mercado','=', $row->mercado);
                                array_push($filter_name,[
                                    'name' =>$row->mercado,
                                    'items' => $data
                                ]);
                }

                $uom = fractal()->collection($filter_name)->transformWith(new reportTransformer())->includeCharacters()->toJson();
                return $uom;
            }
        }
    }

    public function getNameLocal(Request $request){ 

        if ($request->db == "Actual") {
            if($request->departament == "" && $request->municipio == "" && $request->type == "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == ""){
                
                $response = DB::select("SELECT DISTINCT
                        dm.nombreMercado from diaco_vaciadocba dv
                        INNER JOIN diaco_mercadocba dm ON dv.idLugarVisita = dm.idMercado
                ");

                return response()->json($response,200);

            }else if($request->departament != "" && $request->municipio == "" && $request->type == "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == "" ){

                $response = DB::select("SELECT DISTINCT  dm.nombreMercado FROM diaco_vaciadocba dv
                INNER JOIN diaco_mercadocba dm ON dv.idLugarVisita = dm.idMercado
                WHERE dm.departamento_id = '".$request->departament."'");

                return response()->json($response,200);

            }else if($request->departament != "" && $request->municipio != "" && $request->type == "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == ""){

                $response = DB::select("SELECT DISTINCT  dm.nombreMercado FROM diaco_vaciadocba dv
                INNER JOIN diaco_mercadocba dm ON dv.idLugarVisita = dm.idMercado
                WHERE dm.departamento_id = '".$request->departament."' and  dm.municipio_id = '".$request->municipio."'");
                return response()->json($response,200);

            }else if($request->departament != "" && $request->municipio != "" && $request->type != "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == ""){
                $response = DB::select("SELECT DISTINCT  dm.nombreMercado FROM diaco_vaciadocba dv
                INNER JOIN diaco_mercadocba dm ON dv.idLugarVisita = dm.idMercado
                WHERE dm.municipio_id = '".$request->municipio."' and dm.departamento_id = '".$request->departament."' and dv.tipoVerificacion = '".$request->type."'");
                return response()->json($response,200);
            }else if($request->departament != "" && $request->municipio != "" && $request->type != "" && $request->category != "" && $request->fInitial == "" && $request->fFinal == ""){

                $response = DB::select("SELECT DISTINCT dm.nombreMercado FROM diaco_asignar_productos_categoria dap
                INNER JOIN diaco_vaciadocba dv ON dap.idProducto = dv.idProducto AND dap.idMedida = dv.idMedida AND dap.idTipoVerificacion = dv.tipoVerificacion
                INNER JOIN diaco_mercadocba dm ON dv.idLugarVisita = dm.idMercado
                WHERE dm.departamento_id = '".$request->departament."' AND dm.municipio_id = '".$request->municipio."' AND dap.idTipoVerificacion = '".$request->type."' AND dap.idCategoria = '".$request->category."'");

                return response()->json($response,200);
            }else if($request->departament != "" && $request->municipio != "" && $request->type != "" && $request->category != "" && $request->fInitial != "" && $request->fFinal != ""){

                $response = DB::select("SELECT DISTINCT dm.nombreMercado FROM diaco_asignar_productos_categoria dap
                INNER JOIN diaco_vaciadocba dv ON dap.idProducto = dv.idProducto AND dap.idMedida = dv.idMedida AND dap.idTipoVerificacion = dv.tipoVerificacion
                INNER JOIN diaco_mercadocba dm ON dv.idLugarVisita = dm.idMercado
                WHERE dm.departamento_id = '".$request->departament."' AND dm.municipio_id = '".$request->municipio."' AND dap.idTipoVerificacion = '".$request->type."' AND dap.idCategoria = '".$request->category."' and
                convert(varchar,dv.created_at,5) BETWEEN '".$request->fInitial."' AND '".$request->fFinal."'");

                return response()->json($response,200);
            }
        }

        if($request->db == "Anterior"){
            if($request->departament == "" && $request->municipio == "" && $request->type == ""){
                
                $response = DB::select("SELECT DISTINCT
                        dm.nombreMercado from diaco_vaciadocba dv
                        INNER JOIN diaco_mercadocba dm ON dv.idLugarVisita = dm.idMercado
                ");

                return response()->json($response,200);

            }else if($request->departament != "" && $request->municipio == "" && $request->type == ""){

                $response = DB::select("SELECT DISTINCT  dm.nombreMercado FROM diaco_vaciadocba dv
                INNER JOIN diaco_mercadocba dm ON dv.idLugarVisita = dm.idMercado
                WHERE dm.departamento_id = '".$request->departament."'");

                return response()->json($response,200);

            }else if($request->departament != "" && $request->municipio != "" && $request->type == ""){

                $response = DB::select("SELECT DISTINCT  dm.nombreMercado FROM diaco_vaciadocba dv
                INNER JOIN diaco_mercadocba dm ON dv.idLugarVisita = dm.idMercado
                WHERE dm.departamento_id = '".$request->departament."' and  dm.municipio_id = '".$request->municipio."'");
                return response()->json($response,200);

            }else if($request->departament != "" && $request->municipio != "" && $request->type != ""){
                $response = DB::select("SELECT DISTINCT  dm.nombreMercado FROM diaco_vaciadocba dv
                INNER JOIN diaco_mercadocba dm ON dv.idLugarVisita = dm.idMercado
                WHERE dm.municipio_id = '".$request->municipio."' and dm.departamento_id = '".$request->departament."' and dv.tipoVerificacion = '".$request->type."'");
                return response()->json($response,200);
            }
        }
        
        // else{
        //     $response = DB::select("SELECT DISTINCT  dm.nombreMercado FROM diaco_vaciadocba dv
        //     INNER JOIN diaco_mercadocba dm ON dv.idLugarVisita = dm.idMercado
        //     WHERE dm.departamento_id = '".$request->departament."' AND dm.municipio_id = '".$request->municipio."'");
        //     return response()->json($response,200);
        // }
        
        // else{
        //     $res = DB::select("SELECT distinct
        //     dmcba.nombreMercado
        //     FROM diaco_asignar_productos_categoria dapc
        //         INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
        //         dapc.idMedida = dvcba.idMedida AND
        //         dapc.idCategoria = dvcba.id_Categoria AND
        //         dapc.idTipoVerificacion = dvcba.tipoVerificacion
        //         INNER JOIN diaco_asignarsedecba dast
        //             ON dast.correlativo = dvcba.Ncorrelativo
        //         INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
        //         INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
        //         INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
        //         INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
        //         INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
        //         INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
        //         INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
        //         WHERE dapc.idTipoVerificacion = '".$request->type."' AND dapc.idCategoria = '".$request->category."' AND  dep.codigo_departamento = '".$request->departament."' and muni.codigo_municipio = '".$request->municipio."' AND 
        //             convert(varchar,dvcba.created_at,5) BETWEEN '".$request->fInitial."' AND '".$request->fFinal."'
        //         GROUP BY dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre");
    
        //         return response()->json($res,200);
        // }
    }


    public function getFilter(Request $request){

        if ($request->db == "Actual") {
            if($request->filter != "" && $request->type == "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == ""){
                $data = DB::select("SELECT 
                dpcba.nombre AS producto,
                dm.nombre AS medida, 
                CONCAT('Q ',CONVERT(decimal(18,2),avg(dvcba.precioProducto))) as precio
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE
                    dmcba.nombreMercado = '".$request->filter."'   
                    GROUP BY dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre");

                    return response()->json($data,200);
                    // return response()->json('1',200);
            }else if($request->type != "" && $request->filter != "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == ""){
                $data = DB::select("SELECT 
                dpcba.nombre AS producto,
                dm.nombre AS medida, 
                CONCAT('Q ',CONVERT(decimal(18,2),avg(dvcba.precioProducto))) as precio
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dapc.idTipoVerificacion = '".$request->type."' and dmcba.nombreMercado = '".$request->filter."'   
                    GROUP BY dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre");

                return response()->json($data,200);
            }else if ($request->type != "" && $request->filter != "" && $request->category != "" && $request->fInitial == "" && $request->fFinal == ""){

                $data = DB::select("SELECT 
                dpcba.nombre AS producto,
                dm.nombre AS medida, 
                CONCAT('Q ',CONVERT(decimal(18,2),avg(dvcba.precioProducto))) as precio
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dapc.idTipoVerificacion = '".$request->type."' AND dapc.idCategoria = '".$request->category."' AND dmcba.nombreMercado = '".$request->filter."'   
                    GROUP BY dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre");
                    
                    return response()->json($data,200);
            }else if ($request->type != "" && $request->filter != "" && $request->category != "" && $request->fInitial != "" && $request->fFinal != ""){

                $data = DB::select("SELECT 
                dpcba.nombre AS producto,
                dm.nombre AS medida, 
                CONCAT('Q ',CONVERT(decimal(18,2),avg(dvcba.precioProducto))) as precio
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dapc.idTipoVerificacion = '".$request->type."' AND dapc.idCategoria = '".$request->category."' AND dmcba.nombreMercado = '".$request->filter."' and
                    convert(varchar,dvcba.created_at,5) BETWEEN '".$request->fInitial."' AND '".$request->fFinal."'  
                    GROUP BY dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre");
                    
                    return response()->json($data,200);
            }
        }
        if ($request->db == "Anterior") {
            if($request->filter != "" && $request->type == "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == ""){
                $data = DB::select("SELECT 
                    dpcba.nombre AS producto,
                    dm.nombre AS medida, 
                    CONCAT('Q ',CONVERT(decimal(18,2),avg(dapc.precioProducto))) as precio
                    FROM diaco_vaciadocba dapc
                        INNER JOIN diaco_asignarsedecba dast
                            ON dast.correlativo = dapc.Ncorrelativo
                        INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                        INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                        INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                        INNER JOIN diaco_mercadocba dmcba ON dapc.idLugarVisita = dmcba.idMercado
                        INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                        INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                        WHERE
                        dmcba.nombreMercado = '".$request->filter."'     
                        GROUP BY dpcba.nombre, dm.nombre");

                    return response()->json($data,200);
                    // return response()->json('1',200);
            }else if($request->type != "" && $request->filter != "" && $request->category == "" && $request->fInitial == "" && $request->fFinal == ""){
                $data = DB::select("SELECT 
                        dpcba.nombre AS producto,
                        dm.nombre AS medida, 
                        CONCAT('Q ',CONVERT(decimal(18,2),avg(dapc.precioProducto))) as precio
                        FROM diaco_vaciadocba dapc
                            INNER JOIN diaco_asignarsedecba dast
                                ON dast.correlativo = dapc.Ncorrelativo
                            INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                            INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                            INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                            INNER JOIN diaco_mercadocba dmcba ON dapc.idLugarVisita = dmcba.idMercado
                            INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                            INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                            WHERE
                            dmcba.nombreMercado = '".$request->filter."' AND dapc.tipoVerificacion = '".$request->type."'
                            GROUP BY dpcba.nombre, dm.nombre");

                return response()->json($data,200);
            }
            else if ($request->type != "" && $request->filter != "" && $request->category != "" && $request->fInitial != "" && $request->fFinal != ""){

                $data = DB::select("SELECT 
                            dpcba.nombre AS producto,
                            dm.nombre AS medida, 
                            CONCAT('Q ',CONVERT(decimal(18,2),avg(dapc.precioProducto))) as precio
                            FROM diaco_vaciadocba dapc
                                INNER JOIN diaco_asignarsedecba dast
                                    ON dast.correlativo = dapc.Ncorrelativo
                                INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                                INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                                INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                                INNER JOIN diaco_mercadocba dmcba ON dapc.idLugarVisita = dmcba.idMercado
                                INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                                INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                                WHERE
                                dmcba.nombreMercado = '".$request->filter."' AND dapc.tipoVerificacion = '".$request->type."' and
                                convert(varchar,dapc.created_at,5) BETWEEN '".$request->fInitial."' AND '".$request->fFinal."' 
                                GROUP BY dpcba.nombre, dm.nombre
                                ");
                    
                    return response()->json($data,200);
            }
        }






        // $data = DB::select("SELECT 
        // dpcba.nombre AS producto,
        // dm.nombre AS medida, 
        // CONCAT('Q ',CONVERT(decimal(18,2),max(dvcba.precioProducto))) as precio
        // FROM diaco_asignar_productos_categoria dapc
        //     INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
        //     dapc.idMedida = dvcba.idMedida AND
        //     dapc.idCategoria = dvcba.id_Categoria AND
        //     dapc.idTipoVerificacion = dvcba.tipoVerificacion
        //     INNER JOIN diaco_asignarsedecba dast
        //         ON dast.correlativo = dvcba.Ncorrelativo
        //     INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
        //     INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
        //     INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
        //     INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
        //     INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
        //     INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
        //     INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
        //     WHERE dapc.idTipoVerificacion = '".$request->type."' AND dapc.idCategoria = '".$request->category."' AND  dep.codigo_departamento = '".$request->departament."' and muni.codigo_municipio = '".$request->municipio."' AND
        //       dmcba.nombreMercado = '".$request->filter."' AND  
        //         convert(varchar,dvcba.created_at,5) BETWEEN '".$request->fInitial."' AND '".$request->fFinal."'
        //     GROUP BY dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre");

            
        // return response()->json($data,200);
    }
    public function show_table(Request $request){
        
        // if(
        //     $request->departament !== "todos" || 
        //     $request->municipio !== "todos" || 
        //     $request->type !== "todos"|| 
        //     $request->category !== "todos" ||
        //     $request->fInitial !== "todos" ||
        //     $request->fFinal !== "todos" )
        // {
            $query_all = DB::select("SELECT 
                dmcba.nombreMercado,
                dpcba.nombre as producto,
                dm.nombre as medida, 
                CONCAT('Q ',CONVERT(decimal(18,2),max(dvcba.precioProducto))) as precio
                FROM diaco_asignar_productos_categoria dapc
                    INNER JOIN diaco_vaciadocba dvcba ON dapc.idProducto = dvcba.idProducto AND 
                    dapc.idMedida = dvcba.idMedida AND
                    dapc.idCategoria = dvcba.id_Categoria AND
                    dapc.idTipoVerificacion = dvcba.tipoVerificacion
                    INNER JOIN diaco_asignarsedecba dast
                        ON dast.correlativo = dvcba.Ncorrelativo
                    INNER JOIN diaco_sede ds ON dast.idSede = ds.id_diaco_sede
                    INNER JOIN municipio muni ON ds.codigo_municipio = muni.codigo_municipio
                    INNER JOIN departamento dep ON muni.codigo_departamento = dep.codigo_departamento
                    INNER JOIN diaco_mercadocba dmcba ON dvcba.idLugarVisita = dmcba.idMercado
                    INNER JOIN diaco_productocba dpcba ON dapc.idProducto = dpcba.id_producto
                    INNER JOIN diaco_medida dm ON dapc.idMedida = dm.id_medida
                    INNER JOIN diaco_categoriacba dc on dapc.idCategoria = dc.id_Categoria
                    WHERE dapc.idTipoVerificacion = '".$request->type."' AND dapc.idCategoria = '".$request->category."' AND  dep.codigo_departamento = '".$request->departament."' and muni.codigo_municipio = '".$request->municipio."' AND 
                        convert(varchar,dvcba.created_at,5) BETWEEN '".$request->fInitial."' AND '".$request->fFinal."'
                    GROUP BY dmcba.nombreMercado,dpcba.nombre, dm.nombre, dc.nombre
            ");

            // $name = $this->getNameLocal();
            // $name = collect($name);

            //     foreach ($name as $names) {
            //         $filtro = $this->getFilter($names->nombreMercado);
            //         $filtro = collect($filtro);
            //             $response[] = [
            //                 "code"      =>  $names->nombreMercado,
            //                 "uom"      =>  $filtro,
                            
            //             ];
            //     }
            // }

                       
        //    $response = collect($response);

        //     return fractal() 
        //         ->collection($response)
        //         ->transformWith(new dataTable()) 
        //         ->includeCharacters()
        //         ->toArray();
            // return response()->json($response,200);
            
        // }
    }
}
