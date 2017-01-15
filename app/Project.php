<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function getRouteKeyName(){
        return 'slug';
    }
    protected $guarded = [];
    //
    public function tracks()
    {
      return $this->hasMany('App\Track');
    }

    public function tracksApproved(){
      return $this->hasMany('App\Track')->where('approved', '=', '1');
    }

    public function tracksNotApproved(){
      return $this->hasMany('App\Track')->where('approved', '=', '0');
    }

}
