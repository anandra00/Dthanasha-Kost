<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    use HasFactory;

    // Pastikan nama tabelnya sesuai dengan migration-mu
    protected $table = 'penghuni'; 

    // Field apa saja yang boleh diisi lewat form (sesuaikan dengan kolom di databasemu)
    protected $fillable = [
        'nama_penghuni',
        'usia',
        'jenis_kelamin',
        'no_telepon',
        'no_telepon_orangtua',
        'id_kamar', // <-- Ini foreign key yang menghubungkan ke tabel kamar
        'id_user'   // <-- Ini foreign key yang menghubungkan ke tabel users (akun)
    ];

    /**
     * Relasi ke model Kamar.
     * Satu penghuni menempati satu kamar (belongsTo).
     */
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }

    /**
     * Relasi ke model User (Akun login).
     * Satu penghuni memiliki satu akun user (belongsTo).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}