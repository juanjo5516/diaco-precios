<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categoria;
use App\Models\product;
use App\Models\subcategory;
use App\Models\measure;
use App\Models\market;
use App\Models\local;
use App\Models\smarket;
use App\responseData;
use App\TipoVisitaPlantilla;
use Illuminate\Support\Facades\DB;

class catalogos extends Controller
{
    public function dataCategory(){
        $categoria = categoria::select('id_Categoria','nombre')->where('status','=','A')->get();
        return $categoria;
    }

    public function deleteByIdCategory(Request $request){
        $deleteById = categoria::where('id_Categoria', $request->id)->update(['status' => 'I']);
        return $deleteById;
    }
    public function addCategory(Request $request){   

        $validar = $this->VerificarItem($request->names,'categoria','nombre');
        if($validar === 0){
            return response()->json(false, 200);
        }else{
            $data = DB::statement("exec addCategoria '" .$request->names. "'");
            if($data){
                return response()->json($data, 200);
            };
        }

        
    }

    public function UpdateById(Request $request){
        $updateById = categoria::where('id_Categoria', $request->id)->update(['nombre' => $request->name]);
        return response()->json($updateById, 200);
    }

    public function findAllProduct(){
        $product = product::select('id_producto as code','nombre as name')->where('status','=','A')->get();
        return response()->json($product, 200);
    }

    public function findByIdProduct($producto){
        $product = product::select('id_producto as code','nombre as name')->where('status','=','A')->where('id_producto','=',$producto)->get();
        return response()->json($product, 200);
        // return json_encode($product);
    }

    public function addProducto(Request $request){

        $validar = $this->VerificarItem($request->names,'producto','nombre');
        if($validar === 0){
            return response()->json(false, 200);
        }else{
            $data = DB::statement("exec AddProductoCba '" .$request->names. "'");
            if($data){
                return response()->json($data, 200);
            };
        }
    }

    public function deleteByIdProduct(Request $request){
        $deleteById = product::where('id_producto', $request->id)->update(['status' => 'I']);
        return response()->json($deleteById, 200);
    }

    public function updateByIdProduct(Request $request){
        $updateById = product::where('id_producto', $request->id)->update(['nombre' => $request->name]);
        return response()->json($updateById, 200);
    }

    public function findAllSubCategory(){
        $product = subcategory::select('id_sCategoria as code','nombre as name')->where('status','=','A')->get();
        return response()->json($product, 200);
    }

    public function addSubCategory(Request $request){
        $data = DB::statement("exec addSubCategoria '" .$request->names. "'");
        if($data){
            return response()->json($data, 200);
        };
    }
    public function deleteByIdSubCategory(Request $request){
        $deleteById = subcategory::where('id_sCategoria', $request->id)->update(['status' => 'I']);
        return response()->json($deleteById, 200);
    }

    public function updateByIdSubCategory(Request $request){
        $updateById = subcategory::where('id_sCategoria', $request->id)->update(['nombre' => $request->name]);
        return response()->json($updateById, 200);
    }

    public function findAllmeasure(){
        $product = measure::select('id_medida as code','nombre as name')->where('status','=','A')->get();
        return response()->json($product, 200);
    }

    public function findByIdmeasure($medida){
        $measure = measure::select('id_medida as codeMeasure','nombre as nameMeasure')->where('status','=','A')->where('id_medida','=',$medida)->get();
        return response()->json($measure, 200);
        // return json_encode($measure);
    }

    public function addmeasure(Request $request){
        $validar = $this->VerificarItem($request->names,'medida','nombre');
        if($validar === 0){
            return response()->json(false, 200);
        }else{
            $data = DB::statement("exec addMedidaCBA '" .$request->names. "'");
            if($data){
                return response()->json($data, 200);
            };
        }
    }

    public function deleteByIdmeasure(Request $request){
        $deleteById = measure::where('id_medida', $request->id)->update(['status' => 'I']);
        return response()->json($deleteById, 200);
    }

    public function updateByIdmeasure(Request $request){
        $updateById = measure::where('id_medida', $request->id)->update(['nombre' => $request->name]);
        return response()->json($updateById, 200);
    }
    public function findAllMarket(){
        $product = market::select('idMercado as code','nombreMercado as name','direccionMercado as address','departamento.nombre_departamento as departamento','municipio.nombre_municipio as municipio')
                                        ->join('departamento','departamento_id','=','departamento.codigo_departamento')
                                        ->join('municipio','municipio_id','=','municipio.codigo_municipio')
                                        ->where('status','=','A')->get();
                                        // ->join('diaco_name_template_cba','diaco_asignarsedecba.idPlantilla','=','diaco_name_template_cba.id')
        return response()->json($product, 200);
    }
    public function addMarket(Request $request){

        $validar = $this->VerificarItem($request->names,'lugar','nombreMercado');
        if($validar === 0){
            return response()->json(false, 200);
        }else{
            $data = new market;
            $data->nombreMercado = $request->names;
            $data->direccionMercado = $request->address;
            $data->departamento_id = $request->departamento_id;
            $data->municipio_id =  $request->municipio_id;
            $data->status = $request->status;
            
            if($data->save()){
                return response()->json(true, 200);
            };
        }

        
    }
    public function deleteByIdMarket(Request $request){
        $deleteById = market::where('idMercado', $request->id)->update(['status' => 'I']);
        return response()->json($deleteById, 200);
    }
    public function updateByIdMarket(Request $request){
        $updateById = market::where('idMercado', $request->id)->update(['nombreMercado' => $request->name, 'direccionMercado' => $request->address, 'departamento_id' => $request->departamento, 'municipio_id' => $request->municipio]);
        return response()->json($updateById, 200);
    }

