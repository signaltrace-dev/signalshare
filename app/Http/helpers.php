<?php
namespace App\Http;

use Illuminate\Support\Str;

class Helpers
{
  public static function getSlug($title, $model)
  {
  	$slug = Str::slug($title);
  	$slugCount = count( $model->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get() );

  	return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
  }
}
