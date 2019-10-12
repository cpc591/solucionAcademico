<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $user= \Auth::user();
        $rolesAux = explode("|", $roles);
        
        $rolesuser = $user->roles->pluck('id');
        foreach($rolesuser as $role){
            if(!in_array($role,$rolesAux)){
                return \Redirect::to('/');
            }
        }
        
        
        return $next($request);
    }
}
