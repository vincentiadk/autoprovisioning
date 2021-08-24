<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_ports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('olt_site_id');
            $table->string('gpon_port')->nullable();
            $table->integer('ont_number')->nullable();
            $table->timestamps();
        });

        Schema::table('service_ports', function (Blueprint $table) {
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
        Schema::dropIfExists('service_ports');
    }
}
