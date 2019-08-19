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

    public function getIdDepartamento(){
        $FiltroDepartamentos = DB::select("SELECT distinct sede.id_diaco_sede,sede.codigo_municipio,sede.nombre_sede,muni.nombre_municipio,
                                            depa.codigo_departamento,depa.nombre_departamento,
                                            coordenada.latitut, coordenada.longitud
                                        FROM diaco_sede sede
                                            INNER JOIN municipio muni
                                                ON muni.codigo_municipio = sede.codigo_municipio
                                            INNER JOIN departamento depa
                                                ON depa.codigo_departamento = muni.codigo_departamento
                                            INNER JOIN diaco_coordenadas_cba coordenada
		                                        ON coordenada.id_sede = sede.id_diaco_sede
                                            INNER JOIN diaco_usuario usuario
                                                ON usuario.id_sede_diaco = sede.id_diaco_sede
                                            INNER JOIN diaco_vaciadocba vaciado
                                                ON vaciado.idVerificador = usuario.id_usuario
                                            WHERE id_diaco_sede in (SELECT idSede FROM diaco_asignarsedecba
                                            WHERE idPlantilla = (SELECT distinct idPlantilla FROM diaco_vaciadocba 
                                                                    WHERE idPlantilla = (SELECT DISTINCT idPlantilla FROM diaco_vaciadocba))
                                                and estatus = 1)");
        return $FiltroDepartamentos;
    }
    public function getApi()
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
                                                
        $dep = $this->getIdDepartamento();

        $array_departamentos = [];
        $array_sede= [];

        
        foreach ($departamentos as $departamento) {
            $sedes = $departamento->sede;

            
                // array_push($array_sede,[
                //     // "v" => $departamento->sede()->select('id_diaco_sede')->get()
                //     "v" => $k->code
                // ]);
            
            foreach ($dep as $key) {
                foreach($sedes as $idSede){
                    if($departamento->codigo_departamento == $key->codigo_departamento)  {
                        if($idSede->code == $key->id_diaco_sede){
                            
                            array_push($array_departamentos,
                            [
                                [
                                    "code" => $departamento->codigo_departamento,
                                    "name" => $departamento->nombre_departamento,
                                    "branch" => $idSede,
                                    "category" => $cate,
                                    "latitude" => $key->latitut,
                                    "longitude" => $key->longitud
                                    ]
                            ]);
                        }
                    }  
                }  
            }

        }


        return response()->json($array_departamentos, 200);
        // return response()->json($array_departamentos, 200); 
    }

}
