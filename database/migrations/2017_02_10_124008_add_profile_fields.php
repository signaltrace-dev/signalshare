<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add taxonomy_id to tags table
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('city')->nullable();
            $table->string('country', 3)->nullable();
            $table->longtext('bio')->nullable();
            $table->string('image_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('country');
            $table->dropColumn('bio');
            $table->dropColumn('image_url');
        });
    }
}
