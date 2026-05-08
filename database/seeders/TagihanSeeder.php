<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastiin lu udah punya data penghuni dengan ID 1 dan 2 di tabel penghuni ya!
        
        $tagihan = [
            [
                // Skenario 3: Tagihan penghuni lain (Belum Lunas)
                'id_penghuni'     => 2, 
                'periode_bulan'   => 'Mei 2026',
                'status_tagihan'  => 'Belum Lunas',
                'nominal_tagihan' => 10000,
                'tanggal_bayar'   => null,
                'jatuh_tempo'     => Carbon::create(2026, 5, 10)->toDateString(),
                'bukti_transfer'  => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]
        ];

        DB::table('tagihan')->insert($tagihan);
    }
}