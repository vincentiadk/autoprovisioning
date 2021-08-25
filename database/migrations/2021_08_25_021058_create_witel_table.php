<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWitelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('witel', function (Blueprint $table) {
            $table->string('id')->index();
            $table->string('witel');
            $table->string('divisi');
            $table->integer('urut');
            $table->string('witel_txt');
            $table->string('witel_2');
            $table->string('sink_witel');
            $table->integer('regional');
            $table->integer('bsr');
            $table->string('provinsi');
            $table->integer('msn');
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
        Schema::dropIfExists('witel');
    }
}
