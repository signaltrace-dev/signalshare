<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }
    protected $guarded = [];

    public function tracks()
    {
      return $this->belongsToMany('App\Track')
        ->withPivot('name', 'owner_id', 'approved')
        ->withTimestamps();
    }

    public function tracksApproved()
    {
        return $this->belongsToMany('App\Track')
        ->withPivot('name', 'owner_id', 'approved')
        ->withTimestamps()
        ->where('approved', '=', '1');
    }

    public function tracksNotApproved()
    {
        return $this->belongsToMany('App\Track')
        ->withPivot('name', 'owner_id', 'approved')
        ->withTimestamps()
        ->where('approved', '=', '0');
    }

    public function totalTracks(){
        return $this->tracks()->count();
    }
}
