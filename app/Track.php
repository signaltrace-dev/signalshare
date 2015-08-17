<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $guarded = [];
    //

    protected function file(){
      return $this->hasOne('App\AudioFile');
    }
}
