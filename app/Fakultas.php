<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fakultas';
    protected $primaryKey = 'kd_fakultas';
}
