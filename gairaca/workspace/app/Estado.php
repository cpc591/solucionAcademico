<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';
    public function solicitude_user()
    {
        return $this->belongsTo('App\Solicitude_User');
    }
}
