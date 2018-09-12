<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Route;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function index() 
    {
        return view('login'); 
    }

    public function login(Request $request)
    {
        // Validate the form data
      $this->validate($request, [
        'username'  => 'required|email',
        'password'  => 'required|min:6'
      ]);
      
      if ( Auth::guard('admin')->attempt( ['username' => $request->username, 'password' => $request->password], $request->remember) ) {
        // Success attempt to login admin & redirect to admin dashboard
        return redirect()->intended(route('admin.dashboard'));
      } elseif( Auth::guard('dosen')->attempt( ['email' => $request->email, 'password' => $request->password], $request->remember) ) {
        // Success attempt to login dosen & redirect to dosen dashboard
        return redirect()->intended(route('admin.dashboard'));
      } else { 
        // Failed attempt to login either admin or dosen
        // Redirect back to login form
        return redirect()->back();
      }
      
    }

    public function logout() {

        if ( Auth::guard('admin')->check() ) {
            Auth::guard('admin')->logout();
        } else {
            Auth::guard('dosen')->logout();
        }

        return redirect('/');
    }
}
