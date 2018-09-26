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

    public function kuliah() {
        return $this->hasOne( 'App\Kuliah', 'id_rencana', 'id' );
    }
}
