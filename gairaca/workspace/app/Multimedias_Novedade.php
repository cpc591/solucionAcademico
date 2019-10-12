<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Multimedias_Novedade extends Model
{
    protected $table = 'multimedias_novedades';
    
    public function novedades()
    {
        return $this->belongsTo('App\Novedade');
    }
}
