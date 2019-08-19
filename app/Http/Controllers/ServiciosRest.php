<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Support\Facades\DB;

class ServiciosRest extends Controller
{
    public function ApiRest(){
        $departamentos = Departamento::all();
        // $municipio = Municipio::all();
        $array_departamentos = [];
        foreach($departamentos as $key => $departamento){
            array_push($array_departamentos,
                [
                    [
                        "code:" => $departamento->codigo_departamento,
                        "name:" => $departamento->nombre_departamento,
                        "locations" => $departamento->municipio()->select('codigo_municipio as code','nombre_municipio as name')->get()
                    ]
                ]);
        }
        return response()->json($array_departamentos, 200);      
    }

    // public function getSede(){
    //     $departamentos = Departamento::all();
    //     $array_departamentos = [];
        
    //     foreach ($departamentos as $key => $departamento) {
    //         if($departamento->sede()->select('id_diaco_sede as code','nombre_sede as name')->get() == ""){
    //             array_push($array_departamentos,
    //             [
    //                 [
    //                     "code" => $departamento->codigo_departamento,
    //                     "name" => $departamento->nombre_departamento,
    //                     "locations" => $departamento->sede()
    //                                     ->select('id_diaco_sede as code','nombre_sede as name')
    //                                     ->get()
    //                 ]
    //             ]);
    //         }
    //     }
    //     return response()->json($array_departamentos, 200); 
    // }
    
    public function getSede()
    {
        $departamentos = Departamento::with('sede')
            ->whereHas('sede')
            ->get();
        

        

        $cate = DB::select("SELECT distinct categoria.id_Categoria as code, categoria.nombre as name FROM diaco_plantillascba plantilla
		                            INNER JOIN diaco_categoriacba categoria
		                                    ON categoria.id_Categoria = plantilla.idCategoria
	                                WHERE plantilla.NombrePlantilla = (SELECT NombreTemplate FROM diaco_name_template_cba
								                WHERE id = (SELECT distinct idPlantilla FROM diaco_vaciadocba 
												WHERE idPlantilla = (SELECT DISTINCT idPlantilla FROM diaco_vaciadocba))) ");

        $array_departamentos = [];
        
        foreach ($departamentos as $departamento) {
        	$sedes = $departamento->sede;
                array_push($array_departamentos,
                [
                    [
                        "code" => $departamento->codigo_departamento,
                        "name" => $departamento->nombre_departamento,
                        "branch" => $sedes,
                        "category" => $cate
                    ]
                ]);
         
        }
        return response()->json($array_departamentos, 200); 
    }

}
