<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public static function boot(){
        parent::boot();

        static::deleting(function($project){
            foreach($project->tracks as $track){
                $project->tracks()->detach($track->id);

                // Remove track / file only if it's not being used in any other projects
                $other_projects = $track->projects()->count();
                if($other_projects == 0){
                    $track->delete();
                }
            }

        });

    }

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

    public function tags(){
        return $this->belongsToMany('App\Tag')
          ->withPivot('user_id')
          ->withTimestamps();
    }
}
