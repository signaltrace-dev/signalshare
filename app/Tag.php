<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function save(array $options = [])
    {
       // before save code
       if(empty($this->taxonomy_id)){
           $default_taxonomy = Taxonomy::where('name', 'Tags')->first();
           if(empty($default_taxonomy)){
              $default_taxonomy = new Taxonomy();
              $default_taxonomy->name = 'Tags';
              $default_taxonomy->slug = 'tags';
              $default_taxonomy->user_id = 1;
              $default_taxonomy->save();
           }
           $this->taxonomy_id = $default_taxonomy->id;
       }
       parent::save();
       // after save code
    }

    public function projects(){
        return $this->belongsToMany('App\Project')
          ->withPivot('user_id')
          ->withTimestamps();
    }
}
