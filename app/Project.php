<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ProjectSettings;

class Project extends Model
{
    public static function boot(){
        parent::boot();

        static::deleting(function($project){
            foreach($project->needs as $need){
                $project->needs()->detach($need->id);
            }

            foreach($project->tags as $tag){
                $project->tags()->detach($tag->id);
            }

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
        ->withPivot('name', 'user_id', 'approved')
        ->withTimestamps();
    }

    public function tracksApproved()
    {
        return $this->belongsToMany('App\Track')
        ->withPivot('name', 'user_id', 'approved')
        ->withTimestamps()
        ->where('approved', '=', '1');
    }

    public function tracksNotApproved()
    {
        return $this->belongsToMany('App\Track')
        ->withPivot('name', 'user_id', 'approved')
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
        $user = User::where('id', $this->user_id)->first();
        return $user->name .'/'.$this->slug;
    }

    public function tags(){
        return $this->belongsToMany('App\Tag')
          ->withPivot('user_id')
          ->withTimestamps();
    }

    public function needs(){
        return $this->belongsToMany('App\Need')
          ->withPivot('user_id')
          ->withTimestamps();
    }

    public function owner(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function collaborators(){
        // Users other than the project owner who own any tracks that are used in this project
        //->unique('user_id')->toArray();//->unique('user_id')->toArray();//->except($this->user_id)->toArray();
        $user_ids = [];
        foreach($this->tracks as $key => $track){
            if(!in_array($track->user_id, $user_ids) && $track->user_id != $this->user_id){
                $user_ids[] = $track->user_id;
            }
        }
        $users = \App\User::find($user_ids);

        return $users;
    }
}
