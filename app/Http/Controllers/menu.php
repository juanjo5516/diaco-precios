<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use Carbon\Carbon;
use Alert;

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

    public function GetTablaM(){
        DB::beginTransaction();
        try {
            $DataT = DB::table("medida")->select('nombre as Pnombre')->get();
            return datatables()->collection($DataT)->toJson();
            DB::commit();
        }catch (\Throwable $e) {
            DB::rollBack();
            print $e;
        }
    }

    public function GetChangeAddress(Request $request){
        DB::beginTransaction();
        try {
            $DataT = DB::table('mercadoCBA')->select('direccionMercado as direccion')->where('idMercado', '=', $request->mercadoVaciado)->get();
            return $DataT;
            DB::commit();
        }catch (\Throwable $e) {
            DB::rollBack();
            print $e;
        }
    }

    public function GetChangeAddressEstablecimiento(Request $request){
        DB::beginTransaction();
        try {
            $DataT = DB::table('EstablecimientoCBA')->select('direccionEstablecimiento as direccion')->where('idEstablecimiento', '=', $request->establecimientoVaciado)->get();
            return $DataT;
            DB::commit();
        }catch (\Throwable $e) {
            DB::rollBack();
            print $e;
        }
    }
    public function GetTablaMercado(){
        DB::beginTransaction();
        try {
            $DataT = DB::table("mercadoCBA")->select('nombreMercado as ID','direccionMercado as Pnombre')->get();
            return datatables()->collection($DataT)->toJson();
            DB::commit();
        }catch (\Throwable $e) {
            DB::rollBack();
            print $e;
        }
    }

    public function GetTablaEstablecimiento(){
        DB::beginTransaction();
        try {
            $DataT = DB::table("EstablecimientoCBA")->select('nombreEstablecimiento as ID','direccionEstablecimiento as Pnombre')->get();
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

    public function addMedidas(Request $request){
        DB::beginTransaction();

        if($request->nombreP != ""){
            try {
                $query = DB::statement("exec addMedidaCBA '" .$request->nombreP. "'");
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

    public function addDetalleMercados(Request $request){
        DB::beginTransaction();

        if($request->nombreM != ""){
            try {
                $query = DB::insert('INSERT INTO mercadoCBA(nombreMercado, direccionMercado) values (?, ?)', [$request->nombreM, $request->direccionM]);
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

    public function AddDestablecimiento(Request $request){
        DB::beginTransaction();

        if($request->nombreM != ""){
            try {
                $query = DB::insert('INSERT INTO EstablecimientoCBA(nombreEstablecimiento, direccionEstablecimiento) values (?, ?)', [$request->nombreM, $request->direccionM]);
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
    

    public function AddMercadoVaciado(Request $request){
         DB::beginTransaction();
       
         $valor = sizeof($request->Dproducto);
         try {
             for ($i=0; $i  < $valor ; $i++) { 
                $query = DB::statement("exec AddVaciado :fecha,:sede,:verificador,:mercado,:NombreMercado,:direccionMercado,:categoria,:establecimiento,:direccionEstablecimiento,:Dproducto,:Dmedida,:Dprecio",
                [
                    'fecha' => $request->fechaVaciado,
                    'sede' => $request->sedeVaciado,
                    'verificador' => $request->verificadorVaciado,
                    'mercado' => 1,
                    'NombreMercado' => $request->mercadoVaciado,
                    'direccionMercado' => $request->direccionMercadoVaciado,
                    'categoria' => $request->categoriaVaciado,
                    'establecimiento' => $request->establecimientoVaciado,
                    'direccionEstablecimiento' => $request->direccionEstablecimientoVaciado,
                    'Dproducto' => $request->Dproducto[$i],
                    'Dmedida' => $request->Dmedida[$i],
                    'Dprecio' => $request->precio[$i]
                ]); 
             } 
             print $query; 
             DB::commit();
         } catch (\Exceptio $e) {
             DB::rollBack();
             print $e;
         }
    }


    /* view  */
    public function viewProducto(){
        return view ('menu.addProducto');
    }

    public function viewMercado(){
        return view ('menu.addDetalleMercado');
    }

    public function viewCateogira(){
        return view ('menu.addCategoria');
    }

    public function viewSubCategoria(){
        return view('menu.addSubCategoria');
    }

    public function viewEstablecimiento(){
        return view('menu.addEstablecimiento');
    }

    public function viewMedida(){
        return view('menu.addMedida');
    }
    public function UserLogin(){
        $user = DB::table('diaco_usuario')
                    ->join('diaco_sede','id_diaco_sede', '=', 'diaco_usuario.id_sede_diaco')->select('diaco_sede.id_diaco_sede as id','diaco_sede.nombre_sede as sede','diaco_usuario.nombre','diaco_usuario.id_usuario as id_usuario')->where('diaco_usuario.id_usuario', '=', 1)->get();
        return $user;
    }
    
    public function VaciadoMercado(){
        $date = Carbon::now();
        $nusuario = $this->UserLogin();
        $date = $date->format('d-m-Y');
        $categoria = DB::table("categoriaCBA")->select('id_Categoria as id','nombre as nombre')->get();
        $producto = DB::table("productoCBA")->select('id_producto as id','nombre as Pnombre')->get();
        $medida = DB::table('medida')->select('id_medida as id','nombre as nombre')->get();
        $mercado = DB::table('mercadoCBA')->select('idMercado as id','nombreMercado as nombre','direccionMercado as direccion')->get();
        $establecimiento = DB::table('EstablecimientoCBA')->select('idEstablecimiento as id','nombreEstablecimiento as nombre','direccionEstablecimiento as direccion')->get();
        return view('menu.addMercado',
        [
            'fecha' => $date,
            'Nsede' => $nusuario,
            'collection' => $categoria, 
            'producto' => $producto,
            'medida' => $medida,
            'mercado' => $mercado,
            'establecimiento' => $establecimiento
        ]);
    }

}