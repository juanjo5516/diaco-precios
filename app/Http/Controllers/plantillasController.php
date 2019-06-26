<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class plantillasController extends Controller
{
    public function index(){
        return view('Ediciones.index');
    }
}
