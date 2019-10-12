<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitude_User_Accione extends Model
{
     protected $table = 'solicitude_user_accione';
     public $timestamps = false;
     protected $fillable = [
        'accione_id', 'solicitude_user_id','fecha',
    ];
     public function solicitude_user()
    {
        return $this->belongsTo('App\Solicitude_User','solicitude_user_id');
    }
     public function acciones()
    {
        return $this->belongsTo('App\Accione','accione_id');
    }
}
