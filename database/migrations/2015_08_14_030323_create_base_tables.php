<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned()->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->string('username')->default('');
            $table->boolean('active')->default(true);
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name')->default('');
            $table->string('slug')->default('');
            $table->integer('owner_id')->unsigned()->default(0);
            $table->foreign('owner_id')->references('id')->on('users');
            $table->boolean('published')->default(false);
        });

        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name')->default('');
            $table->string('slug')->default('');
            $table->integer('owner_id')->unsigned()->default(0);
            $table->foreign('owner_id')->references('id')->on('users');
        });

        Schema::create('audio_files', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('filename')->default('');
            $table->string('hash')->default('');
            $table->integer('track_id')->unsigned()->default(0);
            $table->foreign('track_id')->references('id')->on('tracks');
        });

        Schema::create('project_track', function(Blueprint $table){
            $table->increments('id');
            $table->timestamps();
            $table->integer('project_id')->unsigned()->default(0);
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('track_id')->unsigned()->default(0);
            $table->foreign('track_id')->references('id')->on('tracks');
            $table->string('name')->default('');
            $table->integer('owner_id')->unsigned()->default(0);
            $table->foreign('owner_id')->references('id')->on('users');
            $table->boolean('approved')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::drop('audio_files');
        Schema::drop('tracks');
        Schema::drop('projects');
        Schema::drop('project_track');
        Schema::drop('user_profiles');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
