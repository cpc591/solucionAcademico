<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Novedade;
use App\Solicitude_User;
use App\Multimedias_Novedade;
use App\User;
use App\Novedades_Solicitud_User;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class NovedadeController extends Controller
{
    public function __construct()
	{
	    $this->middleware('auth');
	    $this->middleware('role:consejoAcademico|dependencia');
	}
    public function crear_novedad(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'novedad' => 'required',
            'solicitude_id'=>'required|exists:solicitudes,id',
            'Galeria.*' => 'mimes:pdf',
            'Galeria' =>'array|max:1'
            
        ],[
            'novedad.required' => 'El mensaje es obligatorio.',
            'solicitude_id.required' => 'Favor recargar la página.',
            'solicitude_id.exists' => 'Favor recargar la página.',
            'Galeria.*.mimes' => 'subir solo archivos pdf',
            'Galeria.max'=>'La cantidad máxima de archivos es 1.'
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        //return intval($request->permiso);
        if($request->permiso!="0" && $request->permiso!="1"){
            $error = [];
            $error["permiso"][0] = "Favor recargar la página";
            return ["success"=>false,"errores"=>$error];
            
        }
        if($request->Galeria != null){
            $tamaño = filesize($request->Galeria[0]);
            if($tamaño/1024 > 5000){
                $error = [];
                $error["Galeria"][0] = "Tamaño total de los adjuntos exceden los 10MB";
                return ["success"=>false,"errores"=>$error];
            } 
        }
        if($request->dependencia_destino!=null){
            $busqueda_dependencia = User::where('id',intval($request->dependencia_destino))->first();
            if($busqueda_dependencia==null){
                $error = [];
                $error["dependencia"][0] = "La dependencia debe existir en la base de datos";
                return ["success"=>false,"errores"=>$error];
            }
        }
        //return $request->all();
        $solicitude_user = Solicitude_User::where('solicitude_id',$request->solicitude_id)->where('user_id',Auth::user()->id)->first();
        $novedad = new Novedade();
        $novedad->texto = $request->novedad;
        $novedad->solicitude_user_id = $solicitude_user->id;
        $novedad->user_create = Auth::user()->nombre;
        $novedad->estado = intval($request->permiso);
        $novedad->save();
            
            $date = Carbon::now();
        if($request->Galeria != null){
            for ($i=0;$i<sizeof($request->Galeria);$i++){
                $multimedia = new Multimedias_Novedade();
                $multimedia->novedade_id = $novedad->id;
                $date->addSeconds($i); 
                $nombrex = $novedad->id."-".$i."-".date("Ymd-His").".".$request->Galeria[$i]->getClientOriginalExtension();
               \Storage::disk('novedades')->put($nombrex,  \File::get($request->Galeria[$i]));
                $multimedia->ruta = "/novedades/".$nombrex;
                $multimedia->user_create = Auth::user()->nombre;
                $multimedia->save();
            }
        }
            //return $request->dependencia_destino;
        if($request->dependencia_destino==null || $request->dependencia_destino=="null"){
            $novedades_solicitud_user = new Novedades_Solicitud_User();    
            $novedades_solicitud_user->novedade_id = $novedad->id;    
            $novedades_solicitud_user->solicitud_user_creador_id = $solicitude_user->id;
            $novedades_solicitud_user->solicitud_user_dirigida_id = $solicitude_user->id;
            $novedades_solicitud_user->fecha = $date;
            $novedades_solicitud_user->save();
            
            
        }else{
            $solicitude_user_destino = Solicitude_User::where('solicitude_id',$request->solicitude_id)->where('user_id',intval($request->dependencia_destino))->first();
            if ($solicitude_user_destino==null){
                $solicitude_user_destino = new Solicitude_User();
                $solicitude_user_destino->user_id = intval($request->dependencia_destino);
                $solicitude_user_destino->solicitude_id = $request->solicitude_id;
                $solicitude_user_destino->estado_id = 3;
                $fecha_solicitude_user =  Solicitude_User::where('solicitude_id',$request->solicitude_id)->orderBy('created_at','asc')->get();
                $solicitude_user_destino->created_at = $fecha_solicitude_user[0]->created_at;
                $solicitude_user_destino->save();
            }
            $novedades_solicitud_user = new Novedades_Solicitud_User();    
            $novedades_solicitud_user->novedade_id = $novedad->id;    
            $novedades_solicitud_user->solicitud_user_creador_id = $solicitude_user->id;
            //$novedades_solicitud_user->solicitud_user_dirigida_id = $solicitude_user->id;
            $novedades_solicitud_user->solicitud_user_dirigida_id = $solicitude_user_destino->id;
            $novedades_solicitud_user->fecha = $date;
            $novedades_solicitud_user->save();
            
        }
        
        $novedadRetornar = Novedade::where('id',$novedad->id)->with('multimedias_novedades')->first();
        
            return  ["success"=>true,"novedad"=>$novedadRetornar];
    }
    public function listado_novedades(){
        
        
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
            return $novedades;
            
        }
        return $novedades;
    }
}
