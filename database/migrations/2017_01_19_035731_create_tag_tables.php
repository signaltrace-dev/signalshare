<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('slug')->default('');
            $table->integer('user_id')->unsigned()->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('project_tag', function(Blueprint $table){
            $table->increments('id');
            $table->timestamps();
            $table->integer('project_id')->unsigned()->default(0);
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('tag_id')->unsigned()->default(0);
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->integer('user_id')->unsigned()->default(0);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_tag');
        Schema::dropIfExists('tags');
    }
}
