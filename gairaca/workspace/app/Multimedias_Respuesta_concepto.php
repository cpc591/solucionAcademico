<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Multimedias_Respuesta_concepto extends Model
{
    protected $table = 'multimedias_respuestas_conceptos';
    public function respuestasConcepto()
    {
        return $this->belongsTo('App\RespuestaConcepto','respuestas_concepto_id');
    }
}
