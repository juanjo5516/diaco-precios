<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\EdicionPlantilla;
use App\NameTemplate;
use App\ListarAsignacion;
use App\vaciadocba;
use App\Models\local;
use App\Models\market;
use Illuminate\Support\Facades\Auth;
use App\TipoVisitaPlantilla;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\user_cba;
use Illuminate\Support\Str;

class plantillasController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    public function UserLogin(){
        // $user = DB::table('diaco_usuario')
        //             ->join('diaco_sede','id_diaco_sede', '=', 'diaco_usuario.id_sede_diaco')->select('diaco_sede.id_diaco_sede as id','diaco_sede.nombre_sede as sede','diaco_usuario.nombre','diaco_usuario.id_usuario as id_usuario')->where('diaco_usuario.id_usuario', '=', 1)->get();
        //return response()->json($user);
        $user2 = Auth::user();
        $user = DB::table('diaco_usuario')
                    ->join('diaco_sede','id_diaco_sede', '=', 'diaco_usuario.id_sede_diaco')
                    // ->join('diaco_usuario_perfil','diaco_usuario_perfil.id_usuario','=','diaco_usuario.id_usuario')
                    ->select('diaco_sede.id_diaco_sede as id','diaco_sede.nombre_sede as sede','diaco_usuario.nombre','diaco_usuario.id_usuario as id_usuario')
                    // ->select('diaco_sede.id_diaco_sede as id','diaco_sede.nombre_sede as sede','diaco_usuario.nombre','diaco_usuario.id_usuario as id_usuario','diaco_usuario_perfil.id_perfil_puesto as tipo')
                    ->where('diaco_usuario.id_usuario', '=', $user2->id_usuario)->get();



