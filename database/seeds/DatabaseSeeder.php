<?php

use Illuminate\Database\Seeder;
use App\AudioFile;
use App\Project;
use App\Track;
use App\User;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        AudioFile::truncate();
        Project::truncate();
        Track::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(Project::class, 10)->create();

        $projects = Project::all()->pluck('id')->toArray();
        foreach(range(1,50) as $index){
            $track = Track::create([
              'name' => $faker->catchPhrase,
              'slug' => $faker->slug,
              'user_id' => factory(App\User::class)->create()->id,
              'project_id' => $faker->randomElement($projects),
            ]);

            $hash = $faker->md5;

            $file = AudioFile::create([
              'filename' => $faker->randomDigit . '_' . $hash . '.mp3',
              'hash' => $hash,
              'track_id' => $track->id,
            ]);
        }
        // $this->call(UserTableSeeder::class);

    }
}
