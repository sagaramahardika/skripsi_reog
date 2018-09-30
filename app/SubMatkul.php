<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubMatkul extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sub_matkul';

    /**
     * Fungsi untuk mendapatkan matkul berdasarkan 
     * kd_matkul dari prodi yg memanggil fungsi ini
     */
    public function matkul() {
        return $this->belongsTo( 'App\MataKuliah', 'kd_matkul', 'kd_matkul' );
    }

    /**
     * Fungsi untuk mendapatkan banyak pengajar berdasarkan 
     * id_sub_matkul dari Submatkul
     */
    public function pengajar() {
        return $this->hasMany( 'App\Mengajar', 'id_sub_matkul', 'id');
    }

    public function periode() {
        return $this->belongsTo( 'App\Periode', 'id_periode', 'id');
    }
}
