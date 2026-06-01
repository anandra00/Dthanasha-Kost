<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            
            // Sesuai inputan form lu:
            $table->string('nama_kegiatan'); 
            $table->string('pihak_tujuan');
            $table->date('tanggal');
            $table->string('metode_pembayaran');
            $table->bigInteger('nominal');        

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
