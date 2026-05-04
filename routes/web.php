<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('admin/dashboard', function () {
        return view('dashboard_admin');
    })->name('admin.dashboard');

    Route::get('admin/data-penghuni', function () {
        return view('data_penghuni');
    })->name('admin.data-penghuni');

    Route::get('admin/manajamen-kamar', function () {
        return view('manajemen_kamar');
    })->name('admin.manajemen-kamar');
});//buat route owner/admin

Route::middleware(['auth', 'role:penghuni'])->group(function () {
    Route::get('penghuni/dashboard', function () {
        return view('dashboard_penghuni');
    })->name('penghuni.dashboard');
}); //buat route penghuni

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
