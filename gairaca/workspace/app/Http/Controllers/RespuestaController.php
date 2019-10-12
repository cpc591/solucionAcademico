<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Respuesta;
use App\User;
use App\Solicitude;
use App\Solicitude_User;
use App\Multimedias_Respuesta;
use App\Solicitude_User_Accione;
use App\Asunto;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class RespuestaController extends Controller
{
    public function __construct()
	{
	    $this->middleware('auth');
	    
	    $this->middleware('role:secretariaGeneral|consejoAcademico|dependencia',['only'=>['crear_respuesta','eliminar_soporteRespuesta']]);
	    $this->middleware('role:consejoAcademico|estudiante|dependencia|secretariaGeneral|radicacion|representanteEstudiantil',['only'=>['pdf_respuesta']]);
	    $this->middleware('role:consejoAcademico|dependencia',['only'=>['crear_borrador']]);
	}
	
    private $rolEstudiantes = 2;
     private $rolDependencias = 1;
    private $respondida_a_desarrollo = 5;
    private $respondida = 7;
    private $esperaAprobacion = 8;
    private $desarrollo_estudiantil = 9;
    private $academico = 39;
    public function crear_respuesta(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'contenido' => 'required',
            'solicitud' => 'required|exists:solicitudes,id',
            'Galeria.*' => 'mimes:pdf',
            'Galeria' =>'array|max:1'
        ],[
            'contenido.required' => 'El contenido o respuesta es requerido.',
            'solicitud.required' => 'El identificador de la solicitud es requerido.',
            'solicitud.exists' => 'El identificador de la solicitud debe existir.',
            'Galeria.*.mimes' => 'subir solo archivos pdf',
            'Galeria.max'=>'La cantidad máxima de archivos es 1.'
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
         if($request->Galeria != null){
            $tamaño = filesize($request->Galeria[0]);
            if($tamaño/1024 > 10000){
                $error = [];
                $error["Galeria"][0] = "Tamaño total de los adjuntos exceden los 10MB";
                return ["success"=>false,"errores"=>$error];
            } 
        }
        //$solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitud)->where('user_id',39)->first();
        $solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitud)->orderBy('updated_at','desc')->get();
        
            // $respuesta = Respuesta::
            //     join("solicitude_user","solicitude_user.id","=","respuestas.solicitude_user_id")
            //     ->join("solicitudes","solicitude_user.solicitude_id","=","solicitudes.id")->
            //     where('solicitudes.id',$request->solicitud)->where('solicitude_user.user_id',39)->first();
            
            $respuesta = Respuesta::where('solicitude_user_id',$solicitude_user[0]->id)->first();
            if($respuesta == null){
                $respuesta = new Respuesta();
            }
            //return $respuesta;
            $respuesta->mensaje = $request->contenido;
            $respuesta->solicitude_user_id = $solicitude_user[0]->id;
            $respuesta->user_create = Auth::user()->nombre;
            $respuesta->save();
            //return $respuesta;
            $date = Carbon::now();
        if($request->Galeria != null){
            for ($i=0;$i<sizeof($request->Galeria);$i++){
                $multimedia = new Multimedias_Respuesta();
                $multimedia->respuesta_id = $respuesta->id;
                $date->addSeconds($i); 
                $nombrex = $respuesta->id."-".$i."-".date("Ymd-His").".".$request->Galeria[$i]->getClientOriginalExtension();
               \Storage::disk('respuestas')->put($nombrex,  \File::get($request->Galeria[$i]));
                $multimedia->ruta = "/respuestas/".$nombrex;
                $multimedia->user_create = Auth::user()->nombre;
                $multimedia->save();
            }
        }
            if(Auth::user()->id == $this->academico){
                $solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitud)->where('user_id',43)->first();
                $solicitude_user_accione = new Solicitude_User_Accione;
                $solicitude_user_accione->accione_id = $this->esperaAprobacion;
                $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
                $solicitude_user_accione->fecha = $date;
                $solicitude_user_accione->save();
            }else{
                $date2=$date = Carbon::now();
                
                $solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitud)->orderBy('updated_at','desc')->get();
                $solicitude_user[0]->estado_id = 2;
                $solicitude_user[0]->save();
            
                $solicitude_user_accione = new Solicitude_User_Accione();
                
                $solicitude_dependencia = Solicitude_User::where('solicitude_id',$request->solicitud)
                ->join("users","solicitude_user.user_id","=","users.id")
                ->join("solicitudes","solicitude_user.solicitude_id","=","solicitudes.id")
                ->where('users.id',44)
                //->where('roles.id','<>',$this->rolEstudiantes)->where('users.id','<>',$this->desarrollo_estudiantil)
                ->select("users.id as dependencia_id", "users.email as email_dependencia","users.nombre as nombre_dependencia",
                "solicitude_user.id as solicitude_user_id", "solicitudes.asunto as Asunto", "solicitudes.id as id_solicitud","solicitudes.asunto_id")->first();
                
                $solicitude_user_accione->accione_id = 11;
                $solicitude_user_accione->solicitude_user_id = $solicitude_dependencia->solicitude_user_id;
                $solicitude_user_accione->fecha = $date2;
                $solicitude_user_accione->save();
        
                $data = [];
                $asunto = Asunto::find($solicitude_dependencia->asunto_id);
                $data["Asunto"] = $asunto != null ? $asunto->nombre : $solicitude_dependencia->Asunto;
                //return $data;
                try{
                    \Mail::send('VistasEmails.emailRespuesta_esperaRad', $data, function($message) use ($solicitude_dependencia){
                           //remitente3
                           $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
                 
                           //asunto
                           $message->subject("Notificación - Respuesta solicitud");
                 
                           //receptor
                           $message->to($solicitude_dependencia->email_dependencia, $solicitude_dependencia->nombre_dependencia);
                    });
                }catch(\Exception $e){
                    // Never reached
                    //return $e;
                }
            }
            
            
            $solicitud = Solicitude::where('id',$request->solicitud)->first();
            $solicitud->respuesta=1;
            $solicitud->save();
            
            return  ["success"=>true];
    }
    public function crear_borrador(Request $request){
        //return $request->contenido;
        $validator = \Validator::make($request->all(), [
            'solicitud' => 'required|exists:solicitudes,id',
            'Galeria.*' => 'mimes:pdf',
            'Galeria' =>'array|max:3'
        ],[
            'solicitud.required' => 'El identificador de la solicitud es requerido.',
            'solicitud.exists' => 'El identificador de la solicitud debe existir.',
            'Galeria.*.mimes' => 'subir solo archivos pdf',
            'Galeria.max'=>'La cantidad máxima de archivos es 3.',
            
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
			//$solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitud)->where('user_id',39)->first();
            $solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitud)->orderBy('updated_at','desc')->get();
            $solicitude_user[0]->estado_id = 1;
            $solicitude_user[0]->save();
        
            $respuesta = Respuesta::where('solicitude_user_id',$solicitude_user[0]->id)->first();
            
            if($respuesta==null){
                $respuesta = new Respuesta();
                
            }
                if($request->contenido!=null){
                    $respuesta->mensaje = $request->contenido;
                }
                
                $respuesta->solicitude_user_id = $solicitude_user[0]->id;
                $respuesta->user_create = Auth::user()->nombre;
                $respuesta->save();
        
            
            $date = Carbon::now();
        if($request->Galeria != null){
            for ($i=0;$i<sizeof($request->Galeria);$i++){
                $multimedia = new Multimedias_Respuesta();
                $multimedia->respuesta_id = $respuesta->id;
                $date->addSeconds($i); 
                $nombrex = $respuesta->id."-".$i."-".date("Ymd-His").".".$request->Galeria[$i]->getClientOriginalExtension();
               \Storage::disk('respuestas')->put($nombrex,  \File::get($request->Galeria[$i]));
                $multimedia->ruta = "/respuestas/".$nombrex;
                $multimedia->user_create = Auth::user()->nombre;
                $multimedia->save();
            }
        }
            
            
            return  ["success"=>true];
    }
    public function pdf_respuesta($id){
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
        return $pdf->stream();
        
    }
    public function eliminar_soporteRespuesta(Request $request){
        $multimedia = Multimedias_Respuesta::where('id',$request[0])->first();
        \File::delete(public_path() . $multimedia->ruta);
        $multimedia->delete();
        return ["success"=>true];
    }
    public function corregir(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'contenido' => 'required',
            'solicitud' => 'required|exists:solicitudes,id',
            'Galeria.*' => 'mimes:pdf',
            'Galeria' =>'array|max:1'
        ],[
            'contenido.required' => 'El contenido o respuesta es requerido.',
            'solicitud.required' => 'El identificador de la solicitud es requerido.',
            'solicitud.exists' => 'El identificador de la solicitud debe existir.',
            'Galeria.*.mimes' => 'subir solo archivos pdf',
            'Galeria.max'=>'La cantidad máxima de archivos es 1.'
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
         if($request->Galeria != null){
            $tamaño = filesize($request->Galeria[0]);
            if($tamaño/1024 > 10000){
                $error = [];
                $error["Galeria"][0] = "Tamaño total de los adjuntos exceden los 10MB";
                return ["success"=>false,"errores"=>$error];
            } 
        }
        $solicitude_dependencia = Solicitude_User::where('solicitude_id',$request->solicitud)
            ->join("solicitudes","solicitude_user.solicitude_id","=","solicitudes.id")
            ->join("users","solicitude_user.user_id","=","users.id")
            ->join("role_user","users.id","=","role_user.user_id")
            ->where('role_user.role_id','<>',$this->rolEstudiantes)->where('users.id','=',43)
            ->select("solicitudes.asunto as Asunto", "solicitudes.id as id_solicitud", "solicitude_user.id as id", "users.id as user_id")
            ->first();
            //$solicitude_user = Solicitude_User::where('solicitude_id',6)->where('user_id',9)->first();
            //return $solicitude_dependencia;
            
            $respuestaBusqueda = Respuesta::
                join("solicitude_user","solicitude_user.id","=","respuestas.solicitude_user_id")
                ->join("solicitudes","solicitude_user.solicitude_id","=","solicitudes.id")->
                where('solicitudes.id',$request->solicitud)->where('solicitude_user.user_id',39)->first();
                //return $respuestaBusqueda;
            $respuesta = Respuesta::where('solicitude_user_id',$respuestaBusqueda->solicitude_user_id)->first();
            //return $respuesta;
            $respuesta->mensaje = $request->contenido;
            $respuesta->user_create = Auth::user()->nombre;
            $respuesta->save();
            
            $date = Carbon::now();
        if($request->Galeria != null){
            for ($i=0;$i<sizeof($request->Galeria);$i++){
                $multimedia = new Multimedias_Respuesta();
                $multimedia->respuesta_id = $respuesta->id;
                $date->addSeconds($i); 
                $nombrex = $respuesta->id."-".$i."-".date("Ymd-His").".".$request->Galeria[$i]->getClientOriginalExtension();
               \Storage::disk('respuestas')->put($nombrex,  \File::get($request->Galeria[$i]));
                $multimedia->ruta = "/respuestas/".$nombrex;
                $multimedia->user_create = Auth::user()->nombre;
                $multimedia->save();
            }
        }
            $solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitud)->where('user_id',43)->first();
            $solicitude_user_accione = new Solicitude_User_Accione;
            $solicitude_user_accione->accione_id = 12;
            $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
            $solicitude_user_accione->fecha = $date;
            $solicitude_user_accione->save();
            
            $date->addSeconds(2); 
            $date->toDateString();
            
            $solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitud)->where('user_id',44)->first();
            $solicitude_user_accione = new Solicitude_User_Accione;
            $solicitude_user_accione->accione_id = 11;
            $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
            $solicitude_user_accione->fecha = $date;
            $solicitude_user_accione->save();
            
            $solicitud = Solicitude::where('id',$solicitude_dependencia->id_solicitud)->first();
            $solicitud->respuesta=1;
            $solicitud->save();
            
            return  ["success"=>true];
    }
    public function rechazarRespuesta(Request $request){
        //return $request->all();
        if(Solicitude::where('id',$request->idSolicitud)->first() == null){
            return response('Bad request.', 400);
        }
        $date = Carbon::now();
        $solicitude_user = Solicitude_User::where('solicitude_id',$request->idSolicitud)->where('user_id',44)->first();
        $solicitude_user_accione = new Solicitude_User_Accione;
        $solicitude_user_accione->accione_id = 14;
        $solicitude_user_accione->comentario = $request->comentario;
        $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
        $solicitude_user_accione->fecha = $date;
        $solicitude_user_accione->save();
        
        $date->addSeconds(2); 
        $date->toDateString();
        
        $solicitude_user = Solicitude_User::where('solicitude_id',$request->idSolicitud)->where('user_id',39)->first();
        $solicitude_user_accione = new Solicitude_User_Accione;
        $solicitude_user_accione->accione_id = 9;
        $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
        $solicitude_user_accione->fecha = $date;
        $solicitude_user_accione->save();
        
        return  ["success"=>true];
    }
}
