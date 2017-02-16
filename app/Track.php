<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Track extends Model
{
    public static function boot(){
        parent::boot();

        static::deleting(function($track){
            $filename = $track->file->filename;
            Storage::delete('public/' . $filename);
            $track->file->delete();
            return true;
        });
    }

    public function getRouteKeyName(){
        return 'slug';
    }
    protected $guarded = [];
    //

    public function projects(){
        return $this->belongsToMany('App\Project')
            ->withPivot('name', 'user_id', 'approved')
            ->withTimestamps();
    }

    protected function file(){
      return $this->hasOne('App\AudioFile');
    }

    public function owner(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
