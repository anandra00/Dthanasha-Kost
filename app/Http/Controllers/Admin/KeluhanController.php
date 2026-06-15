<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keluhan;
use Illuminate\Http\Request;

class KeluhanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        
        $query = Keluhan::with(['penghuni.kamar'])->latest();
        
        if ($status && in_array($status, ['Menunggu', 'Diproses', 'Selesai'])) {
            $query->where('status_keluhan', $status);
        }
        
        $keluhans = $query->get();
        
        // Count for stats
        $totalKeluhan = Keluhan::count();
        $menunggu = Keluhan::where('status_keluhan', 'Menunggu')->count();
        $diproses = Keluhan::where('status_keluhan', 'Diproses')->count();
        $selesai = Keluhan::where('status_keluhan', 'Selesai')->count();
        
        return view('admin.keluhan', compact('keluhans', 'totalKeluhan', 'menunggu', 'diproses', 'selesai', 'status'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_keluhan' => 'required|in:Menunggu,Diproses,Selesai'
        ]);

        $keluhan = Keluhan::findOrFail($id);
        $keluhan->update([
            'status_keluhan' => $request->status_keluhan
        ]);

        return redirect()->back()->with('success', 'Status keluhan berhasil diperbarui');
    }
}
