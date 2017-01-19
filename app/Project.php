<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ProjectSettings;

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

    public function settings(){
        $allSettings = $this->hasMany('App\ProjectSettings');
        foreach ($allSettings as $key => $value) {

        }
    }

    public function fullPath(){
        $user = User::where('id', $this->owner_id)->first();
        return $user->name .'/'.$this->slug;
    }
}
