<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::with(['penghuni.kamar'])->latest()->get();

        $sudahMembayar = Tagihan::where('status_tagihan', 'Lunas')->count();
        $menungguKonfirmasi = Tagihan::where('status_tagihan', 'Menunggu Konfirmasi')->count();
        $belumMembayar = Tagihan::where('status_tagihan', 'Belum Lunas')->count();

        return view('admin.pembayaran', compact('tagihans', 'sudahMembayar', 'menungguKonfirmasi', 'belumMembayar'));
    }

    public function konfirmasi(Request $request, $id)
    {

        $request->validate([
            'status_tagihan' => 'required|in:Belum Lunas,Menunggu Konfirmasi,Lunas'
        ]);

        $tagihan = Tagihan::findOrFail($id);

        $tagihan->update([
            'status_tagihan' => $request->status_tagihan,
        ]);

        if ($request->status_tagihan == 'Lunas') {
            Transaksi::create([
                'order_id' => 'MANUAL-' . time() . '-' . $tagihan->id,
                'id_tagihan' => $tagihan->id,
                'status_transaksi' => 'berhasil', 
            ]);
            $tagihan->update([
                'tanggal_bayar' => now(),
        ]);
        }
        return redirect()->back()->with('success', 'Status tagihan berhasil diperbarui');
    }
}