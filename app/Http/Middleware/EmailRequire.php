<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailRequire
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // KACAMATA SKEPTIS: Cek apakah user udah login, DAN emailnya belum beres
        if ($user && (is_null($user->email) || is_null($user->email_verified_at))) {
            
            // Daftar Putih (Whitelist) route yang diizinkan saat email belum beres
            if ($request->routeIs('penghuni.dashboard') || 
                $request->routeIs('penghuni.submit-email') || 
                $request->routeIs('penghuni.verify-otp') || 
                $request->routeIs('penghuni.reset-email') || 
                $request->routeIs('logout')) {
                return $next($request);
            }

            // Kalau nekat buka route lain (kayak /pembayaran), tendang balik ke dasbor!
            return redirect()->route('penghuni.dashboard')
                ->with('error', 'Wajib isi dan verifikasi email lu dulu, bro!');
        }

        return $next($request);
    }
}