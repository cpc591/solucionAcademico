<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipos_Solicitude_concepto extends Model
{
    protected $table = 'tipos_solicitudes_conceptos';
    protected $fillable = [
        'nombre',
    ];
    public function solicitudes_conceptos()
    {
        return $this->hasMany('App\Solicitude_concepto');
    }
}
