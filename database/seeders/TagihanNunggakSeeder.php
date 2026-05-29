<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tagihan; // Jangan lupa import Model lu!

class TagihanNunggakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // KACAMATA SKEPTIS: Bikin data simulasi nunggak bulan April
        Tagihan::create([
            'id_penghuni'     => 2, // Sesuai screenshot lu
            'periode_bulan'   => 'April 2026', // Sesuai screenshot lu
            
            // DIBIKIN BELUM LUNAS BIAR SKENARIO NUNGGAKNYA JALAN!
            'status_tagihan'  => 'Belum Lunas', 
            
            'nominal_tagihan' => 1200000, // Sesuai screenshot
            'tanggal_bayar'   => null, // Sengaja dikosongin karena belum bayar
            'jatuh_tempo'     => '2026-04-20', // Sesuai screenshot
            'bukti_transfer'  => null,
            'created_at'      => '2026-04-19 18:17:05', // Ngikutin screenshot lu
            'updated_at'      => now(),
        ]);
        
        $this->command->info('Berhasil menyuntikkan utang bulan April 2026 untuk penghuni ID 2!');
    }
}