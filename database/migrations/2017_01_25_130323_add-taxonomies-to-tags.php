<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaxonomiesToTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_taxonomy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        // Add taxonomy_id to tags table
        Schema::table('tags', function (Blueprint $table) {
            $table->integer('taxonomy_id')->unsigned()->default(0);
            $table->foreign('taxonomy_id')->references('id')->on('tag_taxonomy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_taxonomy');

        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('taxonomy_id');
        });
    }
}
