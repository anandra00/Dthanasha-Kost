<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Penghuni;
use App\Models\Tagihan;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GenerateTagihanBulanan extends Command
{
    protected $signature = 'app:generate-tagihan-bulanan';

    // Deskripsi biar lu inget ini robot buat apa
    protected $description = 'Otomatis membuat tagihan baru untuk semua penghuni aktif';

    public function handle()
    {
        Log::info('Scheduler Tagihan Mulai Berjalan...');

        // Cari penghuni yang statusnya punya kamar aja (yang nggak punya kamar ga usah ditagih)
        $penghuniAktif = Penghuni::with('kamar')->whereNotNull('id_kamar')->get();
        
        // Bikin format bulan ini, misal: "May 2026"
        $periodeBulanIni = Carbon::now()->translatedFormat('F Y'); 

        $settingDeadline = Pengaturan::where('kunci', 'deadline')->first();
        $tanggalDeadline = $settingDeadline? (int) $settingDeadline->nilai : 1;

        $jumlahDitagih = 0;

        $jatuhTempo = Carbon::now()->setDay($tanggalDeadline)->endOfDay();

        foreach ($penghuniAktif as $p) {
            $tagihanSudahAda = Tagihan::where('id_penghuni', $p->id)
                                      ->where('periode_bulan', $periodeBulanIni)
                                      ->exists();

            if (!$tagihanSudahAda) {
                Tagihan::create([
                    'id_penghuni'     => $p->id,
                    'periode_bulan'   => $periodeBulanIni,
                    'status_tagihan'  => 'Belum Lunas',
                    'nominal_tagihan' => 1000000, 
                    'jatuh_tempo'     => $jatuhTempo,
                ]);
                $jumlahDitagih++;
            }
        }

        Log::info("Scheduler Selesai! Berhasil membuat $jumlahDitagih tagihan baru untuk periode $periodeBulanIni.");
        $this->info("Berhasil membuat $jumlahDitagih tagihan baru.");
    }
}