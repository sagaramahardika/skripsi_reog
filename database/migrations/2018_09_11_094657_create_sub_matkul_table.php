<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubMatkulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_matkul', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kd_matkul');
            $table->integer('id_periode');
            $table->enum('grup', ['A', 'B', 'C', 'D', 'E'] );
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
        Schema::dropIfExists('sub_matkul');
    }
}
