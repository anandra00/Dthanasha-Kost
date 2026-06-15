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

class DashboardPenghuniController extends Controller
{
    public function index ()
    {
        $user = Auth::user();
        $nama = $user->name;
        $penghuni = Penghuni::where('id_user', $user->id)->first();

        $kamar = null;
        $tagihanSaatIni = null;
        $riwayatPembayaran = collect();
        $riwayatKeluhan = collect();

        if ($penghuni) {
            if ($penghuni->id_kamar) {
                $kamar = Kamar::where('id', $penghuni->id_kamar)->first();
            }
            $tagihanSaatIni = Tagihan::where('id_penghuni', $penghuni->id)
                        ->where('status_tagihan', 'Belum Lunas')
                        ->latest()
                        ->first();

            $riwayatPembayaran = Tagihan::where('id_penghuni', $penghuni->id)
                        ->orderBy('created_at', 'desc')
                        ->take(10)
                        ->get();

            $riwayatKeluhan = Keluhan::where('id_penghuni', $penghuni->id)
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
        }

        $waAdmin = Pengaturan::where('kunci', 'wa_admin')->first();

        return view('penghuni.dashboard', compact('tagihanSaatIni', 'nama', 'kamar', 'penghuni', 'waAdmin', 'riwayatPembayaran', 'riwayatKeluhan'));
    }

   public function submitKeluhan(Request $request)
    {
        // Validasi input form
        $request->validate([
            'isi_keluhan' => 'required|string|max:500'
        ]);

        $user = auth()->user();
        $penghuni = Penghuni::where('id_user', $user->id)->first();

        $keluhan = Keluhan::create([
            'id_penghuni' => $penghuni->id,
            'isi_keluhan' => $request->isi_keluhan,
            'status_keluhan' => 'Menunggu',
            'tanggal' => now(),
        ]);

        $pesan = "Halo Owner Dthanasha Kost, saya ingin melaporkan kendala terkait akun terkunci.\n\n";
        $pesan .= "▪️ *Nama*: {$penghuni->nama_penghuni}\n";
        $pesan .= "▪️ *ID Keluhan*: KLH-{$keluhan->id}\n\n";
        $pesan .= "*Pesan:*\n_{$request->isi_keluhan}_";

        $nomorOwner = "6281234567890"; 

        $urlWa = "https://wa.me/{$nomorOwner}?text=" . urlencode($pesan);

        return redirect()->away($urlWa);
    }
}
