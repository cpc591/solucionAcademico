<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Solicitude_concepto_Solicitude_User;
use App\Solicitude_concepto;
use App\User;
use App\RespuestaConcepto;
use App\Multimedias_Respuesta_concepto;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class RespuestaConceptoController extends Controller
{
    public function __construct()
	{
	    $this->middleware('auth');
	    $this->middleware('role:consejoAcademico|dependencia');
	}
    public function crear_respuesta_concepto(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'contenido' => 'required',
            'solicitudConcepto' => 'required|exists:solicitudes_conceptos,id',
            'Galeria.*' => 'mimes:pdf',
            'Galeria' =>'array|max:1',
        ],[
            'contenido.required' => 'El contenido o respuesta es requerido.',
            'solicitudConcepto.required' => 'El identificador de la solicitud es requerido.',
            'solicitudConcepto.exists' => 'El identificador de la solicitud debe existir.',
            'Galeria.*.mimes' => 'subir solo archivos pdf',
            'Galeria.max'=>'La cantidad máxima de archivos es 1.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $solicitud = Solicitude_concepto::
        join('solicitudes', 'solicitudes.id', '=', 'solicitudes_conceptos.solicitude_id')
        ->join('solicitude_user', 'solicitude_user.solicitude_id', '=', 'solicitudes.id')->
        where('solicitudes_conceptos.id',$request->solicitudConcepto)
        ->where('solicitude_user.estado_id',2)->
        select('solicitudes.id as idSolicitud')->first();
        
        if($solicitud != null){
            return ["success"=>false,"errores"=>[["Ya la solicitud a la que pertenece fue respondida"]]];
        }
        
        if($request->Galeria != null){
            $tamaño = filesize($request->Galeria[0]);
            if($tamaño/1024 > 5000){
                $error = [];
                $error["Galeria"][0] = "Tamaño total de los adjuntos exceden los 10MB";
                return ["success"=>false,"errores"=>$error];
            } 
        }
            $respuesta = new RespuestaConcepto();
            $respuesta->mensaje = $request->contenido;
            $respuesta->solicitudes_conceptos_id = $request->solicitudConcepto;
            $respuesta->user_create = Auth::user()->nombre;
            $respuesta->save();
            
            $date = Carbon::now();
        if($request->Galeria != null){
            for ($i=0;$i<sizeof($request->Galeria);$i++){
                $multimedia = new Multimedias_Respuesta_concepto();
                $multimedia->respuestas_concepto_id = $respuesta->id;
                $date->addSeconds($i); 
                $nombrex = $respuesta->id."-".$i."-".date("Ymd-His").".".$request->Galeria[$i]->getClientOriginalExtension();
               \Storage::disk('respuestas')->put($nombrex,  \File::get($request->Galeria[$i]));
                $multimedia->ruta = "/respuestasConceptos/".$nombrex;
                $multimedia->user_create = Auth::user()->nombre;
                $multimedia->save();
            }
        }
            $solicitudConcepto = Solicitude_concepto::where('id',$request->solicitudConcepto)->first();
            $user_correo = User::where('id',$solicitudConcepto->user_creador_id)->first();
            $data = [];
            $data["nombre"] = $user_correo->nombre;
            try{
                
                \Mail::send('VistasEmails.emailRespuestaSoliConcepto',$data, function($message) use ($solicitudConcepto, $user_correo){
                   //remitente
                   $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
         
                   //asunto
                   $message->subject("Respuesta a solicitud de concepto en GAIRACA");
         
                   //receptor
                   $message->to("luiferpalmera@gmail.com", "Luis Palmera");
                   //$message->to($user_correo->email, $user_correo->nombre);
                });
            }catch(\Exception $e){
                // Never reached
                //return $e;
            }
            
            return  ["success"=>true];
        
    }
}
