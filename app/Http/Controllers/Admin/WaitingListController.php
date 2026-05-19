<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WaitingList;

class WaitingListController extends Controller
{
    public function index()
    {
        $antrean = WaitingList::orderBy('created_at', 'desc')->paginate(5);
        
        $totalPria = WaitingList::where('jenis_kelamin', 'Pria')->count();
        $totalWanita = WaitingList::where('jenis_kelamin', 'Wanita')->count();

        return view('admin.waiting_list', compact('antrean', 'totalPria', 'totalWanita'));
    }

    public function store(Request $request)
    {
        WaitingList::create([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon' => $request->telepon,
        ]);

        return back()->with('success', 'Data antrean berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $antrean = WaitingList::findOrFail($request->id);
        $antrean->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon' => $request->telepon,
        ]);

        return back()->with('success', 'Data antrean berhasil diupdate!');
    }

    public function destroy(Request $request)
    {
        $antrean = WaitingList::findOrFail($request->id);
        $antrean->delete();

        return back()->with('success', 'Data antrean berhasil dihapus!');
    }
}