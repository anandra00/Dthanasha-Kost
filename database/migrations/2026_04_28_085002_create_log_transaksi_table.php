<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            // order_id WAJIB string karena Midtrans pake format string (misal: TRX-9921)
            $table->string('order_id');

            // Nullable karena satu transaksi nggak mungkin buat tagihan dan waiting list sekaligus
            $table->unsignedBigInteger('id_tagihan')->nullable();

            $table->string('snap_token')->nullable();
            $table->string('tipe_pembayaran')->nullable(); // Misal: 'Gopay', 'BCA VA'
            $table->string('status_transaksi'); // Misal: 'Pending', 'Settlement', 'Expire'
            $table->timestamps();

            // Relasi
            $table->foreign('id_tagihan')->references('id')->on('tagihan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
