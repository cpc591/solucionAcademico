<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
class DesarrolloMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     private $desarrollo_estudiantil = 9;
     private $academico = 39;
    public function handle($request, Closure $next)
    {
        
        $user = User::where('id', \Auth::user()->id)->with('roles')->first();
        //return $user;
        if ( $user->id != $this->desarrollo_estudiantil ) {
            if($user->roles->first()->id==1){
                if( \Auth::user()->id==$this->academico){
                    return \Redirect::to('/academico')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                               ->withInput(); 
                }if( \Auth::user()->id==44){
                    return \Redirect::to('/vista_consecutivos')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                               ->withInput(); 
                }
                if( \Auth::user()->id==43){
                    return \Redirect::to('/directorAcademico')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                               ->withInput(); 
                }
                else{
                    return \Redirect::to('/bandeja3')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                               ->withInput(); 
                }
            }else{
                return \Redirect::to('/bandeja2')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                           ->withInput();  
            }
                  
            
            
        }
    
        return $next($request);
    }
}
