<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function tags(){
        return $this->hasMany('App\Tag')->where('taxonomy_id', $this->id);
    }
}
