<?php

namespace App\Http\Controllers; 

use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Fractal;
use App\Transformers\PricesData;
use App\Transformers\DataDepartamento;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class MovilApp extends Controller
{
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
        $getDataPrices = DB::select('exec getPriceWeekly :sede, :categoria',['sede' => $id, 'categoria' => $idCategoria]);
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
        ->transformWith(new PricesData())
        ->includeCharacters()
        ->toArray();

    }


    function array_unique2($a)
    {
        $n = array();
        foreach ($a as $k=>$v) if (!in_array($v,$n))$n[$k]=$v;
        return $n;
    }
}


