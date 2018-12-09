<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mengajar;
use Auth;

class KaprodiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:dosen');
    }

    public function index() {
        $user = Auth::user();
        $forgottenClass = [];

        $mengajars = Mengajar::where('nik', $user->nik)->get();
        foreach($mengajars as $mengajar) {
            $submatkul = $mengajar->submatkul;
            if ( !empty($submatkul) ) {
                $rencanas = $submatkul->rencana;
                if ( !empty($rencanas) ) {
                    foreach ( $rencanas as $rencana ) {
                        $kuliah = $rencana->kuliah;
                        if ( !empty($kuliah) && empty($kuliah->waktu_selesai) ) {
                            $forgottenClass[] = $kuliah;
                        }
                    }
                }
            }
        }

        return view('kaprodi.dashboard', [
            'forgottenClass'    => $forgottenClass
        ]);
    }
}
