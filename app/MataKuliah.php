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
}
