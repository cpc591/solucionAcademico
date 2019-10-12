<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Solicitude_User;
use App\Solicitude_concepto_Solicitude_User;
use App\Solicitude_concepto;
use App\Multimedias_Solicitude_concepto;
use App\User;
use App\Solicitude_User_Accione;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Solicitude;
class Solicitude_conceptoController extends Controller
{
    public function __construct()
	{
	    $this->middleware('auth');
	    $this->middleware('role:consejoAcademico|dependencia');
	}
    private $rolEstudiantes = 2;
    private $rolDependencias = 1;
    /*
    public function crear_solicitudConcepto(Request $request){
        //return $request->texto;
        $validator = \Validator::make($request->all(), [
            'idSolicitud' => 'required|exists:solicitudes,id',
            'dependencia_destino' => 'required|exists:role_user,user_id',
            'tipo' => 'required|exists:tipos_solicitudes_conceptos,id',
            'Galeria.*' => 'mimes:pdf',
            
        ],[
            'dependencia_destino.required' => 'La dependencia de destino es requerida.',
            'dependencia_destino.exists' => 'La dependencia debe existir.',
            'idSolicitud.required' => 'La solicitud es requerida.',
            'idSolicitud.exists' => 'La solicitud debe existir.',
            'tipo.required' => 'El tipo de solicitud es requerido.',
            'tipo.exists' => 'El tipo de solicitud debe existir.',
            'Galeria.*.mimes' => 'subir solo archivos pdf',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $solicitude_user = Solicitude_User::where('solicitude_id',$request->idSolicitud)->where('user_id',Auth::user()->id)->first();
        $solicitudConcepto = new Solicitude_concepto();
        $solicitudConcepto->texto = $request->texto;
        $solicitudConcepto->solicitude_user_id = $solicitude_user->id;
        $solicitudConcepto->tipo_solicitudes_concepto_id = $request->tipo;
        $solicitudConcepto->user_create = Auth::user()->nombre;
        $solicitudConcepto->save();
            
            $date = Carbon::now();
            for ($i=0;$i<sizeof($request->Galeria);$i++){
                $multimedia = new Multimedias_Solicitude_concepto();
                $multimedia->solicitude_concepto_id = $solicitudConcepto->id;
                $date->addSeconds($i); 
                $nombrex = $solicitudConcepto->id."-".$i."-".date("Ymd-His").".".$request->Galeria[$i]->getClientOriginalExtension();
               \Storage::disk('documentos')->put($nombrex,  \File::get($request->Galeria[$i]));
                $multimedia->ruta = "/documentos/".$nombrex;
                $multimedia->user_create = Auth::user()->nombre;
                $multimedia->save();
            }
        
            return  ["success"=>true];
    }*/
    public function crear_solicitud_concepto (Request $request){
        //return $request->all();
        
        $validator = \Validator::make($request->all(), [
            'Asunto' => 'string|min:1|max:150',
            'Descripcion' => 'required',
            'solicitudId' => 'required|exists:solicitudes,id',
            'Galeria.*' => 'mimes:pdf',
            'Galeria' =>'array|max:1',
            'Dependencia_destino' => 'required|exists:users,id',
        ],[
            'Asunto.required' => 'El asunto es requerido.',
            'Asunto.string' => 'El asunto debe ser de tipo string.',
            'Asunto.min' => 'El asunto debe ser mínimo de 1 carácter.',
            'Asunto.max' => 'El asunto debe ser maximo de 120 carácteres.',
            'Descripcion.required' => 'La descripcion es requerida.',
            'Dependencia_destino.required' => 'La dependecncia destino es requerida.',
            'Dependencia_destino.exists' => 'La dependencia destino debe existir.',
            'solicitudId.required' => 'Favor recargar la página.',
            'solicitudId.exists' => 'Favor recargar la página, solicitud no fue encontrada en la base de datos.',
            'Galeria.*.mimes' => 'subir solo archivos pdf',
            'Galeria.max'=>'La cantidad máxima de archivos es 1.',
            
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
       if($request->Galeria != null){
            $tamaño = filesize($request->Galeria[0]);
            if($tamaño/1024 > 5000){
                $error = [];
                $error["Galeria"][0] = "Tamaño total de los adjuntos exceden los 10MB";
                return ["success"=>false,"errores"=>$error];
            } 
        }
        //return $request->all();
        $valor = Solicitude::all();
        if(count($valor)==0){
            $ultimo=1;
            
        }else{
            $valor = $valor->last();
            $ultimo = $valor->id+1;
        }
        $solicitud = new Solicitude_concepto();
        $solicitud->texto = $request->Descripcion;
        $solicitud->asunto = $request->Asunto;
        $solicitud->solicitude_id = $request->solicitudId;
        $solicitud->user_creador_id = Auth::user()->id;
        $solicitud->user_dirigida_id = $request->Dependencia_destino;
        $date = Carbon::now();
        $solicitud->codigo = "CC".$date.(string)$ultimo;
        $solicitud->user_create = Auth::user()->nombre;
        $solicitud->save();
        
        if($request->Galeria != null){
            for ($i=0;$i<sizeof($request->Galeria);$i++){
                $multimedia = new Multimedias_Solicitude_concepto();
                $multimedia->solicitude_concepto_id = $solicitud->id;
                $date->addSeconds($i); 
                $nombrex = $solicitud->id."-".$i."-".date("Ymd-His").".".$request->Galeria[$i]->getClientOriginalExtension();
            \Storage::disk('solicitudesConcepto')->put($nombrex,  \File::get($request->Galeria[$i]));
                $multimedia->ruta = "/solicitudesConcepto/".$nombrex;
                $multimedia->user_create = Auth::user()->nombre;
                $multimedia->save();
            }
        }
        
        $user_correo = User::where('id',$request->Dependencia_destino/*$request->Dependencia*/)->first();
        $user_correo = User::where('codigo',"2012114083")->first();
        $data = $request->all();
        
        try{
                
            \Mail::send('VistasEmails.emailCrearSoliConcepto',$data, function($message) use ($request, $user_correo){
               //remitente
               $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
     
               //asunto
               $message->subject("Solicitud de concepto recibida en GAIRACA");
     
               //receptor
               //$message->to("luiferpalmera@gmail.com", "Luis Palmera");
               $message->to($user_correo->email, $user_correo->nombre);
            });
        }catch(\Exception $e){
            // Never reached
            //return $e;
        }
    
        return  ["success"=>true];
               
        
        
        
        
    }
    public function listado_solicitudesConceptos(){
        
        
        $solicitudesConceptos = [];
        $lista_solicitudesConceptos_solicitud_user = [];
        $solicitude_user = Solicitude_User::where('user_id',Auth::user()->id)->get();
        
        if($solicitude_user){
            for($i=0;$i<sizeof($solicitude_user);$i++){
                $solicitudesConceptos_solicitud_user = Solicitude_concepto_Solicitud_User::where('solicitud_user_dirigida_id',$solicitude_user[$i]->id)->get();
                if(sizeof($solicitudesConceptos_solicitud_user)>0){
                    array_push($lista_solicitudesConceptos_solicitud_user,$solicitudesConceptos_solicitud_user);
                }
            }
        }
        //return $lista_novedades_solicitud_user;
        if($lista_solicitudesConceptos_solicitud_user){
            for($i=0;$i<sizeof($lista_solicitudesConceptos_solicitud_user[0]);$i++){
               
               $solicitudConcepto = Solicitude_concepto::where('id',$lista_solicitudesConceptos_solicitud_user[0][$i]->solicitude_concepto_id)->with('multimedias_solicitudes_conceptos')->first();
               array_push($solicitudesConceptos,$solicitudConcepto);
            }
            return $solicitudesConceptos;
            
        }
    }
    
    public function vista_solicitud_concepto($id){
        return view('Solicitudes.responder_concepto', array('idConcepto' => $id));
        
    }
    
    public function datos_solicitud_concepto($id){
        
        $solicitud_concepto = Solicitude_concepto::
        join('users as usersDirigida', 'solicitudes_conceptos.user_dirigida_id', '=', 'usersDirigida.id')
        ->join('users', 'solicitudes_conceptos.user_creador_id', '=', 'users.id')
        ->where('solicitudes_conceptos.id',$id)->select("solicitudes_conceptos.id as id","users.nombre as nombreCreador","usersDirigida.nombre as nombreDirigida", "solicitudes_conceptos.user_dirigida_id as dirigidaId",
            "solicitudes_conceptos.asunto", "solicitudes_conceptos.texto as descripcion")
        ->with(['respuestaConcepto'=>function($q){$q->with('multimedias_respuestasConceptos');}])
        ->first();
        $multimediasConcepto = Multimedias_Solicitude_concepto::where('solicitude_concepto_id',$id)->get();
        return ["solicitudConcepto"=>$solicitud_concepto, "multimediasConcepto"=>$multimediasConcepto]; 
    }
}
