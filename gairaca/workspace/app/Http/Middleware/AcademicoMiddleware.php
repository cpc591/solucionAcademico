<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
class AcademicoMiddleware
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
        if ( $user->id != $this->academico ) {
            if($user->roles->first()->id==1){
                if( \Auth::user()->id==$this->desarrollo_estudiantil){
                    return \Redirect::to('/bandeja')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                               ->withInput(); 
                }else if(\Auth::user()->id==43){
                    return \Redirect::to('/directorAcademico')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                               ->withInput(); 
                }else{
                    return \Redirect::to('/bandeja3')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                               ->withInput(); 
                }
            }else if ($user->roles->first()->id==5){
                return \Redirect::to('/vista_consecutivos')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                               ->withInput(); 
            }else if ($user->roles->first()->id==4){
                return \Redirect::to('/directorAcademico')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                               ->withInput(); 
            }else{
                return \Redirect::to('/bandeja2')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                           ->withInput();  
            }
                  
            
            
        }
    
        return $next($request);
    }
}
