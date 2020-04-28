<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class imprimirController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function imprimir(){
        
        $pdf = \PDF::loadView('imprimir');
        return $pdf->download('imprimir.pdf');
    }
}
