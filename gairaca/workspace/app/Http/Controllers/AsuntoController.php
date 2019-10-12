<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Asunto;

class AsuntoController extends Controller
{
    public function lista_asuntos (Request $request){
        $lista_asuntos = Asunto::all();
        return $lista_asuntos;
    }
}