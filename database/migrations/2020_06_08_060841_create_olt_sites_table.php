<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOltSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('olt_sites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->unsignedBigInteger('user_id');
            $table->string('hostname')->nullable();
            $table->string('uplink_port')->nullable();
            $table->string('site_id')->nullable();
            $table->string('site_name')->nullable();
            $table->decimal('bw_order_total',8,2)->nullable();
            $table->decimal('bw_order_oam',8,2)->nullable();
            $table->decimal('bw_order_2g',8,2)->nullable();
            $table->decimal('bw_order_3g',8,2)->nullable();
            $table->decimal('bw_order_4g',8,2)->nullable();
            $table->string('vlan')->nullable();
            $table->string('vlan_2g')->nullable();
            $table->string('vlan_3g')->nullable();
            $table->string('vlan_4g')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::table('olt_sites', function (Blueprint $table) {
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
        Schema::dropIfExists('olt_sites');
    }
}
