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
                'deadline' => 'required|integer',
                'wa_admin' => 'required|string',
                'email_admin' => 'required|string',
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
      return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}
