<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Transformers\PricesData;
use League\Fractal;
use App\User;
// use League\Fractal\Resource\Collection;
use App\Models\pricesModel;
use Illuminate\Support\Collection;

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


    // function __construct( )
    // {
    //     $this->fractal = new Fractal\Manager();
    //     $this->dataTransformer = new PricesData;
    // }

    public function getPriceLast($id,$idCatetoria){
        $date = Carbon::now('America/Guatemala');
        $date->toDateTimeString();

        $date_last = $date->addDay(1);

        $last_price = DB::table('diaco_vaciadocba')
                        ->join('diaco_productocba','diaco_productocba.id_producto','=','diaco_vaciadocba.idProducto')
                        ->join('diaco_medida','diaco_medida.id_medida','=','diaco_vaciadocba.idMedida')
                        ->join('diaco_usuario','diaco_usuario.id_usuario','=','diaco_vaciadocba.idVerificador')
                        ->join('diaco_sede','diaco_sede.id_diaco_sede','=','diaco_usuario.id_sede_diaco')
                        ->join('diaco_plantillascba','diaco_plantillascba.idProducto','=','diaco_vaciadocba.idProducto')
                        ->join('diaco_categoriacba','diaco_categoriacba.id_Categoria','=','diaco_plantillascba.idCategoria')
                        ->selectraw('diaco_medida.id_medida as idMedida, diaco_productocba.id_producto as code,diaco_productocba.nombre as articulo,diaco_medida.nombre as medida,getdate() as fecha_Actual,avg(diaco_vaciadocba.precioProducto) as price')
                        ->where('diaco_vaciadocba.created_at','<=', $date_last)
                        ->where('diaco_categoriacba.id_Categoria','=',$idCatetoria)
                        ->where('diaco_sede.id_diaco_sede','=',$id)
                        ->groupBy('diaco_productocba.nombre','diaco_medida.nombre','diaco_productocba.id_producto','diaco_medida.id_medida')
                        ->orderByRaw('diaco_productocba.id_producto')
                        ->get();
    
        // return response()->json($last_price, 200);
        return $last_price;
    }

    public function getPricePrevious($id,$idCatetoria){
        $date = Carbon::now('America/Guatemala');
        $date->toDateTimeString();
        $date_previous = $date->subHours(3);
        
        $previous_price = DB::table('diaco_vaciadocba')
                        ->join('diaco_productocba','diaco_productocba.id_producto','=','diaco_vaciadocba.idProducto')
                        ->join('diaco_medida','diaco_medida.id_medida','=','diaco_vaciadocba.idMedida')
                        ->join('diaco_usuario','diaco_usuario.id_usuario','=','diaco_vaciadocba.idVerificador')
                        ->join('diaco_sede','diaco_sede.id_diaco_sede','=','diaco_usuario.id_sede_diaco')
                        ->join('diaco_plantillascba','diaco_plantillascba.idProducto','=','diaco_vaciadocba.idProducto')
                        ->join('diaco_categoriacba','diaco_categoriacba.id_Categoria','=','diaco_plantillascba.idCategoria')
                        ->selectraw('diaco_productocba.id_producto as code,DATEADD(hour,-3,getdate()) as fecha_Actual,avg(diaco_vaciadocba.precioProducto) as price')
                        ->where('diaco_vaciadocba.created_at','<=', $date_previous)
                        ->where('diaco_categoriacba.id_Categoria','=',$idCatetoria)
                        ->where('diaco_sede.id_diaco_sede','=',$id)
                        ->groupBy('diaco_productocba.nombre','diaco_medida.nombre','diaco_productocba.id_producto')
                        ->orderByRaw('diaco_productocba.id_producto')
                        ->get();
    
        // return response()->json($previous_price, 200);
        return $previous_price;
    }

    public function apiPrice($id,$idCategoria){

        $last = $this->getPriceLast($id,$idCategoria);
        $previous = $this->getPricePrevious($id,$idCategoria);
   

        $array_price = [];

        foreach ($last as $prices) {
            $nivel2 = $last->where('code',$prices->code);
            foreach($previous as $prev){
                if($prices->code == $prev->code){
                    array_push($array_price,
                    [
                        
                        [
                                [
                                    'code' =>$prices->code,
                                    'name' => $prices->articulo,
                                    'uom' => $nivel2
                                    // [
                                    //     'code' => $prices->idMedida,
                                    //     'name' => $prices->medida,
                                    //     'current_date' => $prices->fecha_Actual,
                                    //     'actual_price' => $prices->price,
                                    //     'previous_price' =>$prev->price,
                                    //     'previous_date' => $prev->fecha_Actual
                                    // ]
                                ]
                        ]
                    ]);
                }
            }
        }
        
        return response()->json($array_price, 200);

    }

    // apirest de diaco
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
                                                                    WHERE idPlantilla = (SELECT DISTINCT idPlantilla FROM diaco_vaciadocba)))");
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
    // *********************************************

    

}
