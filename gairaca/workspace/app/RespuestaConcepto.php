<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestaConcepto extends Model
{
    protected $table = 'respuestas_conceptos';
    public function solicitude_concepto()
    {
        return $this->belongsTo('App\Solicitude_concepto');
    }
    public function multimedias_respuestasConceptos()
    {
        return $this->hasMany('App\Multimedias_Respuesta_concepto','respuestas_concepto_id');
    }
}
