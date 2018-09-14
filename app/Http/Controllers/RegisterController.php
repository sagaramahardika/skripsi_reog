<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Prodi;
use Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin-dosen');
    }

    public function index() 
    {
        $allProdi = Prodi::all();

        return view('register', [
            'allProdi'  => $allProdi,
        ]); 
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'kd_prodi'  => 'required',
            'nik'       => 'required|digits:10|unique:dosen',
            'nama'      => 'required|string',
            'email'     => 'required|string|email',
            'no_tlpn'   => 'required',
            'password'  => 'required|string|confirmed', 
        ]);

        $dosen = new Dosen();
        $dosen->kd_prodi = $request->input('kd_prodi');
        $dosen->nik = $request->input('nik');
        $dosen->nama = $request->input('nama');
        $dosen->email = $request->input('email');
        $dosen->no_tlpn = $request->input('no_tlpn');
        $dosen->jabatan = 3;
        $dosen->password = bcrypt($request->input('password'));
        $dosen->save();
    
        return redirect()->route( 'login-form' );
    }
}
