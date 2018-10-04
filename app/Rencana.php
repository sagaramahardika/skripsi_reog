<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rencana extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rencana';

    public function submatkul() {
        return $this->belongsTo( 'App\SubMatkul', 'id_sub_matkul', 'id' );
    }

    public function kuliah() {
        return $this->hasOne( 'App\Kuliah', 'id_rencana', 'id' );
    }
}
