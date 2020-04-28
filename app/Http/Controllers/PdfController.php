<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    public function getPdf($id){
        
        return view('pdf.pdfDemo',[
            'id' => $id
        ]);
    }

    public function getInfoUser(){
        $date = Carbon::now();
        $date = $date->format('d-m-Y');
        $user2 = Auth::user();
        $user = DB::table('diaco_usuario')
                    ->join('diaco_sede','id_diaco_sede', '=', 'diaco_usuario.id_sede_diaco')
                    ->select('diaco_sede.id_diaco_sede as id','diaco_sede.nombre_sede as sede','diaco_usuario.nombre as usuario','diaco_usuario.id_usuario as id_usuario')
                    ->where('diaco_usuario.id_usuario', '=', $user2->id_usuario)->get();
        
        $array_n2 = array();
        foreach ($user as $userInfo) {
            // foreach($getDataPrices as $nivel2){                    
                    // if($nivel1->code  == $nivel2->code){
                        // $data = $convert->where('code',$nivel1->code);
                        
                                array_push($array_n2,[
                                    'id' =>$userInfo->id,
                                    'sede' => $userInfo->sede,
                                    'usuario' => $userInfo->usuario,  
                                    'usuario_id' => $userInfo->id_usuario,
                                    'date' => $date
                                ]);

                    // }
            // }
        }

        return response()->json($array_n2, 200);
    }

    public function getCategoria(Request $request){
        $categoria = DB::table('diaco_plantillascba')
                            ->selectraw('distinct diaco_categoriacba.nombre as categoria')
                            ->join('diaco_categoriacba','id_Categoria','=','idCategoria')
                            ->join('diaco_productocba','id_producto','=','idProducto')
                            ->join('diaco_medida','id_medida','=','idMedida')
                            ->join('diaco_name_template_cba','NombreTemplate','=','NombrePlantilla')
                            ->where('diaco_name_template_cba.id',$request->id)
                            ->get();
        // return $categoria;

return response()->json($categoria, 200);    }


public function getPlantillas(Request $request){
    $query = DB::table('diaco_plantillascba')
    ->selectraw("diaco_plantillascba.idCategoria as idCategoria,diaco_medida.id_medida as idmedida,diaco_plantillascba.NombrePlantilla,diaco_plantillascba.created_at,diaco_categoriacba.nombre as categoria,diaco_productocba.nombre as produto,diaco_medida.nombre as medida, diaco_productocba.id_producto as producto,diaco_plantillascba.tipoVerificacion")
    ->join('diaco_categoriacba','id_Categoria','=','idCategoria')
    ->join('diaco_productocba','id_producto','=','idProducto')
    ->join('diaco_medida','id_medida','=','idMedida')
    ->join('diaco_name_template_cba','NombreTemplate','=','NombrePlantilla')
    ->where('diaco_name_template_cba.id',$request->id)
    ->get();
    return response()->json($query, 200);
    
}

public function github (){
    // return \PDF::loadFile('http://www.github.com')->stream('github.pdf'); 
        return \PDF::loadFile('http://www.github.com')->inline('github.pdf');
    }
}