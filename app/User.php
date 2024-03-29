<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function roles(){
        return $this->belongsToMany('App\Role')
          ->withPivot('user_id');
    }

    public function projects(){
        return $this->hasMany('App\Project');
    }

    public function tracks(){
        return $this->belongsToMany('App\Track')
            ->withPivot('user_id');
    }

    public function collabs(){
        // Get any projects not owned by the user, but which have tracks owned by the user
        $collabs = \App\Project::whereHas('tracks', function ($query){
            $query->where('tracks.user_id', $this->id);
        })->where('user_id', '!=', $this->id);

        return $collabs;
    }
}
