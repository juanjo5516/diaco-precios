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
        // $Producto = DB::table('vaciadoCBA')->join('productoCBA','productoCBA.id_producto','=','vaciadoCBA.id_producto')
        // ->select('vaciadoCBA.precio','productoCBA.nombre')
        // ->groupBy('productoCBA.nombre')
        // ->get();

        $Producto = DB::select('SELECT avg(v.precio) as precio,p.nombre FROM vaciadoCBA v INNER JOIN productoCBA p ON p.id_producto = v.id_producto  GROUP BY p.nombre');
        $array[] = ['Gender', 'Number'];
        foreach($Producto as $key => $value)
        {
        $array[++$key] = [$value->nombre, (int)$value->precio];
        }

        return view('menu.dashboard')->with('chart', json_encode($array));
        //return $Producto;
    }
}
