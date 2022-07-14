<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class season extends Model
{
    //
}

public function locations(){
    return $this->belongsToMany('App\Location');
}
