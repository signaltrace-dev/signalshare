<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudioFile extends Model
{
  protected $table = 'audio_files';

  public function track()
  {
    return $this->belongsTo('App\Track');
  }
}
