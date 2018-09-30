<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dosen;
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
        return view('dosen.dashboard');
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
            'nik'       => 'required|digits:10|unique:dosen',
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
