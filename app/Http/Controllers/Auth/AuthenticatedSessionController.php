<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Cek username & password (bawaan asli)
        $request->authenticate();

        // 2. Bikin sesi baru biar aman dari hacker (bawaan asli)
        $request->session()->regenerate();

        // 3. LOGIKA CUSTOM KITA: Cek role si user
        $role = $request->user()->role;

        if ($role === 'owner') {
            // Kalau yang login owner, lempar ke route owner.dashboard
            return redirect()->intended(route('admin.dashboard'));
            
        } elseif ($role === 'penghuni') {
            // Kalau yang login penghuni, lempar ke route penghuni.dashboard
            return redirect()->intended(route('penghuni.dashboard'));
        }

        // Jaga-jaga kalau ada role siluman yang nggak dikenali
        Auth::logout();
        return redirect('/login')->withErrors(['login' => 'Role tidak valid!']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
