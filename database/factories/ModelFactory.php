<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Project::class, function(Faker\Generator $faker){
  return[
    'name' => $faker->company,
    'slug' => $faker->slug,
    'user_id' => factory(App\User::class)->create()->id,
  ];
});

$factory->define(App\Track::class, function(Faker\Generator $faker){
  return[
    'name' => $faker->realText($maxNbChars = 50, $indexSize = 2),
    'slug' => $faker->slug,
    'user_id' => factory(App\User::class)->create()->id,
    'project_id' => factory(App\Project::class)->create()->id,
  ];
});

$factory->define(App\AudioFile::class, function(Faker\Generator $faker){
  $hash = $faker->md5;
  return [
    'filename' => $faker->randomDigit . '_' . $hash,
    'hash' => $hash,
  ];
});
