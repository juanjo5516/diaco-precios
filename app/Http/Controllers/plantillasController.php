<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\EdicionPlantilla;
use App\NameTemplate;
use App\ListarAsignacion;

class plantillasController extends Controller
{

  

    public function Asede(){
        $Lista = $this->ListarAsignaciones();
        $Plantillas = DB::table('NAME_TEMPLATE_CBA')->select('id','NombreTemplate')->get();
        $sede = DB::table('diaco_sede')->select('id_diaco_sede', 'nombre_sede')->get(); 
     
        return view('Ediciones.sedes',
        [
            'Coleccion' => $Lista,
            'Plantillas' => $Plantillas,
            'Sedes' =>$sede
        ]);
    }
    // select distinct NombrePlantilla from plantillasCBA
    
    public function index(){
        $date = Carbon::now();
        $date = $date->format('d-m-Y');
        $categoria = DB::table("categoriaCBA")->select('id_Categoria as id','nombre as nombre')->get()->toJson(JSON_PRETTY_PRINT);
        $producto = DB::table("productoCBA")->select('id_producto as id','nombre as Pnombre')->get();
        $medida = DB::table('medida')->select('id_medida as id','nombre as nombre')->get();
        //dd($categoria);
        return view('Ediciones.index',
        [
            'fecha' => $date,
            'collection' => $categoria, 
            'producto' => $producto,
            'medida' => $medida
        ]);
    }

    public function VerificarIdTemplate($nombre){
       
        if (NameTemplate::where('NombreTemplate', '=', $nombre)->exists()){
            return 0;
        }else{
            try {
                $Template = new NameTemplate;
                $Template->NombreTemplate = $nombre ;
                $Template->estado = 1;
                $Template->save();
                return $TemplateId = $Template->id;
            } catch (\Exceptio $e) {
                return $e;
            }
        }
    }

   
    public function store(Request $request){
        $TIMESTAMP = Carbon::now();

        DB::beginTransaction();
        $valor = sizeof($request->Dproducto);
        
        $validar = $this->VerificarIdTemplate($request->Nplantilla);
        if ($validar != 0) {
            try {
                for ($i=0; $i < $valor; $i++) { 
                    
                    $Edicion = new EdicionPlantilla;
     
                    $Edicion->NombrePlantilla = $request->Nplantilla;
                    $Edicion->idCategoria  = $request->categoriaVaciado;
                    $Edicion->idProducto  = $request->Dproducto[$i];
                    $Edicion->idMedida  = $request->Dmedida[$i];
                    $Edicion->estado  = 1;
                    $Edicion->created_at = $TIMESTAMP;
                    $Edicion->save();
    
                }
                print 1;
                DB::commit();     
            } catch (\Exceptio $e) {
                DB::rollBack();
                print $e;
            }  
        }else{
            try {
                for ($i=0; $i < $valor; $i++) { 
                    
                    $Edicion = new EdicionPlantilla;
     
                    $Edicion->NombrePlantilla = $request->Nplantilla;
                    $Edicion->idCategoria  = $request->categoriaVaciado;
                    $Edicion->idProducto  = $request->Dproducto[$i];
                    $Edicion->idMedida  = $request->Dmedida[$i];
                    $Edicion->estado  = 1;
                    $Edicion->created_at = $TIMESTAMP;
                    $Edicion->save();
    
                }
                print 1;
                DB::commit();     
            } catch (\Exceptio $e) {
                DB::rollBack();
                print $e;
            } 
        }
    }

    public function ListarAsignaciones(){
        $Listar = new ListarAsignacion;

        return $Listar->all();
         
    }

    public function storeLista(Request $request){
        $TIMESTAMP = Carbon::now();

        $Lista = new ListarAsignacion;
     
        $Lista->idPlantilla = $request->SPlantilla;
        $Lista->idSede  = $request->SSede;
        $Lista->created_at  = $TIMESTAMP;
        $Lista->estatus  = 1;
        $Lista->save();
        print $Lista;
    }


}
