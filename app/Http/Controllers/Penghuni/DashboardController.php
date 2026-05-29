<?php

namespace App\Http\Controllers\Penghuni;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tagihan;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pengaturan;
use App\Models\Transaksi;
use App\Models\Keluhan;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index ()
    {
        $user = Auth::user();
        $nama = $user->name;
        $penghuni = Penghuni::where('id_user', $user->id)->first();

        // Jaga kalau penghuni belum terdaftar atau belum ada kamar
        $kamar = null;
        $tagihanSaatIni = null;
        $riwayatPembayaran = collect();

        if ($penghuni) {
            if ($penghuni->id_kamar) {
                $kamar = Kamar::where('id', $penghuni->id_kamar)->first();
            }
            $tagihanSaatIni = Tagihan::where('id_penghuni', $penghuni->id)
                        ->where('status_tagihan', 'Belum Lunas')
                        ->latest()
                        ->first();

            // Riwayat pembayaran dari tagihan yang sudah lunas
            $riwayatPembayaran = Tagihan::where('id_penghuni', $penghuni->id)
                        ->orderBy('created_at', 'desc')
                        ->take(10)
                        ->get();
        }

        $waAdmin = Pengaturan::where('kunci', 'wa_admin')->first();

        return view('penghuni.dashboard', compact('tagihanSaatIni', 'nama', 'kamar', 'penghuni', 'waAdmin', 'riwayatPembayaran'));
    }

   public function submitKeluhan(Request $request)
    {
        // Validasi input form
        $request->validate([
            'isi_keluhan' => 'required|string|max:500'
        ]);

        $user = auth()->user();
        $penghuni = Penghuni::where('id_user', $user->id)->first();

        // 1. Simpan data ke tabel keluhans!
        // KACAMATA SKEPTIS: Sesuaikan nama kolom ('isi_keluhan', 'status', dll) sama yang ada di database lu ya!
        $keluhan = Keluhan::create([
            'id_penghuni' => $penghuni->id,
            'isi_keluhan' => $request->isi_keluhan,
            'status_keluhan' => 'Menunggu', // Default status pas pertama masuk
            'tanggal' => now(),
        ]);

        // 2. Generate Pesan Template (Sekarang udah punya data nyata!)
        $pesan = "Halo Owner Dthanasha Kost, saya ingin melaporkan kendala terkait akun terkunci.\n\n";
        $pesan .= "▪️ *Nama*: {$penghuni->nama_penghuni}\n";
        $pesan .= "▪️ *ID Keluhan*: KLH-{$keluhan->id}\n\n";
        $pesan .= "*Pesan:*\n_{$request->isi_keluhan}_";

        // 3. Nomor WA Bapak Kos (Ganti pake nomor asli Owner nantinya)
        // Pastiin depannya 62, jangan 0 atau +62!
        $nomorOwner = "6281234567890"; 

        // 4. Bikin URL API WhatsApp
        $urlWa = "https://wa.me/{$nomorOwner}?text=" . urlencode($pesan);

        // 5. Lempar/Redirect user ke URL WhatsApp!
        return redirect()->away($urlWa);
    }
}
