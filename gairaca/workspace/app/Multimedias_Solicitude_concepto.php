<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Multimedias_Solicitude_concepto extends Model
{
    protected $table = 'multimedias_solicitudes_conceptos';
    protected $fillable = [
        'ruta','solicitude_concepto_id'
    ];
    public function solicitudes_conceptos()
    {
        return $this->belongsTo('App\Solicitude_concepto');
    }
}
