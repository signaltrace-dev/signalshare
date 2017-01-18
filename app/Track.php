<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    public function getRouteKeyName(){
        return 'slug';
    }
    protected $guarded = [];
    //

    public function projects(){
        return $this->belongsToMany('App\Project')
            ->withPivot('name', 'owner_id', 'approved')
            ->withTimestamps();
    }

    protected function file(){
      return $this->hasOne('App\AudioFile');
    }
}
