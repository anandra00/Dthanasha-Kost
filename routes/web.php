<?php

use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Penghuni\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PenghuniController;
use App\Http\Controllers\Penghuni\PaymentController;
use App\Http\Controllers\Admin\WaitingListController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\PembayaranController; // <--- Tambahan import PembayaranController
use Illuminate\Support\Facades\Route;

// ==========================================
// ROUTE SISI PEMILIK (ADMINISTRATOR)
// ==========================================
Route::middleware(['auth', 'role:owner'])->group(function () {
    
    // --- Views Admin ---
    Route::get('admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // ---> Route CRUD Data Penghuni <---
    Route::get('admin/data-penghuni', [PenghuniController::class, 'index'])->name('admin.data-penghuni');
    Route::post('/admin/tambah_akun', [PenghuniController::class, 'store'])->name('admin.tambah-akun');
    Route::put('/admin/edit_penghuni/{id}', [PenghuniController::class, 'update']);
    Route::delete('/admin/hapus_penghuni/{id}', [PenghuniController::class, 'destroy']); // <-- Pastikan ada /{id}

    // ---> Route CRUD Waiting List <---
    Route::get('admin/waiting-list', [WaitingListController::class, 'index'])->name('admin.waiting-list');
    Route::post('/admin/tambah_waiting_list', [WaitingListController::class, 'store']);
    Route::put('/admin/edit_waiting_list/{id}', [WaitingListController::class, 'update']);
    Route::delete('/admin/hapus_waiting_list/{id}', [WaitingListController::class, 'destroy']);

    // ---> Route CRUD Manajemen Kamar <---
    Route::get('admin/manajemen-kamar', [KamarController::class, 'index'])->name('admin.manajemen-kamar');
    Route::post('/admin/tambah_kamar', [KamarController::class, 'store']);
    Route::put('/admin/edit_kamar/{id}', [KamarController::class, 'update']);
    Route::delete('/admin/hapus_kamar/{id}', [KamarController::class, 'destroy']);

    // ---> Route Manajemen Pembayaran <---
    Route::get('admin/pembayaran', [PembayaranController::class, 'index'])->name('admin.pembayaran');
    Route::post('/admin/proses_pembayaran/{id}', [PembayaranController::class, 'konfirmasi']);
    Route::get('/kirim_notifikasi', function () { return back(); }); // (Sementara biarkan back dulu sampai ada fitur notifnya)

    // --- Views Admin Lainnya ---
    Route::get('admin/riwayat', function () { 
        return view('admin.riwayat'); 
    })->name('admin.riwayat');

    Route::get('admin/pengaturan', function () { 
        return view('admin.pengaturan'); 
    })->name('admin.pengaturan');


    // --- Action Admin Lainnya (Proses Form yang belum pakai Controller) ---

    // Manajemen Riwayat Transaksi
    Route::post('/tambah_riwayat', function () { return back(); });
    Route::put('/edit_riwayat', function () { return back(); });
    Route::delete('/hapus_riwayat', function () { return back(); });

    // Action Pengaturan
    Route::get('/admin/pengaturan', [PengaturanController::class, 'index'])->name('admin.pengaturan');
    Route::post('/admin/update-pengaturan', [PengaturanController::class, 'update'])->name('admin.update-pengaturan');
});


// ==========================================
// ROUTE SISI PENGHUNI
// ==========================================
Route::middleware(['auth', 'role:penghuni'])->group(function () { 
    
    // --- Views Penghuni ---
    Route::get('penghuni/dashboard', [DashboardController::class, 'index'])->name('penghuni.dashboard');

    Route::get('penghuni/pembayaran-manual', function () {
        return view('penghuni.pembayaran_manual');
    })->name('penghuni.pembayaran-manual');

    Route::get('penghuni/profile', function () {
        return view('penghuni.profile_penghuni');
    })->name('penghuni.profile');


    // --- Profil Bawaan Breeze ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // --- Action Penghuni (Proses Form) ---
    Route::post('/update-profile', function () {
        return redirect()->back()->with('success', 'Profil berhasil diupdate!');
    })->name('penghuni.update-profile');

    Route::post('/proses_bayar_penghuni', function () {
        // Logic upload dari modal gateway
        return redirect()->back();
    });

    Route::get('penghuni/pembayaran', [PaymentController::class, 'halamanPembayaran'])->name('penghuni.pembayaran');
    Route::post('penghuni/proses-bayar', [PaymentController::class, 'prosesBayar'])->name('penghuni.proses-bayar');

    Route::post('/proses_bayar_manual', function () {
        // Logic upload dari halaman upload manual
        return redirect('/penghuni/pembayaran');


    });
});
Route::post('/midtrans/webhook', [PaymentController::class, 'webhook']);


// Route autentikasi bawaan Breeze
require __DIR__.'/auth.php';