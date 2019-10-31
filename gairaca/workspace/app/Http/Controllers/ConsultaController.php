<?php

namespace App\Http\Controllers;

use App\User;
use App\ListaSolicitudes;
use App\ConsultaGeneral;
use App\ProcedimientoConsultaGeneral;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;


class ConsultaController extends Controller
{
    public function __construct()
	{
	    $this->middleware('auth');
	    $this->middleware('role:consejoAcademico');
	}
    public function consultasGeneralesVista(){
        //return ListaSolicitudes::get();
        return view('Consultas.prueba');
    }

    public function ConsultasGenerales(Request $request){
        /*$validator = \Validator::make($request->all(),[
            
            'fechaInicio' => 'date',
            'fechaFin' => 'date',
            
        ],[
            
            'fechaInicio.date' => 'Fecha de inicio con formato no válido.',
            'fechaFin.date' => 'Fecha de fin con formato no válido.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }*/
        //return $request->fechaInicio;
        //return ["fechaInicio"=>date('d/m/Y',strtotime($request->fechaInicio)),"fechaFin"=>date('d/m/Y',strtotime($request->fechaFin))];
        //$solicitudes = ConsultaGeneral::where('fechaCreacion','>=',date('Y-m-d',strtotime($request->fechaInicio)))->where('fechaCreacion','<=',date('Y-m-d',strtotime($request->fechaFin)))->get();
        //$solicitudes = \DB::select('call procedimiento_consultasgenerales(?,?)', array(date('Y-m-d',strtotime($request->fechaInicio)),date('Y-m-d',strtotime($request->fechaFin))));
        $solicitudes = ConsultaGeneral::get();
        return ["success"=>true, "solicitudes"=> $solicitudes];
    }
    
}