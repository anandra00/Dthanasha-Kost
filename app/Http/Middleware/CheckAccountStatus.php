<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->is_locked) {
            
            // KACAMATA SKEPTIS: Tambahin route pembayaran ke whitelist!
            // Asumsi prefix route pembayaran lu pakai 'penghuni.pembayaran'
            if ($request->routeIs('penghuni.keluhan*') || 
                $request->routeIs('penghuni.pembayaran*') || 
                $request->routeIs('logout')) {
                return $next($request);
            }

            // Tendang ke halaman pembayaran dengan pesan peringatan ala monochrome lu
            return redirect()->route('penghuni.pembayaran')
                ->with('warning', 'Akses dasbor dikunci sementara. Lu wajib melunasi tunggakan sebelum bisa mengakses fitur lainnya.');
        }

        return $next($request);
    }
}