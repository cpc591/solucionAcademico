<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Solicitude_User;
use App\Solicitude;
use App\Solicitude_User_Accione;
use App\User;
use App\ListaSolicitudes;
use App\Respuesta;
use App\Accione;
use App\Tipo;
use App\Asunto;


use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class RadicacionController extends Controller
{
    private $headers = [  'Content-Type' => 'application/json; charset=utf-8', 'Accept'=>'application/json' ];
     private $desarrollo_estudiantil = 9;
     private $creada = 1;
     private $sinaprobar =2;
     private $aprobada = 3;
     private $tramite = 4;
     private $respondida_a_desarrollo = 5;
     private $reenviada = 6;
     //private $respondida = 7;
     private $esperaAbropacionDirector = 8;
     private $respondida = 7;
     private $rolEstudiantes = 2;
     private $rolDependencias = 1;
     
     private $academico = 39;
     private $directorAcademico = 43;
     
    public function __construct()
	{
	    $this->middleware('auth');
	    $this->middleware('role:radicacion');
	}
	public function vista_consecutivos() {
          
        return view('Solicitudes.vista_consecutivos');
    }
	public function solicitudes_radicacion(){
        $lista = Solicitude::where('solicitudes.respuesta','<>',1)->where('solicitudes.consecutivo','=',null)->with('tipos','asunto_nuevo')->get();
        $solicitudesConRadicacion = Solicitude::where('consecutivo','<>',null)->with('tipos','asunto_nuevo')->get();
        $respuestas = Respuesta::get();
        $resRadicadas = [];
        $resSinRadicar = [];
        for($i=0;$i<sizeof($respuestas);$i++){
            $solicitude_user = Solicitude_User::find($respuestas[$i]->solicitude_user_id);
            $estudiante=Solicitude_User::
            join("users","solicitude_user.user_id","=","users.id")
            ->join("role_user","role_user.user_id","=","users.id")
            ->join("solicitudes","solicitudes.id","=","solicitude_user.solicitude_id")
            ->leftjoin("asuntos","asuntos.id","=","solicitudes.asunto_id")
            ->where("solicitude_user.solicitude_id","=", $solicitude_user->solicitude_id)->where('role_user.role_id','=',2)->
            select("users.id as id","users.nombre as nombre","users.codigo","users.email as email", "asuntos.nombre as nombreAsunto", "solicitudes.asunto"
			,"solicitude_user.id as solicitude_user_id","solicitudes.id as idSolicitud","solicitudes.consecutivo as radicadoSolicitud")->first();
            
            $respuestas[$i]["estudiante"] = $estudiante;
            $respuestas[$i]["esRespuesta"] = true;
			$sol_user_accione = Solicitude_User_Accione::
			join("solicitude_user","solicitude_user.id","=","solicitude_user_accione.solicitude_user_id")
			->where('solicitude_user.solicitude_id',$estudiante->idSolicitud)->orderBy('fecha','DESC')->get();
			//return $sol_user_accione;
			
                    
            if($respuestas[$i]->radicado == null && $sol_user_accione[0]->accione_id == 11){
                $consultaRespuesta = Respuesta::where('solicitude_user_id',$solicitude_user->id)->first();
                $respuestas[$i]["radicadoRespuesta"] = $consultaRespuesta->radicado;
                array_push($resSinRadicar, $respuestas[$i]);
            }else{
                array_push($resRadicadas, $respuestas[$i]);
            }
        }
        $lista2 = [];
        $listaRechazadas = [];
        for($i=0;$i<sizeof($lista);$i++){
            $estudiante=Solicitude_User::
        join("users","solicitude_user.user_id","=","users.id")
        ->join("role_user","role_user.user_id","=","users.id")
        ->join("solicitudes","solicitudes.id","=","solicitude_user.solicitude_id")
        ->where("solicitude_user.solicitude_id","=",$lista[$i]->id)->where('role_user.role_id','=',2)->
        select("users.id as id","users.nombre as nombre","users.codigo","users.email as email","solicitude_user.id as solicitude_user_id","solicitudes.id as idSolicitud")->first();
        //return $estudiante;
        $lista[$i]["estudiante"] = $estudiante;
        
            $acciones = Solicitude_User_Accione::
                join("solicitude_user","solicitude_user.id","=","solicitude_user_accione.solicitude_user_id")
                ->join("solicitudes","solicitudes.id","=","solicitude_user.solicitude_id")
                ->where('solicitudes.id',$estudiante->idSolicitud)->where('solicitude_user_accione.accione_id',13)->first();
            //return $acciones;
            if($acciones != null){
                array_push($listaRechazadas, $lista[$i]);
            }else{
                array_push($lista2, $lista[$i]);
            }
            
        }
        for($i=0;$i<sizeof($solicitudesConRadicacion);$i++){
            $estudiante=Solicitude_User::
        join("users","solicitude_user.user_id","=","users.id")
        ->join("role_user","role_user.user_id","=","users.id")
        ->where("solicitude_user.solicitude_id","=",$solicitudesConRadicacion[$i]->id)->where('role_user.role_id','=',2)->
        select("users.id as id","users.nombre as nombre","users.codigo","users.email as email")->first();
        $solicitudesConRadicacion[$i]["estudiante"] = $estudiante;
            
        }
        
        return ["lista"=>$lista2,"solicitudesRechazadas"=>$listaRechazadas, "solicitudesConRadicacion"=>$solicitudesConRadicacion, "resRadicadas"=>$resRadicadas, "resSinRadicar"=>$resSinRadicar];
    }
    public function guardar_consecutivo(Request $request){
        //return date("Y-m-d",strtotime($request->fecha));
        //return date("Y-m-d",strtotime($request->fecha))." ".$request->horaRadicado.":".$request->minutoRadicado.":00";
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'consecutivo' => 'required|string|min:1|max:250',
            'solicitud' => 'required|exists:solicitudes,id',
            'horaRadicado' => 'required|between:0,12',
            'minutoRadicado' => 'required|between:0,59',
            'am' => 'required|boolean'
        ],[
            'consecutivo.required' => 'El r¿número de radicado es obligatorio.',
            'consecutivo.min' => 'El asunto debe ser mínimo de 1 carácter.',
            'consecutivo.max' => 'El asunto debe ser maximo de 250 carácteres.',
            'solicitud.required' => 'La solicitud  es requerida.',
            'solicitud.exists' => 'La solicitud debe existir.',
            'horaRadicado.between' => 'No está ingresando una hora correcta.',
            'minutoRadicado.between' => 'No está ingresando un minuto correcto.',
            'horaRadicado.required' => 'La hora del radicado es obligatoria.',
            'minutoRadicado.required' => 'El minuto del radicado es obligatorio.',
            'am.required' => 'La jornada es obligatoria.',
            'am.boolean' => 'No ha escogido una jornada correcta.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        
        
        
        $consecutivo = Solicitude::where('id',$request->solicitud)->first();
        if(Solicitude::where('consecutivo',$request->consecutivo)->first() != null){
            return ["success"=>false, "errores"=>["El radicado ya se encuentra registrado con otra solicitud."]];
        }
        
        $fechaSolicitud =  date("Y-m-d H:i",strtotime($consecutivo->created_at));
        
        $fechaRadicado = intval($request->am) == 1 ? date("Y-m-d H:i",strtotime ( '+12 hour' , strtotime ( $request->fecha." ".$request->horaRadicado.":".$request->minutoRadicado.":00" ) )) : date("Y-m-d",strtotime($request->fecha))." ".$request->horaRadicado.":".$request->minutoRadicado.":00";
        
        
        if(($fechaSolicitud >= $fechaRadicado)){
            return ["success"=>false,"errores"=>["La fecha de radicación de la solicitud debe ser mayor a la fecha de creación de la solicitud."]];
        }
        
        $consecutivo->consecutivo = $request->consecutivo;
        $consecutivo->user_radicado = Auth::user()->nombre;
        $consecutivo->fecha_radicado = date("Y-m-d",strtotime($request->fecha))." ".$request->horaRadicado.":".$request->minutoRadicado.":00";
        $consecutivo->jornadaRadicado = intval($request->am);
        $consecutivo->save();
        
        $solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitud)->orderBy('created_at','desc')->get();
        
        $nueva_solicitude_accione = new Solicitude_User_Accione();
        $nueva_solicitude_accione->solicitude_user_id = $solicitude_user[0]->id;
        $nueva_solicitude_accione->accione_id = 4;
        $nueva_solicitude_accione->fecha = Carbon::now();
        $nueva_solicitude_accione->save();
        
        $dependencia = User::where('id',$solicitude_user[0]->user_id)->first();
                
        $asunto = $consecutivo->asunto_id == null ? $consecutivo->asunto : Asunto::where('id',$consecutivo->asunto_id)->select('asuntos.nombre')->first();
        $data=[];
        $data["Asunto"] = $asunto;
            try{
                \Mail::send('VistasEmails.emailCreacion',$data, function($message) use ($request, $dependencia){
                   //remitente
                   $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
         
                   //asunto
                   $message->subject("Notificación - Nueva solicitud");
         
                   //receptor
                   $message->to($dependencia->email, $dependencia->nombre);
                });
            }catch(\Exception $e){
                // Never reached
                //return $e;
            }
        
        $estudiante=Solicitude_User::
                join("users","solicitude_user.user_id","=","users.id")
                ->join("role_user","role_user.user_id","=","users.id")
                ->where("solicitude_user.solicitude_id","=",$consecutivo->id)->where('role_user.role_id','=',2)->
                select("users.id as id","users.nombre as nombre","users.codigo","users.email as email")->first();
        
        $data["Asunto"] = $asunto;
        $data["nombreEstudiante"] = $estudiante->nombre;
        $data["codigo"] = $estudiante->codigo;
        $data["consecutivo"] = $consecutivo->consecutivo;
        $data["fecha_radicado"] = $consecutivo->fecha_radicado;
            try{
                \Mail::send('VistasEmails.emailCreacion',$data, function($message) use ($request, $estudiante){
                   //remitente
                   $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
         
                   //asunto
                   $message->subject("Radicación de solicitud");
         
                   //receptor
                   $message->to($estudiante->email, $estudiante->nombre);
                });
            }catch(\Exception $e){
                // Never reached
                //return $e;
            }
        if($consecutivo->email_adicional != null){
            try{
                \Mail::send('VistasEmails.emailCreacion',$data, function($message) use ($request, $estudiante,$consecutivo){
                   //remitente
                   $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
         
                   //asunto
                   $message->subject("Radicación de solicitud");
         
                   //receptor
                   $message->to($consecutivo->email_adicional, $estudiante->nombre);
                });
            }catch(\Exception $e){
                // Never reached
                //return $e;
            }
        }
            
        
        return ["success"=>true];
    }
    public function guardar_consecutivoRespuesta(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'consecutivo' => 'required|string|min:1|max:250',
            'respuesta' => 'required|exists:respuestas,id',
            
        ],[
            'consecutivo.min' => 'El asunto debe ser mínimo de 1 carácter.',
            'consecutivo.max' => 'El asunto debe ser maximo de 250 carácteres.',
            'solicitud.required' => 'La solicitud  es requerida.',
            'solicitud.exists' => 'La solicitud debe existir.',
            
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $radicado = Respuesta::where('id',$request->respuesta)->with('correos')->first();
        if(Respuesta::where('radicado',$request->consecutivo)->first() != null){
            return ["success"=>false, "errores"=>["El radicado ya se encuentra registrado con otra solicitud."]];
        }
        $solicitud = Solicitude_User::
        join('solicitudes', 'solicitudes.id', '=', 'solicitude_user.solicitude_id')
        ->where('solicitude_user.id',$radicado->solicitude_user_id)
        ->select('solicitudes.id as solicitude_id','solicitudes.fecha_radicado','solicitudes.jornadaRadicado')->first();
        
        $fechaRadicadoSolicitud = $solicitud->jornadaRadicado == 1 ? date("Y-m-d",strtotime ( '+12 hour' , strtotime ( $solicitud->fecha_radicado ) )) : $solicitud->fecha_radicado;
        
        $fechaRadicadoRespuesta = intval($request->am) == 1 ? date("Y-m-d H:i:s",strtotime ( '+12 hour' , strtotime ( $request->fecha." ".$request->horaRadicado.":".$request->minutoRadicado.":00" ) )) : date("Y-m-d",strtotime($request->fecha))." ".$request->horaRadicado.":".$request->minutoRadicado.":00";
        
       
        
        if(($fechaRadicadoSolicitud >= $fechaRadicadoRespuesta)){
            return ["success"=>false,"errores"=>["La fecha de radicación de la respuesta debe ser mayor a la fecha de radicación de la solicitud."]];
        }
        
        $radicado->radicado = $request->consecutivo;
        $radicado->user_radicado = Auth::user()->nombre;
        $radicado->fecha_radicado = date("Y-m-d",strtotime($request->fecha))." ".$request->horaRadicado.":".$request->minutoRadicado.":00";
        $radicado->jornadaRadicado = intval($request->am);
        $radicado->save();
        
        $solicitude_user = Solicitude_User::where('id',$radicado->solicitude_user_id)->first();
        
        $nueva_solicitude_accione = new Solicitude_User_Accione();
        $nueva_solicitude_accione->solicitude_user_id = $solicitude_user->id;
        $nueva_solicitude_accione->accione_id = 7;
        $nueva_solicitude_accione->fecha = Carbon::now();
        $nueva_solicitude_accione->save();
        
        
        //$asunto = Asunto::find($consecutivo->asunto_id);
        $estudiante=Solicitude_User::
                join("users","solicitude_user.user_id","=","users.id")
                ->join("role_user","role_user.user_id","=","users.id")
                ->join("solicitudes","solicitudes.id","=","solicitude_user.solicitude_id")
                ->where("solicitudes.id","=",$solicitude_user->solicitude_id)->where('role_user.role_id','=',2)->
                select("users.id as id","users.nombre as nombre","users.codigo","users.email as email", "solicitudes.asunto", "solicitudes.email_adicional","solicitudes.asunto_id")->first();
        $data["Asunto"] = $estudiante->aunto_id == null ? $estudiante->asunto : Asunto::where('id',$estudiante->asunto_id)->select('asuntos.nombre')->first();
        $data["radicado"] = $radicado->radicado;
        $data["fecha_radicado"] = $radicado->fecha_radicado;
        try{
            \Mail::send('VistasEmails.email_respuesta',$data, function($message) use ($request, $estudiante){
               //remitente
               $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
     
               //asunto
               $message->subject("Respuesta de solicitud");
     
               //receptor
               $message->to($estudiante->email, $estudiante->nombre);
            });
        }catch(\Exception $e){
            // Never reached
            //return $e;
        }
        
        if($estudiante->email_adicional != null){
            try{
                \Mail::send('VistasEmails.email_respuesta',$data, function($message) use ($request, $estudiante){
                   //remitente
                   $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
         
                   //asunto
                   $message->subject("Respuesta de solicitud");
         
                   //receptor
                   $message->to($estudiante->email_adicional, $estudiante->nombre);
                   
                });
            }catch(\Exception $e){
                // Never reached
                //return $e;
            }
        }
        $solicitude_user = Solicitude_User::
            has('respuestas')->
            join("respuestas","respuestas.solicitude_user_id","=","solicitude_user.id")
            ->where('solicitude_user.solicitude_id',$id)
            
            ->select('respuestas.mensaje','solicitude_user.id as solicitude_user_id')->first();
            
            //return $solicitude_user;
        //$solicitude_user = Solicitude_User::where('solicitude_id',$id)->where('user_id',39)->first();
            
        
           // $respuesta = Respuesta::where('solicitude_user_id',$solicitude_user->id)->first();
            //return $respuesta;
        $view =  \View::make('Solicitudes.pdf_respuesta', ['respuesta' => $solicitude_user->mensaje])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        if($radicado->correos != null){
            for($i=0;$i<sizeof($radicado->correos);$i++){
                $enviarCorreoUser = User::where('id',$radicado["correos"][$i]->user_id)->first();
                try{
                    \Mail::send('VistasEmails.email_respuesta',$data, function($message) use ($request, $enviarCorreoUser){
                       //remitente
                       $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
             
                       //asunto
                       $message->subject("Respuesta de solicitud");
             
                       //receptor
                       $message->to($enviarCorreoUser->email, $enviarCorreoUser->nombre);
                       
                    });
                }catch(\Exception $e){
                    // Never reached
                    //return $e;
                }
            }
            
        }
        
        return ["success"=>true];
    }
	
    public function rechazarRadicacion(Request $request){
        //return $request->all();
        
        $validator = \Validator::make($request->all(), [
            'comentario' =>'required',
            'idSolicitud' => 'required|exists:solicitudes,id',
        ],[
            'comentario.required' => 'El comentario es requerido.',
            'idSolicitud.required' => 'La solicitud es requerida.',
            'idSolicitud.exists' => 'La solicitud debe existir.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        
        $solicitude_user = Solicitude_User::where('solicitude_id',$request->idSolicitud)->where('user_id',44)->first();
        
        $nueva_solicitude_accione = new Solicitude_User_Accione();
        $nueva_solicitude_accione->solicitude_user_id = $solicitude_user->id;
        $nueva_solicitude_accione->accione_id = 13;
        $nueva_solicitude_accione->comentario = $request->comentario;
        $nueva_solicitude_accione->fecha = Carbon::now();
        $nueva_solicitude_accione->save();
        
        $estudiante=Solicitude_User::
                join("users","solicitude_user.user_id","=","users.id")
                ->join("role_user","role_user.user_id","=","users.id")
                ->join("solicitudes","solicitudes.id","=","solicitude_user.solicitude_id")
                ->where("solicitude_user.solicitude_id","=",$solicitude_user->solicitude_id)->where('role_user.role_id','=',2)->
                select("users.id as id","users.nombre as nombre","users.codigo","users.email as email", "solicitudes.asunto", "solicitudes.email_adicional", "solicitudes.asunto_id")->first();
                $data = [];
        $data["Asunto"] = $estudiante->asunto_id == null ? $estudiante->asunto : Asunto::where('id',$estudiante->asunto_id)->select('asuntos.nombre')->first();
        
        try{
            \Mail::send('VistasEmails.emailMensaje',$data, function($message) use ($request, $estudiante){
               //remitentes
               $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
     
               //asunto
               $message->subject("Notificación - GAIRACA");
     
               //receptor
               $message->to($estudiante->email, $estudiante->nombre);
            });
        }catch(\Exception $e){
            // Never reached
            //return $e;
        }
        
        if($estudiante->email_adicional != null){
            try{
                \Mail::send('VistasEmails.emailMensaje',$data, function($message) use ($request, $estudiante){
                   //remitente
                   $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
         
                   //asunto
                   $message->subject("Notificación - GAIRACA");
         
                   //receptor
                   $message->to($estudiante->email_adicional, $estudiante->email_adicional);
                });
            }catch(\Exception $e){
                // Never reached
                //return $e;
            }
        }
        
        return ["success"=>true];
        
        
    }
}
