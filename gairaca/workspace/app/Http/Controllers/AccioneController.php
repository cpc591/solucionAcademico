<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Accione;
class AccioneController extends Controller
{
    public function lista_acciones (Request $request){
        $lista_acciones = Accione::all();
        return $lista_acciones;
    }
}
