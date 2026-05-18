<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi beserta relasi tagihan & penghuni
        $transaksis = Transaksi::with('tagihan.penghuni')->latest()->paginate(10);

        // Hitung pemasukan (hanya dari tagihan yang lunas)
        $totalPemasukan = Tagihan::where('status_tagihan', 'Lunas')->sum('nominal_tagihan');

        // Hitung pengeluaran (dari transaksi manual yang id_tagihan-nya null)
        $totalPengeluaran = Transaksi::whereNull('id_tagihan')
                            ->whereIn('status_transaksi', ['settlement', 'berhasil'])
                            ->sum('nominal');

        // Keuntungan bersih
        $keuntungan = $totalPemasukan - $totalPengeluaran;

        // Data chart mingguan - ambil transaksi 7 hari terakhir
        $chartLabels = [];
        $chartPemasukan = [];
        $chartPengeluaran = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D');

            $chartPemasukan[] = Tagihan::where('status_tagihan', 'Lunas')
                ->whereDate('tanggal_bayar', $date->toDateString())
                ->sum('nominal_tagihan');

            $chartPengeluaran[] = Transaksi::whereNull('id_tagihan')
                ->whereIn('status_transaksi', ['settlement', 'berhasil'])
                ->whereDate('waktu', $date->toDateString())
                ->sum('nominal');
        }

        return view('admin.riwayat', compact(
            'transaksis',
            'totalPemasukan',
            'totalPengeluaran',
            'keuntungan',
            'chartLabels',
            'chartPemasukan',
            'chartPengeluaran'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan'  => 'required|string|max:255',
            'nama'      => 'required|string|max:255',
            'waktu'     => 'required|date',
            'metode'    => 'required|string',
            'nominal'   => 'required|numeric|min:0',
            'status'    => 'required|string',
        ]);

        Transaksi::create([
            'order_id'          => 'MANUAL-' . time() . '-' . rand(100, 999),
            'id_tagihan'        => null,
            'tipe_pembayaran'   => $request->metode,
            'status_transaksi'  => $request->status,
            'kegiatan'          => $request->kegiatan,
            'nama'              => $request->nama,
            'waktu'             => $request->waktu,
            'nominal'           => $request->nominal,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kegiatan'  => 'required|string|max:255',
            'nama'      => 'required|string|max:255',
            'waktu'     => 'required|date',
            'metode'    => 'required|string',
            'nominal'   => 'required|numeric|min:0',
            'status'    => 'required|string',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([
            'kegiatan'          => $request->kegiatan,
            'nama'              => $request->nama,
            'waktu'             => $request->waktu,
            'nominal'           => $request->nominal,
            'tipe_pembayaran'   => $request->metode,
            'status_transaksi'  => $request->status,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil diupdate!');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}
