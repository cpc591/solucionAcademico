<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Novedades_Solicitud_User extends Model
{
    protected $table = 'novedades_solicitud_user';
     public $timestamps = false;
     protected $fillable = [
        'novedade_id', 'solicitud_user_creador_id','solicitud_user_dirigida_id','fecha',
    ];
     public function solicitude_user()
    {
        return $this->belongsTo('App\Solicitude_User','solicitude_user_id');
    }
     public function novedade()
    {
        return $this->belongsTo('App\Novedade','novedade_id');
    }
}
