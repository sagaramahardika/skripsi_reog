<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->string('nik', 7);
            $table->integer('kd_prodi');
            $table->string('nama');
            $table->string('email');
            $table->string('no_tlpn');
            $table->enum('jabatan', ['kaprodi', 'dosen', 'guest'] );
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->primary('nik');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosen');
    }
}
