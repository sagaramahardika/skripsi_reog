<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Dosen extends Authenticatable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $incrementing = false;
    protected $table = 'dosen';
    protected $guard = 'dosen';
    protected $primaryKey = 'nik';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nik', 'kd_prodi', 'nama', 'email', 'no_tlpn', 'jabatan','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function mengajar() {
        return $this->hasMany( 'App\Mengajar', 'nik', 'nik' );
    }
}
