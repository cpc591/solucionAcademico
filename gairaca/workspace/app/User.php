<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
class User extends Authenticatable
{
    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    public function solicitudes()
    {
        return $this->belongsToMany('App\Solicitude');
    }
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
    public function solicitudeConcepto()
    {
        return $this->hasMany('App\Solicitude_concepto');
    }
    public function correos()
    {
        return $this->belongsToMany('App\Respuesta','users_correos','respuesta_id','user_id');
    }
    
    
    public function contieneRol($rol){
        
        return \Auth::user()->roles()->where('nombre',$rol)->first() == null;
    }
    
}
