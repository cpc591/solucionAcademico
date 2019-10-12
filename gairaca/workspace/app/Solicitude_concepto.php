<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitude_concepto extends Model
{
    protected $table = 'solicitudes_conceptos';
    public $timestamps = false;
    
    protected $fillable = [
        'solicitude_id', 'texto','user_creador_id','user_dirigida_id'
    ];
    public function solicitude()
    {
        return $this->belongsTo('App\Solicitude_User');
    }
    public function users()
    {
        return $this->belongsTo('App\Solicitude_User');
    }
    public function multimedias_solicitude_concepto()
    {
        return $this->hasMany('App\Multimedias_Solicitude_concepto','solicitude_concepto_id');
    }
    public function respuestaConcepto()
    {
        return $this->hasMany('App\RespuestaConcepto','solicitudes_conceptos_id');
    }
}