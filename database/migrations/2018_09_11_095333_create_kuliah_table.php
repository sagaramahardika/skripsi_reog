<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_rencana');
            $table->integer('nim')->nullable();
            $table->text('catatan')->nullable();
            $table->integer('waktu_mulai');
            $table->integer('waktu_selesai')->nullable();
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
        Schema::dropIfExists('kuliah');
    }
}
