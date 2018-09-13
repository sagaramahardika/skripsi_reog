<?php

namespace App\Http\Controllers;

use App\Dosen;
use Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct()
    {
        if ( Auth::guard('admin')->check() ) {
            $this->middleware('guest:admin');
        } else {
            $this->middleware('guest:dosen');
        }
    }

    public function index() 
    {
        return view('register'); 
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'nik'       => 'required',
            'name'      => 'required|string',
            'email'     => 'required|string|email',
            'no_tlpn'   => 'required',
            'password'  => 'required|string|confirmed', 
        ]);

        $dosen = new Dosen();
        $dosen->nik = $request->input('nik');
        $dosen->nama = $request->input('nama');
        $dosen->email = $request->input('email');
        $dosen->no_tlpn = $request->input('no_tlpn');
        $dosen->password = bcrypt($request->input('password'));
        $dosen->save();
    
        return redirect()->route( 'login-form' );
    }
}
