<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use Carbon\Carbon;

class menu extends Controller
{

    


    public function GetSelectMedida(){
        // $Cmedidas = DB::select('select * from medida');
        // $Ccategorias = DB::select('select * from categoriaCBA');
        // $Scategoria = DB::select('select * from subcategoriaCBA');
        //return view('admin.home',['Cmedidas' => $Cmedidas,'Ccategoria' => $Ccategorias,'s' => $Scategoria]);
        return view('admin.home');

    }

    /* Show tables */
    public function GetTabla(){
        DB::beginTransaction();
        try {
            $DataT = DB::table("productoCBA")
                                            ->select('productoCBA.nombre as Pnombre')->get();
            return datatables()->collection($DataT)->toJson();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            print $e;
        }
            
    }

    public function GetTablaC(){
        DB::beginTransaction();
        try {
            $DataT = DB::table("categoriaCBA")->select('id_Categoria as ID','nombre as Pnombre')->get();
            return datatables()->collection($DataT)->toJson();
            DB::commit();
        }catch (\Throwable $e) {
            DB::rollBack();
            print $e;
        }
    }

    public function GetTablaS(){
        DB::beginTransaction();
        try {
            $DataT = DB::table("subcategoriaCBA")->select('nombre as Pnombre')->get();
            return datatables()->collection($DataT)->toJson();
            DB::commit();
        }catch (\Throwable $e) {
            DB::rollBack();
            print $e;
        }
    }

    /*Add Data */
    public function addProductos(Request $request){
        DB::beginTransaction();

        if($request->nombreP != ""){
            try {
                $query = DB::statement("exec AddProductoCba '".$request->nombreP ."'");
                print $query;

                DB::commit();
            } catch (\Exceptio $e) {
                DB::rollBack();
                print $e;
            }
        }else{
            print 'No se puede ingresar, por falta de datos';
        }
    }

    public function addCategorias(Request $request){
        DB::beginTransaction();

        if($request->nombreP != ""){
            try {
                $query = DB::statement("exec addCategoria '" .$request->nombreP. "'");
                print $query;
                DB::commit();
            } catch(\Exceptio $e){
                DB::rollBack();
                print $e;
            }
        }else{
            print 'No se puede ingresar, por falta de datos';
        }
        
        
    }

    public function addSCategorias(Request $request){
        DB::beginTransaction();

        if($request->nombreP != ""){
            try {
                $query = DB::statement("exec addSubCategoria '" .$request->nombreP. "'");
                print $query;
                DB::commit();
            } catch(\Exceptio $e){
                DB::rollBack();
                print $e;
            }
        }else{
            print 'No se puede ingresar, por falta de datos';
        }
        
        
    }


    /* view */
    public function viewProducto(){
        return view ('menu.addProducto');
    }

    public function viewCateogira(){
        return view ('menu.addCategoria');
    }

    public function viewSubCategoria(){
        return view('menu.addSubCategoria');
    }

    public function UserLogin(){
        $user = DB::table('diaco_usuario')
                    ->join('diaco_sede','id_diaco_sede', '=', 'diaco_usuario.id_sede_diaco')->select('diaco_sede.nombre_sede as sede','diaco_usuario.nombre')->where('diaco_usuario.id_usuario', '=', 1)->get();
        return $user;
    }
    
    public function VaciadoMercado(){
        $date = Carbon::now();
        $nusuario = $this->UserLogin();
        $date = $date->format('d-m-Y');
        $categoria = DB::table("categoriaCBA")->select('id_Categoria as id','nombre as nombre')->get();
        $producto = DB::table("productoCBA")->select('id_producto as id','nombre as Pnombre')->get();
        $medida = DB::table('medida')->select('id_medida as id','nombre as nombre')->get();
        return view('menu.addMercado',['fecha' => $date,'Nsede' => $nusuario,'collection' => $categoria, 'producto' => $producto,
        'medida' => $medida]);
    }

    
}

/*

SELECT usuario.*,sede.nombre_sede FROM diaco_usuario usuario
	inner join diaco_sede sede
        ON sede.id_diaco_sede = usuario.id_sede_diaco


        DB::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get();
        */