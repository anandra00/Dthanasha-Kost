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
        // Ambil data penghuni beserta data kamar dan usernya
        $penghunis = Penghuni::with(['kamar', 'user'])->latest()->paginate(5);
        $semuaKamar = Kamar::all();

        // Hitung total pria dan wanita untuk Summary Cards
        $totalPria = Penghuni::where('jenis_kelamin', 'L')->count();
        $totalWanita = Penghuni::where('jenis_kelamin', 'P')->count();

        // Ambil data waiting list untuk fitur import
        $waitingList = WaitingList::orderBy('created_at', 'desc')->get();

        // Kirim semua variabel ke view
        return view('admin.data_penghuni', compact('penghunis', 'semuaKamar', 'totalPria', 'totalWanita', 'waitingList'));
    }

    // 2. Fungsi Tambah Penghuni Baru
    public function store(Request $request)
    {
        // --- FITUR PINTAR: Pembersih Akun Nyangkut ---
        // Cari apakah ada akun dengan username yang sama persis di tabel users
        $akunLama = User::where('username', $request->nama_akun)->first();
        
        if ($akunLama) {
            // Cek apakah akun ini masih tersambung dengan penghuni yang aktif
            $masihDipakai = Penghuni::where('id', $akunLama->id)->exists();
            
            if (!$masihDipakai) {
                // Jika sudah tidak dipakai (penghuninya sudah pindah/dihapus), 
                // hapus akun lama ini secara otomatis agar username-nya bisa dipakai lagi.
                $akunLama->delete();
            }
        }
        // ----------------------------------------------

        $request->validate([
            'nama' => 'required|string|max:255',
            'usia' => 'required|integer',
            'jk' => 'required|string',
            'kontak' => 'required|string',
            'kontak_ortu' => 'required|string',
            'email' => 'nullable|email|unique:users,email',
            'nama_akun' => 'required|string|unique:users,username', // Pastikan tabel users ada kolom 'username'
            'password' => 'required|string|min:6',
        ]);

        // A. Buat akun login untuk penghuni
        $user = User::create([
            'name' => $request->nama,
            'username' => $request->nama_akun,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'penghuni', // Buka komen ini jika kamu punya kolom role di tabel users
        ]);

        // B. Buat data profil penghuninya
        Penghuni::create([
            'nama_penghuni' => $request->nama,
            'usia' => $request->usia,
            'jenis_kelamin' => $request->jk,
            'no_telepon' => $request->kontak,
            'no_telepon_orangtua' => $request->kontak_ortu,
            'id_user' => $user->id, // Sambungkan ke akun yang baru dibuat
        ]);

        // C. Jika berasal dari import waiting list, hapus data di waiting list
        if ($request->filled('waiting_list_id')) {
            WaitingList::where('id', $request->waiting_list_id)->delete();
        }

        return redirect()->back()->with('success', 'Akun penghuni baru berhasil ditambahkan!');
    }

    // 3. Fungsi Edit & Sinkronisasi Kamar
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kamar_id' => 'nullable|exists:kamar,id',
            'usia' => 'nullable|integer|min:1',
            'jk' => 'nullable|string|in:L,P',
            'kontak' => 'nullable|string|max:20',
            'kontak_ortu' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ]);

        $penghuni = Penghuni::findOrFail($id);
        $kamarLamaId = $penghuni->id_kamar;
        $kamarBaruId = $request->kamar_id ?: null;

        // Cek apakah kamar diubah
        if ($kamarLamaId != $kamarBaruId) {
            // Kosongkan kamar lama
            if ($kamarLamaId) {
                Kamar::where('id', $kamarLamaId)->update(['status_kamar' => 'Kosong']);
            }
            // Isi kamar baru
            if ($kamarBaruId) {
                Kamar::where('id', $kamarBaruId)->update(['status_kamar' => 'Terisi']);
            }
        }

        // Update semua field di tabel penghuni
        $penghuni->update([
            'nama_penghuni' => $request->nama,
            'id_kamar' => $kamarBaruId,
            'jenis_kelamin' => $request->jk ?? $penghuni->jenis_kelamin,
            'usia' => $request->usia ?? $penghuni->usia,
            'no_telepon' => $request->kontak ?? $penghuni->no_telepon,
            'no_telepon_orangtua' => $request->kontak_ortu ?? $penghuni->no_telepon_orangtua,
        ]);

        // Update email di tabel users jika diisi
        if ($request->filled('email') && $penghuni->id_user) {
            $user = User::find($penghuni->id_user);
            if ($user) {
                $user->update(['email' => $request->email]);
            }
        }

        return redirect()->back()->with('success', 'Data penghuni dan status kamar berhasil diupdate!');
    }

    // 4. Fungsi Hapus Data Penghuni
    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);

        // 1. Jika penghuni ini menempati kamar, ubah status kamarnya jadi Kosong dulu
        if ($penghuni->id_kamar) {
            Kamar::where('id', $penghuni->id_kamar)->update(['status_kamar' => 'Kosong']);
        }

        $userId = $penghuni->id_user;
        $namaPenghuni = $penghuni->nama_penghuni;
        
        // 2. Hapus profil penghuninya
        $penghuni->delete();

        // 3. Hapus akun login-nya dari tabel users secara permanen
        if ($userId) {
            User::where('id', $userId)->delete();
        } else {
            // FALLBACK UNTUK DATA LAMA: 
            // Jika belum ada user_id, kita cari berdasarkan namanya dan hapus
            User::where('name', $namaPenghuni)->delete();
        }

        return redirect()->back()->with('success', 'Data penghuni dan akun loginnya berhasil dihapus permanen!');
    }
}