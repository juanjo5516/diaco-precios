<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Datatables;
use Carbon\Carbon;
use Charts;

class ChartController extends Controller
{
    /* SELECT year(VAC.fecha),VAC.precio,PRO.nombre FROM vaciadoCBA VAC
	INNER JOIN productoCBA PRO
	ON PRO.id_producto = VAC.id_producto
	WHERE VAC.id_producto = 6
 */
    function ChartProductos(){
        $Producto = DB::table('vaciadoCBA')->join('productoCBA','productoCBA.id_producto','=','vaciadoCBA.id_producto')
        ->select('vaciadoCBA.fecha','vaciadoCBA.precio','productoCBA.nombre')
        ->where('vaciadoCBA.id_producto','=',6)
        ->get();

        $array[] = ['Gender', 'Number'];
        foreach($Producto as $key => $value)
        {
        $array['data'.++$key] = [$value->nombre, $value->precio];
        }
        //return view('menu.dashboard')->with('chart', json_encode($array));


        // $chart = Charts::create('pie', 'highcharts')
        //     ->title('My nice chart')
        //     ->labels(['First', 'Second', 'Third'])
        //     ->values($Producto[0])
        //     ->dimensions(1000,500)
        //     ->responsive(false);
            
        return view('menu.dashboard')->with('chart', json_encode($array));
        //return $Producto;
    }
}