    public function findAllLocal(){
        $product = local::select('idEstablecimiento as code','nombreEstablecimiento as name','direccionEstablecimiento as address','departamento.nombre_departamento as departamento','municipio.nombre_municipio as municipio')
                                    ->join('departamento','departamento_id','=','departamento.codigo_departamento')
                                    ->join('municipio','municipio_id','=','municipio.codigo_municipio')                            
                                    ->where('status','=','A')->get();
        return response()->json($product, 200);
    }

    public function addLocal(Request $request){

        $validar = $this->VerificarItem($request->names,'local','nombreEstablecimiento');
        if($validar === 0){
            return response()->json(false, 200);
        }else{
            $data = new local;
            $data->nombreEstablecimiento = $request->names;
            $data->direccionEstablecimiento = $request->address;
            $data->departamento_id = $request->departamento_id;
            $data->municipio_id = $request->municipio_id;
            $data->status = $request->status;
            
            if($data->save()){
                return response()->json(true, 200);
            };
        }
    }
    public function deleteByIdLocal(Request $request){
        $deleteById = local::where('idEstablecimiento', $request->id)->update(['status' => 'I']);
        return response()->json($deleteById, 200);
    }

    public function updateByIdLocal(Request $request){
        $updateById = local::where('idEstablecimiento', $request->id)->update(['nombreEstablecimiento' => $request->name, 'direccionEstablecimiento' => $request->address,  'departamento_id' => $request->departamento, 'municipio_id' => $request->municipio]);
        return response()->json($updateById, 200);
    }
    public function findAllSmarket(){
        $product = smarket::select('code','name','address')->where('status','=','A')->get();
        return response()->json($product, 200);
    }

    public function addSmarket(Request $request){
        $data = new smarket;
        $data->name = $request->names;
        $data->address = $request->address;
        $data->status = $request->status;
        if($data->save()){
            return response()->json($data, 200);
        };
    }
    public function deleteByIdSmarket(Request $request){
        $deleteById = smarket::where('code', $request->id)->update(['status' => 'I']); 
        return response()->json($deleteById, 200);
    }

    public function updateByIdSmarket(Request $request){
        $updateById = smarket::where('code', $request->id)->update(['name' => $request->name, 'address' => $request->address]);
        return response()->json($updateById, 200);
    }

    public function findAllVisit(){ 
        $product = TipoVisitaPlantilla::select('id_TipoVerificacion as code','nombreVerificacion as name')->where('status','=','A')->get();
        return response()->json($product, 200);
    }

    public function addSVisit(Request $request){

        $validar = $this->VerificarItem($request->names,'tipo','nombreVerificacion');
        if($validar === 0){
            return response()->json(false, 200);
        }else{
            DB::beginTransaction();
         try {
                $query = DB::statement("exec AddTipo :name",
                [
                    'name' => $request->names
                ]); 
             DB::commit();
             return response()->json(true, 200);
         } catch (\Exceptio $e) {
             DB::rollBack();
             print $e;
         }
        }
    }
    public function deleteByIdVisit(Request $request){
        $deleteById = TipoVisitaPlantilla::where('id_TipoVerificacion', $request->id)->update(['status' => 'I']);
        return response()->json($deleteById, 200);
    }

    public function updateByIdVisit(Request $request){
        $updateById = TipoVisitaPlantilla::where('id_TipoVerificacion', $request->id)->update(['nombreVerificacion' => $request->name]);
        return response()->json($updateById, 200);
    }


    public function getProductoAndMeasure(Request $request){
        $producto = $this->findByIdProduct($request->producto);
        $medida = $this->findByIdmeasure($request->medida);
        $array = array();
        for ($i=0; $i < 1; $i++) { 
             array_push($array,[
                'codeProducto' => $producto->original[0]->code,
                'nameProducto' => $producto->original[0]->name,
                'codeMedida' => $medida->original[0]->codeMeasure,
                'nameMedida' => $medida->original[0]->nameMeasure,
             ]);
        }
        return response()->json($array, 200);
    }

    public function VerificarItem($nombre, $tabla,$campo){
        if($tabla === 'producto'){
            if (product::where($campo, '=', $nombre)->where('status','=','A')->exists()){
                return 0;
            }else{
                return 1;
            }
        }elseif ($tabla === 'categoria') {
            if (categoria::where($campo, '=', $nombre)->where('status','=','A')->exists()){
                return 0;
            }else{
                return 1;
            }
        }elseif ($tabla === 'medida') {
            if (measure::where($campo, '=', $nombre)->where('status','=','A')->exists()){
                return 0;
            }else{
                return 1;
            }
        }elseif ($tabla === 'lugar') {
            if (market::where($campo, '=', $nombre)->where('status','=','A')->exists()){
                return 0; 
            }else{
                return 1;
            }
        }elseif ($tabla === 'local') {
            if (local::where($campo, '=', $nombre)->where('status','=','A')->exists()){
                return 0; 
            }else{
                return 1;
            }
        }elseif ($tabla === 'tipo') {
            if (TipoVisitaPlantilla::where($campo, '=', $nombre)->where('status','=','A')->exists()){
                return 0; 
            }else{
                return 1;
            }
        }
    }
    
}
