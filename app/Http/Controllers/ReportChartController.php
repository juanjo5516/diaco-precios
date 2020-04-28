<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportChartController extends Controller
{
    public function submitData(){
        return view('chart.submitData');
    }

    public function getCountSubmit(){
        $data = DB::select(' 
        select distinct  ds.id_diaco_sede as code, ds.nombre_sede as name, count(da.idSede) as cantidad
        from diaco_asignarsedecba da
        INNER JOIN diaco_sede ds on da.idSede = ds.id_diaco_sede
        WHERE da.filtro = 3
        group by ds.id_diaco_sede, ds.nombre_sede
        ');
 
        return response()->json($data, 200);
    }
}
