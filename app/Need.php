<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    public function needs(){
        return $this->belongsToMany('App\Project')
          ->withPivot('user_id')
          ->withTimestamps();
    }
}
