<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;

class menu extends Controller
{



    public function GetSelectMedida(){
        // $Cmedidas = DB::select('select * from medida');
        // $Ccategorias = DB::select('select * from categoriaCBA');
        // $Scategoria = DB::select('select * from subcategoriaCBA');
        //return view('admin.home',['Cmedidas' => $Cmedidas,'Ccategoria' => $Ccategorias,'s' => $Scategoria]);
        return view('admin.home');

    }

    public function GetTabla(){
        $DataT = DB::table("productoCBA")
                                        ->select('productoCBA.id_producto as ID','productoCBA.nombre as Pnombre')->get();
        return datatables()->collection($DataT)->toJson();
    }


    public function addProductos(Request $request){
        $query = DB::statement("exec AddProductoCba '".$request->nombreP ."',".$request->medidaP.",".$request->CategoriaP.",".$request->SCategoriaP);
        print $query;

    }


}
