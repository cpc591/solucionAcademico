<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitude_concepto_Solicitude_User extends Model
{
    protected $table = 'solicitudes_conceptos_solicitude_user';
     public $timestamps = false;
     protected $fillable = [
        'solicitude_concepto_id', 'solicitud_user_creador_id','solicitud_user_dirigida_id','fecha',
    ];
     public function solicitude_user()
    {
        return $this->belongsTo('App\Solicitude_User','solicitude_user_id');
    }
     public function solicitude_concepto()
    {
        return $this->belongsTo('App\Solicitude_concepto','solicitude_concepto_id');
    }
     public function respuestasConcepto()
    {
        return $this->hasMany('App\RespuestaConcepto','solicitude_user_id','solicitude_concepto_id');
    }
}
