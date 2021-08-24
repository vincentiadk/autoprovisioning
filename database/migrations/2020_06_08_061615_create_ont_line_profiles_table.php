<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOntLineProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ont_line_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('olt_site_id');
            $table->integer('profile_id')->nullable();
            $table->string('tcont_1')->nullable();
            $table->string('tcont_2')->nullable();
            $table->string('tcont_3')->nullable();
            $table->string('tcont_4')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });


        Schema::table('ont_line_profiles', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('olt_site_id')->references('id')->on('olt_sites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ont_line_profiles');
    }
}
