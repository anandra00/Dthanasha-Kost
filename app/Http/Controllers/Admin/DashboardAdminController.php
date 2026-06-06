<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Kamar;
use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Models\Pengeluaran;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Summary cards
        $totalPenghuni = Penghuni::count();
        $totalKamar = Kamar::count();
        $kamarKosong = Kamar::where('status_kamar', 'Kosong')->count();
        $kamarTerisi = Kamar::where('status_kamar', 'Terisi')->count();

        // Keuntungan
        $totalPemasukan = Transaksi::where('status_transaksi', 'berhasil')->sum('nominal');

        $totalPengeluaran = Pengeluaran::sum('nominal');

        $keuntungan = $totalPemasukan - $totalPengeluaran;

        // Transaksi terakhir
        $transaksiTerakhir = Transaksi::with('tagihan.penghuni')->latest()->take(5)->get();

        // Penghuni lewat jatuh tempo
        $lewatJatuhTempo = Tagihan::with('penghuni')
            ->where('status_tagihan', 'Belum Lunas')
            ->where('jatuh_tempo', '<', now())
            ->latest('jatuh_tempo')
            ->take(5)
            ->get();

        // Chart data mingguan
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
                ->whereIn('status_transaksi', ['settlement', 'berhasil', 'Lunas', 'Berhasil'])
                ->whereDate('waktu', $date->toDateString())
                ->sum('nominal');
        }

        return view('admin.dashboard', compact(
            'totalPenghuni',
            'totalKamar',
            'kamarKosong',
            'kamarTerisi',
            'keuntungan',
            'transaksiTerakhir',
            'lewatJatuhTempo',
            'chartLabels',
            'chartPemasukan',
            'chartPengeluaran'
        ));
    }
}
