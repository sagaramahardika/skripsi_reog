<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $incrementing = false;
    protected $table = 'matakuliah';
    protected $primaryKey = 'kd_matkul';

    /**
     * Fungsi untuk mendapatkan fakultas berdasarkan 
     * kd_fakultas dari prodi yg memanggil fungsi ini
     */
    public function prodi() {
        return $this->belongsTo( 'App\Prodi', 'kd_prodi', 'kd_prodi' );
    }
}
