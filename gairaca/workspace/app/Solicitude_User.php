<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitude_User extends Model
{
    protected $table = 'solicitude_user';
    public $timestamps = false;
    
    protected $fillable = [
        'user_id', 'solicitude_id','created_at'
    ];
    
    public function acciones()
    {
        return $this->belongsToMany('App\Accione');
    }
     public function respuestas()
    {
        return $this->hasMany('App\Respuesta','solicitude_user_id');
    }
    
    public function solicitude_user_accione()
    {
        return $this->hasMany('App\Solicitude_User_Accione','solicitude_user_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function solicitude()
    {
        return $this->belongsTo('App\Solicitude');
    }
    public function estados()
    {
        return $this->hasMany('App\Estado');
    }
    public function novedades()
    {
        return $this->hasMany('App\Novedade');
    }
    public function solicitudes_conceptos()
    {
        return $this->hasMany('App\Solicitude_concepto');
    }
}
