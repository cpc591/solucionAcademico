<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Novedade extends Model
{
    //
    protected $table = 'novedades';
    public $timestamps = false;
    
    protected $fillable = [
        'solicitude_user_id', 'texto',
    ];
    public function solicitude_user()
    {
        return $this->belongsTo('App\Solicitude_User');
    }
    public function multimedias_novedades()
    {
        return $this->hasMany('App\Multimedias_Novedade');
    }
}
