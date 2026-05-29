<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'wajib.email' => \App\Http\Middleware\EmailRequire::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            '/midtrans/webhook',
        ]);

        // Fix redirect loop: ketika user sudah login mengakses halaman guest (/ atau /login),
        // redirect ke dashboard sesuai role
        $middleware->redirectGuestsTo('/login');
        $middleware->redirectUsersTo(fn ($request) => 
            $request->user()?->role === 'owner' ? '/admin/dashboard' : '/penghuni/dashboard'
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
