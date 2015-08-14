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
        Schema::create('user_profiles', function (Blueprint $table) {
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

        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('filename')->default('');
            $table->string('hash')->default('');
            $table->string('guid')->default('');
        });

        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->default(0);
            $table->foreign('project_id')->references('id')->on('projects');
            $table->timestamps();
            $table->integer('track_num')->unsigned()->default(1);
            $table->string('name')->default('');
            $table->integer('file_id')->unsigned()->default(0);
            $table->foreign('file_id')->references('id')->on('files');
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
        Schema::drop('user_profiles');
        Schema::drop('projects');
        Schema::drop('files');
        Schema::drop('tracks');
    }
}
