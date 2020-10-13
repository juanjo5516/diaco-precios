<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use http\Client\Response;
use Illuminate\Support\Facades\DB;
use League\Fractal;
use App\Transformers\preciosPublicos;
use App\Transformers\PublicDepartament;
use Illuminate\Support\Collection;
use App\Model\Precios;
use Carbon\Carbon;

class InfoPublic extends Controller
{
    public function index(){
        return view('public.index'); 
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
            ->transformWith(new PublicDepartament()) 
            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer()) 
            ->toArray();
        
    }

    public function getPriceMorning($id,$idCatetoria){
        $date = Carbon::now('America/Guatemala');
        $date->toDateTimeString();
        $date_last = $date->addDay(1);//obtiene el dia siguiente del actual
        $last_price = DB::table('diaco_vaciadocba')
                        ->distinct()
                        ->join('diaco_productocba','diaco_productocba.id_producto','=','diaco_vaciadocba.idProducto')
                        ->join('diaco_medida','diaco_medida.id_medida','=','diaco_vaciadocba.idMedida')
                        ->join('diaco_usuario','diaco_usuario.id_usuario','=','diaco_vaciadocba.idVerificador')
                        ->join('diaco_sede','diaco_sede.id_diaco_sede','=','diaco_usuario.id_sede_diaco')
                        ->join('diaco_plantillascba','diaco_plantillascba.idProducto','=','diaco_vaciadocba.idProducto')
                        ->join('diaco_categoriacba','diaco_categoriacba.id_Categoria','=','diaco_plantillascba.idCategoria')
                        ->selectraw('diaco_productocba.id_producto as code,diaco_productocba.nombre as articulo')
                        ->where('diaco_vaciadocba.created_at','<=', $date_last)
                        ->where('diaco_categoriacba.id_Categoria','=',$idCatetoria)
                        ->where('diaco_sede.id_diaco_sede','=',$id)
                        ->groupBy('diaco_productocba.nombre','diaco_productocba.id_producto')
                        ->orderByRaw('diaco_productocba.id_producto')
                        ->get();
        return $last_price; 
    }

    public function apiPrice_app($id,$idCategoria){

        

        $last = $this->getPriceMorning($id,$idCategoria);
        $getDataPrices = DB::select('exec getPricePublic :sede, :categoria',['sede' => $id, 'categoria' => $idCategoria]);
        $convert = collect($getDataPrices); 
        $array_n2 = array();
        foreach ($last as $nivel1) {
            foreach($getDataPrices as $nivel2){
                if($nivel1->code  == $nivel2->code){
                    $data = $convert->where('code',$nivel1->code);
                    $array_n2[] = [
                        'code' =>$nivel1->code,
                        'name' => $nivel1->articulo,
                        'uom' => $data
                    ];
                    
                }
            }
        }
        
        // $codigo = $this->array_unique2($array_n2);
        return fractal() 
        ->collection($array_n2)
        ->transformWith(new preciosPublicos())
        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer()) 
        ->toArray();

    }

    public function price_view(Request $request){
        // $data = Precios::selectraw('medida,articulo,CONVERT(DECIMAL(10,2),ROUND(max(precio_anterior),2,0)) as precio')->where(['sede_uno' => $request->sede, 'categoria_uno' => $request->categoria,'sede_dos' => $request->sede,'categoria_dos' => $request->categoria])
        // ->groupBy('medida','articulo')
        $data = Precios::selectraw('idMedida as code, medida')->where(['sede_uno' => $request->sede, 'categoria_uno' => $request->categoria,'sede_dos' => $request->sede,'categoria_dos' => $request->categoria, 'code' => $request->code])
        ->groupBy('medida','idMedida')
        ->get();

        return response()->json($data,200);
    }

    public function price_view_Category(Request $request){
        $data = Precios::selectraw('code, articulo')->where(['sede_uno' => $request->sede, 'categoria_uno' => $request->categoria,'sede_dos' => $request->sede,'categoria_dos' => $request->categoria])
        ->groupBy('code','articulo')
        ->get();

        return response()->json($data,200);
    }

    public function price_viewFilter(Request $request){
        $data = Precios::selectraw('medida,articulo,CONVERT(DECIMAL(10,2),ROUND(max(precio_anterior),2,0)) as precio')->where(['sede_uno' => $request->sede, 'categoria_uno' => $request->categoria,'sede_dos' => $request->sede,'categoria_dos' => $request->categoria, 'idMedida' => $request->idMedida, 'code' => $request->code])
        ->groupBy('medida','articulo')
        ->get();

        return response()->json($data,200);
    }

    public function chartPublic(Request $request){
        
        $data = Precios::selectraw("CONVERT(DECIMAL(10,2),ROUND(precio_anterior,2,0)) as precio,
        (case month(fecha_uno)
            when  1 then concat('Enero',' ',year(fecha_uno))
            when  2 then concat('Febrero',' ',year(fecha_uno))
            when  3 then concat('Marzo',' ',year(fecha_uno))
            when  4 then concat('Abril',' ',year(fecha_uno))
            when  5 then concat('Mayo',' ',year(fecha_uno))
            when  6 then concat('Junio',' ',year(fecha_uno))
            when  7 then concat('Julio',' ',year(fecha_uno))
            when  8 then concat('Agosto',' ',year(fecha_uno))
            when  9 then concat('Septiembre',' ',year(fecha_uno))
            when  10 then concat('Octubre',' ',year(fecha_uno))
            when  11 then concat('Noviembre',' ',year(fecha_uno))
            when  12 then concat('Diciembre',' ',year(fecha_uno))
        END) mes,
        year(fecha_uno) as fecha
        ")->where((['sede_uno' => $request->sede, 'sede_dos' => $request->sede,'categoria_uno' => $request->categoria, 'categoria_dos' => $request->categoria,'idMedida' => $request->medida,'code' => $request->code ]))
        // ")->where((['sede_uno' => $request->sede, 'sede_dos' => $request->sede,'categoria_uno' => $request->categoria, 'categoria_dos' => $request->categoria,'idMedida' => $request->medida['code'], 'articulo' => $request->medida['medida'] ]))
        ->groupBy('fecha_uno','precio_anterior')
        ->orderBy('fecha','asc')
        ->distinct()->get();

        return response()->json($data,200);
    }


    function array_unique2($a)
    {
        $n = array();
        foreach ($a as $k=>$v) if (!in_array($v,$n))$n[$k]=$v;
        return $n;
    }
}
