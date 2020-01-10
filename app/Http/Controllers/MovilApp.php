<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Fractal;
use App\Transformers\PricesData;
use App\Transformers\DataDepartamento;

class MovilApp extends Controller
{
    public function check(){
        $departments = DB::SELECT('exec VerifyActiveDepartments');
        $coordenadas = DB::SELECT('EXEC department_coordinates');
        $coordenadas = collect($coordenadas);
        // $coor = $coordenadas->where('code','=',2);

        foreach ($departments as $branche)
        {
            $codeDepart = $branche->code;
            // $sedes = DB::SELECT('exec getOfficesByDepartment :department',['department' => $codeDepart]);
            $sedes = $coordenadas->where('codigo_departamento','=',$codeDepart);
            $convert2 = collect($sedes);
            $responseSede2[] = [
                "data" => $convert2
            ];
            $convert = collect($sedes);
            foreach ($convert as $convertt)
            {
                // $data = DB::SELECT('exec getCategoriesForDepartament :sede',['sede' => $convertt->code]);
                $responseSede[] = [
                    'code' => $convertt->code,
                    'name' => $convertt->name,
                    'latitude' => $convertt->latitut,
                    'longitude' => $convertt->longitud,
                    'departamento' => $convertt->codigo_departamento,
                    // 'categories' =>$data
                ];
            }


        }
        /* $brancheData = collect($responseSede);
        foreach ($departments as $department){
            $branches = $department->code;
            $sedes = DB::SELECT('exec getOfficesByDepartment :department',['department' => $branches]);
            $data = $brancheData->where('departamento',$department->code);
            //codigo_departamento

            $response[] = [
                'code' => $department->code,
                'name' => $department->name,
                'sedes' => $data
            ];

        } */
        /* return fractal()
            ->collection($response)
            ->transformWith(new DataDepartamento())
            ->includeCharacters()
            ->toArray(); */

        return response()->json($responseSede, 200);
    }


}
