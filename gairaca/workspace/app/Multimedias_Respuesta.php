<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Multimedias_Respuesta extends Model
{
    protected $table = 'multimedias_respuestas';
    public function respuestas()
    {
        return $this->belongsTo('App\Respuesta');
    }
}
