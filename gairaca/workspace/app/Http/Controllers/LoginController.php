<?php

namespace App\Http\Controllers;

use App\User;
use App\Role_User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;


class LoginController extends Controller
{
    private $headers = [  'Content-Type' => 'application/json; charset=utf-8', 'Accept'=>'application/json' ];
    private $desarrollo = "desarrolloest";
    private $desarrollo_estudiantil = 9;
    private $rolEstudiantes = 2;
    private $academico = 39;
    private $directorAcademico = 43;
    public function loginestudiante(Request $request){
         
         $clave = md5("DELUNOALSIETE*".''.date("d/m/Y"));
         $clave = strtoupper($clave);
              $data = [
                        
                         'token' => $clave,
                         'codigo' => $request->codigo,
                         'password' => $request->password
                     ];
        
            $client = new \GuzzleHttp\Client(['headers' => $this->headers ]);
            $response = $client->post( 'http://softsimulation.com/WebServices/LoginAdmisiones', [ 'body' => json_encode($data) ]);
            
            $res = (array) json_decode( $response->getBody()->getContents() ) ;  
            
            //return $res;
        
            //return redirect()->intended('index')->with('message', 'Error en el servicio');
              
                 
    
        if($res["success"]==true){
        
       
        $clave = md5("DELUNOALSIETE*".''.date("d/m/Y"));
        $clave = strtoupper($clave);
        $data = [
                'codigo' => $request->codigo,
                'token' => $clave,
            ];
       
        $client = new \GuzzleHttp\Client(['headers' => $this->headers ]);
        $response = $client->post( 'http://softsimulation.com/WebServices/SeguimientoControl', [ 'body' => json_encode($data) ]);
        $res = (array) json_decode( $response->getBody()->getContents() ) ;
        $user = User::where('codigo',$request->codigo)->first();
        
        
   
   
        if($user == null){    
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
          Auth::login($user);
          return redirect()->intended('bandeja2');    
        
        
    }
    /*$user = User::where('codigo',$request->codigo)->first();
    if($user!=null){
        Auth::login($user);
        return redirect()->intended('bandeja2');
    }*/
    return redirect()->intended('index')->with('message', 'Credenciales no válidas');
    
    }    
    
    
    
     public function logindependencia(Request $request){
         //return $request->all();
              $clave = md5("DELUNOALSIETE*".''.date("d/m/Y"));
              $clave = strtoupper($clave);
              //return $clave;
              $data = [
                        
                        //'token' => $clave,
                        'username' => $request->userName,
                        'password' => $request->password
                    ];
               
                $client = new \GuzzleHttp\Client(['headers' => $this->headers ]);
                $response = $client->post( 'http://softsimulation.com/WebServices/LoginDirectorio', [ 'body' => json_encode($data) ]);
                $res = (array) json_decode( $response->getBody()->getContents() ) ;          
    
     //if($res["success"]){
        
       
       
        $user = User::where('email',$request->userName)->first();
        //return $user;
   
        /*if($user == null){    

                 return redirect()->intended('index')->with('message', 'Credenciales no validas');;
                  
        }*/
        //$user = User::where('id',43)->first();
        //return $user;
          Auth::login($user);
          //return $user;
          if($user->id==$this->directorAcademico){
              return redirect()->intended('directorAcademico');
          }else if($user->id==44){
              return redirect()->intended('vista_consecutivos');
          }else{
          return redirect()->intended('bandeja3');    
          } 
        
    //}
    return redirect()->intended('index');
    
    }    
    
    
    
         /*$user=User::where('email',$request->email)->with('roles')->first();
         return $user->roles[0]["id"];
       
       
       
         if($user!=null){
            
            // if($user->roles[0]["id"]==2){
              $clave = md5("DELUNOALSIETE*".''.date("d/m/Y"));
              $clave = strtoupper($clave);
              $data = [
                        
                        'token' => $clave,
                        'username' => $request->email,
                        'password' => $request->password
                    ];
               
                $client = new \GuzzleHttp\Client(['headers' => $this->headers ]);
                $response = $client->post( 'http://softsimulation.com/WebServices/LoginDirectorio', [ 'body' => json_encode($data) ]);
                $res = (array) json_decode( $response->getBody()->getContents() ) ;  
                
             }
            
               
               Auth::login($user,false);
                
                if($user->id==5){
                   return redirect()->intended('bandeja');
             }else if ($user->roles[0]["id"]==2 && $user->id!=5){
                    return redirect()->intended('bandeja2');
               }else{
                    return redirect()->intended('bandeja3');
               }
                
            
         }else{
                 $clave = md5("DELUNOALSIETE*".''.date("d/m/Y"));
                 $clave = strtoupper($clave);
                 $data = [
                        
                           'token' => $clave,
                           'codigo' => 2012114072,
                           'password' => $request->password
                      ];
               
                   $client = new \GuzzleHttp\Client(['headers' => $this->headers ]);
                   $response = $client->post( 'http://softsimulation.com/WebServices/LoginAdmisiones', [ 'body' => json_encode($data) ]);
                   $res = (array) json_decode( $response->getBody()->getContents() ) ;              
            
        
              return  $res;
          
           }
            
    }
    
    
    */
    
    public function cerrar_sesion(){
        Auth::logout();
        //Redireccionamos al inicio de la app con un mensaje
        return redirect()->intended('/');
    }
    
}