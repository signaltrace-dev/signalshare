<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectNeedsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_needs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('');
            $table->integer('user_id')->unsigned()->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('project_project_needs', function(Blueprint $table){
            $table->increments('id');
            $table->timestamps();
            $table->integer('project_id')->unsigned()->default(0);
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('need_id')->unsigned()->default(0);
            $table->foreign('need_id')->references('id')->on('project_needs');
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
        Schema::dropIfExists('project_project_needs');
        Schema::dropIfExists('project_needs');
    }
}
