<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRencanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rencana', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sub_matkul');
            $table->integer('pertemuan');
            $table->text('pembelajaran')->nullable();
            $table->integer('waktu_mulai');
            $table->integer('waktu_selesai');
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
        Schema::dropIfExists('rencana');
    }
}
