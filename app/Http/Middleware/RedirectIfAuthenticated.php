<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'admin-dosen':
                if ( Auth::guard('admin')->check() ) {
                    return redirect()->route('admin.dashboard');
                } elseif ( Auth::guard('dosen')->check() ) {
                    $dosen = Auth::guard('dosen')->user();
                    if ( $dosen->jabatan == 'kaprodi') {
                        return redirect()->route('kaprodi.dashboard');
                    } else {
                        return redirect()->route('dosen.dashboard');
                    }
                }
                break;
            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('/');
                }
                break;
        }
        return $next($request);
    }
}
