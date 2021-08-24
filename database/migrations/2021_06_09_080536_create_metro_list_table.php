<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetroListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metro_list', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('service_description')->nullable();
            $table->string('access_description')->nullable();
            $table->string('vcid')->nullable();
            $table->string('port_access')->nullable();
            $table->string('node_access')->nullable();
            $table->string('vlan_access')->nullable();
            $table->string('node_backhaul_1')->nullable();
            $table->string('node_backhaul_2')->nullable();
            $table->string('port_backhaul_1')->nullable();
            $table->string('port_backhaul_2')->nullable();
            $table->string('vlan_backhaul_1')->nullable();
            $table->string('vlan_backhaul_2')->nullable();
           
            $table->string('task_id')->nullable();
            $table->string('task')->nullable();
            $table->string('createTime')->nullable();
            $table->string('startTime')->nullable();
            $table->string('endTime')->nullable();
            $table->boolean('done')->default(false);
            $table->timestamp('done_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metro_list');
    }
}
