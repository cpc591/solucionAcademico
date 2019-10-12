<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    
    private $headers = [  'Content-Type' => 'application/json; charset=utf-8', 'Accept'=>'application/json' ];
    
    public function crear(Request $request){
        
        $user = User::where('');
        $user->nombre = "Desarrollo estudiantil";
        $user->apellido = "";
        $user->codigo = 123;
        $user->email = "desarrolloestudiantil@unimagdalena.edu.co";
        $user->password = \Hash::make("desarrollo123");
        $user->estado = 1;
        $user->user_create = "Luis";
        $user->user_update = "Luis";
        $user->save();
        
        return "Guardado";
    }
    public function login(Request $request){
        $user = User::where('email',$request->email)->first();
        if($user!=null){
            if($user->email==$request->email && $user->password==$request->password){
                return $user;
            }else{
                return "No existe";
            }
        }else{
            return "No existe";
        }
        
    }
    public function lista_dependencia(){
        
        $lista_dependencia = User::where('estado',1)->where('id','<>',5)->whereHas('roles', function ($query) {
            $query->where('role_id',1);
        })->get();
        
     
        return $lista_dependencia;
    }
    public function lista_dependencia_responder(){
        
        $lista_dependencia = User::where('estado',1)->where('id','<>',5)->where('id','<>',Auth::user()->id)->whereHas('roles', function ($query) {
            $query->where('role_id',1);
        })->get();
        
     
        return $lista_dependencia;
    }
    
    public function peticion(Request $request){
        
        $clave = md5("DELUNOALSIETE*".''.date("d/m/Y"));
        $clave = strtoupper($clave);
        $data = [
                'codigo' => $request->codigo,
                'token' => $clave,
            ];
       
        $client = new \GuzzleHttp\Client(['headers' => $this->headers ]);
        $response = $client->post( 'https://softsimulation.com/WebServices/SeguimientoControl', [ 'body' => json_encode($data) ]);
        $res = (array) json_decode( $response->getBody()->getContents() ) ;
        
        return $res;
    }
    
}
