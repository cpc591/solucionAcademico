<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asunto extends Model
{
    protected $fillable = [
        'id', 'nombre',
    ];
    protected $table = 'asuntos';
    
    public function solicitudes()
    {
        return $this->hasMany('App\Solicitude');
    }
}
