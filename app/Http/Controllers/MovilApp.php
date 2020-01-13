<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Fractal;
use App\Transformers\PricesData;
use App\Transformers\DataDepartamento;

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

        
        // return view('api.check',[
        //     'data'      =>  $response
        // ]);
        return fractal()
            ->collection($response)
            ->transformWith(new DataDepartamento())
            ->includeCharacters()
            ->toArray();
        
    }


}
