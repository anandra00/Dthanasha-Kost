<?php

namespace App\Http\Controllers\Penghuni;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Keluhan;
use App\Models\Pengaturan;

class KeluhanController extends Controller
{
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
        $pesan = "Halo Kak, saya ingin melaporkan kendala.\n\n";
        $pesan .= "▪️ *Nama*: {$penghuni->nama_penghuni}\n";
        $pesan .= "▪️ *ID Keluhan*: KLH-{$keluhan->id}\n\n";
        $pesan .= "*Pesan:*\n_{$request->isi_keluhan}_";

        $nomorOwner = Pengaturan::where('kunci', 'wa_admin')->value('nilai'); 

        // 4. Bikin URL API WhatsApp
        $urlWa = "https://wa.me/{$nomorOwner}?text=" . urlencode($pesan);

        // 5. Lempar/Redirect user ke URL WhatsApp!
        return redirect()->away($urlWa);
    }
}
