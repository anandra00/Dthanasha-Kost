<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::with('penghuni')->latest()->paginate(8); // Pagination responsif 8 item per halaman
        
        // Menghitung statistik untuk Summary Cards secara dinamis
        $terisi = Kamar::where('status_kamar', 'Terisi')->count();
        $kosong = Kamar::where('status_kamar', 'Kosong')->count();
        $reguler = Kamar::where('jenis_kamar', 'Reguler')->count();
        $vip = Kamar::where('jenis_kamar', 'VIP')->count();

        return view('admin.manajemen_kamar', compact('kamars', 'terisi', 'kosong', 'reguler', 'vip'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|string|max:255|unique:kamar',
            'harga_kamar' => 'required|integer',
            'jenis_kamar' => 'required|string',
            'status_kamar' => 'required|string',
        ]);

        Kamar::create($request->all());

        return redirect()->back()->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_kamar' => 'required|string|max:255|unique:kamar,nomor_kamar,'.$id,
            'harga_kamar' => 'required|integer',
            'jenis_kamar' => 'required|string',
            'status_kamar' => 'required|string',
        ]);

        $kamar = Kamar::findOrFail($id);
        $kamar->update($request->all());

        return redirect()->back()->with('success', 'Data kamar berhasil diupdate!');
    }

    public function destroy($id)
    {
        Kamar::findOrFail($id)->delete();
        
        return redirect()->back()->with('success', 'Kamar berhasil dihapus!');
    }
}