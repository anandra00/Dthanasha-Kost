<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Kamar;
use App\Models\User;
use App\Models\WaitingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenghuniController extends Controller
{
    // 1. Menampilkan Halaman Data Penghuni
    public function index()
    {
        $penghunis = Penghuni::with(['kamar', 'user'])->latest()->paginate(5);
        $semuaKamar = Kamar::all();

        $totalPria = Penghuni::where('jenis_kelamin', 'L')->count();
        $totalWanita = Penghuni::where('jenis_kelamin', 'P')->count();

        $waitingList = WaitingList::orderBy('created_at', 'desc')->get();

        return view('admin.data_penghuni', compact('penghunis', 'semuaKamar', 'totalPria', 'totalWanita', 'waitingList'));
    }

    public function store(Request $request)
    {
        $akunLama = User::where('username', $request->nama_akun)->first();
        
        if ($akunLama) {
            // Cek apakah akun ini masih tersambung dengan penghuni yang aktif
            $masihDipakai = Penghuni::where('id', $akunLama->id)->exists();
            
            if (!$masihDipakai) {
                $akunLama->delete();
            }
        }
        // ----------------------------------------------

        $request->validate([
            'nama'  => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'usia' => 'required|integer',
            'jk' => 'required|string',
            'kontak' => ['nullable','string', 'max:20', 'regex:/^628[0-9]{7,12}$/'],
            'kontak_ortu' => ['nullable','string', 'max:20', 'regex:/^628[0-9]{7,12}$/'],
            'nama_akun' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'username' => $request->nama_akun,
            'password' => Hash::make($request->password),
            'role' => 'penghuni',
        ]);

        Penghuni::create([
            'nama_penghuni' => $request->nama,
            'usia' => $request->usia,
            'jenis_kelamin' => $request->jk,
            'no_telepon' => $request->kontak,
            'no_telepon_orangtua' => $request->kontak_ortu,
            'id_user' => $user->id, // Sambungkan ke akun yang baru dibuat
        ]);

        if ($request->filled('waiting_list_id')) {
            WaitingList::where('id', $request->waiting_list_id)->delete();
        }

        return redirect()->back()->with('success', 'Akun penghuni baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'kamar_id' => 'nullable|exists:kamar,id',
            'usia' => 'nullable|integer|min:0',
            'jk' => 'nullable|string|in:L,P',
            'kontak' => ['nullable','string', 'max:20', 'regex:/^628[0-9]{7,12}$/'],
            'kontak_ortu' => ['nullable','string', 'max:20', 'regex:/^628[0-9]{7,12}$/'],
            'email' => 'nullable|email' . ($penghuni->id_user ? '|unique:users,email,' . $penghuni->id_user : '|unique:users,email'),
        ], [
            'nama.required'   => 'Nama penghuni tidak boleh kosong.',
            'nama.max'        => 'Nama penghuni terlalu panjang (maksimal 255 karakter).',
            
            'kamar_id.exists' => 'Pilihan kamar tidak ditemukan di dalam sistem.',
            
            'usia.min'        => 'Usia tidak valid (tidak boleh angka minus).',
            
            'jk.in'           => 'Pilihan jenis kelamin tidak valid.',
            
            'kontak.regex'    => 'Nomor WA penghuni harus diawali 628 dan berisi 10-15 digit angka.',
            'kontak.max'      => 'Nomor WA penghuni terlalu panjang.',
            
            'kontak_ortu.regex' => 'Nomor WA orang tua harus diawali 628 dan berisi 10-15 digit angka.',
            'kontak_ortu.max'   => 'Nomor WA orang tua terlalu panjang.',
            
            'email.email'     => 'Format email tidak valid (pastikan menggunakan tanda @ dan domain yang benar).',
            'email.unique'    => 'Email ini sudah digunakan oleh pengguna lain.',
        ]);

        $kamarLamaId = $penghuni->id_kamar;
        $kamarBaruId = $request->kamar_id ?: null;

        if ($kamarLamaId != $kamarBaruId) {
            if ($kamarLamaId) {
                Kamar::where('id', $kamarLamaId)->update(['status_kamar' => 'Kosong']);
            }
            // Isi kamar baru
            if ($kamarBaruId) {
                Kamar::where('id', $kamarBaruId)->update(['status_kamar' => 'Terisi']);
            }
        }

        $penghuni->update([
            'nama_penghuni' => $request->nama,
            'id_kamar' => $kamarBaruId,
            'jenis_kelamin' => $request->jk ?? $penghuni->jenis_kelamin,
            'usia' => $request->usia ?? $penghuni->usia,
            'no_telepon' => $request->kontak ?? $penghuni->no_telepon,
            'no_telepon_orangtua' => $request->kontak_ortu ?? $penghuni->no_telepon_orangtua,
        ]);

        if ($request->filled('email') && $penghuni->id_user) {
            $user = User::find($penghuni->id_user);
            if ($user) {
                $user->update(['email' => $request->email]);
            }
        }

        return redirect()->back()->with('success', 'Data penghuni dan status kamar berhasil diupdate!');
    }

    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);

        if ($penghuni->id_kamar) {
            Kamar::where('id', $penghuni->id_kamar)->update(['status_kamar' => 'Kosong']);
        }

        $userId = $penghuni->id_user;
        $namaPenghuni = $penghuni->nama_penghuni;
        
        $penghuni->delete();

        if ($userId) {
            User::where('id', $userId)->delete();
        } else {
            User::where('name', $namaPenghuni)->delete();
        }

        return redirect()->back()->with('success', 'Data penghuni dan akun loginnya berhasil dihapus permanen!');
    }
}