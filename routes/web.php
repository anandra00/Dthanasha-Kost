<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\RiwayatController;
use App\Http\Controllers\Penghuni\DashboardController;
use App\Http\Controllers\Penghuni\ProfileController as PenghuniProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PenghuniController;
use App\Http\Controllers\Penghuni\PaymentController;
use App\Http\Controllers\Admin\WaitingListController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\PembayaranController;
use Illuminate\Support\Facades\Route;

// ==========================================
// ROUTE SISI PEMILIK (ADMINISTRATOR)
// ==========================================
Route::middleware(['auth', 'role:owner'])->group(function () {
    
    // --- Dashboard Admin (Pakai Controller) ---
    Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // ---> Route CRUD Data Penghuni <---
    Route::get('admin/data-penghuni', [PenghuniController::class, 'index'])->name('admin.data-penghuni');
    Route::post('/admin/tambah_akun', [PenghuniController::class, 'store'])->name('admin.tambah-akun');
    Route::put('/admin/edit_penghuni/{id}', [PenghuniController::class, 'update']);
    Route::delete('/admin/hapus_penghuni/{id}', [PenghuniController::class, 'destroy']);

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
    Route::get('/kirim_notifikasi', function () { return back(); });

    // ---> Route CRUD Riwayat Transaksi <---
    Route::get('admin/riwayat', [RiwayatController::class, 'index'])->name('admin.riwayat');
    Route::post('/admin/tambah_riwayat', [RiwayatController::class, 'store'])->name('admin.tambah-riwayat');
    Route::put('/admin/edit_riwayat/{id}', [RiwayatController::class, 'update'])->name('admin.edit-riwayat');
    Route::delete('/admin/hapus_riwayat/{id}', [RiwayatController::class, 'destroy'])->name('admin.hapus-riwayat');

    // ---> Route Pengaturan <---
    Route::get('/admin/pengaturan', [PengaturanController::class, 'index'])->name('admin.pengaturan');
    Route::post('/admin/update-pengaturan', [PengaturanController::class, 'update'])->name('admin.update-pengaturan');
});


// ==========================================
// ROUTE SISI PENGHUNI
// ==========================================
Route::middleware(['auth', 'role:penghuni'])->group(function () { 
    
    // --- Views Penghuni ---
    Route::get('penghuni/dashboard', [DashboardController::class, 'index'])->name('penghuni.dashboard');

    Route::get('penghuni/pembayaran-manual', [PaymentController::class, 'halamanManual'])->name('penghuni.pembayaran-manual');

    Route::get('penghuni/profile', [PenghuniProfileController::class, 'index'])->name('penghuni.profile');
    Route::post('penghuni/update-profile', [PenghuniProfileController::class, 'update'])->name('penghuni.update-profile');

    Route::post('/proses_bayar_penghuni', function () {
        // Logic upload dari modal gateway
        return redirect()->back();
    });

    Route::get('penghuni/pembayaran', [PaymentController::class, 'halamanPembayaran'])->name('penghuni.pembayaran');
    Route::post('penghuni/proses-bayar', [PaymentController::class, 'prosesBayar'])->name('penghuni.proses-bayar');

    Route::post('/proses_bayar_manual', [PaymentController::class, 'prosesBayarManual']);
});
Route::post('/midtrans/webhook', [PaymentController::class, 'webhook']);


// Route autentikasi bawaan Breeze
require __DIR__.'/auth.php';