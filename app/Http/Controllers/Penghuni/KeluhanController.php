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

        $pesan = "Halo Kak, saya ingin melaporkan kendala.\n\n";
        $pesan .= "▪️ *Nama*: {$penghuni->nama_penghuni}\n";
        $pesan .= "▪️ *ID Keluhan*: KLH-{$keluhan->id}\n\n";
        $pesan .= "*Pesan:*\n_{$request->isi_keluhan}_";

        $nomorOwner = Pengaturan::where('kunci', 'wa_admin')->value('nilai'); 

        $urlWa = "https://wa.me/{$nomorOwner}?text=" . urlencode($pesan);

        return redirect()->away($urlWa);
    }
}