        return $user;
    }

    public function getSedeData(){
        $sede = DB::table('diaco_sede')
                    // ->join()
                    ->select('id_diaco_sede as code', 'nombre_sede as name')->get();
        return response()->json($sede, 200);
    }

    public function Asede(){

        $Plantillas = DB::table('diaco_name_template_cba')->select('id','NombreTemplate')->get();
        $sede = DB::table('diaco_sede')->select('id_diaco_sede', 'nombre_sede')->get();




        return view('Ediciones.sedes',
        [
            'Plantillas' => $Plantillas,
            'Sedes' =>$sede
        ]);

    }

    public function getAsede(){

        try {
             $Lista = $this->ListarAsignaciones();
             return datatables()->collection($Lista)->toJson();
             DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            print $e;
        }

    }
    public function getAsedeJson(){

        $Lista = $this->ListarAsignaciones();
        return response()->json($Lista, 200);

    }

    public function getTipoVisita(){
        $Tipo = TipoVisitaPlantilla::all();
        return response()->json($Tipo, 200);
    }

    public function index(){
        $date = Carbon::now();
        $date = $date->format('d-m-Y');
        $categoria = DB::table("diaco_categoriacba")->select('id_Categoria as id','nombre as nombre')->where('status','=','A')->orderBy('nombre','asc')->get()->toJson(JSON_PRETTY_PRINT);
        $producto = DB::table("diaco_productocba")->select('id_producto as id','nombre as Pnombre')->where('status','=','A')->get();
        $medida = DB::table('diaco_medida')->select('id_medida as id','nombre as nombre')->where('status','=','A')->get();
        //dd($categoria);
        return view('Ediciones.index',
        [
            'fecha' => $date,
            'collection' => $categoria,
            'producto' => $producto,
            'medida' => $medida
        ]);
    }

    public function VerificarIdTemplate($nombre, $columnas){

        if (NameTemplate::where('NombreTemplate', '=', $nombre)->exists()){
            return 0;
        }else{
            try {
                $Template = new NameTemplate;
                $Template->NombreTemplate = $nombre ;
                $Template->cantidadColmna = $columnas;
                $Template->estado = 1;
                $Template->save();



                return $TemplateId = $Template->id;
                // $TemplateId = $Template->id;
                // dd($TemplateId);
            } catch (\Exceptio $e) {
                return $e;
            }
        }
    }

    public function getFecha(){
        $date = Carbon::now();
        $date = $date->format('d-m-Y');
        return $date;
    }

    public function handleTemplate($name){
        
        $type = TipoVisitaPlantilla::where('nombreVerificacion','=',$name)->exists();

        if($type){
            $id = TipoVisitaPlantilla::select('id_TipoVerificacion')->where('nombreVerificacion','=',$name)->get();
            $response = $id[0]['id_TipoVerificacion'];
            
            return response()->json($response,200);
        }else{
            try {
                
                $query = DB::statement("exec AddTipo :name",
                [
                    'name' => $name
                ]);
                
                
                $id = TipoVisitaPlantilla::select('id_TipoVerificacion')->where('nombreVerificacion','=',$name)->get();
                $response = $id[0]['id_TipoVerificacion'];
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(false, 200);
            }

        }
        
    }
    
    public function handleCategory($name){

    }

    public function store(Request $request){

        
        $TIMESTAMP = Carbon::now();

        DB::beginTransaction();
        $valor = sizeof($request->Dproducto);
        // dd($request->Dproducto[0]['codeProducto']);

        

        $validar = $this->VerificarIdTemplate($request->Nplantilla, $request->NColumna);
        if ($validar != 0) {
            try {
                for ($i=0; $i < $valor; $i++) {

                    $Edicion = new EdicionPlantilla;

                    $Edicion->NombrePlantilla = $request->Nplantilla;
                    $Edicion->idCategoria  = $request->categoriaVaciado;
                    $Edicion->idProducto  = $request->Dproducto[$i]['codeProducto'];
                    $Edicion->idMedida  = $request->Dproducto[$i]['codeMedida'];
                    $Edicion->estado  = 1;
                    $Edicion->created_at = $TIMESTAMP;
                    $Edicion->tipoVerificacion = $request->TipoVisita;
                    $Edicion->save();

                }

                // print 200;
                DB::commit();
                return response()->json('success', 200); 
            } catch (\Exceptio $e) {
                DB::rollBack();
                return $e;

            }
        }else{
            try {
                for ($i=0; $i < $valor; $i++) {

                    $Edicion = new EdicionPlantilla;

                    $Edicion->NombrePlantilla = $request->Nplantilla;
                    $Edicion->idCategoria  = $request->categoriaVaciado;
                    $Edicion->idProducto  = $request->Dproducto[$i]['codeProducto'];
                    $Edicion->idMedida  = $request->Dproducto[$i]['codeMedida'];
                    $Edicion->estado  = 1;
                    $Edicion->created_at = $TIMESTAMP;
                    $Edicion->tipoVerificacion = $request->TipoVisita;
                    $Edicion->save();

                }
                // print 200;
                DB::commit();
                return response()->json('success', 200);
            } catch (\Exceptio $e) {
                DB::rollBack();
                print $e;
            }
        }
    }

    public function ListarAsignaciones(){
        $Listar = DB::table('diaco_asignarsedecba')
                        ->join('diaco_name_template_cba','diaco_asignarsedecba.idPlantilla','=','diaco_name_template_cba.id')
                        ->join('diaco_sede','diaco_asignarsedecba.idSede','=','diaco_sede.id_diaco_sede')
                        // ->select('diaco_name_template_cba.NombreTemplate','diaco_sede.nombre_sede','diaco_asignarsedecba.estatus','diaco_asignarsedecba.created_at')
                        ->selectraw("diaco_asignarsedecba.id_Asignacion,diaco_name_template_cba.NombreTemplate,diaco_sede.nombre_sede,(CASE WHEN (diaco_asignarsedecba.estatus = 1) THEN 'Activo' ELSE 'Enviado' END) as estatus,diaco_asignarsedecba.created_at,diaco_asignarsedecba.correlativo,diaco_asignarsedecba.idPlantilla")
                        ->where('diaco_asignarsedecba.estatus','>',0)
                        ->get();
        return $Listar;

    }

    public function deleteByIdAsignacion(Request $request){
        $deleteById = ListarAsignacion::where('id_Asignacion', $request->id)->update(['estatus' => 0]);
        return response()->json($deleteById, 200);
    }

    public function getInbox(){
        $usuario = $this->UserLogin();

        if (Auth()->user()->nombre == 'Juan José Jolón Granados'  || Auth()->user()->nombre == 'Herberth Ordoñez' || Auth()->user()->nombre == 'Jose Gudiel' || Auth()->user()->nombre == 'Carlos Paxtor' || Auth()->user()->nombre == 'Oliver Salvador' || Auth()->user()->nombre == 'Javier Pineda'){
            $buson = DB::table('diaco_asignarsedecba')
                                ->join('diaco_name_template_cba','diaco_asignarsedecba.idPlantilla','=','diaco_name_template_cba.id')
                                ->join('diaco_sede','diaco_asignarsedecba.idSede','=','diaco_sede.id_diaco_sede')
                                ->join('diaco_usuario','diaco_sede.id_diaco_sede','=','diaco_usuario.id_sede_diaco')
                                ->join('diaco_plantillascba','NombrePlantilla','=','diaco_name_template_cba.NombreTemplate')
                                // ->select('NAME_TEMPLATE_CBA.NombreTemplate','diaco_sede.nombre_sede','AsignarSedeCBA.estatus','AsignarSedeCBA.created_at')
                                ->selectraw("distinct diaco_name_template_cba.id,diaco_asignarsedecba.correlativo,diaco_name_template_cba.NombreTemplate,diaco_sede.nombre_sede,(CASE WHEN (diaco_asignarsedecba.estatus = 1) THEN 'Activo' ELSE 'Inactivo' END) as estatus, diaco_plantillascba.tipoVerificacion as Tipo,FORMAT(diaco_asignarsedecba.created_at, 'dd/MM/yyyy') as fecha,DATEDIFF(DAY,diaco_asignarsedecba.created_at, getdate())  as retrazo,diaco_asignarsedecba.filtro")
                                ->where('diaco_sede.id_diaco_sede', '=', $usuario[0]->id)
                                ->where('diaco_asignarsedecba.idUsuario','=',$usuario[0]->id_usuario)
                                ->where('diaco_asignarsedecba.estatus','>','0')
                                ->where('diaco_asignarsedecba.filtro','<','3')
                                ->get();
        }else{
             $buson = DB::table('diaco_asignarsedecba')
                                ->join('diaco_name_template_cba','diaco_asignarsedecba.idPlantilla','=','diaco_name_template_cba.id')
                                ->join('diaco_sede','diaco_asignarsedecba.idSede','=','diaco_sede.id_diaco_sede')
                                ->join('diaco_usuario','diaco_sede.id_diaco_sede','=','diaco_usuario.id_sede_diaco')
                                ->join('diaco_plantillascba','NombrePlantilla','=','diaco_name_template_cba.NombreTemplate')
                                // ->select('NAME_TEMPLATE_CBA.NombreTemplate','diaco_sede.nombre_sede','AsignarSedeCBA.estatus','AsignarSedeCBA.created_at')
                                ->selectraw("distinct diaco_name_template_cba.id,diaco_asignarsedecba.correlativo,diaco_name_template_cba.NombreTemplate,diaco_sede.nombre_sede,(CASE WHEN (diaco_asignarsedecba.estatus = 1) THEN 'Activo' ELSE 'Inactivo' END) as estatus, diaco_plantillascba.tipoVerificacion as Tipo ,FORMAT(diaco_asignarsedecba.created_at, 'dd/MM/yyyy') as fecha,diaco_asignarsedecba.filtro")
                                ->where('diaco_sede.id_diaco_sede', '=', $usuario[0]->id)
                                ->where('diaco_asignarsedecba.idUsuario','=',$usuario[0]->id_usuario)
                                ->where('diaco_asignarsedecba.estatus','>','0')
                                ->where('diaco_asignarsedecba.filtro','<','3')
                                ->get();
        }
        // dd($usuario);

        //dd($buson);

        return response()->json($buson);
    }
    public function storeLista(Request $request){
        $cantidadObjeto = sizeof($request->SSede);
        for($i = 0; $i < $cantidadObjeto; $i++){
            $UserCba = $this->getUserCba($request->SSede[$i]);
            $cantidadUser = sizeof($UserCba);
            if($cantidadUser > 0){
                for($userCount = 0; $userCount < $cantidadUser; $userCount++ ){
                    $Lista = new ListarAsignacion;
                    $Lista->idPlantilla = $request->SPlantilla;
                    $Lista->idSede  = $request->SSede[$i];
                    $Lista->created_at  = $request->created_at_new;
                    $Lista->estatus  = 1;
                    $Lista->filtro = 1;
                    $Lista->idUsuario = $UserCba[$userCount]->code_user;
                    $Lista->save();

                    $ListaId = $Lista->id;
                    $Ncorrelativo = $this->createCorrelative($ListaId);
                    ListarAsignacion::where('id_Asignacion','=',$ListaId)
                                                ->update(['correlativo' => $Ncorrelativo]);
                }
            }
        }
        return 1;
    }
    public function storeListaUsuario(Request $request){
        $Lista = new ListarAsignacion;
        $Lista->idPlantilla = $request->SPlantilla;
        $Lista->idSede  = $request->SSede;
        $Lista->created_at  = $request->created_at_new;
        $Lista->estatus  = 1;
        $Lista->filtro = 1;
        $Lista->idUsuario = $request->Usuario;
        $Lista->save();

        $ListaId = $Lista->id;
        $Ncorrelativo = $this->createCorrelative($ListaId);
        ListarAsignacion::where('id_Asignacion','=',$ListaId)
                                    ->update(['correlativo' => $Ncorrelativo]);
        return 1;
    }

    public function getUserCba($sede){
        $data = user_cba::select('code_user','code_sede')->where('code_sede','=',$sede)->where('status','=','A')->get();
        // return response()->json($data, 200);
        return $data;
    }

    public function showInbox(){
        return view('Ediciones.bandejaEntrada');
    }

    public function showprinter($id,$correlativo){
       // DB::beginTransaction();
        try {

            $fecha = $this->getFecha();
            $usuario = $this->UserLogin();
            $columna = $this->getCountColumnfindId($id);
            // dd($columna);

            $query = DB::table('diaco_plantillascba')
                            ->selectraw('diaco_plantillascba.NombrePlantilla,diaco_plantillascba.created_at,diaco_categoriacba.nombre as categoria,diaco_productocba.nombre as produto,diaco_medida.nombre as medida')
                            ->join('diaco_categoriacba','id_Categoria','=','idCategoria')
                            ->join('diaco_productocba','id_producto','=','idProducto')
                            ->join('diaco_medida','id_medida','=','idMedida')
                            ->join('diaco_name_template_cba','NombreTemplate','=','NombrePlantilla')
                            ->where('diaco_name_template_cba.id',$id)
                            ->get();
            $categorias = DB::select("
                                SELECT distinct 
                                (CASE
                                    WHEN pl.tipoVerificacion = '6' THEN '1'
                                    WHEN pl.tipoVerificacion = '52' THEN '11'
                                    ELSE '0'
                                END)  as paso,
                                dtv.nombreVerificacion as type_verify
                                    FROM diaco_plantillascba pl
                                    INNER JOIN diaco_categoriacba cl
                                        ON cl.id_Categoria = pl.idCategoria
                                    INNER JOIN diaco_productocba prl
                                        ON prl.id_producto = pl.idProducto
                                    INNER JOIN diaco_medida md
                                        ON md.id_medida = pl.idMedida
                                    INNER JOIN diaco_name_template_cba npl
                                        ON npl.NombreTemplate = pl.NombrePlantilla
                                    INNER JOIN diaco_tipoverificacioncba dtv 
                                        ON pl.tipoVerificacion = dtv.id_TipoVerificacion 
                                    WHERE npl.id = :id",[
                                        'id' => $id]);
                                        // WHEN pl.tipoVerificacion = '5' THEN '1' //para desarrollo
                                        // WHEN pl.tipoVerificacion = '11' THEN '11'
                                        // WHEN pl.tipoVerificacion = '6' THEN '1' //para produccion
                                        // WHEN pl.tipoVerificacion = '52' THEN '11'
            $categorias_mercado = DB::select("
                                SELECT distinct cl.nombre,
                                (CASE
                                    WHEN pl.tipoVerificacion = '6' THEN '1'
                                    WHEN pl.tipoVerificacion = '52' THEN '11'
                                    ELSE '0'
                                END)  as paso,
                                dtv.nombreVerificacion as type_verify
                                    FROM diaco_plantillascba pl
                                    INNER JOIN diaco_categoriacba cl
                                        ON cl.id_Categoria = pl.idCategoria
                                    INNER JOIN diaco_productocba prl
                                        ON prl.id_producto = pl.idProducto
                                    INNER JOIN diaco_medida md
                                        ON md.id_medida = pl.idMedida
                                    INNER JOIN diaco_name_template_cba npl
                                        ON npl.NombreTemplate = pl.NombrePlantilla
                                    INNER JOIN diaco_tipoverificacioncba dtv 
                                        ON pl.tipoVerificacion = dtv.id_TipoVerificacion 
                                    WHERE npl.id = :id",[
                                        'id' => $id]);

            $cat_pro_gas = DB::select('
                                    SELECT distinct dpc.nombre as producto,count(dpc.nombre) as coulspan 
                                    FROM diaco_plantillascba dp 
                                    INNER JOIN diaco_categoriacba dc 
                                        ON dp.idCategoria = dc.id_Categoria
                                    INNER JOIN diaco_productocba dpc 
                                        ON dp.idProducto = dpc.id_producto
                                    INNER JOIN diaco_medida dm 
                                        ON dp.idMedida = dm.id_medida
                                    INNER JOIN diaco_name_template_cba dnt
                                        ON  dp.NombrePlantilla = dnt.NombreTemplate
                                    WHERE dnt.id = :id
                                    group by dpc.nombre',['id' => $id]);
            $cat_pro_com = DB::select('
                                    SELECT distinct dpc.nombre as producto,count(dpc.nombre) as coulspan, dc.nombre as category 
                                    FROM diaco_plantillascba dp 
                                    INNER JOIN diaco_categoriacba dc 
                                        ON dp.idCategoria = dc.id_Categoria
                                    INNER JOIN diaco_productocba dpc 
                                        ON dp.idProducto = dpc.id_producto
                                    INNER JOIN diaco_medida dm 
                                        ON dp.idMedida = dm.id_medida
                                    INNER JOIN diaco_name_template_cba dnt
                                        ON  dp.NombrePlantilla = dnt.NombreTemplate
                                    WHERE dnt.id = :id
                                    group by dpc.nombre,dc.nombre',['id' => $id]);
            
            $category_handle = DB::select('
                                SELECT distinct dc.id_categoria as code,dc.nombre as categoria, count(dpc.nombre) as coulspan 
                                FROM diaco_plantillascba dp 
                                INNER JOIN diaco_categoriacba dc 
                                    ON dp.idCategoria = dc.id_Categoria
                                INNER JOIN diaco_productocba dpc 
                                    ON dp.idProducto = dpc.id_producto
                                INNER JOIN diaco_medida dm 
                                    ON dp.idMedida = dm.id_medida
                                INNER JOIN diaco_name_template_cba dnt
                                    ON  dp.NombrePlantilla = dnt.NombreTemplate
                                WHERE dnt.id = :id
                                group by dc.id_categoria,dc.nombre',['id' => $id]);

        
            
            // return view('Ediciones.printer_data',[
            //     'id' => $id,
            //     'fecha' => $fecha,
            //     'usuario' => $usuario,
            //     'coleccion' => $query,
            //     'categoria' => $categorias
            // ]);


            // return view('Ediciones.pdfdata');

            // dd($query);
            // dd($categorias);
            // return view('Ediciones.printer_data',[
            //     'id' => $id,
            //     'fecha' => $fecha,
            //     'usuario' => $usuario,
            //     'coleccion' => $query,
            //     'categoria' => $categorias,
            //     'Ncolumna' => $columna,
            //     'correlativo' => $correlativo,
            //     'cat_pro_gas' => $cat_pro_gas,
            //     "type_category" => $category_handle,
            //     "data_pro_category" => $cat_pro_com,
            //     "category_mer" => $categorias_mercado
                
            // ]);

                $paso = 0;
            if($categorias[0]->type_verify === 'Gas Propano'){
                $pdf = \PDF::loadView('Ediciones.printer_data',[
                    'id' => $id,
                    'fecha' => $fecha,
                    'usuario' => $usuario,
                    'coleccion' => $query,
                    'categoria' => $categorias,
                    'Ncolumna' => $columna,
                    'correlativo' => $correlativo,
                    'cat_pro_gas' => $cat_pro_gas,
                    "type_category" => $category_handle,
                    "data_pro_category" => $cat_pro_com,
                    "category_mer" => $categorias_mercado
                ]);
                $pdf->setPaper('Legal', 'landscape');
            }elseif($categorias[0]->type_verify === 'Tortillería'){
                $pdf = \PDF::loadView('Ediciones.printer_data',[
                    'id' => $id,
                    'fecha' => $fecha,
                    'usuario' => $usuario,
                    'coleccion' => $query,
                    'categoria' => $categorias,
                    'Ncolumna' => $columna,
                    'correlativo' => $correlativo,
                    'cat_pro_gas' => $cat_pro_gas,
                    "type_category" => $category_handle,
                    "data_pro_category" => $cat_pro_com,
                    "category_mer" => $categorias_mercado
                ]);
                $pdf->setPaper('Legal', 'landscape');
            }elseif($categorias[0]->type_verify === 'Combustibles'){
                $pdf = \PDF::loadView('Ediciones.printer_data',[
                    'id' => $id,
                    'fecha' => $fecha,
                    'usuario' => $usuario,
                    'coleccion' => $query,
                    'categoria' => $categorias,
                    'Ncolumna' => $columna,
                    'correlativo' => $correlativo,
                    'cat_pro_gas' => $cat_pro_gas,
                    "type_category" => $category_handle,
                    "data_pro_category" => $cat_pro_com,
                    "category_mer" => $categorias_mercado
                ]);
                $pdf->setPaper('Legal', 'portrait');
            }
            else{
                
                $pdf = \PDF::loadView('Ediciones.printer_data',[
                    'id' => $id,
                    'fecha' => $fecha,
                    'usuario' => $usuario,
                    'coleccion' => $query,
                    'categoria' => $categorias,
                    'Ncolumna' => $columna,
                    'correlativo' => $correlativo,
                    'cat_pro_gas' => $cat_pro_gas,
                    "type_category" => $category_handle,
                    "data_pro_category" => $cat_pro_com,
                    "category_mer" => $categorias_mercado
                ]);
                $pdf->setPaper('Legal', 'portrait');
            }
            return $pdf->stream($correlativo.'.pdf'); 
            // return $pdf->save('Ediciones.pdf');
            // return $pdf->stream();
           // DB::commit();
        } catch (\Exceptio $e) {
            //DB::rollBack();
            print $e;
        }
    }

    public function getProductoEdicionPlantilla(Request $request){
        $query = DB::table('diaco_plantillascba')
                            ->selectraw('diaco_plantillascba.NombrePlantilla,diaco_plantillascba.created_at,diaco_categoriacba.nombre as categoria,diaco_productocba.nombre as produto,diaco_medida.nombre as medida,diaco_plantillascba.idPlantilla')
                            ->join('diaco_categoriacba','id_Categoria','=','idCategoria')
                            ->join('diaco_productocba','id_producto','=','idProducto')
                            ->join('diaco_medida','id_medida','=','idMedida')
                            ->join('diaco_name_template_cba','NombreTemplate','=','NombrePlantilla')
                            ->where('diaco_name_template_cba.id',$request->id)
                            ->get();


        return response()->json($query, 200);
    }

    public function showEdit($id,$correlativo){

        try {
            $fecha = $this->getFecha();
            $usuario = $this->UserLogin();
            // $columna = $this->getCountColumnfindId($id);

            // dd($columna);


            $query = DB::table('diaco_plantillascba')
                            ->selectraw('diaco_plantillascba.NombrePlantilla,diaco_plantillascba.created_at,diaco_categoriacba.nombre as categoria,diaco_productocba.nombre as produto,diaco_medida.nombre as medida,diaco_plantillascba.idPlantilla')
                            ->join('diaco_categoriacba','id_Categoria','=','idCategoria')
                            ->join('diaco_productocba','id_producto','=','idProducto')
                            ->join('diaco_medida','id_medida','=','idMedida')
                            ->join('diaco_name_template_cba','NombreTemplate','=','NombrePlantilla')
                            ->where('diaco_name_template_cba.id',$id)
                            ->get();

            $categorias = DB::select('
                                SELECT distinct cl.nombre as categoria FROM diaco_plantillascba pl
                                    INNER JOIN diaco_categoriacba cl
                                        ON cl.id_Categoria = pl.idCategoria
                                    INNER JOIN diaco_productocba prl
                                        ON prl.id_producto = pl.idProducto
                                    INNER JOIN diaco_medida md
                                        ON md.id_medida = pl.idMedida
                                    INNER JOIN diaco_name_template_cba npl
                                        ON npl.NombreTemplate = pl.NombrePlantilla
                                    WHERE npl.id = :id',[
                                        'id' => $id]);
            // return view('Ediciones.printer_data',[
            //     'id' => $id,
            //     'fecha' => $fecha,
            //     'usuario' => $usuario,
            //     'coleccion' => $query,
            //     'categoria' => $categorias
            // ]);


            // return view('Ediciones.pdfdata');

            return view('Ediciones.editPlantilla',[
                'id' => $id,
                'fecha' => $fecha,
                'usuario' => $usuario,
                'coleccion' => $query,
                'categoria' => $categorias,
                'correlativo' => $correlativo
            ]);

            // $pdf = \PDF::loadView('Ediciones.editPlantilla',[
            //     'id' => $id,
            //     'fecha' => $fecha,
            //     'usuario' => $usuario,
            //     'coleccion' => $query,
            //     'categoria' => $categorias,
            //     'Ncolumna' => $columna,
            //     'correlativo' => $correlativo
            // ]);
            // return $pdf->download('Ediciones.pdf');
        } catch (\Exceptio $e) {
            print $e;
        }
    }

    public function getPlantillas($id){

        $query = DB::table('diaco_plantillascba')
                        ->selectraw("diaco_plantillascba.idCategoria as idCategoria,diaco_medida.id_medida as idmedida,diaco_plantillascba.NombrePlantilla,diaco_plantillascba.created_at,diaco_categoriacba.nombre as categoria,diaco_productocba.nombre as produto,diaco_medida.nombre as medida, diaco_productocba.id_producto as producto,diaco_plantillascba.tipoVerificacion")
                        ->join('diaco_categoriacba','id_Categoria','=','idCategoria')
                        ->join('diaco_productocba','id_producto','=','idProducto')
                        ->join('diaco_medida','id_medida','=','idMedida')
                        ->join('diaco_name_template_cba','NombreTemplate','=','NombrePlantilla')
                        // ->join('diaco_vaciadocba as dv','dv.idProducto','=','diaco_plantillascba.idProducto')
                        // ->join('diaco_vaciadocba','diaco_vaciadocba.idMedida','=','diaco_plantillascba.idMedida')
                        ->where('diaco_name_template_cba.id',$id)
                        ->groupBy(['diaco_plantillascba.idCategoria','diaco_medida.id_medida','diaco_plantillascba.NombrePlantilla','diaco_plantillascba.created_at','diaco_categoriacba.nombre','diaco_productocba.nombre','diaco_medida.nombre','diaco_productocba.id_producto','diaco_plantillascba.tipoVerificacion'])
                        ->orderBy('diaco_productocba.nombre')
                        ->get();
        // $query = DB::table('diaco_plantillascba')
        //                 ->selectraw(" distinct diaco_plantillascba.idCategoria as idCategoria,diaco_medida.id_medida as idmedida,diaco_plantillascba.NombrePlantilla,diaco_plantillascba.created_at,diaco_categoriacba.nombre as categoria,diaco_productocba.nombre as produto,diaco_medida.nombre as medida, diaco_productocba.id_producto as producto,diaco_plantillascba.tipoVerificacion,CONCAT('Q ',CONVERT(decimal(18,2),avg(diaco_vaciadocba.precioProducto))) as precio")
        //                 ->join('diaco_categoriacba','id_Categoria','=','idCategoria')
        //                 ->join('diaco_productocba','id_producto','=','idProducto')
        //                 ->join('diaco_medida','id_medida','=','idMedida')
        //                 ->join('diaco_name_template_cba','NombreTemplate','=','NombrePlantilla')
        //                 ->join('diaco_vaciadocba as dv','dv.idProducto','=','diaco_plantillascba.idProducto')
        //                 ->join('diaco_vaciadocba','diaco_vaciadocba.idMedida','=','diaco_plantillascba.idMedida')
        //                 ->where('diaco_name_template_cba.id',$id)
        //                 ->groupBy(['diaco_plantillascba.idCategoria','diaco_medida.id_medida','diaco_plantillascba.NombrePlantilla','diaco_plantillascba.created_at','diaco_categoriacba.nombre','diaco_productocba.nombre','diaco_medida.nombre','diaco_productocba.id_producto','diaco_plantillascba.tipoVerificacion'])
        //                 ->orderBy('diaco_productocba.nombre')
        //                 ->get();


        // dd($query);
        $query_data = DB::table('diaco_plantillascba')
            ->selectraw("diaco_plantillascba.idCategoria as idCategoria,diaco_medida.id_medida as idmedida,diaco_plantillascba.NombrePlantilla,diaco_plantillascba.created_at,diaco_categoriacba.nombre as categoria,diaco_productocba.nombre as produto,diaco_medida.nombre as medida, diaco_productocba.id_producto as producto,diaco_plantillascba.tipoVerificacion")
            ->join('diaco_categoriacba','id_Categoria','=','idCategoria')
            ->join('diaco_productocba','id_producto','=','idProducto')
            ->join('diaco_medida','id_medida','=','idMedida')
            ->join('diaco_name_template_cba','NombreTemplate','=','NombrePlantilla')
//            ->join('diaco_vaciadocba as dv','dv.idProducto','=','diaco_plantillascba.idProducto')
//            ->join('diaco_vaciadocba','diaco_vaciadocba.idMedida','=','diaco_plantillascba.idMedida')
            ->where('diaco_name_template_cba.id',$id)
//            ->groupBy(['diaco_plantillascba.idCategoria','diaco_medida.id_medida','diaco_plantillascba.NombrePlantilla','diaco_plantillascba.created_at','diaco_categoriacba.nombre','diaco_productocba.nombre','diaco_medida.nombre','diaco_productocba.id_producto','diaco_plantillascba.tipoVerificacion'])
//            ->orderBy('diaco_productocba.nombre')
            ->get();
        if(!$query->isEmpty()){
            return $query;
        }else{
            return $query_data;
        }
//        return $query;
    }

    public function getCategoria($id){
        $categoria = DB::table('diaco_plantillascba')
                            ->selectraw('distinct diaco_categoriacba.id_categoria as code,diaco_categoriacba.nombre as categoria')
                            ->join('diaco_categoriacba','id_Categoria','=','idCategoria')
                            ->join('diaco_productocba','id_producto','=','idProducto')
                            ->join('diaco_medida','id_medida','=','idMedida')
                            ->join('diaco_name_template_cba','NombreTemplate','=','NombrePlantilla')
                            ->where('diaco_name_template_cba.id',$id)
                            ->get();
        return $categoria;
    }

    public function getMercado(){
        $mercado = DB::table('diaco_mercadocba')->select('idMercado','nombreMercado as nombre')->get();
        return $mercado;
    }

    public function getEstablecimiento(){
        $mercado = DB::table('diaco_establecimientocba')->select('idEstablecimiento','nombreEstablecimiento as nombre')->get();
        return $mercado;
    }

    public function getTipoVerificacionVaciado($id){

        $tipo = DB::table('diaco_plantillascba')
                        ->join('diaco_name_template_cba','NombreTemplate','=','diaco_plantillascba.NombrePlantilla')
                        ->selectraw('distinct top 1 diaco_plantillascba.tipoVerificacion, diaco_plantillascba.NombrePlantilla as name')
                        ->where('diaco_name_template_cba.id','=',$id)
                        ->get();



        //return $tipo;
        return response()->json($tipo, 200);
    }

    public function showVaciado($id,$correlativo){
         $fecha = $this->getFecha();
         $usuario = $this->UserLogin();
         $plantilla = $this->getPlantillas($id);
         $categoria = $this->getCategoria($id);
         $data = $this->getEstablecimiento();
         $lugarMercado = $this->getMercado();
        //  $tipos = $this->getTipoVerificacionVaciado($id);
        //dd($valores);
        //return response()->json($mercado);

        // dd($plantilla);
        // dd($plantilla);
        return view('Ediciones.vaciado',
            [
                'fecha' => $fecha,
                'user' => $usuario,
                'coleccion' => $plantilla,
                'categoria' => $categoria,
                'establecimiento' => $data,
                'idPlantilla' => $id,
                'mercado' => $lugarMercado,
                'correlativo' => $correlativo

            ]
        );
    }

    public function exportExcelView($id,$correlativo,$user){
            $categoria = $this->getCategoria($id);
            $plantilla = $this->getPlantillas($id);
            return view('exportacion.datos',[
                  'categorias' => $categoria,
                  'producto' => $plantilla,
                  'correlativo' => $correlativo,
                  'id' => $id,
                  'user' => $user
            ]);
    }
    public function submitView($id,$correlativo,$user){
            $categoria = $this->getCategoria($id);
            $plantilla = $this->getPlantillas($id);
            return view('exportacion.submitPreview',[
                  'categorias' => $categoria,
                  'producto' => $plantilla,
                  'correlativo' => $correlativo,
                  'id' => $id,
                  'user' => $user
            ]);
    }
    public function submitViewEditPrices($id,$correlativo,$user){
            $categoria = $this->getCategoria($id);
            $plantilla = $this->getPlantillas($id);
            return view('exportacion.submitEditPrices',[
                  'categorias' => $categoria,
                  'producto' => $plantilla,
                  'correlativo' => $correlativo,
                  'id' => $id,
                  'user' => $user
            ]);
    }

    public function preview($id,$correlativo,$user){
            $categoria = $this->getCategoria($id);
            $plantilla = $this->getPlantillas($id);
            return view('exportacion.datospreview',[
                  'categorias' => $categoria,
                  'producto' => $plantilla,
                  'correlativo' => $correlativo,
                  'id' => $id,
                  'user' => $user
            ]);
    }


    public function createMarket($nombre,$direccion,$departamento){
        $id="";
        $validar = $this->VerificarItem($nombre,'market','nombreMercado');
        if($validar === 0){
            $id = market::select('idMercado as code')->where('nombreMercado','=',$nombre)->get();
            return $id[0]['code'];
        }else{
                $data = new market;
                $data->nombreMercado = $nombre;
                $data->direccionMercado = $direccion;
                $data->departamento_id = $departamento;
                $data->municipio_id =  1;
                $data->status = "A";
                if($data->save()){
                    $id = $data->id;
                    return $id;
                }
        }
    }


    public function setDataSubmit(Request $request){
        // dd($request);
        $timeStamp = Carbon::now();
        $countProduct = count($request->option[0]['dataProduct']);
        $columns = (int)$request->option[0]['column'];
        $columns = 1;
        // dd($countProduct);
        try {
            for ($row=0; $row < $countProduct; $row++) {
                // for ($column=0; $column < $columns; $column++) {
                    $local = $this->createMarket($request->option[0]['dataProduct'][$row]['prices'][$row]['dataName'],
                                                 $request->option[0]['dataProduct'][$row]['prices'][$row]['dataAddress'],
                                                 $request->option[0]['dataProduct'][$row]['prices'][$row]['dataDepartment']);
                    $model = new vaciadocba;
                    $model->numeroLocal = 0;
                    $model->idLugarVisita = $local;
                    $model->created_at = $timeStamp;
                    $model->idPlantilla = $request->option[0]['idP'];
                    $model->idVerificador = $request->option[0]['user'];
                    $model->tipoVerificacion = $request->option[0]['idType'][0]['tipoVerificacion'];
                    // $modelo->idEstablecimientoVisita = $local;
                    $model->idProducto = $request->option[0]['dataProduct'][$row]['producto_id'];
                    $model->idMedida = $request->option[0]['dataProduct'][$row]['medidaId'];
                    // $model->precioProducto = $request->option[0]['dataProduct'][$row]['price'][$column];
                    $model->precioProducto = $request->option[0]['dataProduct'][$row]['prices'][$row]['price'][0];
                    $model->estado = 'I';
                    $model->Ncorrelativo = $request->option[0]['nCorrelative'];
                    $model->id_Categoria = $request->option[0]['dataProduct'][$row]['categoria_id'];
                    $model->save();
                // }
            }
            $respuesta = 'ingresado';
            return response()->json($respuesta, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            print $th;
        }

    }

    public function vaciado(Request $request){

        $TIMESTAMP = Carbon::now();
        $cantidadProducto = count($request->option[0]['dataProduct']);
        $columnas = (int)$request->option[0]['column'];
        // dd($request);
        // dd($request->option[0]['mLugar']);

        try {
            // for ($ii=0; $ii < $columnas ; $ii++) {
                    for ($i=0; $i  < $cantidadProducto ; $i++) {
                        $local = $this->createLocal($request->option[0]['dataProduct'][$i]['prices'][$i]['dataName']);
                        $modelo = new vaciadocba;
                        $modelo->numeroLocal = $request->option[0]['dataProduct'][$i]['prices'][$i]['dataAddress'];
                        $modelo->idLugarVisita = $request->option[0]['mLugar'];
                        $modelo->created_at = $TIMESTAMP;
                        $modelo->idPlantilla = $request->option[0]['idP'];
                        $modelo->idVerificador = $request->option[0]['user'];
                        $modelo->tipoVerificacion = $request->option[0]['idType'][0]['tipoVerificacion'];
                        $modelo->idEstablecimientoVisita = $local;
                        $modelo->idProducto = $request->option[0]['dataProduct'][$i]['producto_id'];
                        $modelo->idMedida = $request->option[0]['dataProduct'][$i]['medidaId'];
                        $modelo->precioProducto = $request->option[0]['dataProduct'][$i]['prices'][$i]['price'][0];
                        $modelo->estado = 'I';
                        $modelo->Ncorrelativo = $request->option[0]['nCorrelative'];
                        $modelo->id_Categoria = $request->option[0]['dataProduct'][$i]['categoria_id'];
                        $modelo->save();
                        
                    }
            // }
            $respuesta = 'ingresado';
            // DB::update('update diaco_asignarsedecba set estatus = 0 where idPlantilla = ? and idSede = ?', [$request->idP,$request->idSede]);
            return response()->json($respuesta, 200);
            // return response()->json(true, 200);

        }

        catch (\Exceptio $e) {
            DB::rollBack();
                print "ERROR";
        }
    }
    public function updateStatusVaciado(Request $request){

        $updateById = ListarAsignacion::where('idPlantilla', $request->idP)
                                                         ->where('idSede',$request->idSede)
                                                         ->where('idUsuario',$request->Usuarios)
                                                         ->where('correlativo',$request->correlativo)->update(['filtro'  => 2]);
                                                        //  ->where('correlativo',$request->correlativo)->update(['estatus'  => 0]);
        return response()->json($updateById, 200);
    }

    public function clon(){
        $plantillasAll = $this->getPlantillasAll();
        //$comprobar = $this->getPlantillas($id);
        return view('Ediciones.clon');
        //return response()->json($comprobar);
    }

    public function getPlantillasAll(){
        $query = DB::table('diaco_name_template_cba')
                        ->selectraw('id,NombreTemplate')
                        ->where('diaco_name_template_cba.estado','>',0)
                        ->get();

        // // return $query;
        return response()->json($query, 200);

    }
    public function getDataPlantillas(Request $request){

        // dd($request);
        $TIMESTAMP = Carbon::now();
        $comprobar = $this->getPlantillas($request->SPlantilla);
        $cantidadProducto = count($comprobar);
        $cantidadColumna = $this->getCountColumnfindId((int)$request->SPlantilla);
        // dd($cantidadColumna);
        $validar = $this->VerificarIdTemplate($request->dataResponse,$cantidadColumna);

        if ($validar != 0) {
            try {
                for ($i=0; $i < $cantidadProducto; $i++) {

                    $Edicion = new EdicionPlantilla;

                    $Edicion->NombrePlantilla = $request->dataResponse;
                    $Edicion->idCategoria  = $comprobar[$i]->idCategoria;
                    $Edicion->idProducto  = $comprobar[$i]->producto;
                    $Edicion->idMedida  = $comprobar[$i]->idmedida;
                    $Edicion->estado  = 1;
                    $Edicion->created_at = $TIMESTAMP;
                    $Edicion->tipoVerificacion = $comprobar[$i]->tipoVerificacion;
                    $Edicion->save();

                }
                print 1;
                DB::commit();
            } catch (\Exceptio $e) {
                DB::rollBack();
                print $e;
            }
       }

        dd($comprobar);
    }

    function check(){
        $user = $this->UserLogin();
        $ti = $this->getTipoVisita();
        $tipo = $this->getTipoVerificacionVaciado(20);
        $plantilla = $this->getPlantillas(1);
        $all = $this->getPlantillasAll();
        $enviado = $this->GetEnviados();

        $user2 = Auth::user()->id_usuario;

        //$userId = auth()->user()->id_usuario;
        $Permio = DB::table('diaco_usuario_perfil')
                    ->join('diaco_perfiles_puesto','diaco_perfiles_puesto.id_perfil_puesto','=','diaco_usuario_perfil.id_perfil_puesto')
                    ->select('diaco_perfiles_puesto.perfil')
                    ->where('diaco_usuario_perfil.id_usuario','=',$user2)
                    ->get();
        dd($enviado);
    }

    public function GetEnviados(){
        $usuario = $this->UserLogin();


        if (Auth()->user()->nombre == 'Juan José Jolón Granados'  || Auth()->user()->nombre == 'Herberth Ordoñez' || Auth()->user()->nombre == 'Jose Gudiel' || Auth()->user()->nombre == 'Carlos Paxtor' || Auth()->user()->nombre == 'Oliver Salvador' || Auth()->user()->nombre == 'Javier Pineda'){
            $buson = DB::table('diaco_asignarsedecba')
            ->join('diaco_name_template_cba','diaco_asignarsedecba.idPlantilla','=','diaco_name_template_cba.id')
            ->join('diaco_sede','diaco_asignarsedecba.idSede','=','diaco_sede.id_diaco_sede')
            ->join('diaco_usuario','diaco_sede.id_diaco_sede','=','diaco_usuario.id_sede_diaco')
            ->join('diaco_usuario as usuarioss','diaco_asignarsedecba.idUsuario','=','diaco_usuario.id_usuario')
            ->join('diaco_vaciadocba','diaco_vaciadocba.Ncorrelativo','=','diaco_asignarsedecba.correlativo')
            ->selectraw("
                                distinct
                                diaco_name_template_cba.id,
                                diaco_name_template_cba.NombreTemplate,
                                diaco_sede.nombre_sede,
                                (CASE WHEN (diaco_asignarsedecba.estatus = 1) THEN 'Activo' ELSE 'Enviado' END) as estatus,
                                diaco_usuario.nombre,
                                diaco_asignarsedecba.correlativo"
                            )
            ->where('diaco_asignarsedecba.estatus','=','1')
            ->orWhere('diaco_asignarsedecba.filtro','=','3')
            ->orderBy('diaco_asignarsedecba.correlativo', 'DESC')
            ->get();
                            // ->selectraw("
                            //                     distinct diaco_name_template_cba.id,
                            //                     diaco_name_template_cba.NombreTemplate,
                            //                     diaco_sede.nombre_sede,
                            //                     (CASE WHEN (diaco_asignarsedecba.estatus = 1) THEN 'Activo' ELSE 'Enviado' END) as estatus,
                            //                     diaco_plantillascba.tipoVerificacion as Tipo,
                            //                     diaco_vaciadocba.created_at,
                            //                     diaco_usuario.nombre"
                            //                 )
            // ->join('diaco_plantillascba','NombrePlantilla','=','diaco_name_template_cba.NombreTemplate')
            // ->select('NAME_TEMPLATE_CBA.NombreTemplate','diaco_sede.nombre_sede','AsignarSedeCBA.estatus','AsignarSedeCBA.created_at')
            // ->where('diaco_sede.id_diaco_sede', '=', $usuario[0]->id)
            // ->where('diaco_usuario.id_usuario','=',$usuario[0]->id_usuario)
        }else{

            $buson = DB::table('diaco_asignarsedecba')
            ->join('diaco_name_template_cba','diaco_asignarsedecba.idPlantilla','=','diaco_name_template_cba.id')
            ->join('diaco_sede','diaco_asignarsedecba.idSede','=','diaco_sede.id_diaco_sede')
            ->join('diaco_usuario','diaco_sede.id_diaco_sede','=','diaco_usuario.id_sede_diaco')
            ->join('diaco_usuario as usuarioss','diaco_asignarsedecba.idUsuario','=','diaco_usuario.id_usuario')
            ->join('diaco_plantillascba','NombrePlantilla','=','diaco_name_template_cba.NombreTemplate')
            // ->select('NAME_TEMPLATE_CBA.NombreTemplate','diaco_sede.nombre_sede','AsignarSedeCBA.estatus','AsignarSedeCBA.created_at')
            ->join('diaco_vaciadocba','diaco_vaciadocba.Ncorrelativo','=','diaco_asignarsedecba.correlativo')
            ->selectraw("
                                distinct
                                diaco_name_template_cba.id,
                                diaco_name_template_cba.NombreTemplate,
                                diaco_sede.nombre_sede,
                                (CASE WHEN (diaco_asignarsedecba.estatus = 1) THEN 'Activo' ELSE 'Enviado' END) as estatus,
                                diaco_usuario.nombre,
                                diaco_asignarsedecba.correlativo"
                            )
            // ->selectraw("distinct diaco_name_template_cba.id,diaco_name_template_cba.NombreTemplate,diaco_sede.nombre_sede,(CASE WHEN (diaco_asignarsedecba.estatus = 1) THEN 'Activo' ELSE 'Enviado' END) as estatus, diaco_plantillascba.tipoVerificacion as Tipo,diaco_vaciadocba.created_at")
            ->where('diaco_sede.id_diaco_sede', '=', $usuario[0]->id)
            ->where('diaco_usuario.id_usuario','=',$usuario[0]->id_usuario)
            // ->where('diaco_asignarsedecba.estatus','=','0')
            ->get();
        }

        //dd($buson);

        return response()->json($buson);
    }
    public function GetFilterSubmit(Request $req){
            $buson = DB::table('diaco_asignarsedecba')
            ->join('diaco_name_template_cba','diaco_asignarsedecba.idPlantilla','=','diaco_name_template_cba.id')
            ->join('diaco_sede','diaco_asignarsedecba.idSede','=','diaco_sede.id_diaco_sede')
            ->join('diaco_usuario','diaco_sede.id_diaco_sede','=','diaco_usuario.id_sede_diaco')
            ->join('diaco_usuario as usuarioss','diaco_asignarsedecba.idUsuario','=','diaco_usuario.id_usuario')
            ->join('diaco_vaciadocba','diaco_vaciadocba.Ncorrelativo','=','diaco_asignarsedecba.correlativo')
            ->selectraw("
                                distinct
                                diaco_name_template_cba.id,
                                diaco_name_template_cba.NombreTemplate,
                                diaco_sede.nombre_sede,
                                (
                                    CASE
                                        WHEN (diaco_asignarsedecba.filtro = 2) THEN 'Ingresada'
                                        WHEN (diaco_asignarsedecba.filtro = 3) THEN 'Enviada'
                                        WHEN (diaco_asignarsedecba.filtro = 4) THEN 'Publicada'
                                        ELSE  'Asignada'
                                        END
                                ) as estatus,
                                diaco_usuario.nombre,
                                diaco_asignarsedecba.correlativo"
                            )
            ->where('diaco_asignarsedecba.estatus','=','1')
            ->where('diaco_asignarsedecba.idSede','=',$req->sede)
            ->Where('diaco_asignarsedecba.filtro','>','1')
            ->orderBy('diaco_asignarsedecba.correlativo', 'DESC')
            ->get();

        return response()->json($buson);
    }

    public function showEnviados(){

        return view('Ediciones.Enviados');
    }

    public function previewSubmit(){
        return view('Ediciones.previewSubmit');
    }


    public function getDepartament(){
            $Departamento = Departamento::all();
            return response()->json($Departamento, 200);
    }

    public function getMunicipioById(Request $request){
        $municipio = Municipio::where('codigo_departamento','=',$request->id)->get();
        return response()->json($municipio, 200);
    }

    public function getCountColumn(Request $request){
        $cantidad = NameTemplate::select('cantidadColmna as Columna')->where('id','=',$request->id)->get();

        // return (int)$cantidad[0]->Columna;
        return response()->json($cantidad, 200);
    }
    public function getCountColumnfindId($id){
        $cantidad = NameTemplate::select('cantidadColmna as Columna')->where('id','=',$id)->get();

        return (int)$cantidad[0]->Columna;
        // return response()->json($cantidad, 200);
    }

    public function createCorrelative($id){

            $sede = ListarAsignacion::select('diaco_sede.nombre_sede as sede','diaco_tipoverificacioncba.nombreVerificacion as tipo')
                                                    ->join('diaco_sede','idSede','=','diaco_sede.id_diaco_sede')
                                                    ->join('diaco_name_template_cba','idPlantilla','=','diaco_name_template_cba.id')
                                                    ->join('diaco_plantillascba','diaco_name_template_cba.NombreTemplate','=','diaco_plantillascba.NombrePlantilla')
                                                    ->join('diaco_tipoverificacioncba','diaco_plantillascba.tipoVerificacion','=','diaco_tipoverificacioncba.id_TipoVerificacion')
                                                    ->where('diaco_asignarsedecba.id_Asignacion','=',$id)
                                                    ->get();

            $Nsede = Str::substr($sede[0]->sede,0,2);
            $Ntipo = Str::substr($sede[0]->tipo,0,2);
            $date = Carbon::now('America/Guatemala');
            $date->toDateTimeString();
            $date->format('Y');
            $correlativo = $Nsede . '-' . $Ntipo . '-' . $date->isoFormat('Y') . '-' . $id;
            $correlativo = strtoupper($correlativo);
            return $correlativo;
            // return response()->json($correlativo, 200);
    }

    public function createLocal($nombre){

        $id="";
        $validar = $this->VerificarItem($nombre,'local','nombreEstablecimiento');
        if($validar === 0){
            // return response()->json(false, 200);
            $id = local::select('idEstablecimiento as code')->where('nombreEstablecimiento','=',$nombre)->get();
            // print $id[0]['code'];
            return $id[0]['code'];

        }else{
            $data = new local;
            $data->nombreEstablecimiento = $nombre;
            $data->status = 'A';
            $data->save();
            $id = $data->id;
            return $id;

        }
    }


    public function VerificarItem($nombre, $tabla,$campo){
        if ($tabla === 'local') {
            if (local::where($campo, '=', $nombre)->where('status','=','A')->exists()){
                return 0;
            }else{
                return 1;
            }
        }else if($tabla === 'market'){
            if (market::where($campo, '=', $nombre)->where('status','=','A')->exists()){
                return 0;
            }else{
                return 1;
            }
        }
    }


    // public function getCorrelativo($id){
    //     $correlativo = ListarAsignaciones::select('correlativo')
    //                                                         ->where()
    // }

}
