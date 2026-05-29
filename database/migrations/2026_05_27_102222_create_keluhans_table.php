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
        Schema::create('keluhans', function (Blueprint $table) {
            $table->id();
            
            // KACAMATA SKEPTIS: Relasi ke tabel penghunis.
            // Pastiin tipe datanya (unsignedBigInteger) cocok sama primary key di tabel penghunis lu.
            $table->unsignedBigInteger('id_penghuni');
            
            // Buat nyimpen uneg-uneg anak kos (pake text biar muat panjang)
            $table->text('isi_keluhan');
            
            // Status buat di dasbor Bapak Kos, default-nya langsung 'Menunggu'
            $table->string('status_keluhan')->default('Menunggu');
            
            // Buat nyatet kapan dia ngirim keluhannya
            $table->timestamp('tanggal')->useCurrent();
            
            // Bawaan Laravel (created_at & updated_at)
            $table->timestamps();

            // (Opsional/Best Practice) Kalau tabel penghunis dihapus, keluhannya ikut kehapus:
            // $table->foreign('id_penghuni')->references('id')->on('penghunis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluhans');
    }
};