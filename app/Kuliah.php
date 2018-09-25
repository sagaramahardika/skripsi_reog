<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kuliah extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kuliah';

    public function rencana() {
        return $this->hasOne( 'App\Rencana', 'id', 'id_rencana' );
    }
}
