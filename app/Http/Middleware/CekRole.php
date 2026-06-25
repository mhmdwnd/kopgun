<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
	    public function handle(Request $request, Closure $next, $role)
	{
	    // Jika user belum login, lempar ke halaman login
	    if (!auth()->check()) {
	        return redirect('/login');
	    }

	    // Jika role user sesuai dengan yang diizinkan, silakan masuk
	    if (auth()->user()->role == $role) {
	        return $next($request);
	    }

	    // Jika role tidak sesuai, lemparkan kembali ke dashboard masing-masing
	    if (auth()->user()->role == 'admin') {
	        return redirect('/admin/dashboard');
	    } elseif (auth()->user()->role == 'kasir') {
	        return redirect('/kasir/dashboard');
	    }

	    return redirect('/');
	}
}
