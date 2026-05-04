<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
        {
            // Pastiin user udah login, kalau belum lempar ke login
            if (!Auth::check()) {
                return redirect('/login');
            }

            // Cek apakah role user di database SESUAI sama role yang dimau di Route
            if (Auth::user()->role !== $role) {
                // Kalau beda, kasih error 403 (Forbidden)
                abort(403, 'Akses Ditolak! Lu bukan ' . $role . '.');
            }

            return $next($request);
        }
}
