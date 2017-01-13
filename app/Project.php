<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];
    //
    public function tracks()
    {
      return $this->hasMany('App\Track');
    }

    public function tracksApproved(){
      return $this->hasMany('App\Track')->where('approved', '=', '1');
    }
}
