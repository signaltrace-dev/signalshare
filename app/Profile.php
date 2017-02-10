<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getImageUrlAttribute($value)
    {
        if(!empty($value))
        {
            $base_path = config('settings.profile_image_base');
            return $base_path . $value;
        }
        return $value;
    }

    public function title(){
        $this->load('user');

        $full_name = !empty($this->first_name) ? $this->first_name : '';
        $full_name = !empty($this->last_name) ? $full_name . ' ' . $this->last_name : $full_name;
        return $full_name;
    }
}
