<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;

class controllerVuetify extends Controller
{
    public function reportDesign(){
        return view('vuetify.report.design');
    }

    public function getDepartament(){
        $departament = Departamento::all();
        return response()->json($departament,200);
    }
}
