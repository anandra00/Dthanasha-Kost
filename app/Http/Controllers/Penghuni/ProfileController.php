<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Kamar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $penghuni = Penghuni::where('id_user', $user->id)->first();
        $kamar = null;

        if ($penghuni && $penghuni->id_kamar) {
            $kamar = Kamar::find($penghuni->id_kamar);
        }

        return view('penghuni.profile_penghuni', compact('user', 'penghuni', 'kamar'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $penghuni = Penghuni::where('id_user', $user->id)->first();

        $request->validate([
            'nama'  => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'usia'       => 'required|integer|min:1',
            'kontak'      => ['required', 'string', 'regex:/^628[0-9]{7,13}$/'],
            'kontak_ortu' => ['required', 'string', 'regex:/^628[0-9]{7,13}$/'],
            'jk'         => 'required|string|in:L,P',
            'email'      => 'required|email',
        ], [
            'nama.regex'        => 'Nama hanya boleh berisi huruf dan spasi, tidak boleh ada angka atau simbol.',
            'usia.min'          => 'Usia minimal adalah 0 tahun.',
            'kontak.regex'      => 'Nomor kontak harus diawali dengan 628 dan hanya berisi angka yang valid.',
            'kontak_ortu.regex' => 'Nomor kontak orang tua harus diawali dengan 628 dan hanya berisi angka yang valid.',
        ]);

        if ($penghuni) {
            $penghuni->update([
                'nama_penghuni'       => $request->nama,
                'usia'                => $request->usia,
                'no_telepon'          => $request->kontak,
                'no_telepon_orangtua' => $request->kontak_ortu,
                'jenis_kelamin'       => $request->jk,
            ]);
        }

        $user->name = $request->nama;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diupdate!');
    }
}
