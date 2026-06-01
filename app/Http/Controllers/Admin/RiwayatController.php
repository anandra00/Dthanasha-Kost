<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('tagihan.penghuni')->latest()->paginate(10);

        $totalPemasukan = Transaksi::where('status_transaksi', 'berhasil')->sum('nominal');

        $totalPengeluaran = Pengeluaran::sum('nominal');

        $keuntungan = $totalPemasukan - $totalPengeluaran;

        $chartLabels = [];
        $chartPemasukan = [];
        $chartPengeluaran = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D');

            $chartPemasukan[] = Tagihan::where('status_tagihan', 'Lunas')
                ->whereDate('tanggal_bayar', $date->toDateString())
                ->sum('nominal_tagihan');

            $chartPengeluaran[] = Pengeluaran::whereDate('tanggal', $date->toDateString())
                ->sum('nominal');
        }
        $pemasukan = Transaksi::with('tagihan.penghuni')->get()->map(function ($item) {
            return (object) [
                'id'            => $item->order_id, // ID unik buat tombol hapus/edit
                'keterangan'    => 'Tagihan: ' . $item->order_id,
                'pihak'         => $item->tagihan?->penghuni?->nama_penghuni ?? '-',
                'tanggal'       => Carbon::parse($item->created_at), // Atau $item->waktu
                'metode'        => $item->tipe_pembayaran ?? '-',
                'nominal'       => $item->nominal ?? ($item->tagihan?->nominal_tagihan ?? 0),
                'status'        => $item->status_transaksi,
                'tipe'          => 'pemasukan'
            ];
        });

        $pengeluaran = Pengeluaran::get()->map(function ($item) {
            return (object) [
                'id'            => $item->id,
                'keterangan'    => $item->nama_kegiatan,
                'pihak'         => $item->pihak_tujuan,
                'tanggal'       => Carbon::parse($item->tanggal),
                'metode'        => $item->metode_pembayaran,
                'nominal'       => $item->nominal,
                'status'        => 'Berhasil',
                'tipe'          => 'pengeluaran'
            ];
        });

        $gabungan = $pemasukan->concat($pengeluaran)->sortByDesc('tanggal')->values();

        $perPage = 10;
        $currentPage = Paginator::resolveCurrentPage();
        $currentItems = $gabungan->slice(($currentPage - 1) * $perPage, $perPage);
        $riwayats = new LengthAwarePaginator($currentItems, $gabungan->count(), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
        ]);

        return view('admin.riwayat', compact(
            'riwayats', 
            'totalPemasukan',
            'totalPengeluaran',
            'keuntungan',
            'chartLabels',
            'chartPemasukan',
            'chartPengeluaran'
        ));
    }

    public function getChartData(Request $request)
    {
        $filter = $request->query('filter', 'hari'); 
        $labels = [];
        $chartPemasukan = [];
        $chartPengeluaran = [];

        if ($filter == 'hari') {
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $labels[] = $date->translatedFormat('D'); 
                
                $chartPemasukan[] = Tagihan::where('status_tagihan', 'Lunas')
                    ->whereDate('tanggal_bayar', $date->toDateString())
                    ->sum('nominal_tagihan');
                    
                $chartPengeluaran[] = Pengeluaran::whereDate('tanggal', $date->toDateString())
                    ->sum('nominal');
            }
        } elseif ($filter == 'bulan') {
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $labels[] = $month->translatedFormat('M'); // Jan, Feb, Mar...
                
                $chartPemasukan[] = Tagihan::where('status_tagihan', 'Lunas')
                    ->whereYear('tanggal_bayar', $month->year)
                    ->whereMonth('tanggal_bayar', $month->month)
                    ->sum('nominal_tagihan');
                    
                $chartPengeluaran[] = Pengeluaran::whereYear('tanggal', $month->year)
                    ->whereMonth('tanggal', $month->month)
                    ->sum('nominal');
            }
        }

        return response()->json([
            'labels' => $labels,
            'pemasukan' => $chartPemasukan,
            'pengeluaran' => $chartPengeluaran
        ]);
    }
    public function store(Request $request)
    {
        // 1. VALIDASI LAPIS BAJA
        $validated = $request->validate([
            'kegiatan'  => ['required', 'string', 'max:150'], 
            
            'nama'      => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'], 
            
            'waktu'     => ['required', 'date', 'before_or_equal:today'], 
            
            'metode'    => ['required', 'string', 'in:Cash,Transfer Bank,E-Wallet'], 
            
            'nominal'   => ['required', 'numeric', 'min:1', 'max:1000000000'], 
            
            'keterangan'=> ['nullable', 'string', 'max:500'], 
        ], [
            'nama.regex'            => 'Nama penanggung jawab hanya boleh berisi huruf!',
            'waktu.before_or_equal' => 'Tanggal pengeluaran tidak boleh lebih dari hari ini!',
            'metode.in'             => 'Metode pembayaran tidak valid/tidak dikenali sistem!',
            'nominal.min'           => 'Nominal pengeluaran tidak masuk akal (minimal Rp 500)!',
            'nominal.max'           => 'Nominal terlalu besar, batas maksimal adalah 1 Milyar.',
        ]);

        Pengeluaran::create([
            'nama_kegiatan'     => $validated['kegiatan'],
            'pihak_tujuan'      => $validated['nama'],
            'tanggal'           => $validated['waktu'],
            'metode_pembayaran' => $validated['metode'],
            'nominal'           => $validated['nominal'],
            'keterangan'        => $validated['keterangan'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil dicatat dengan aman!');
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
