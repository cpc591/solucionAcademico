<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $table = 'respuestas';
    public function multimedias_respuestas()
    {
        return $this->hasMany('App\Multimedias_Respuesta');
    }
    public function solicitude_user()
    {
        return $this->belongsTo('App\Solicitude_User');
    }
}
