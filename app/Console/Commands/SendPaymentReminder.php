<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderPembayaranMail;
use Carbon\Carbon;

class SendPaymentReminder extends Command
{
    // Nama command yang bakal dipanggil oleh scheduler
    protected $signature = 'app:send-payment-reminder';
    protected $description = 'Kirim email reminder tagihan nunggak H-1 dan H-2 secara otomatis';

    public function handle()
    {
        $hariIni = Carbon::today();
        $h1Date = Carbon::today()->addDays(1)->toDateString();
        $h2Date = Carbon::today()->addDays(2)->toDateString();

        // KACAMATA SKEPTIS: Tarik tagihan yang Belum Lunas di dua tanggal tersebut
        // Pakai eager loading (with) ke user lewat relasi penghuni biar ga kena N+1 Query Problem!
        $tagihans = Tagihan::with('penghuni.user')
            ->where('status_tagihan', 'Belum Lunas')
            ->whereIn('jatuh_tempo', [$h1Date, $h2Date])
            ->get();

        if ($tagihans->isEmpty()) {
            $this->info('Aman jaya, gak ada tagihan yang masuk rentang H-1 atau H-2 hari ini.');
            return;
        }

        foreach ($tagihans as $tagihan) {
            $emailTarget = $tagihan->penghuni?->user?->email;

            // Validasi skeptis: Pastiin emailnya ada dan gak kosong!
            if ($emailTarget) {
                // Hitung sisa harinya secara dinamis buat ditaruh di template
                $deadline = Carbon::parse($tagihan->jatuh_tempo);
                $sisaHari = $hariIni->diffInDays($deadline);

                Mail::to($emailTarget)->send(new ReminderPembayaranMail($tagihan, $sisaHari));
                
                $this->info("Email reminder sukses dikirim ke: {$emailTarget} (H-{$sisaHari})");
            }
        }

        $this->info('Proses pengiriman email reminder selesai!');
    }
}