<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mengajar extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mengajar';

    public function submatkul() {
        return $this->belongsTo( 'App\SubMatkul', 'id_sub_matkul', 'id' );
    }

    public function dosen() {
        return $this->belongsTo( 'App\Dosen', 'nik', 'nik' );
    }
}
