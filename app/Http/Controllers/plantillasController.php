<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\EdicionPlantilla;
use App\NameTemplate;
use App\ListarAsignacion;
use App\vaciadocba;

class plantillasController extends Controller
{

    public function UserLogin(){
        $user = DB::table('diaco_usuario')
                    ->join('diaco_sede','id_diaco_sede', '=', 'diaco_usuario.id_sede_diaco')->select('diaco_sede.id_diaco_sede as id','diaco_sede.nombre_sede as sede','diaco_usuario.nombre','diaco_usuario.id_usuario as id_usuario')->where('diaco_usuario.id_usuario', '=', 1)->get();
        //return response()->json($user);
                    return $user;
    }

    public function Asede(){
        
        $Plantillas = DB::table('diaco_name_template_cba')->select('id','NombreTemplate')->get();
        $sede = DB::table('diaco_sede')->select('id_diaco_sede', 'nombre_sede')->get(); 
     
        return view('Ediciones.sedes',
        [
            'Plantillas' => $Plantillas,
            'Sedes' =>$sede
        ]);
        
    }
    
    public function getAsede(){
        
        try {
             $Lista = $this->ListarAsignaciones();
             return datatables()->collection($Lista)->toJson();
             DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            print $e;
        }
        
    }
    
    public function index(){
        $date = Carbon::now();
        $date = $date->format('d-m-Y');
        $categoria = DB::table("diaco_categoriacba")->select('id_Categoria as id','nombre as nombre')->get()->toJson(JSON_PRETTY_PRINT);
        $producto = DB::table("diaco_productocba")->select('id_producto as id','nombre as Pnombre')->get();
        $medida = DB::table('diaco_medida')->select('id_medida as id','nombre as nombre')->get();
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

    public function getFecha(){
        $date = Carbon::now();
        $date = $date->format('d-m-Y');
        return $date;
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
        $Listar = DB::table('diaco_asignarsedecba')
                        ->join('diaco_name_template_cba','diaco_asignarsedecba.idPlantilla','=','diaco_name_template_cba.id')
                        ->join('diaco_sede','diaco_asignarsedecba.idSede','=','diaco_sede.id_diaco_sede')
                        ->select('diaco_name_template_cba.NombreTemplate','diaco_sede.nombre_sede','diaco_asignarsedecba.estatus','diaco_asignarsedecba.created_at')
                        ->get();
        return $Listar;
         
    }

    public function getInbox(){
        $usuario = $this->UserLogin();

        
        $buson = DB::table('diaco_asignarsedecba')
                        ->join('diaco_name_template_cba','diaco_asignarsedecba.idPlantilla','=','diaco_name_template_cba.id')
                        ->join('diaco_sede','diaco_asignarsedecba.idSede','=','diaco_sede.id_diaco_sede')
                        ->join('diaco_usuario','diaco_sede.id_diaco_sede','=','diaco_usuario.id_sede_diaco')
                        // ->select('NAME_TEMPLATE_CBA.NombreTemplate','diaco_sede.nombre_sede','AsignarSedeCBA.estatus','AsignarSedeCBA.created_at')
                        ->selectraw("diaco_name_template_cba.id,diaco_name_template_cba.NombreTemplate,diaco_sede.nombre_sede,(CASE WHEN (diaco_asignarsedecba.estatus = 1) THEN 'Activo' ELSE 'Inactivo' END) as estatus")
                        ->where('diaco_sede.id_diaco_sede', '=', $usuario[0]->id)
                        ->where('diaco_usuario.id_usuario','=',$usuario[0]->id_usuario)
                        ->get();
        //print $buson;
        return response()->json($buson);
    }
    public function storeLista(Request $request){
        $Lista = new ListarAsignacion;
     
        $Lista->idPlantilla = $request->SPlantilla;
        $Lista->idSede  = $request->SSede;
        $Lista->created_at  = $request->created_at_new;
        $Lista->estatus  = 1;
        $Lista->save();
        return 1;
    }

    public function showInbox(){
        return view('Ediciones.bandejaEntrada');
    }

    public function showprinter($id){
       // DB::beginTransaction();
        try {

            $fecha = $this->getFecha();
            $usuario = $this->UserLogin();
            
            $query = DB::table('diaco_plantillascba')
                            ->selectraw('diaco_plantillascba.NombrePlantilla,diaco_plantillascba.created_at,diaco_categoriacba.nombre as categoria,diaco_productocba.nombre as produto,diaco_medida.nombre as medida') 
                            ->join('diaco_categoriacba','id_Categoria','=','idCategoria')
                            ->join('diaco_productocba','id_producto','=','idProducto')
                            ->join('diaco_medida','id_medida','=','idMedida')
                            ->join('diaco_name_template_cba','NombreTemplate','=','NombrePlantilla')
                            ->where('diaco_name_template_cba.id',$id)
                            ->get();
            $categorias = DB::select('
                                SELECT distinct cl.nombre as categoria FROM diaco_plantillascba pl
                                    INNER JOIN diaco_categoriacba cl
                                        ON cl.id_Categoria = pl.idCategoria
                                    INNER JOIN diaco_productocba prl
                                        ON prl.id_producto = pl.idProducto
                                    INNER JOIN diaco_medida md
                                        ON md.id_medida = pl.idMedida
                                    INNER JOIN diaco_name_template_cba npl
                                        ON npl.NombreTemplate = pl.NombrePlantilla
                                    WHERE npl.id = :id',[
                                        'id' => $id]);
            // return view('Ediciones.printer_data',[
            //     'id' => $id,
            //     'fecha' => $fecha,
            //     'usuario' => $usuario,
            //     'coleccion' => $query,
            //     'categoria' => $categorias
            // ]);

                
            $pdf = \PDF::loadView('Ediciones.printer_data',[
                'id' => $id,
                'fecha' => $fecha,
                'usuario' => $usuario,
                'coleccion' => $query,
                 'categoria' => $categorias
            ]);
            return $pdf->stream();
            // return $pdf->download('Ediciones.pdf');
            
           // DB::commit(); 
        } catch (\Exceptio $e) {
            //DB::rollBack();
            print $e;
            
        }

        
    }
    public function getPlantillas($id){
        $query = DB::table('diaco_plantillascba')
                        // ->selectraw("diaco_plantillascba.NombrePlantilla,diaco_plantillascba.created_at,diaco_categoriacba.nombre as categoria,diaco_productocba.nombre as produto,diaco_medida.nombre as medida, diaco_productocba.id_producto as producto,FORMAT(ISNULL((select precioProducto from diaco_vaciadocba where idProducto = diaco_productocba.id_producto),0),'N2') as Precio") 
                        ->selectraw("diaco_medida.id_medida as idmedida,diaco_plantillascba.NombrePlantilla,diaco_plantillascba.created_at,diaco_categoriacba.nombre as categoria,diaco_productocba.nombre as produto,diaco_medida.nombre as medida, diaco_productocba.id_producto as producto,	FORMAT(ISNULL((select precioProducto from diaco_vaciadocba where idProducto = diaco_productocba.id_producto AND created_at BETWEEN DATEADD(DAY,-20,CONVERT(date,GETDATE())) and CONVERT(date,GETDATE()) and ((Day(getdate()) + (Datepart(dw, Dateadd(Month, Datediff(Month, 0, getdate()), 0)) - 1) -1) / 7 + 1) = (((Day(getdate()) + (Datepart(dw, Dateadd(Month, Datediff(Month, 0, getdate()), 0)) - 1) -1) / 7 + 1)-1) ) ,0),'N2') as Anterior1,FORMAT(ISNULL((select precioProducto from diaco_vaciadocba where idProducto = diaco_productocba.id_producto AND created_at BETWEEN DATEADD(DAY,-20,CONVERT(date,GETDATE())) and CONVERT(date,GETDATE()) and ((Day(getdate()) + (Datepart(dw, Dateadd(Month, Datediff(Month, 0, getdate()), 0)) - 1) -1) / 7 + 1) = (((Day(getdate()) + (Datepart(dw, Dateadd(Month, Datediff(Month, 0, getdate()), 0)) - 1) -1) / 7 + 1)) ) ,0),'N2') as Anterior2")
                        ->join('diaco_categoriacba','id_Categoria','=','idCategoria')
                        ->join('diaco_productocba','id_producto','=','idProducto')
                        ->join('diaco_medida','id_medida','=','idMedida')
                        ->join('diaco_name_template_cba','NombreTemplate','=','NombrePlantilla')
                        ->where('diaco_name_template_cba.id',$id)
                        ->get();

        $query2 = DB::select("
        SELECT 
	dp.NombrePlantilla,
	dp.created_at,
	cb.nombre as categoria,
	pc.nombre as produto,
	dm.nombre as medida,
	pc.id_producto as idProducto,
	FORMAT(ISNULL((select precioProducto from diaco_vaciadocba where idProducto = pc.id_producto AND created_at BETWEEN DATEADD(DAY,-1,CONVERT(date,GETDATE())) and CONVERT(date,GETDATE()) and ((Day(getdate()) + (Datepart(dw, Dateadd(Month, Datediff(Month, 0, getdate()), 0)) - 1) -1) / 7 + 1) = (((Day(getdate()) + (Datepart(dw, Dateadd(Month, Datediff(Month, 0, getdate()), 0)) - 1) -1) / 7 + 1)-1) ) ,0),'N2') as Anterior1,
	FORMAT(ISNULL((select precioProducto from diaco_vaciadocba where idProducto = pc.id_producto AND created_at BETWEEN DATEADD(DAY,-1,CONVERT(date,GETDATE())) and CONVERT(date,GETDATE()) and ((Day(getdate()) + (Datepart(dw, Dateadd(Month, Datediff(Month, 0, getdate()), 0)) - 1) -1) / 7 + 1) = (((Day(getdate()) + (Datepart(dw, Dateadd(Month, Datediff(Month, 0, getdate()), 0)) - 1) -1) / 7 + 1)) ) ,0),'N2') as Anterior2
		 FROM diaco_plantillascba dp
	INNER JOIN diaco_categoriacba cb
		ON cb.id_Categoria = dp.idCategoria
	INNER JOIN diaco_productocba pc
		ON pc.id_producto = dp.idProducto
	INNER JOIN diaco_medida dm
		ON dm.id_medida = dp.idMedida
	INNER JOIN diaco_name_template_cba nca
		ON nca.NombreTemplate = dp.NombrePlantilla
	WHERE nca.id = :id
        ",['id' => $id]);
        return $query;
    }

    public function getCategoria($id){
        $categoria = DB::table('diaco_plantillascba')
                            ->selectraw('distinct diaco_categoriacba.nombre as categoria')
                            ->join('diaco_categoriacba','id_Categoria','=','idCategoria')
                            ->join('diaco_productocba','id_producto','=','idProducto')
                            ->join('diaco_medida','id_medida','=','idMedida')
                            ->join('diaco_name_template_cba','NombreTemplate','=','NombrePlantilla')
                            ->where('diaco_name_template_cba.id',$id)
                            ->get();
        return $categoria;
    }

    public function getMercado(){
        $mercado = DB::table('diaco_mercadocba')->select('idMercado','nombreMercado as nombre')->get();
        return $mercado;
    }

    public function showVaciado($id){
        $fecha = $this->getFecha();
        $usuario = $this->UserLogin();
        $plantilla = $this->getPlantillas($id); 
        $categoria = $this->getCategoria($id);
        $data = $this->getMercado();
        //dd($plantilla);
        //return response()->json($mercado);
        

        return view('Ediciones.vaciado',
            [
                'fecha' => $fecha,
                'user' => $usuario,
                'coleccion' => $plantilla,
                'categoria' => $categoria,
                'mercado' => $data,
                'idPlantilla' => $id

            ]
        );
    }

    public function vaciado(Request $request){
        
        $TIMESTAMP = Carbon::now();
        //$r = json_decode($request->getContent(), true);
        $valor = sizeof($request->idProducto);
        try {
            for ($mercado=1; $mercado < 6; $mercado++) { 
                
                for ($i=0; $i  < $valor ; $i++) { 
                    
                    $modelo = new vaciadocba;
                $modelo->numeroLocal = $request->iputMercado[$mercado];
                    $modelo->created_at = $TIMESTAMP;
                    $modelo->idPlantilla = $request->idPlantilla;
                    $modelo->idVerificador = $request->idVerificador;
                    $modelo->tipoVerificacion = 1;
                    $modelo->idLugarVisita = 1;
                    $modelo->idEstablecimientoVisita = 1;
                    
                    $modelo->idProducto = $request->idProducto[$i];
                    $modelo->idMedida = 1;
                    $modelo->precioProducto = $request->inputColumn[$mercado][$i];
                    $modelo->estado = 'A';
                    $modelo->save();

                    
                }
                
            }
        }catch (\Exceptio $e) {
            DB::rollBack();
            print $e;
        }
        //dd($request->idPlantilla);
    }


}
