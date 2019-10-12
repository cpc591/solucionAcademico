<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Multimedias_Solicitude extends Model
{
    protected $table = 'multimedias_solicitudes';
    
    public function solicitudes()
    {
        return $this->belongsTo('App\Solicitude');
    }
}
