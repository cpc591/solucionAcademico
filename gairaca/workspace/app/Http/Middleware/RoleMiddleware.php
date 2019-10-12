<?php

namespace App\Http\Middleware;
use App\User;
use App\Role;
use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $academico = 39;
    private $desarrollo_estudiantil = 9;
    public function handle($request, Closure $next, $roles)
    {
        $arrayRoles = explode("|", $roles);
        $user = User::where('id', \Auth::user()->id)->whereHas('roles', function($q)use($arrayRoles){
            $q->whereIn('nombre',$arrayRoles);
        })->first();
        
        if ( $user != null ) {
            if( \Auth::user()->id==$this->academico){
                return \Redirect::to('/academico')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                           ->withInput(); 
            }
            if( \Auth::user()->id==$this->desarrollo_estudiantil){
                return \Redirect::to('/bandeja')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                           ->withInput(); 
            }
            if( \Auth::user()->id==44){
                return \Redirect::to('/vista_consecutivos')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                           ->withInput(); 
            }
            if( \Auth::user()->id==43){
                return \Redirect::to('/directorAcademico')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                           ->withInput(); 
            }
                return \Redirect::to('/bandeja2')->with('message', 'El usuario no cuenta con los permisos requeridos.')
                           ->withInput();    
            
            
        }
    
        return $next($request);
    }
}
