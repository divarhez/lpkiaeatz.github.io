<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PetugasMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            // Jika belum login, redirect ke login
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'petugas') {
            // Jika bukan petugas, redirect ke home dengan pesan
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return $next($request);
    }
}
