<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluarans';

    // Sesuaikan dengan kolom di migration baru lu
    protected $fillable = [
        'nama_kegiatan',
        'pihak_tujuan',
        'tanggal',
        'metode_pembayaran',
        'nominal'
    ];

    // Casting biar gampang pas manggil di view/controller
    protected $casts = [
        'tanggal' => 'date',      // Langsung jadi format Carbon biar gampang diformat d/m/Y
        'nominal' => 'integer',   // Pastiin dia keluar sebagai angka murni
    ];
}