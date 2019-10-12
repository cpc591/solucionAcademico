<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accione extends Model
{
   
    public function solicitude_user()
    {
        return $this->belongsToMany('App\Solicitude_User');
    }
    public function solicitude_user_accione()
    {
        return $this->hasMany('App\Solicitude_User_Accione');
    }
}
