<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () { return view('login'); });
Route::get('/dashboard', function () { return view('dashboard'); });
Route::get('/data_penghuni', function () { return view('data_penghuni'); });
Route::get('/waiting_list', function () { return view('waiting_list'); });
Route::get('/manajemen_kamar', function () { return view('manajemen_kamar'); });
Route::get('/pembayaran', function () { return view('pembayaran'); });
Route::get('/riwayat', function () { return view('riwayat'); });


Route::post('/login', function () { return redirect('/dashboard'); });
Route::post('/logout', function () { return redirect('/'); });

Route::post('/tambah_akun', function () { return back(); });
Route::delete('/hapus_penghuni', function () { return back(); });

Route::post('/tambah_waiting_list', function () { return back(); });
Route::put('/edit_waiting_list', function () { return back(); });
Route::delete('/hapus_waiting_list', function () { return back(); });

Route::post('/tambah_kamar', function () { return back(); });
Route::put('/edit_kamar', function () { return back(); });
Route::delete('/hapus_kamar', function () { return back(); });

Route::post('/proses_pembayaran', function () { return back(); });
Route::get('/kirim_notifikasi', function () { return back(); });

Route::post('/tambah_riwayat', function () { return back(); });
Route::put('/edit_riwayat', function () { return back(); });
Route::delete('/hapus_riwayat', function () { return back(); });