<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\GasPropano;

class PropanoController extends Controller
{
    
    public function GetPropano(){
       $propano = DB::table('diaco_propano_cba')
                    ->select('id','name')
                    ->get();
        return response()->json($propano, 200);
    }

    public function addPropano(Request $request){
            $Propano = new GasPropano;

            $Propano->name = $request->names;
            $Propano->state = 1;
            $Propano->save();
        return response()->json('',200);
    }
}
