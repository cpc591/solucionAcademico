<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitude extends Model
{
    protected $fillable = [
        'codigo', 'asunto', 'contenido','asunto_id',
    ];
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function multimedias_solicitudes()
    {
        return $this->hasMany('App\Multimedias_Solicitude');
    }
    public function estados()
    {
        return $this->belongsTo('App\Estado');
    }
    public function tipos()
    {
        return $this->belongsTo('App\Tipo','tipo_id');
    }
    public function solicitude_user()
    {
        return $this->hasMany('App\Solicitude_User');
    }
    public function asunto_nuevo()
    {
        return $this->belongsTo('App\Asunto', 'asunto_id');
    }
}
