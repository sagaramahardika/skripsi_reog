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
     * Fungsi untuk mendapatkan fakultas berdasarkan 
     * kd_fakultas dari prodi yg memanggil fungsi ini
     */
    public function matkul() {
        return $this->belongsTo( 'App\MataKuliah', 'kd_matkul', 'kd_matkul' );
    }
}
