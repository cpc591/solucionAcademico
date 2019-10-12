<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Role_User;
use App\Solicitude;
use Carbon\Carbon;
use App\Multimedias_Solicitude;
use App\Multimedias_Respuesta;
use App\Solicitude_User;
use App\User;
use App\ListaSolicitudes;
use App\Solicitude_User_Accione;
use App\Respuesta;
use App\Accione;
use App\Tipo;
use App\Tipos_Solicitude_concepto;
use App\Asunto;
use App\Novedade;
use App\Novedades_Solicitud_User;
use App\Calendario_fecha;
use App\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Solicitude_concepto_Solicitude_User;
use App\Solicitude_concepto;
use App\Multimedias_Solicitude_concepto;

class SolicitudeController extends Controller
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
    
    /*public function __construct()
	{
	    $this->middleware('auth');
	    $this->middleware('rolePermiso:Dependencia',['only' => ['bandeja3'] ]);
	    $this->middleware('rolePermiso:Radicación',['only' => ['vista_consecutivos'] ]);
	    $this->middleware('rolePermiso:Director (a) consejo académico',['only' => ['directorAcademico'] ]);
	    //$this->middleware('rolePermiso:Radicación',['only' => ['vista_consecutivos'] ]);
	    $this->middleware('roleDesarrollo:9',['only' => ['bandeja'] ]);
	    //$this->middleware('roleAcademico:44',['only' => ['vista_consecutivos'] ]);
	    $this->middleware('roleAcademico:39',['only' => ['academico','calendario','calendarioExcluidos','calendarioIncluidos'] ]);
	    $this->middleware('rolePermiso:Estudiante',['only' => ['bandeja2'] ]);
	    
	    //$this->middleware('role:1', ['only' => [''] ]);
	    //$this->middleware('role:Recepcion|Admin', ['except' => ['ListarCitas','getListarCitas','Atencion','getDatosAtencion','GuardarAtencion','AtencionOrtodoncia','getDatosOrtodoncia','GuardarAtencionOrtodoncia','PasarAtencion','Higiene','getDatosHigiene','GuardarHigiene','Evolucion','getEvoluciones','GuardarEvolucion'] ]);
	    //$this->middleware('role:Odontologo', ['only' => ['Atencion','getDatosAtencion','GuardarAtencion','AtencionOrtodoncia','getDatosOrtodoncia','GuardarAtencionOrtodoncia','PasarAtencion','Higiene','getDatosHigiene','GuardarHigiene','Evolucion','getEvoluciones','GuardarEvolucion'] ]);
	}*/
	public function __construct()
    {
        
        $this->middleware('auth');
        $this->middleware('role:estudiante|dependencia|secretariaGeneral|consejoAcademico|radicacion',['only'=>['datos_para_solicitud','obtenerFechaEstimada','obtenerDuracion','ver_mas']]);
        $this->middleware('role:consejoAcademico|estudiante|dependencia|secretariaGeneral',['only'=>['pdf_respuesta']]);
        $this->middleware('role:secretariaGeneral|estudiante',['only'=>['aprobar_solicitud']]);
        
        $this->middleware('role:estudiante',['only'=>['bandeja2','listado_solicitudes_estudiantes','crear_solicitud_estudiante']]);
        
        $this->middleware('role:dependencia|consejoAcademico',['only'=>['bandeja3','crear_solicitud_concepto','listado_solicitudes_dependencias','reenviar_solicitud']]);
        
        $this->middleware('role:dependencia',['only'=>['bandeja3','crear_solicitud_concepto']]);
        
        $this->middleware('role:radicacion',['only'=>['vista_consecutivos','','solicitudes_radicacion','guardar_consecutivoRespuesta','guardar_consecutivo']]);
        
        $this->middleware('role:consejoAcademico',['only'=>['crear_solicitud_concepto','guardarEncargado','fechasCalendarioExcluidos','fechasCalendarioIncluidos',
        'fechasCalendario','agregarFechasExcluidos','agregarFechasIncluidos','responder_academico','calendario','calendarioIncluidos','calendarioExcluidos','fechasCalendario']]);
        
        
        
        $this->middleware('role:secretariaGeneral',['only'=>['directorAcademico','aprobar_directorAcademico','noAprobarDirector','listado_solicitudes_directorAcademico','ver_mas_academico']]);
        
        
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
        
        
    }

	public function bandeja2() {
        return view('Solicitudes.bandeja2');
      }
      public function bandeja() {
            return view('Solicitudes.bandeja');
      }
      public function bandeja3() {
          
            return view('Solicitudes.bandeja3');
      }
      public function directorAcademico() {
          
            return view('Solicitudes.directorAcademico');
      }
      public function aprobar_directorAcademico() {
          
            return view('Solicitudes.aprobar_directorAcademico');
      }
      public function responder($id) {
          
            return view('Solicitudes.responder', array('id' => $id));
      }
      /*
      public function academico() {
          
            return view('academico');
      }*/
      
	public function datos_para_solicitud(){
	    $lista_acciones = Accione::all();
	    $lista_asuntos = Asunto::all();
	    $lista_tipos = Tipo::where('id','<>',4)->get();
	    $lista_dependencia = User::where('estado',1)->where('id','<>',Auth::user()->id)->whereHas('roles', function ($query) {
            $query->where('role_id',1);
        })->get();
        
	    return ["solicitudesRespresentanteEstudiantil"=>$lista_solicitudes,"representante"=>$representante,"roles"=>$roles,"acciones"=>$lista_acciones, "asuntos"=>$lista_asuntos, "tipos"=>$lista_tipos, "dependencias"=>$lista_dependencia, "solicitudesConceptos"=>$solicitudesConceptos];
	}
	
    public function crear_solicitud (Request $request){
        //return Auth::user()->codigo;
        //return $request->all();
        if(Auth::user()->id==$this->desarrollo_estudiantil){
            $request->Estudiante = intval($request->Estudiante);
        }
        
        $request->Tipo = intval($request->Tipo);
        $request->asunto = intval($request->asunto);
        //$request->Dependencia = intval($request->Dependencia);
        
        $clave = md5("DELUNOALSIETE*".''.date("d/m/Y"));
        $clave = strtoupper($clave);
        $data = [
                'codigo' => $request->Estudiante,
                'token' => $clave,
            ];
       
        $client = new \GuzzleHttp\Client(['headers' => $this->headers ]);
        $response = $client->post( 'http://softsimulation.com/WebServices/SeguimientoControl', [ 'body' => json_encode($data) ]);
        $res = (array) json_decode( $response->getBody()->getContents() ) ;
        //return $res;
        if($res==true && $res["estudiante"]!=null){
            
            $user = User::where('codigo',$request->Estudiante)->first();
            
            if($user==null){
                $user = new User();
                $user->nombre = $res["estudiante"]->NOMBRES;
                $user->codigo = $res["estudiante"]->COD;
                $user->email = $res["estudiante"]->EMAIL;
                $user->programa = $res["estudiante"]->PROGRAMA;
                $user->estado = 1;
                $user->user_create = "Prueba";
                $user->save();
                
                $user->roles()->attach($this->rolEstudiantes);
            }
            
        }else{
            if($res["estudiante"]==null){
                return ["success"=>false,"errores"=>["Código del estudiante no válido."]];
            }else{
                return ["success"=>false,"errores"=>["La conexión con el servicio ha sido fallida."]];    
            }
            
        }
        
        $validator = \Validator::make($request->all(), [
            'Asunto' => 'string|min:1|max:150',
            //'Descripcion' => 'required_if:Dependencia,,39',
            'Dependencia' => 'required|exists:role_user,user_id',
            'asunto' => 'required_if:Dependencia,39|exists:asuntos,id',
            'Tipo' => 'required|exists:tipos,id',
            'Galeria.*' => 'mimes:pdf',
            'Galeria' =>'array|max:3',
            
        ],[
            'Asunto.string' => 'El asunto debe ser de tipo string.',
            'Asunto.min' => 'El asunto debe ser mínimo de 1 carácter.',
            'Asunto.max' => 'El asunto debe ser maximo de 120 carácteres.',
            //'Descripcion.required_if' => 'La descripcion es requerida.',
            'asunto.required_if' => 'El asunto es requerido.',
            'asunto.exists' => 'El asunto debe existir.',
            'Dependencia.required' => 'La dependencia de destino es requerida.',
            'Dependencia.exists' => 'La dependencia debe existir.',
            'Tipo.required' => 'El tipo de solicitud es requerido.',
            'Tipo.exists' => 'El tipo de solicitud debe existir.',
            'Galeria.*.mimes' => 'subir solo archivos pdf',
            'Galeria.max'=>'La cantidad máxima de archivos es 3.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        return $request->all();
        if($request->Dependencia==$this->academico){
            $error = [];
            if($request->asunto == null){
                $error["asunto"][sizeof($error)] = "El campo asunto es requerido.";
                return ["success"=>false,"errores"=>$error];
            }
            if($request->Descripcion == null){
                $error["descripcion"][sizeof($error)] = "El campo descripción es requerido.";
                return ["success"=>false,"errores"=>$error];
            }
            if(Asunto::where('id',intval($request->asunto))->first() == null){
                $error["asunto"][sizeof($error)] = "EL asunto debe existir en el sistema.";
                return ["success"=>false,"errores"=>$error];
            }
            
        }
        if($request->Galeria != null){
            $contFile = 0;
            $error = [];
            $error["Galeria"][0] = "Tamaño total de los adjuntos exceden los 10MB";
            for($i=0; $i<sizeof($request->Galeria); $i++){
                $tamaño = filesize($request->Galeria[$i]);
                $contFile = ($tamaño/1024)+ $contFile;
                if($contFile > 10000){
                    return ["success"=>false,"errores"=>$error];
                }
            }
            
        }
        $valor = Solicitude::all();
        if(count($valor)==0){
            $ultimo=1;
            
        }else{
            $valor = $valor->last();
            $ultimo = $valor->id+1;
        }
        
            $solicitud = new Solicitude();
            
            if($request->Dependencia==$this->academico){
                //$request->asunto==null;
                $solicitud->asunto_id = $request->asunto;
            }else{
                //$request->asunto_id==null;
                $solicitud->asunto = $request->Asunto;
            }
            
            $solicitud->asunto_id = $request->asunto;
            $solicitud->contenido = $request->Descripcion;
            $solicitud->tipo_id = 2;
            //$solicitud->tipo_id = intval($request->Tipo);
            $date3 = $date2 = $date1 = $date = Carbon::now();
            $solicitud->codigo = "CC".$date.(string)$ultimo;
            $solicitud->user_create = Auth::user()->nombre;
            $solicitud->save();
        
        
        for ($i=0;$i<sizeof($request->Galeria);$i++){
            $multimedia = new Multimedias_Solicitude();
            $multimedia->solicitude_id = $solicitud->id;
            $date->addSeconds($i); 
            $nombrex = $solicitud->id."-".$i."-".date("Ymd-His").".".$request->Galeria[$i]->getClientOriginalExtension();
           \Storage::disk('documentos')->put($nombrex,  \File::get($request->Galeria[$i]));
            $multimedia->ruta = "/documentos/".$nombrex;
            $multimedia->user_create = Auth::user()->nombre;
            $multimedia->save();
        }
     
   
        
        $solicitude_user = new Solicitude_User();
        $solicitude_user->user_id = $this->desarrollo_estudiantil;
        $solicitude_user->solicitude_id = $solicitud->id;
        $solicitude_user->created_at = $date1;
        $solicitude_user->save();
        
        //$user_correo = User::where('id',5/*$request->Dependencia*/)->first();
        
        $solicitude_user_accione = new Solicitude_User_Accione();
        $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
        $solicitude_user_accione->accione_id = $this->creada;
      
        $date1->toDateString();
        $solicitude_user_accione->fecha = $date1;
        $solicitude_user_accione->save();
        
        $solicitude_user = new Solicitude_User();
        //$user = User::where('codigo',$request->Estudiante)->first();
        $solicitude_user->user_id = $this->academico;
        $solicitude_user->solicitude_id = $solicitud->id;
         $solicitude_user->created_at = $date1;
        $solicitude_user->save();
        
        $solicitude_user = new Solicitude_User();
        //$user = User::where('codigo',$request->Estudiante)->first();
        $solicitude_user->user_id = $user->id;
        $solicitude_user->solicitude_id = $solicitud->id;
         $solicitude_user->created_at = $date1;
        $solicitude_user->save();
        
        
        $date2->addSeconds(2); 
        $date2->toDateString();
        $solicitude_user_accione = new Solicitude_User_Accione();
        $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
        $solicitude_user_accione->accione_id = $this->sinaprobar;
      
        $date1->toDateString();
        $solicitude_user_accione->fecha = $date2;
        $solicitude_user_accione->save();
        
        $user_correo = User::where('id',$user->id/*$request->Dependencia*/)->first();
        /*
        $solicitude_user_accione = new Solicitude_User_Accione();
        $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
        $solicitude_user_accione->accione_id = 5;
        $date2->addSeconds(2); 
        $date2->toDateString();
        $solicitude_user_accione->fecha = $date2;
        $solicitude_user_accione->save();
        */
        
        
        
        $solicitude_user = new Solicitude_User();
        $solicitude_user->user_id = $this->academico;
        $solicitude_user->solicitude_id = $solicitud->id;
        $solicitude_user->created_at = $date1;
        $solicitude_user->save();
        
        /*
        $solicitude_user_accione = new Solicitude_User_Accione();
        $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
        $solicitude_user_accione->accione_id = 3;
        $date3->addSeconds(4); 
        $date3->toDateString();
        $solicitude_user_accione->fecha = $date3;
        $solicitude_user_accione->save();
        */
        $data = $request->all();
        //if($request->Dependencia==$this->academico){
                
            $asunto=Asunto::where('id',$request->asunto)->first();
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        
        /*
        \Mail::send('VistasEmails.emails', $data, function($message) use ($request, $user_correo){
           //remitente
           $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
 
           //asunto
           $message->subject("Notificación - Nueva solicitud");
 
           //receptor
           $message->to($user_correo->email, $user_correo->nombre);
        });
        if( count(\Mail::failures()) > 0 ) {
            return ["success"=>false,"errores"=>"La solicitud ha sido creada, pero no se pudo notificar a la dependencia que se dirige. Por favor, comunicarse con el remitente."];
           
        } else {*/
            return  ["success"=>true];
        //}
        
    }
    public function crear_solicitud_estudiante (Request $request){
        //return $request->all();
        //return $request->Galeria;
        //$request->Tipo = intval($request->Tipo);
        
        //return $request->Asunto;
        $validator = \Validator::make($request->all(), [
            'Asunto' => 'required_unless:Dependencia,39|string|min:1|max:150',
            'Descripcion' => 'required',
            //'Tipo' => 'required|exists:tipos,id',
            'asunto' => 'required_if:Dependencia,39|exists:asuntos,id',
            'Dependencia' => 'required|exists:users,id',
            'Galeria.*' => 'mimes:pdf',
            
        ],[
            'Asunto.required_unless' => 'El asunto es requerido.',
            'Asunto.string' => 'El asunto debe ser de tipo string.',
            'Asunto.min' => 'El asunto debe ser mínimo de 1 carácter.',
            'Asunto.max' => 'El asunto debe ser maximo de 120 carácteres.',
            'asunto.required_if' => 'El asunto es requerido.',
            'asunto.exists' => 'El asunto debe existir en el sistema.',
            'Dependencia.required' => 'La dependencia es requerida.',
            'Dependencia.exists' => 'La dependencia destino debe existir.',
            'Descripcion.required' => 'La descripcion es requerida.',
            //'Tipo.required' => 'El tipo de solicitud es requerido.',
            //'Tipo.exists' => 'El tipo de solicitud debe existir.',
            'Galeria.*.mimes' => 'subir solo archivos pdf',
            'Galeria.max'=>'La cantidad máxima de archivos es 3.',
            
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        //return $request->all();
        /*/if($request->Dependencia==$this->academico){
            $error = [];
            if($request->asunto == null){
                $error["asunto"][sizeof($error)] = "El campo asunto es requerido.";
                return ["success"=>false,"errores"=>$error];
            }
            if(Asunto::where('id',intval($request->asunto))->first() == null){
                $error["asunto"][sizeof($error)] = "EL asunto debe existir en el sistema.";
                return ["success"=>false,"errores"=>$error];
            }
            
        }*/
        if($request->Galeria != null){
            $contFile = 0;
            $error = [];
            $error["Galeria"][0] = "Tamaño total de los adjuntos exceden los 10MB";
            for($i=0; $i<sizeof($request->Galeria); $i++){
                $tamaño = filesize($request->Galeria[$i]);
                $contFile = ($tamaño/1024)+ $contFile;
                if($contFile > 10000){
                    return ["success"=>false,"errores"=>$error];
                }
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
        $solicitud = new Solicitude();
        if($request->Dependencia==$this->academico){
                //$request->asunto==null;
            $solicitud->asunto_id = $request->asunto;
        }else{
            //$request->asunto_id==null;
            $solicitud->asunto = $request->Asunto;
        }
        //$solicitud->asunto_id = $request->asunto;
        $solicitud->contenido = $request->Descripcion;
        $solicitud->tipo_id = 2;
        //$solicitud->tipo_id = intval($request->Tipo);
        $date6 = $date5 = $date4 = $date3 = $date2 = $date1 = $date = Carbon::now();
        $solicitud->codigo = "CC".$date.(string)$ultimo;
        $solicitud->user_create = Auth::user()->nombre;
        if($request->emailAdicional != null){
            $solicitud->email_adicional = $request->emailAdicional;
        }
        $solicitud->save();

        if($request->Galeria != null){
            for ($i=0;$i<sizeof($request->Galeria);$i++){
                $multimedia = new Multimedias_Solicitude();
                $multimedia->solicitude_id = $solicitud->id;
                $date->addSeconds($i); 
                $nombrex = $solicitud->id."-".$i."-".date("Ymd-His").".".$request->Galeria[$i]->getClientOriginalExtension();
                //return $nombrex;
                \Storage::disk('solicitudes')->put($nombrex,  \File::get($request->Galeria[$i]));
                $multimedia->ruta = "/solicitudes/".$nombrex;
                $multimedia->user_create = Auth::user()->nombre;
                $multimedia->user_update = Auth::user()->nombre;
                $multimedia->save();
            }
        }
   
        
        $solicitude_user = new Solicitude_User();
        $solicitude_user->user_id = Auth::user()->id;
        $solicitude_user->solicitude_id = $solicitud->id;
        $solicitude_user->created_at = $date1;
        $solicitude_user->updated_at = $date1;
        $solicitude_user->save();
        
        //$user_correo = User::where('id',5/*$request->Dependencia*/)->first();
        
        $solicitude_user_accione = new Solicitude_User_Accione();
        $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
        $solicitude_user_accione->accione_id = $this->creada;
      
        $date1->toDateString();
        $solicitude_user_accione->fecha = $date1;
        $solicitude_user_accione->save();
        
        $date2->addSeconds(2); 
        $date2->toDateString();
        $solicitude_user_accione = new Solicitude_User_Accione();
        $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
        $solicitude_user_accione->accione_id = $this->sinaprobar;
      
        $date1->toDateString();
        $solicitude_user_accione->fecha = $date2;
        $solicitude_user_accione->save();
        
        $date3->addSeconds(3); 
        $date3->toDateString();
        $solicitude_user_accione = new Solicitude_User_Accione();
        $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
        $solicitude_user_accione->accione_id = $this->aprobada;
        $solicitude_user_accione->fecha = $date3;
        $solicitude_user_accione->save();
        
        
        $date4->addSeconds(4); 
        $date4->toDateString();
        $solicitude_user = new Solicitude_User();
        //$user = User::where('codigo',$request->Estudiante)->first();
        $solicitude_user->user_id = 44;
        $solicitude_user->solicitude_id = $solicitud->id;
         $solicitude_user->created_at = $date4;
         $solicitude_user->updated_at = $date4;
        $solicitude_user->save();
        
        $date4->addSeconds(4); 
        $date4->toDateString();
        $solicitude_user_accione = new Solicitude_User_Accione();
        $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
        $solicitude_user_accione->accione_id = 10;
        $solicitude_user_accione->fecha = $date4;
        $solicitude_user_accione->save();
        
        $date5->addSeconds(5); 
        $date5->toDateString();
        if($request->Dependencia == 39){
            $solicitude_user = new Solicitude_User();
            //$user = User::where('codigo',$request->Estudiante)->first();
            $solicitude_user->user_id = 43;
            $solicitude_user->solicitude_id = $solicitud->id;
             $solicitude_user->created_at = $date5;
             $solicitude_user->updated_at = $date5;
            $solicitude_user->save();
        }
        
        $date6->addSeconds(6); 
        $date6->toDateString();
        
        $solicitude_user = new Solicitude_User();
        //$user = User::where('codigo',$request->Estudiante)->first();
        $solicitude_user->user_id =$request->Dependencia;
        $solicitude_user->solicitude_id = $solicitud->id;
         $solicitude_user->created_at = $date6;
         $solicitude_user->updated_at = $date6;
        $solicitude_user->save();
        
        
        $user_correoRadicacion = User::where('id',44)->first();
    
        $data = $request->all();
        
        $asunto = Asunto::find($request->asunto);
        $data["Asunto"] = $request->Dependencia == 39 ? $asunto->nombre : $request->Asunto;
        
            try{
                \Mail::send('VistasEmails.emails', $data, function($message) use ($request, $user_correoRadicacion){
                   //remitente
                   $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
         
                   //asunto
                   $message->subject("Notificación - Nueva solicitud");
         
                   //receptor
                   $message->to($user_correoRadicacion->email, $user_correoRadicacion->nombre);
                });
            }catch(\Exception $e){
                // Never reached
                //return $e;
            }
            
            $userEstudiante = User::where('id',Auth::user()->id)->first();
            
            try{
                
                \Mail::send('VistasEmails.emailCreacion',$data, function($message) use ($request, $userEstudiante){
                   //remitente
                   $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
         
                   //asunto
                   $message->subject("Notificación - Nueva solicitud");
         
                   //receptor
                   $message->to($userEstudiante->email, $userEstudiante->nombre);
                });
            }catch(\Exception $e){
                // Never reached
                //return $e;
            }
            
            if($solicitud->email_adicional != null){
                try{
                    \Mail::send('VistasEmails.emailCreacion', $data, function($message) use ($request, $userEstudiante,$solicitud){
                       //remitente
                       $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
             
                       //asunto
                       $message->subject("Notificación - Nueva solicitud");
             
                       //receptor
                       $message->to($solicitud->email_adicional, $userEstudiante->nombre);
                    });
                }catch(\Exception $e){
                    // Never reached
                    //return $e;
                }
            }
            
            return  ["success"=>true];
        
    }
    
    public function crear_solicitud_concepto (Request $request){
        //return $request->all();
        
        $validator = \Validator::make($request->all(), [
            'Asunto' => 'string|min:1|max:150',
            'Descripcion' => 'required',
            'Galeria.*' => 'mimes:pdf',
            'Galeria' =>'array|max:3',
            'Dependencia_destino' => 'required|exists:users,id',
        ],[
            'Asunto.required' => 'El asunto es requerido.',
            'Asunto.string' => 'El asunto debe ser de tipo string.',
            'Asunto.min' => 'El asunto debe ser mínimo de 1 carácter.',
            'Asunto.max' => 'El asunto debe ser maximo de 120 carácteres.',
            'Descripcion.required' => 'La descripcion es requerida.',
            'Dependencia_destino.required' => 'La dependecncia destino es requerida.',
            'Dependencia_destino.exists' => 'La dependencia destino debe existir.',
            'Galeria.*.mimes' => 'subir solo archivos pdf',
            'Galeria.max'=>'La cantidad máxima de archivos es 3.',
            
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
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
        
        for ($i=0;$i<sizeof($request->Galeria);$i++){
            $multimedia = new Multimedias_Solicitude_concepto();
            $multimedia->solicitude_concepto_id = $solicitud->id;
            $date->addSeconds($i); 
            $nombrex = $solicitud->id."-".$i."-".date("Ymd-His").".".$request->Galeria[$i]->getClientOriginalExtension();
           \Storage::disk('documentos')->put($nombrex,  \File::get($request->Galeria[$i]));
            $multimedia->ruta = "/documentos/".$nombrex;
            $multimedia->user_create = Auth::user()->nombre;
            $multimedia->save();
        }
        
        $user_correo = User::where('id',$request->Dependencia/*$request->Dependencia*/)->first();
        
        $data = $request->all();
        /*
            \Mail::send('VistasEmails.emails', $data, function($message) use ($request, $user_correo){
               //remitente
               $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
     
               //asunto
               $message->subject("Notificación - Nueva solicitud");
     
               //receptor
               $message->to($user_correo->email, $user_correo->nombre);
            });
            
                //return ["success"=>false,"errores"=>"La solicitud ha sido creada, pero no se pudo notificar a la dependencia que se dirige. Por favor, comunicarse con el remitente."];
            
        if( count(\Mail::failures()) > 0 ) {
            return ["success"=>false,"errores"=>"La solicitud ha sido creada, pero no se pudo notificar a la dependencia que se dirige. Por favor, comunicarse con el remitente."];
           
        } else {*/
            return  ["success"=>true];
        //}
               
        
        
        
        
    }
    public function aprobar_solicitud(Request $request){
        
        ////return $request->contenido;
        if(Auth::user()->id!=$this->directorAcademico){
            $solicitude_estudiante = Solicitude_User::where('solicitude_id',$request->solicitud_id)
            ->join("users","solicitude_user.user_id","=","users.id")
            ->join("solicitudes","solicitude_user.solicitude_id","=","solicitudes.id")
            ->join("role_user","users.id","=","role_user.user_id")
            ->join("roles","role_user.role_id","=","roles.id")
            ->where('roles.id','<>',$this->rolDependencias)
            ->select("users.id as estudiante_id", "users.email as email_estudiante","users.nombre as nombre_estudiante", "roles.id as role_id",
            "solicitude_user.id as solicitude_user_id", "solicitudes.asunto as Asunto")->first();
            
            $solicitude_dependencia = Solicitude_User::where('solicitude_id',$request->solicitud_id)
            ->join("users","solicitude_user.user_id","=","users.id")
            ->join("solicitudes","solicitude_user.solicitude_id","=","solicitudes.id")
            ->join("role_user","users.id","=","role_user.user_id")
            ->join("roles","role_user.role_id","=","roles.id")
            //->where('roles.id','<>',$this->rolEstudiantes)
            ->where('roles.id','<>',$this->rolEstudiantes)->where('users.id','<>',$this->desarrollo_estudiantil)
            ->select("users.id as dependencia_id", "users.email as email_dependencia","users.nombre as nombre_dependencia", "roles.id as role_id",
            "solicitude_user.id as solicitude_user_id", "solicitudes.asunto as Asunto")->first();
            //return $solicitude_estudiante;
            
            $solicitud = Solicitude::where('id',$request->solicitud_id)->first();
            $solicitud->contenido=$request->contenido;
            $solicitud->save();
            $date = Carbon::now();
            
            for ($i=0;$i<sizeof($request->Galeria);$i++){
                $multimedia = new Multimedias_Solicitude();
                $multimedia->solicitude_id = $solicitud->id;
                $date->addSeconds($i); 
                $nombrex = $solicitud->id."-".$i."-".date("Ymd-His").".".$request->Galeria[$i]->getClientOriginalExtension();
               \Storage::disk('documentos')->put($nombrex,  \File::get($request->Galeria[$i]));
                $multimedia->ruta = "/documentos/".$nombrex;
                $multimedia->user_create = Auth::user()->nombre;
                $multimedia->save();
            }
            
            $date2=$date = Carbon::now();
            $solicitude_user_accione = new Solicitude_User_Accione();
            
            $solicitude_user_accione->accione_id = $this->aprobada;
            $solicitude_user_accione->solicitude_user_id = $solicitude_estudiante->solicitude_user_id;
            $solicitude_user_accione->fecha = $date;
            $solicitude_user_accione->save();
            
            $solicitude_user_accione = new Solicitude_User_Accione();
            $date2->addSeconds(2); 
            $solicitude_user_accione->accione_id = 10;
            $solicitude_user_accione->solicitude_user_id = $solicitude_dependencia->solicitude_user_id;
            $solicitude_user_accione->fecha = $date2;
            $solicitude_user_accione->save();
            
            $data = $solicitude_estudiante;
            //return $data;
            /*
            \Mail::send('VistasEmails.emails', $data->toArray(), function($message) use ($solicitude_dependencia){
                   //remitente3
                   $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
         
                   //asunto
                   $message->subject("Notificación - Nueva solicitud");
         
                   //receptor
                   $message->to($solicitude_dependencia->email_dependencia, $solicitude_dependencia->nombre_dependencia);
            });
            if( count(Mail::failures()) > 0 ) {
                return ["success"=>false,"errores"=>"La solicitud ha sido creada, pero no se pudo notificar a la dependencia que se dirige. Por favor, comunicarse con el remitente."];
               
            } else {*/
                return  ["success"=>true];
            //}    
        }else{
            
            $solicitude_estudiante = Solicitude_User::where('solicitude_id',$request->solicitud_id)
            ->join("users","solicitude_user.user_id","=","users.id")
            ->join("solicitudes","solicitude_user.solicitude_id","=","solicitudes.id")
            ->join("role_user","users.id","=","role_user.user_id")
            ->join("roles","role_user.role_id","=","roles.id")
            ->where('roles.id','<>',$this->rolDependencias)
            ->select("users.id as estudiante_id", "users.email as email_estudiante","users.nombre as nombre_estudiante", "roles.id as role_id",
            "solicitude_user.id as solicitude_user_id", "solicitudes.asunto as Asunto", "solicitudes.asunto_id")->first();
            
            $solicitude_dependencia = Solicitude_User::where('solicitude_id',$request->solicitud_id)
            ->join("users","solicitude_user.user_id","=","users.id")
            ->join("solicitudes","solicitude_user.solicitude_id","=","solicitudes.id")
            ->join("role_user","users.id","=","role_user.user_id")
            ->join("roles","role_user.role_id","=","roles.id")
            ->where('users.id',44)
            //->where('roles.id','<>',$this->rolEstudiantes)->where('users.id','<>',$this->desarrollo_estudiantil)
            ->select("users.id as dependencia_id", "users.email as email_dependencia","users.nombre as nombre_dependencia", "roles.id as role_id",
            "solicitude_user.id as solicitude_user_id", "solicitudes.asunto as Asunto", "solicitudes.id as id_solicitud","solicitudes.asunto_id")->orderby('solicitude_user_id','DESC')->take(1)->get();
            //return $solicitude_dependencia[0];
            
            $date2=$date = Carbon::now();
            
            $solicitude_user_accione = new Solicitude_User_Accione();
             
            $solicitude_user_accione->accione_id = 11;
            $solicitude_user_accione->solicitude_user_id = $solicitude_dependencia[0]->solicitude_user_id;
            $solicitude_user_accione->fecha = $date2;
            $solicitude_user_accione->save();
            
            $solicitud = Solicitude::where('id',$solicitude_dependencia[0]->id_solicitud)->first();
            $solicitud->respuesta=1;
            $solicitud->save();
            
            $user_correoRadicacion = User::where('id',44)->first();
    
            $data = [];
            $asunto = Asunto::find($solicitude_dependencia[0]->asunto_id);
            $data["Asunto"] = $asunto->nombre;
            //return $data;
            try{
                \Mail::send('VistasEmails.emailRespuesta_esperaRad', $data, function($message) use ($user_correoRadicacion){
                       //remitente3
                       $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
             
                       //asunto
                       $message->subject("Notificación - Respuesta solicitud");
             
                       //receptor
                       $message->to($user_correoRadicacion->email, $user_correoRadicacion->nombre);
                });
            }catch(\Exception $e){
                // Never reached
                //return $e;
            }
                return  ["success"=>true];
            //}
            //return $request;
        }
        
    }
    public function obtenerFechaEstimada($fecha,$limite){
        
        $diaActual = Carbon::now();
        $diaSiguiente = $fecha;
        $diaSiguienteObtenerFecha = $fecha;
        $indice=0;
        $lista_dias=[];
        $sw=0;
        //return [$diaSiguiente,$date];
        $diaSiguienteObtenerFecha = strtotime ( '+'.$limite.' day' ,  strtotime($diaSiguienteObtenerFecha) ) ;
        //return $diaSiguienteObtenerFecha;
        $diaSiguienteObtenerFecha = date('Y-m-d H:i:s',$diaSiguienteObtenerFecha);
        $fecha=date('Y-m-d H:i:s',strtotime($fecha));
        //return [$fecha, $diaSiguienteObtenerFecha];
        $diferenciaFecha = $limite;
        $diaSiguienteCont =$fecha;
        $contFinesSemana =0;
        //while(strtotime($diaSiguienteCont) <= strtotime($diaSiguienteObtenerFecha)){
        $duracion =0;
        while($duracion < $limite){    
            $diaSiguienteCont = date('Y-m-d',strtotime($diaSiguienteCont));
            //return $diaSiguienteCont;
            $diaSiguienteObtenerFecha = date('Y-m-d',strtotime($diaSiguienteObtenerFecha));
            $diasIncluidos = Calendario_fecha::where([['fecha',">",$diaSiguienteCont],['fecha',"<=",$diaSiguienteObtenerFecha],['tipo',1]])->count();
            //return $diasIncluidos;
            $diasExcluidos = Calendario_fecha::where([['fecha',">",$diaSiguienteCont],['fecha',"<=",($diaSiguienteObtenerFecha)],['tipo',0]])->count();
            
            //return date('Y-m-d',$diaSiguiente);
            
            //$busqueda = Calendario_fecha::where('fecha',$diaSiguiente)->first();
            //return $busqueda;
            //return [intval(date('N', strtotime($diaSiguiente))),intval(date('N', strtotime($diaSiguiente)))];
            $contFinesSemana = 0;
            
            while(strtotime($diaSiguienteCont) < strtotime($diaSiguienteObtenerFecha)){
                $diaSiguienteCont = strtotime ( '+1 day' ,  strtotime($diaSiguienteCont) ) ;
                $diaSiguienteCont = date('Y-m-d',$diaSiguienteCont);
                
                //$busqueda = Calendario_fecha::where('fecha',$diaSiguiente)->first();
                //return $busqueda;
                //return [intval(date('N', strtotime($diaSiguiente))),intval(date('N', strtotime($diaSiguiente)))];
                if(intval(date('N', strtotime($diaSiguienteCont)))<1 || intval(date('N', strtotime($diaSiguienteCont)))>5){
                    $contFinesSemana = $contFinesSemana+1;
                    //return $contFecha;
                }
                
                
            }
            
            
            $duracion = ($diferenciaFecha-intval($diasExcluidos)-intval($contFinesSemana)+intval($diasIncluidos))+$duracion;
            
            array_push($lista_dias,$duracion);
            array_push($lista_dias,(intval($diferenciaFecha)-intval($diasExcluidos)-intval($contFinesSemana)+intval($diasIncluidos)));
            
            if($duracion < $limite)
            {
                $calculoAdicion = $limite-$duracion;
                $diferenciaFecha = $calculoAdicion;
                
                $fechaAux = $diaSiguienteCont;
                
                $diaSiguienteObtenerFecha = strtotime ( '+'.$calculoAdicion.'day' ,  strtotime($diaSiguienteCont) ) ;   
                $diaSiguienteObtenerFecha = date('Y-m-d',$diaSiguienteObtenerFecha);
                
                
                array_push($lista_dias,$diaSiguienteCont);
                array_push($lista_dias,$diaSiguienteObtenerFecha);
                
                
            }
            
            
                   
                  
            
        }
        return $diaSiguienteObtenerFecha;
        //return [$lista_dias,$diaSiguienteObtenerFecha];
    }
    public function obtenerDuracion($fecha,$accion,$fechaAux){
        $date = Carbon::now();
        $date = date('Y-m-d',strtotime($date));
        if($accion==7){
            $date = $fechaAux;
        }
        $diaSiguiente = $fecha;
        
        $diferenciaFecha = date_diff(date_create($fecha),date_create($date));
        $diferenciaFecha=$diferenciaFecha->format('%R%a');
        $diferenciaFecha=substr($diferenciaFecha, 1);
        
        $diasIncluidos = Calendario_fecha::where([['fecha',">=",$fecha],['fecha',"<=",$date],['tipo',1]])->count();
        $diasExcluidos = Calendario_fecha::where([['fecha',">=",$fecha],['fecha',"<=",$date],['tipo',0]])->count();
        
        $indice=0;
        $lista_dias=[];
        $sw=0;
        //return [$diaSiguiente,$date];
        $contFinesSemana = 0;
        while(strtotime($diaSiguiente) <= strtotime($date)){
            
            /*if($indice==1){
                return $diaSiguiente;
            }*/
           
            $diaSiguiente = strtotime ( '+1 day' ,  strtotime($diaSiguiente) ) ;
            
            
            $indice= $indice+1;
            //return date('Y-m-d',$diaSiguiente);
            $diaSiguiente = date('Y-m-d',$diaSiguiente);
            array_push($lista_dias,$diaSiguiente);
            //$busqueda = Calendario_fecha::where('fecha',$diaSiguiente)->first();
            //return $busqueda;
            //return [intval(date('N', strtotime($diaSiguiente))),intval(date('N', strtotime($diaSiguiente)))];
            if(intval(date('N', strtotime($diaSiguiente)))<1 || intval(date('N', strtotime($diaSiguiente)))>5){
                $contFinesSemana = $contFinesSemana+1;
                //return $contFecha;
            }
            
            
        }
        
        $duracion = intval($diferenciaFecha)-intval($diasExcluidos)-intval($contFinesSemana)+intval($diasIncluidos);
        if($duracion<0){
            $duracion=0;
        }
        return $duracion;
    }
    public function listado_solicitudes(){
        
         $usuario=Auth::user();
        $user=User::where('id',$usuario->id)->first();
        $lista_solicitudes = [];
        $date = Carbon::now();
        
        $solicitude = ListaSolicitudes::where("idUsuario","=",$this->desarrollo_estudiantil)->orderby("idEstado", "DESC")->orderby("created_at","ASC")->orderby("tipo_id", "ASC")->get();
        
        for($i=0;$i<sizeof($solicitude);$i++){
            $contFinesSemana = 0;
            if($solicitude[$i]->asunto_id !=null){
                $asunto = Asunto::where('id',$solicitude[$i]->asunto_id)->first();
                $solicitude[$i]["asunto_nuevo"] = $asunto;
            }
            $solicitudes2=Solicitude_User::join("solicitude_user_accione","solicitude_user.id","=","solicitude_user_accione.solicitude_user_id")
            ->join("acciones",'solicitude_user_accione.accione_id',"=","acciones.id")
            ->join("users","solicitude_user.user_id","=","users.id")
            ->where("solicitude_user.solicitude_id","=",$solicitude[$i]->id)->
            select("solicitude_user_accione.fecha as fecha","solicitude_user_accione.comentario as comentario","acciones.nombre as accion",
            "acciones.id as id_acciones","users.id as id","users.nombre as nombre","users.id as user_id","solicitude_user.id as id_solicitude_user")
            ->orderby('solicitude_user_accione.id','DESC')->get();
             //$fecha = date_create($solicitudes2[$i]->fecha);
            $respuestas = Respuesta::where('solicitude_user_id',$solicitudes2[0]->id_solicitude_user)->with('multimedias_respuestas')->first();
            
            if($solicitudes2){
                    for($j=0;$j<sizeof($solicitudes2);$j++){
                        if($solicitudes2[$j]->id_acciones== $this->sinaprobar){
                            $fecha=$solicitudes2[$j]->fecha;
                            $fecha=date('Y-m-d',strtotime($fecha));
                        }
                        if($solicitudes2[$j]->id_acciones== $this->aprobada){
                            $fecha=$solicitudes2[$j+1]->fecha;
                            $fecha=date('Y-m-d',strtotime($fecha));
                            break;
                        }
                    }
                    //if($solicitudes2[0]->id_acciones!=$this->creada && $solicitudes2[0]->id_acciones!=$this->sinaprobar && $solicitudes2[0]->user_id==$user->id){
                        $alertaDuracion = 0;
                        $duracion=0;
                        if($solicitudes2[0]->id_acciones!=2){
                            //$alertaDuracion = 0;
                            if($solicitude[$i]->tipo_id==1){
                                $alertaDuracion = 10;
                            }else{
                                if($solicitude[$i]->tipo_id==2){
                                    $alertaDuracion = 15;
                                }
                            }
                            $fechaEstimada = $this->obtenerFechaEstimada($fecha,$alertaDuracion);
                            $duracion = $this->obtenerDuracion($fecha,$solicitudes2[0]->id_acciones,$date);
                        }else{
                            $fechaEstimada = $solicitudes2[0]->fecha;
                            $duracion = 0;
                        }
                        $solicitude[$i]["alertaDuracion"]  = $alertaDuracion-intval($duracion);
                        $solicitude[$i]["acciones"] = $solicitudes2;
                        $solicitude[$i]["respuestas"] = $respuestas;
                        
                        $solicitude[$i]["duracion"]  = $duracion;
                        $solicitude[$i]["fechaEstimada"]  = $fechaEstimada;
                        array_push($lista_solicitudes,$solicitude[$i]);
                    //}
                
                
            }
            
        }
        return $lista_solicitudes;
    }
    public function listado_solicitudes_academico(){
        
        $usuario=Auth::user();
        $user=User::where('id',$usuario->id)->first();
        $lista_solicitudes = [];
        $date = Carbon::now();
        
        
        $solicitude = ListaSolicitudes::where("idUsuario","=",$user->id)->orderby("idEstado", "DESC")->orderby("created_at","ASC")->orderby("tipo_id", "ASC")->get();
        
        
        for($i=0;$i<sizeof($solicitude);$i++){
            $contFinesSemana = 0;
            if($solicitude[$i]->asunto_id !=null){
                $asunto = Asunto::where('id',$solicitude[$i]->asunto_id)->first();
                $solicitude[$i]["asunto_nuevo"] = $asunto;
            }
            $solicitudes2=Solicitude_User::join("solicitude_user_accione","solicitude_user.id","=","solicitude_user_accione.solicitude_user_id")
            ->join("acciones",'solicitude_user_accione.accione_id',"=","acciones.id")
            ->join("users","solicitude_user.user_id","=","users.id")
            ->where("solicitude_user.solicitude_id","=",$solicitude[$i]->id)->
            select("solicitude_user_accione.fecha as fecha","solicitude_user_accione.comentario as comentario","acciones.nombre as accion",
            "acciones.id as id_acciones","users.id as id","users.nombre as nombre","users.id as user_id","solicitude_user.id as id_solicitude_user")
            ->orderby('solicitude_user_accione.id','DESC')->get();
            
            $estudiante=Solicitude_User::
                join("users","solicitude_user.user_id","=","users.id")
                ->join("role_user","role_user.user_id","=","users.id")
                ->where("solicitude_user.solicitude_id","=",$solicitude[$i]->id)->where('role_user.role_id','=',2)->
                select("users.id as id","users.nombre as nombre","users.codigo","users.email as email")->first();
                return $estudiante;
                $solicitude[$i]["estudiante"] = $estudiante;
            
            $respuestas = Respuesta::where('solicitude_user_id',$solicitudes2[0]->id_solicitude_user)->with('multimedias_respuestas')->first();
            
            if($solicitudes2){
                    for($j=0;$j<sizeof($solicitudes2);$j++){
                        if($solicitudes2[$j]->id_acciones== $this->sinaprobar){
                            $fecha=$solicitudes2[$j]->fecha;
                            $fecha=date('Y-m-d',strtotime($fecha));
                        }
                        if($solicitudes2[$j]->id_acciones== $this->aprobada){
                            $fecha=$solicitudes2[$j+1]->fecha;
                            $fecha=date('Y-m-d',strtotime($fecha));
                            break;
                        }
                    }
                    if($solicitudes2[0]->id_acciones!=$this->creada && $solicitudes2[0]->id_acciones!=$this->sinaprobar){
                        if($solicitudes2[0]->id_acciones==7){
                            $date=date('Y-m-d',strtotime($solicitudes2[0]->fecha));
                        }
                        $alertaDuracion = 0;
                        if($solicitude[$i]->tipo_id==1){
                            $alertaDuracion = 10;
                        }else{
                            if($solicitude[$i]->tipo_id==2){
                                $alertaDuracion = 15;
                            }
                        }
                        
                        $fechaEstimada = $this->obtenerFechaEstimada($fecha,$alertaDuracion);
                        $duracion = $this->obtenerDuracion($fecha,$solicitudes2[0]->id_acciones,$date);
                        
                        $solicitude[$i]["alertaDuracion"]  = $alertaDuracion-intval($duracion);
                        
                        $solicitude[$i]["acciones"] = $solicitudes2;
                        $solicitude[$i]["respuestas"] = $respuestas;
                        
                        $solicitude[$i]["duracion"]  = $duracion;
                        $solicitude[$i]["fechaEstimada"]  = $fechaEstimada;
                        array_push($lista_solicitudes,$solicitude[$i]);
                    }
                
                
            }
            
        }
        return $lista_solicitudes;
    }
    public function listado_solicitudes_dependencias(){
        
        $usuario=Auth::user();
        $user=User::where('id',$usuario->id)->first();
        $lista_solicitudes = [];
        $solicitudesConceptos = [];
        $estudiante = null;
        $date = Carbon::now();
        
        
        $solicitude = ListaSolicitudes::where("idUsuario","=",$user->id)->orderby("idEstado", "DESC")->orderby("created_at","DESC")->orderby("tipo_id", "ASC")->get();
        
        //return $solicitude;
        for($i=0;$i<sizeof($solicitude);$i++){
            $contFinesSemana = 0;
            if($solicitude[$i]->asunto_id !=null){
                $asunto = Asunto::where('id',$solicitude[$i]->asunto_id)->first();
                $solicitude[$i]["asunto_nuevo"] = $asunto;
            }
            $solicitudes2=Solicitude_User::join("solicitude_user_accione","solicitude_user.id","=","solicitude_user_accione.solicitude_user_id")
            ->join("acciones",'solicitude_user_accione.accione_id',"=","acciones.id")
            ->join("users","solicitude_user.user_id","=","users.id")
            ->where("solicitude_user.solicitude_id","=",$solicitude[$i]->id)->
            select("solicitude_user_accione.fecha as fecha","solicitude_user_accione.comentario as comentario","acciones.nombre as accion",
            "acciones.id as id_acciones","users.id as id","users.nombre as nombre","users.id as user_id","solicitude_user.id as id_solicitude_user")
            ->orderby('solicitude_user_accione.fecha','DESC')->get();
            
            $estudiante=Solicitude_User::
            join("users","solicitude_user.user_id","=","users.id")
            ->join("role_user","role_user.user_id","=","users.id")
            ->join("solicitudes","solicitudes.id","=","solicitude_user.solicitude_id")
            ->where("solicitude_user.solicitude_id","=",$solicitude[$i]->id)->where('role_user.role_id','=',2)->
            select("users.id as id","users.nombre as nombre","users.codigo","users.email as email",
            "solicitude_user.id as solicitude_user_id","solicitudes.id as idSolicitud","solicitudes.consecutivo as radicadoSolicitud")->first();
            $solicitude[$i]["estudiante"] = $estudiante;
            $respuestas = Respuesta::where('solicitude_user_id',$solicitudes2[0]->id_solicitude_user)->with('multimedias_respuestas')->first();
            
            
            
            
            
            if($solicitudes2){
                
                    /*for($j=0;$j<sizeof($solicitudes2);$j++){
                        if($solicitudes2[$j]->id_acciones== $this->sinaprobar){
                            $fecha=$solicitudes2[$j]->fecha;
                            $fecha=date('Y-m-d',strtotime($fecha));
                        }
                        if($solicitudes2[$j]->id_acciones== $this->aprobada){
                            $fecha=$solicitudes2[$j+1]->fecha;
                            $fecha=date('Y-m-d',strtotime($fecha));
                            break;
                        }
                    }*/
                    //return $solicitude[$i];
                    if($solicitude[$i]->fecha_radicado != null){
                        $fecha = date('Y-m-d',strtotime($solicitude[$i]->fecha_radicado));
                        
                    }else{
                        $fecha = Carbon::now();
                    }
                    if(Auth::user()->id != 39){
                        if($solicitudes2[0]->id_acciones!=$this->creada && $solicitudes2[0]->id_acciones!=$this->sinaprobar && $solicitudes2[0]->id_acciones!=10 && $solicitudes2[0]->user_id==$user->id){
                        
                            if($solicitudes2[0]->id_acciones==7){
                                $date=date('Y-m-d',strtotime($solicitudes2[0]->fecha));
                            }
                            $alertaDuracion = 0;
                            if($solicitude[$i]->tipo_id==1){
                                $alertaDuracion = 10;
                            }else{
                                if($solicitude[$i]->tipo_id==2){
                                    $alertaDuracion = 15;
                                }
                            }
                            
                            $fechaEstimada = $this->obtenerFechaEstimada($fecha,$alertaDuracion);
                            $duracion = $this->obtenerDuracion($fecha,$solicitudes2[0]->id_acciones,$date);
                            
                            $solicitude[$i]["alertaDuracion"]  = $alertaDuracion-intval($duracion);
                            
                            $solicitude[$i]["acciones"] = $solicitudes2;
                            $solicitude[$i]["respuestas"] = $respuestas;
                            
                            $solicitude[$i]["duracion"]  = $duracion;
                            $solicitude[$i]["fechaEstimada"]  = $fechaEstimada;
                            
                            array_push($lista_solicitudes,$solicitude[$i]);
                        }
                    }else{
                        if($solicitudes2[0]->id_acciones!=$this->creada && $solicitudes2[0]->id_acciones!=$this->sinaprobar && $solicitudes2[0]->id_acciones!=10){
                        
                            if($solicitudes2[0]->id_acciones==7){
                                $date=date('Y-m-d',strtotime($solicitudes2[0]->fecha));
                            }
                            $alertaDuracion = 0;
                            if($solicitude[$i]->tipo_id==1){
                                $alertaDuracion = 10;
                            }else{
                                if($solicitude[$i]->tipo_id==2){
                                    $alertaDuracion = 15;
                                }
                            }
                            
                            $fechaEstimada = $this->obtenerFechaEstimada($fecha,$alertaDuracion);
                            $duracion = $this->obtenerDuracion($fecha,$solicitudes2[0]->id_acciones,$date);
                            
                            $solicitude[$i]["alertaDuracion"]  = $alertaDuracion-intval($duracion);
                            
                            $solicitude[$i]["acciones"] = $solicitudes2;
                            $solicitude[$i]["respuestas"] = $respuestas;
                            
                            $solicitude[$i]["duracion"]  = $duracion;
                            $solicitude[$i]["fechaEstimada"]  = $fechaEstimada;
                            
                            array_push($lista_solicitudes,$solicitude[$i]);
                        }
                    }
                    
                
                
            }
            
        }
        $novedades = [];
        $lista_novedades_solicitud_user = [];
        $solicitude_user = Solicitude_User::where('user_id',Auth::user()->id)->get();
        if($solicitude_user){
            for($i=0;$i<sizeof($solicitude_user);$i++){
                $novedades_solicitud_user = Novedades_Solicitud_User::where('solicitud_user_dirigida_id',$solicitude_user[$i]->id)->get();
                if(sizeof($novedades_solicitud_user)>0){
                    array_push($lista_novedades_solicitud_user,$novedades_solicitud_user);
                }
            }
        }
        //return $lista_novedades_solicitud_user;
        if($lista_novedades_solicitud_user){
            for($i=0;$i<sizeof($lista_novedades_solicitud_user[0]);$i++){
               
               $novedad = Novedade::where('id',$lista_novedades_solicitud_user[0][$i]->novedade_id)->with('multimedias_novedades')->first();
               array_push($novedades,$novedad);
            }
            
        }
        $lista_dependencia = User::where('estado',1)->where('id','<>',Auth::user()->id)->whereHas('roles', function ($query) {
            $query->where('role_id',1);
        })->get();
        
        $lista_solicitudesConceptos_solicitud_user = [];
        //$lista_solicitudesConceptos_solicitud_user["idSolicitud"]=[];
        //return $lista_solicitudesConceptos_solicitud_user;
        $solicitude_user = Solicitude_User::where('user_id',Auth::user()->id)->get();
        $solicitudesConceptos = Solicitude_concepto::
        leftJoin('multimedias_solicitudes_conceptos', 'solicitudes_conceptos.id', '=', 'multimedias_solicitudes_conceptos.solicitude_concepto_id')
        ->leftJoin('respuestas_conceptos', 'solicitudes_conceptos.id', '=', 'respuestas_conceptos.solicitudes_conceptos_id')
        ->leftJoin('multimedias_respuestas_conceptos', 'respuestas_conceptos.id', '=', 'multimedias_respuestas_conceptos.respuestas_concepto_id')
        ->join('users', 'solicitudes_conceptos.user_creador_id', '=', 'users.id')
        ->join('users as usersDirigida', 'solicitudes_conceptos.user_dirigida_id', '=', 'usersDirigida.id')
        ->where('user_dirigida_id',Auth::user()->id)
        ->select("solicitudes_conceptos.id as id","solicitudes_conceptos.asunto as asunto","solicitudes_conceptos.texto as descripcion","solicitudes_conceptos.created_at as fechaCreacion",
            "users.nombre as nombreCreador", "usersDirigida.nombre as nombreDirigida", "multimedias_solicitudes_conceptos.ruta as multimediaSolicitud",
            "solicitudes_conceptos.solicitude_id as solicitudId", "solicitudes_conceptos.user_dirigida_id as dirigidaId"
        )
        ->with(['respuestaConcepto'=>function($q){$q->with('multimedias_respuestasConceptos');}])->orderBy('solicitudes_conceptos.created_at','desc')->get();
        
	    //return ["solicitudesRespresentanteEstudiantil"=>$lista_solicitudes,"representante"=>$representante,"roles"=>$roles,"acciones"=>$lista_acciones, "asuntos"=>$lista_asuntos, "tipos"=>$lista_tipos, "dependencias"=>$lista_dependencia, "solicitudesConceptos"=>$solicitudesConceptos];
        
        return ["lista_solicitudes"=>$lista_solicitudes,"solicitudesConceptos"=>$solicitudesConceptos,"novedades"=>$novedades,"dependencias"=>$lista_dependencia];
    }
    
    public function listado_solicitudes_directorAcademico(){
        
        $usuario=Auth::user();
        $user=User::where('id',$usuario->id)->first();
        $lista_solicitudes = [];
        $solicitudesConceptos = [];
        $date = Carbon::now();
        
        
        $solicitude = ListaSolicitudes::where('respondida',1)->where("idUsuario",43)->orderby("idEstado", "DESC")->orderby("created_at","ASC")->orderby("tipo_id", "ASC")->get();
        
        //return $solicitude;
        for($i=0;$i<sizeof($solicitude);$i++){
            $contFinesSemana = 0;
            if($solicitude[$i]->asunto_id !=null){
                $asunto = Asunto::where('id',$solicitude[$i]->asunto_id)->first();
                $solicitude[$i]["asunto_nuevo"] = $asunto;
            }
            if($solicitude[$i]->tipo_id != 4){
                $solicitudes2=Solicitude_User::join("solicitude_user_accione","solicitude_user.id","=","solicitude_user_accione.solicitude_user_id")
                ->join("acciones",'solicitude_user_accione.accione_id',"=","acciones.id")
                ->join("users","solicitude_user.user_id","=","users.id")
                ->where("solicitude_user.solicitude_id","=",$solicitude[$i]->id)->
                select("solicitude_user_accione.fecha as fecha","solicitude_user_accione.comentario as comentario","acciones.nombre as accion",
                "acciones.id as id_acciones","users.id as id","users.nombre as nombre","users.id as user_id","solicitude_user.id as id_solicitude_user")
                ->orderby('solicitude_user_accione.id','DESC')->get();
                
                $estudiante=Solicitude_User::
                join("users","solicitude_user.user_id","=","users.id")
                ->join("role_user","role_user.user_id","=","users.id")
                ->where("solicitude_user.solicitude_id","=",$solicitude[$i]->id)->where('role_user.role_id','=',2)->
                select("users.id as id","users.nombre as nombre","users.codigo","users.email as email")->first();
                
                $solicitude[$i]["estudiante"] = $estudiante;
                $respuestas = Respuesta::
                    join("solicitude_user","solicitude_user.id","=","respuestas.solicitude_user_id")
                    ->where('solicitude_user.solicitude_id',$solicitude[$i]->id)->where('solicitude_user.user_id',39)->
                    select("respuestas.radicado as radicadoRespuesta")->first();
            }else{
                array_push($solicitudesConceptos,$solicitude[$i]);
            }
            
            
            
            
            if($solicitudes2){
                
                    for($j=0;$j<sizeof($solicitudes2);$j++){
                        if($solicitudes2[$j]->id_acciones== $this->sinaprobar){
                            $fecha=$solicitudes2[$j]->fecha;
                            $fecha=date('Y-m-d',strtotime($fecha));
                        }
                        if($solicitudes2[$j]->id_acciones== $this->aprobada){
                            $fecha=$solicitudes2[$j+1]->fecha;
                            $fecha=date('Y-m-d',strtotime($fecha));
                            break;
                        }
                    }
                    if($solicitudes2[0]->id_acciones!=$this->creada && $solicitudes2[0]->id_acciones!=$this->sinaprobar){
                        
                        if($solicitudes2[0]->id_acciones==7){
                            $date=date('Y-m-d',strtotime($solicitudes2[0]->fecha));
                        }
                        $alertaDuracion = 0;
                        if($solicitude[$i]->tipo_id==1){
                            $alertaDuracion = 10;
                        }else{
                            if($solicitude[$i]->tipo_id==2){
                                $alertaDuracion = 15;
                            }
                        }
                        
                        $fechaEstimada = $this->obtenerFechaEstimada($fecha,$alertaDuracion);
                        $duracion = $this->obtenerDuracion($fecha,$solicitudes2[0]->id_acciones,$date);
                        
                        $solicitude[$i]["alertaDuracion"]  = $alertaDuracion-intval($duracion);
                        
                        $solicitude[$i]["acciones"] = $solicitudes2;
                        $solicitude[$i]["respuestas"] = $respuestas;
                        
                        $solicitude[$i]["duracion"]  = $duracion;
                        $solicitude[$i]["fechaEstimada"]  = $fechaEstimada;
                        
                        array_push($lista_solicitudes,$solicitude[$i]);
                    }
                
                
            }
            
        }
        return ["lista_solicitudes"=>$lista_solicitudes,"lista_solicitudes_concepto"=>$solicitudesConceptos];
    }
    
    public function listado_solicitudes_estudiantes(){
        $usuario=Auth::user();
        $user=User::where('id',$usuario->id)->first();
        $lista_solicitudes = [];
        $date = Carbon::now();
        $date->toDateString();
      
        $solicitude = ListaSolicitudes::where("idUsuario","=",$user->id)->orderby("idEstado", "DESC")->orderby("created_at","ASC")->orderby("tipo_id", "ASC")->get();
            
            
        for($i=0;$i<sizeof($solicitude);$i++){
            $contFinesSemana = 0;
            if($solicitude[$i]->asunto_id !=null){
                $asunto = Asunto::where('id',$solicitude[$i]->asunto_id)->first();
                $solicitude[$i]["asunto_nuevo"] = $asunto;
            }
            $solicitudes2=Solicitude_User::join("solicitude_user_accione","solicitude_user.id","=","solicitude_user_accione.solicitude_user_id")
            ->join("acciones",'solicitude_user_accione.accione_id',"=","acciones.id")
            ->join("users","solicitude_user.user_id","=","users.id")
            ->where("solicitude_user.solicitude_id","=",$solicitude[$i]->id)->
            select("solicitude_user_accione.fecha as fecha","solicitude_user_accione.comentario as comentario","acciones.nombre as accion",
            "acciones.id as id_acciones","users.id as id","users.nombre as nombre","users.id as user_id","solicitude_user.id as id_solicitude_user")
            ->orderby('solicitude_user_accione.id','DESC')->get();
            
            
            
            $respuestas = Respuesta::where('solicitude_user_id',$solicitudes2[0]->id_solicitude_user)->with('multimedias_respuestas')->first();
            $fecha = date_create($solicitude[$i]->created_at);
            
            
            if($solicitudes2){
                    for($j=0;$j<sizeof($solicitudes2);$j++){
                        if($solicitudes2[$j]->id_acciones== $this->sinaprobar){
                            $fecha=$solicitudes2[$j]->fecha;
                            $fecha=date('Y-m-d',strtotime($fecha));
                        }
                        if($solicitudes2[$j]->id_acciones== $this->aprobada){
                            $fecha=$solicitudes2[$j+1]->fecha;
                            $fecha=date('Y-m-d',strtotime($fecha));
                            break;
                        }
                    }
                    
                    //if($solicitudes2[0]->id_acciones!=$this->creada && $solicitudes2[0]->id_acciones!=$this->sinaprobar && $solicitudes2[0]->user_id==$user->id){
                        $alertaDuracion = 0;
                        if($solicitude[$i]->tipo_id==1){
                            $alertaDuracion = 10;
                        }else{
                            if($solicitude[$i]->tipo_id==2){
                                $alertaDuracion = 15;
                            }
                        }
                        if($solicitudes2[0]->id_acciones!=2){
                            if($solicitudes2[0]->id_acciones==7){
                                $date=date('Y-m-d',strtotime($solicitudes2[0]->fecha));
                            }
                            $fechaEstimada = $this->obtenerFechaEstimada($fecha,$alertaDuracion);
                            $duracion = $this->obtenerDuracion($fecha,$solicitudes2[0]->id_acciones,$date);
                        }else{
                            $fechaEstimada = date('Y-m-d',strtotime($solicitudes2[0]->fecha));
                            $duracion = 0;
                            $alertaDuracion = 0;
                        }
                        $solicitude[$i]["alertaDuracion"]  = $alertaDuracion-intval($duracion);
                        
                        $solicitude[$i]["acciones"] = $solicitudes2;
                        $solicitude[$i]["respuestas"] = $respuestas;
                        
                        $solicitude[$i]["duracion"]  = $duracion;
                        $solicitude[$i]["fechaEstimada"]  = $fechaEstimada;
                        
                        array_push($lista_solicitudes,$solicitude[$i]);
                        
                    //}
                    
                
            }
            
        }
        
        $lista_acciones = Accione::all();
	    $lista_asuntos = Asunto::all();
	    $lista_tipos = Tipo::where('id','<>',4)->get();
	    $lista_dependencia = User::where('estado',1)->where('id','<>',Auth::user()->id)->whereHas('roles', function ($query) {
            $query->where('role_id',1);
        })->get();
        
        
        
        return ["listaSoclicitudes"=>$lista_solicitudes,"acciones"=>$lista_acciones, "asuntos"=>$lista_asuntos, "tipos"=>$lista_tipos, "dependencias"=>$lista_dependencia];
    }
    
    public function obtener_solicitud($id){
        if(Solicitude::where('id',$id)->first() == null){
            return response('Bad request.', 400);
        }
        $solicitud = Solicitude::where('id',$id)->with('tipos')->first();
        if($solicitud->asunto_id!=null){
            $asunto2 = Asunto::where('id',$solicitud->asunto_id)->select('nombre')->first();
            $solicitud->asunto = $asunto2->nombre;
        }
        
        $user = User::join("solicitude_user","users.id","=","solicitude_user.user_id")
            ->join("role_user","users.id","=","role_user.user_id")
            ->where('role_user.role_id',$this->rolEstudiantes)->where('solicitude_user.solicitude_id',$id)
            ->first();
        $solicitude_user = Solicitude_User::where('solicitude_id',$id)->orderby('updated_at','DESC')->get();
        $solicitude_user_accione = Solicitude_User_accione::where('solicitude_user_id',$solicitude_user[0]->id)->orderby('fecha','DESC')->get();
        
        $respuestas = Respuesta::where('solicitude_user_id',$solicitude_user[0]->id)->first();
        //return $respuestas;
        
        $multimedias_respuesta=null;
         
        if($respuestas!=null){
            $multimedias_respuesta = Multimedias_Respuesta::where('respuesta_id',$respuestas->id)->get();
        }
        
        $multimedias = Multimedias_Solicitude::where('solicitude_id',$id)->get();   
        
        $clave = md5("DELUNOALSIETE*".''.date("d/m/Y"));
        $clave = strtoupper($clave);
        $data = [
                'codigo' => $user->codigo,
                'token' => $clave,
            ];
		//return $data;
        $client = new \GuzzleHttp\Client(['headers' => $this->headers ]);
        $response = $client->post( 'http://softsimulation.com/WebServices/SeguimientoControl', [ 'body' => json_encode($data) ]);
        $res = (array) json_decode( $response->getBody()->getContents() ) ;
        //return $user;
		//return array('solicitud' => $solicitud,'user' => $user, 'multimedias' => $multimedias, 'datos' => $res, 'respuesta'=>$respuestas, 'multimedias_respuesta'=>$multimedias_respuesta);
		
		$lista_dependencia = User::where('estado',1)->where('id','<>',5)->where('id','<>',Auth::user()->id)->whereHas('roles', function ($query) {
            $query->where('role_id',1);
        })->get();
		
        return ['solicitud' => $solicitud,'user' => $user, 'multimedias' => $multimedias, 'datos' => $res, 'respuesta'=>$respuestas, 'multimedias_respuesta'=>$multimedias_respuesta,
        'dependencias'=>$lista_dependencia]; 
    }
    
    public function responder_desarrollo($id){
        if(Solicitude::where('id',$id)->first() == null){
            return response('Bad request.', 400);
        }
        $solicitud = Solicitude::where('id',$id)->with('tipos')->first();
        
        $user = User::join("solicitude_user","users.id","=","solicitude_user.user_id")
            ->join("role_user","users.id","=","role_user.user_id")
            ->where('role_user.role_id',$this->rolEstudiantes)->where('solicitude_user.solicitude_id',$id)
            ->first();
        
        $multimedias = Multimedias_Solicitude::where('solicitude_id',$id)->get();   
        
        $clave = md5("DELUNOALSIETE*".''.date("d/m/Y"));
        $clave = strtoupper($clave);
        $data = [
                'codigo' => $user->codigo,
                'token' => $clave,
            ];
       
        $client = new \GuzzleHttp\Client(['headers' => $this->headers ]);
        $response = $client->post( 'http://softsimulation.com/WebServices/SeguimientoControl', [ 'body' => json_encode($data) ]);
        $res = (array) json_decode( $response->getBody()->getContents() ) ;
        //return $user;
        return view('responder_desarrollo', array('solicitud' => $solicitud,'user' => $user, 'multimedias' => $multimedias, 'datos' => $res)); 
    }
    public function responder_academico($id){
        if(Solicitude::where('id',$id)->first() == null){
            return response('Bad request.', 400);
        }
        $solicitud = Solicitude::where('id',$id)->with('tipos')->first();
        
        $user = User::join("solicitude_user","users.id","=","solicitude_user.user_id")
            ->join("role_user","users.id","=","role_user.user_id")
            ->where('role_user.role_id',$this->rolEstudiantes)->where('solicitude_user.solicitude_id',$id)
            ->first();
        
        $multimedias = Multimedias_Solicitude::where('solicitude_id',$id)->get();   
        
        $clave = md5("DELUNOALSIETE*".''.date("d/m/Y"));
        $clave = strtoupper($clave);
        $data = [
                'codigo' => $user->codigo,
                'token' => $clave,
            ];
       
        $client = new \GuzzleHttp\Client(['headers' => $this->headers ]);
        $response = $client->post( 'http://softsimulation.com/WebServices/SeguimientoControl', [ 'body' => json_encode($data) ]);
        $res = (array) json_decode( $response->getBody()->getContents() ) ;
        //return $user;
        return view('responder_academico', array('solicitud' => $solicitud,'user' => $user, 'multimedias' => $multimedias, 'datos' => $res)); 
    }
    public function reenviar_solicitud(Request $request){
        //return $request->all();
        $date2=$date = Carbon::now();
        $solicitude_user2 = Solicitude_User::where('solicitude_id',$request->solicitude_id)
        ->join("solicitudes","solicitude_user.solicitude_id","=","solicitudes.id")
        ->join("users","solicitude_user.user_id","=","users.id")
        ->join("role_user","users.id","=","role_user.user_id")
        ->where('role_user.role_id','<>',$this->rolEstudiantes)
        ->where('users.id','=',Auth::user()->id)
        ->select("solicitudes.asunto as Asunto", "solicitude_user.id as solicitude_user_id", "users.id as user_id", "solicitudes.asunto_id")->first();
        
        
        //return $solicitude_user2;
        
        $solicitude_user_accione = new Solicitude_User_Accione();
        $solicitude_user_accione->accione_id = $this->reenviada;
        $solicitude_user_accione->solicitude_user_id = $solicitude_user2->solicitude_user_id;
        $solicitude_user_accione->comentario = $request->Comentario;
        $solicitude_user_accione->fecha = $date;
        $solicitude_user_accione->save();
        
        $busqueda = Solicitude_User::find($solicitude_user2->solicitude_user_id)->where('solicitude_id',$request->solicitude_id)->where('user_id',$request->dependencia_reenviar)->first();
        if($busqueda==null){
            $solicitude_user = new Solicitude_User;
            $solicitude_user->solicitude_id = $request->solicitude_id;
            $solicitude_user->user_id = $request->dependencia_reenviar;
            $solicitude_user->created_at = $date2;
            $solicitude_user->updated_at = $date2;
            $solicitude_user->save();
        
            $date2->addSeconds(2);
            $solicitude_user_accione = new Solicitude_User_Accione();
            $solicitude_user_accione->accione_id = $this->tramite;
            $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
            $solicitude_user_accione->comentario = $request->Comentario;
            $solicitude_user_accione->fecha = $date2;
            $solicitude_user_accione->save();
        }else{
            $busqueda->updated_at = $date2;
            $busqueda->save();
            
            $date2->addSeconds(2);
            $solicitude_user_accione = new Solicitude_User_Accione();
            $solicitude_user_accione->accione_id = $this->tramite;
            $solicitude_user_accione->solicitude_user_id = $busqueda->id;
            $solicitude_user_accione->comentario = $request->Comentario;
            $solicitude_user_accione->fecha = $date2;
            $solicitude_user_accione->save();
        }
        
        
        
        
        
        $user_correo = User::where('id',$request->dependencia_reenviar)->first();
        
        $data=[];
        $asunto = $solicitude_user2->asunto_id == null ? $solicitude_user2->asunto : Asunto::where('asunto_id',$solicitude_user2->asunto_id)->select('asuntos.nombre')->first();
        $data["Asunto"] = $asunto;
            try{
                \Mail::send('VistasEmails.emails',$data, function($message) use ($request, $user_correo){
                   //remitente
                   $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
         
                   //asunto
                   $message->subject("Notificación - Nueva solicitud");
         
                   //receptor
                   $message->to($user_correo->email, $user_correo->nombre);
                });
            }catch(\Exception $e){
                // Never reached
                //return $e;
            }
            return  ["success"=>true];
    }
    public function aprobar_vista($id){
        //$solicitud = Solicitude::where('id',$id)->with('tipos')->first();
        return view('aprobar', array('solicitud' => $id)); 
    }
    public function aprobar_vista_desarrollo($id){
        $solicitud = Solicitude::where('id',$id)->with('tipos')->first();
        return view('aprobar_desarrollo', array('solicitud' => $solicitud)); 
    }
    public function aprobar_vista_academico($id){
        $solicitud = Solicitude::where('id',$id)->with('tipos')->first();
        return view('Solicitudes.aprobar_directorAcademico', array('solicitud' => $solicitud)); 
    }
    public function datos_solicitud(Request $request){
        
            $user = Auth::user();
        
            $solicitud = Solicitude::where('id',$request->solicitud_id)->with(['tipos','asunto_nuevo'])->with('multimedias_solicitudes')->first();
            if($solicitud){
                $dependencia = Solicitude_User::where('solicitude_id',$solicitud->id)
                ->join("users","solicitude_user.user_id","=","users.id")
                ->join("solicitudes","solicitude_user.solicitude_id","=","solicitudes.id")
                ->join("role_user","users.id","=","role_user.user_id")
                ->join("roles","role_user.role_id","=","roles.id")
                ->where('roles.id','<>',$this->rolEstudiantes)->where('users.id','<>',$this->desarrollo_estudiantil)
                ->select("users.id as dependencia_id", "users.email as email_dependencia","users.nombre as nombre_dependencia", "roles.id as role_id",
                "solicitude_user.id as solicitude_user_id", "solicitudes.asunto as Asunto")->first();
            }
            
            return ["solicitud"=>$solicitud, "estudiante"=>$user, "dependencia"=>$dependencia]; 
            
    }
    public function datos_solicitud_desarrollo(Request $request){
        $solicitud = Solicitude::where('id', $request[0])->with(['tipos','multimedias_solicitudes','asunto_nuevo','solicitude_user'=>function($q){
            $q->whereHas('user', function($w){
                $w->whereHas('roles', function($p){
                    $p->where('id',2);
                });
                
            })->with(['user','respuestas']);
        }])->first();
        
        $respuestas = Solicitude::where('id', $request[0])->with(['tipos','multimedias_solicitudes','asunto_nuevo','solicitude_user'=>function($q){
            $q->whereHas('user', function($w){
                $w->whereHas('roles', function($p){
                    $p->where('id',1);
                });
                
            })->with(['user','respuestas'=>function($r){$r->with('multimedias_respuestas')->get();},'solicitude_user_accione'=>function($s){$s->with('acciones');}]);
        }])->first();
        //return $solicitud;
        $user = $solicitud->solicitude_user[0]->user;
        return ["solicitud"=>$solicitud, "estudiante"=>$user,"respuestas"=>$respuestas]; 
  
    }
    public function ver_mas($id){
        if(Solicitude::where('id',$id)->first() == null || Solicitude_User::where('solicitude_id',$id)->where('user_id',Auth::user()->id)->first() == null){
            
            return response('Bad request.', 400);
            
        }
        $rol = User::join("role_user","users.id","=","role_user.user_id")->where('users.id',Auth::user()->id)->select("role_user.role_id")->first();
        return view('Solicitudes.ver_mas', array('idSolicitudVerMas' => $id,'rol'=>$rol->role_id)); 
    }
    public function ver_mas_academico($id){
        if(Solicitude::where('id',$id)->first() == null){
            return response('Bad request.', 400);
        }
        return view('ver_mas_academico', array('idSolicitudVerMas' => $id)); 
    }
    
    public function ver_mas_solicitud($id){
        
        $datos_solicitud = Solicitude_User_Accione::whereHas('solicitude_user',function($q) use ($id){
            $q->where('solicitude_id',$id);
        })->with(['acciones', 'solicitude_user' => function($q){
            $q->with(['user','solicitude' => function($t){
                $t->with(['multimedias_solicitudes','asunto_nuevo','tipos']);
            }, 'respuestas'=>function($r){
                $r->with('multimedias_respuestas');
            }]);
        }])->orderby('fecha','DESC')->get();
        
        $rol = User::where('id',Auth::user()->id)->with('roles')->first();
        $lista_novedades=[];
        $lista_novedades2=[];
        $solicitudesConceptos = Solicitude_concepto::
        join('users as usersDirigida', 'solicitudes_conceptos.user_dirigida_id', '=', 'usersDirigida.id')
        ->join('users', 'solicitudes_conceptos.user_creador_id', '=', 'users.id')
        ->where('solicitude_id',$id)->select("solicitudes_conceptos.id as id","users.nombre as nombreCreador", "solicitudes_conceptos.user_dirigida_id as dirigidaId",
            "solicitudes_conceptos.asunto", "solicitudes_conceptos.texto", "usersDirigida.nombre as nombreDirigida", "solicitudes_conceptos.created_at")
        ->with(['multimedias_solicitude_concepto','respuestaConcepto'=>function($q){$q->with('multimedias_respuestasConceptos');}])
        ->get();
        //return $solicitudesConceptos;
        //return $rol;
        if($rol["roles"][0]->id!=2){
            $solicitude_user = Solicitude_User::where('solicitude_id',$id)->where('user_id',$rol->id)->first();
            $novedades=[];
            if($solicitude_user){
                $novedades = Novedade::where('solicitude_user_id',$solicitude_user->id)->with('multimedias_novedades')->get();
            }
           return ["datos_solicitud"=>$datos_solicitud, "novedades"=>$novedades, "solicitudesConceptos"=>$solicitudesConceptos]; 
        }else{
            $solicitude_user = Solicitude_User::where('solicitude_id',$id)->get();
            if($solicitude_user){
                for($i=0;$i<sizeof($solicitude_user);$i++){
                    $novedades = Novedade::where('solicitude_user_id',$solicitude_user[$i]->id)->where('estado',1)->with('multimedias_novedades')->get();
                    if(count($novedades)>0){
                        array_push($lista_novedades,$novedades);
                    }
                    
                }
                for($i=0;$i<sizeof($lista_novedades);$i++){
                    
                        for($j=0;$j<sizeof($lista_novedades[$i]);$j++){
                    
                                array_push($lista_novedades2,$lista_novedades[$i][$j]);
                            
                        }
                    
                }
            }
            
        }
        return ["datos_solicitud"=>$datos_solicitud, "novedades"=>$lista_novedades2, "solicitudesConceptos"=>$solicitudesConceptos]; 
        
    }
    public function ver_mas_solicitudAcademico(Request $request){
        
        $datos_solicitud = Solicitude_User_Accione::whereHas('solicitude_user',function($q) use ($request){
            $q->where('solicitude_id',$request->solicitud_id);
        })->with(['acciones', 'solicitude_user' => function($q){
            $q->with(['user','solicitude' => function($t){
                $t->with(['multimedias_solicitudes','asunto_nuevo','tipos']);
            }, 'respuestas'=>function($r){
                $r->with('multimedias_respuestas');
            }]);
        }])->orderby('fecha','DESC')->get();
        
        for($i=0;$i<sizeof($datos_solicitud);$i++){
            if($datos_solicitud[$i]["solicitude_user"]["user"]->codigo != null){
                $estudiante = $datos_solicitud[$i]["solicitude_user"]->user;
            }
        }
        
        $lista_novedades=[];
        $lista_novedades2=[];
        $solicitudesConceptos = Solicitude_concepto::
        join('users as usersDirigida', 'solicitudes_conceptos.user_dirigida_id', '=', 'usersDirigida.id')
        ->join('users', 'solicitudes_conceptos.user_creador_id', '=', 'users.id')
        ->where('solicitude_id',$request->solicitud_id)->select("solicitudes_conceptos.id as id","users.nombre as nombreCreador", "solicitudes_conceptos.user_dirigida_id as dirigidaId",
            "solicitudes_conceptos.asunto", "solicitudes_conceptos.texto", "usersDirigida.nombre as nombreDirigida", "solicitudes_conceptos.created_at")
        ->with(['multimedias_solicitude_concepto','respuestaConcepto'=>function($q){$q->with('multimedias_respuestasConceptos');}])
        ->get();
        //return $solicitudesConceptos;
        //return $rol;
            $solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitud_id)->where('user_id',39)->get();
            if($solicitude_user){
                for($i=0;$i<sizeof($solicitude_user);$i++){
                    $novedades = Novedade::where('solicitude_user_id',$solicitude_user[$i]->id)->where('estado',1)->with('multimedias_novedades')->get();
                    if(count($novedades)>0){
                        array_push($lista_novedades,$novedades);
                    }
                    
                }
                for($i=0;$i<sizeof($lista_novedades);$i++){
                    
                        for($j=0;$j<sizeof($lista_novedades[$i]);$j++){
                    
                                array_push($lista_novedades2,$lista_novedades[$i][$j]);
                            
                        }
                    
                }
            }
        return ["datos_solicitud"=>$datos_solicitud, "novedades"=>$lista_novedades2, "solicitudesConceptos"=>$solicitudesConceptos,"estudiante"=>$estudiante]; 
        
    }
    
    
    public function asignar_limite(Request $request){
        $request->fecha_limite = strtotime($request->fecha_limite);
        $request["fecha_actual"] = date("Y-m-d H:i:s"); 
        $request->fecha_actual = strtotime($request->fecha_actual);
        
        //return $request->fecha_actual;
        $validator = \Validator::make($request->all(),[
            
            'solicitude_id' => 'required|exists:solicitudes,id',
            'fecha_limite' => 'required|after:fecha_actual',
            
        ],[
            
            'solicitude_id.required' => 'La solicitud  es requerida.',
            'solicitude_id.exists' => 'La solicitud debe existir.',
            'fecha_limite.required' => 'La fecha es obligatoria.',
            'fecha_limite.after' => 'La fecha debe ser superior a la fecha actual.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $request->fecha_limite = date("Y-m-d H:i:s",$request->fecha_limite); 
        //return $request->fecha_limite;
        $solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitude_id)->where('user_id',Auth::user()->id)->first();
        $solicitude_user_accione = Solicitude_User_Accione::where('solicitude_user_id',$solicitude_user->id)->orderby('fecha','DESC')->get();
        
        $nueva_solicitude_accione = new Solicitude_User_Accione();
        $nueva_solicitude_accione->solicitude_user_id = $solicitude_user->id;
        $nueva_solicitude_accione->accione_id = 8;
        $nueva_solicitude_accione->fecha = $request->fecha_limite;
        $nueva_solicitude_accione->save();
        return ["success"=>true, "accion"=>$nueva_solicitude_accione];
    }
    
    
    public function guardarEncargado(Request $request){
        //return $request->all();
        $solicitud = Solicitude::find($request->idSolicitud);
        //return $solicitud;
        $solicitud->encargado = $request->encargado;
        $solicitud->save();
        
        return ["success"=>true];
    }
    public function noAprobarDirector(Request $request){
        
        $solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitudId)->where('user_id',39)->first();
        
        $nueva_solicitude_accione = new Solicitude_User_Accione();
        $nueva_solicitude_accione->solicitude_user_id = $solicitude_user->id;
        $nueva_solicitude_accione->accione_id = 9;
        $nueva_solicitude_accione->comentario = $request->comentario;
        $nueva_solicitude_accione->fecha = Carbon::now();
        $nueva_solicitude_accione->save();
        
        $consejo = User::where('id',39)->first();
            try{
                \Mail::send('VistasEmails.emailNoAprobacionResp', function($message) use ($request, $consejo){
                   //remitente
                   $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
         
                   //asunto
                   $message->subject("Notificación - Corrección de respuesta");
         
                   //receptor
                   $message->to($consejo->email, $consejo->nombre);
                });
            }catch(\Exception $e){
                // Never reached
                //return $e;
            }
        
        return ["success"=>true];
    }
    
    public function pdf_respuesta($id){
            
            //$solicitude_user = Solicitude_User::where('solicitude_id',6)->where('user_id',9)->first();
            //return $solicitude_dependencia;
            $solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitud)
            ->join("respuestas","respuestas.solicitude_user_id","=","solicitude_user.id")
            ->select('respuestas.mensaje','solicitude_user.id as solicitude_user_id')->first();
        $view =  \View::make('pdf_respuesta', ['respuesta' => $solicitude_user->mensaje])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream();
    }
    
    
    
    public function agregarSolicitudeUser(){
        $solicitudes = Solicitude::all();
        for($i=0;$i<sizeof($solicitudes);$i++){
            
            $estudiante=Solicitude_User::
                join("users","solicitude_user.user_id","=","users.id")
                ->join("role_user","role_user.user_id","=","users.id")
                ->join("solicitudes","solicitudes.id","=","solicitude_user.solicitude_id")
                ->where("solicitude_user.solicitude_id","=",$solicitudes[$i]->id)->where('role_user.role_id','=',2)
                ->first();
                
            if($estudiante == null){
                //return "si";
                $user = User::where('nombre','like','%'.$solicitudes[$i]->user_create.'%')->first();
                //return ["user"=>$user,"create"=>$solicitudes[$i]->user_create];
                $solicitude_user = new Solicitude_User();
                //$user = User::where('codigo',$request->Estudiante)->first();
                $solicitude_user->user_id = $user->id;
                $solicitude_user->solicitude_id = $solicitudes[$i]->id;
                 $solicitude_user->created_at = $solicitudes[$i]->created_at;
                $solicitude_user->save();
                
                $solicitude_user_accione = new Solicitude_User_Accione();
                $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
                $solicitude_user_accione->accione_id = $this->creada;
              
                $solicitude_user_accione->fecha = $solicitudes[$i]->created_at;
                $solicitude_user_accione->save();
                
                $fecha = date_create($solicitude_user_accione->fecha);
                date_add($fecha, date_interval_create_from_date_string('2 second'));
                $fecha =date_format($fecha, 'Y-m-d H:i:s');
                
                $solicitude_user_accione = new Solicitude_User_Accione();
                $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
                $solicitude_user_accione->accione_id = $this->sinaprobar;
                $solicitude_user_accione->fecha = $fecha;
                $solicitude_user_accione->save();
                
                $fecha = date_create($solicitude_user_accione->fecha);
                date_add($fecha, date_interval_create_from_date_string('2 second'));
                $fecha =date_format($fecha, 'Y-m-d H:i:s');
                
                $solicitude_user_accione = new Solicitude_User_Accione();
                $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
                $solicitude_user_accione->accione_id = $this->aprobada;
                $solicitude_user_accione->fecha = $fecha;
                $solicitude_user_accione->save();
            }
            //return $estudiante->fechaCreacion;
            $s_user = Solicitude_User::where('solicitude_id',$solicitudes[$i]->id)->where('user_id',44)->first();
            if($s_user == null){
                
                $solicitude_user = new Solicitude_User();
                //$user = User::where('codigo',$request->Estudiante)->first();
                $solicitude_user->user_id = 44;
                $solicitude_user->solicitude_id = $solicitudes[$i]->id;
                 $solicitude_user->created_at = $solicitudes[$i]->created_at;
                $solicitude_user->save();
                
                $accion = Solicitude_User_Accione::
                    join("solicitude_user","solicitude_user.id","=","solicitude_user_accione.solicitude_user_id")->
                    where('solicitude_user.solicitude_id',$solicitudes[$i]->id)->where('solicitude_user_accione.accione_id',3)
                    ->first();
                $fecha = date_create($accion->fecha);
                date_add($fecha, date_interval_create_from_date_string('2 second'));
                $fecha =date_format($fecha, 'Y-m-d H:i:s');
                $solicitude_user_accione = new Solicitude_User_Accione();
                $solicitude_user_accione->solicitude_user_id = $solicitude_user->id;
                $solicitude_user_accione->accione_id = 10;
                $solicitude_user_accione->fecha = $fecha;
                $solicitude_user_accione->save();
            }
            
            $s_user = Solicitude_User::where('solicitude_id',$solicitudes[$i]->id)->where('user_id',39)->first();
            if($s_user == null){
                $solicitude_user = new Solicitude_User();
                //$user = User::where('codigo',$request->Estudiante)->first();
                $solicitude_user->user_id = 39;
                $solicitude_user->solicitude_id = $solicitudes[$i]->id;
                 $solicitude_user->created_at = $solicitudes[$i]->created_at;
                $solicitude_user->save();
            }
            
            $s_user = Solicitude_User::where('solicitude_id',$solicitudes[$i]->id)->where('user_id',43)->first();
            if($s_user == null){
                $solicitude_user = new Solicitude_User();
                //$user = User::where('codigo',$request->Estudiante)->first();
                $solicitude_user->user_id = 43;
                $solicitude_user->solicitude_id = $solicitudes[$i]->id;
                 $solicitude_user->created_at = $solicitudes[$i]->created_at;
                $solicitude_user->save();
            }
        }
        return "true";
    }
}



