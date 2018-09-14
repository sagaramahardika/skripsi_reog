<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prodi';
    protected $primaryKey = 'kd_prodi';

    /**
     * Fungsi untuk mendapatkan fakultas berdasarkan 
     * kd_fakultas dari prodi yg memanggil fungsi ini
     */
    public function fakultas() {
        return $this->belongsTo( 'App\Fakultas', 'kd_fakultas', 'kd_fakultas' );
    }
}
