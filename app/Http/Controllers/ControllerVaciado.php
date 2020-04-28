<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\name_template;
use App\Models\templates;
use App\vaciadocba;


class ControllerVaciado extends Controller
{
    public function getNameTemplate($plantilla){
        
        $name = templates::select('diaco_productocba.nombre as producto','diaco_medida.nombre as medida','diaco_plantillascba.idMedida as code_measure')
            ->join('diaco_name_template_cba','diaco_name_template_cba.NombreTemplate','=','diaco_plantillascba.NombrePlantilla')
            ->join('diaco_asignarsedecba','diaco_asignarsedecba.idPlantilla','=','diaco_name_template_cba.id')
            ->join('diaco_productocba','diaco_productocba.id_producto','=','diaco_plantillascba.idProducto')
            ->join('diaco_medida','diaco_medida.id_medida','=','diaco_plantillascba.idMedida')
            ->where('diaco_asignarsedecba.correlativo',$plantilla)
            ->get();

        return response()->json($name,200);
    }

    public function getPricesTemplate($template){
        $prices = vaciadocba::selectRaw("diaco_vaciadocba.correlativo as code,diaco_productocba.id_producto as code_product,diaco_productocba.nombre as name_product,diaco_medida.id_medida as code_measure,diaco_medida.nombre as name_measure,CONCAT('Q ',CONVERT(decimal(18,2),diaco_vaciadocba.precioProducto)) as price_product,diaco_vaciadocba.id_Categoria as code_category")
            ->join('diaco_productocba','diaco_productocba.id_producto','=','diaco_vaciadocba.idProducto')
            ->join('diaco_medida','diaco_medida.id_medida','=','diaco_vaciadocba.idMedida')
            ->join('diaco_name_template_cba','diaco_name_template_cba.id','=','diaco_vaciadocba.idPlantilla')
            ->where('diaco_vaciadocba.Ncorrelativo',$template)
            // ->where('diaco_medida.id_medida',$measure)
            ->get();
        
        return response()->json($prices,200);

    }

    public function union(){
        $data = $this->getNameTemplate('CE-GA-2020-180');
        $res = $data->original[0]['code_measure'];

        $segundo = $this->getPricesTemplate('CE-GA-2020-180',$res);

        $response = [];
        foreach ($segundo->original as $key ) {
            array_push($response,
                [
                    [

                        "code:" => $key->code,
                        "code_product:" => $key->code_product,
                        "name_product" => $key->name_product,
                        "code_measure" => $key->code_measure,
                        "name_measure" => $key->name_measure,
                        "price_product" =>$key->price_product,
                        "code_category" =>$key->code_category,
                    ]
                ]);
        }
        return response()->json($response,200);
    }
}
