<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dosen;
use App\Mengajar;
use App\Prodi;
use Auth;

class DosenController extends Controller
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
                $matkul = $submatkul->matkul;
                if ( !empty($rencanas) ) {
                    foreach ( $rencanas as $rencana ) {
                        $kuliah = $rencana->kuliah;
                        if ( !empty($kuliah) && empty($kuliah->waktu_selesai) ) {
                            $forgottenClass[] = [
                                'matkul'        => $matkul->nama_matkul,
                                'grup'          => $submatkul->grup,
                                'pertemuan'     => $rencana->pertemuan,
                                'id_rencana'    => $rencana->id
                            ];
                        }
                    }
                }
            }
        }

        return view('dosen.dashboard', [
            'forgottenClass'    => $forgottenClass
        ]);
    }

    public function edit($nik) {
        try {
            $dosen = Dosen::findOrFail($nik);
        } catch ( Exception $e ) {
            return redirect()->route( 'dosen.dashboard' )
                ->with('error', "Failed to view Dosen with NIK {$nik}");
        }

        $allProdi = Prodi::all();

        return view( 'dosen.edit', [
            'allProdi'  => $allProdi,
        ])->with( 'dosen', $dosen );

    }

    public function update($nik, Request $request) {
        $user = Auth::user();

        try {
            $dosen = Dosen::findOrFail($nik);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update profile Dosen with NIK {$nik}!"
            );

            if ( $user->jabatan == "kaprodi" ) {
                return redirect()->route( 'kaprodi.dashboard' );
            } else {
                return redirect()->route( 'dosen.dashboard' );
            }
        }

        $this->validate($request, [
            'kd_prodi'  => 'required',
            'nik'       => 'required|string|size:7|unique:dosen',
            'nama'      => 'required|string',
            'email'     => 'required|string|email',
            'no_tlpn'   => 'required',
            'password'  => 'required|string|confirmed', 
        ]);

        $dosen->kd_prodi = $request->input('kd_prodi');
        $dosen->nik = $request->input('nik');
        $dosen->nama = $request->input('nama');
        $dosen->email = $request->input('email');
        $dosen->no_tlpn = $request->input('no_tlpn');
        $dosen->password = bcrypt($request->input('password'));
        $dosen->save();
    
        if ( $user->jabatan == "kaprodi" ) {
            return redirect()->route( 'kaprodi.dashboard' );
        } else {
            return redirect()->route( 'dosen.dashboard' );
        }
    }
}
