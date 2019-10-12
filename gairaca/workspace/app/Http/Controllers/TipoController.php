<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tipo;

class TipoController extends Controller
{
    public function lista_tipos (Request $request){
        $lista_tipos = Tipo::all();
        return $lista_tipos;
    }
}
