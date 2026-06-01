<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaturan;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::pluck('nilai', 'kunci')->toArray();

        return view('admin.pengaturan', compact('pengaturan'));
    }

    public function update(Request $request)
    {   
        $request->validate([
            'deadline'    => 'required|integer|min:5|max:28',

            'wa_admin'    => ['required', 'string', 'regex:/^628[0-9]{7,12}$/'],

            'email_admin' => 'required|email:rfc,dns',
        ], [
            'deadline.min' => 'Deadline minimal tanggal 5.',
            'deadline.max' => 'Deadline maksimal tanggal 28 (menghindari bug Februari).',
            'wa_admin.regex' => 'Nomor WA harus diawali 628 dan berisi angka yang valid (10-15 digit).',
            'email_admin.email' => 'Format email tidak valid atau domain tidak ditemukan.',
        ]);

        $dataSettings = [
            'deadline'    => $request->deadline,
            'wa_admin'    => $request->wa_admin,
            'email_admin' => $request->email_admin,
        ];

        foreach ($dataSettings as $kunci => $nilai) {
            Pengaturan::updateOrCreate(
                ['kunci' => $kunci],
                [
                    'kunci' => $kunci,
                    'nilai' => $nilai,
                ]
            );
        }
        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan');
    }
}
