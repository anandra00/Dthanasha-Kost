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
        // Add indexes for frequently queried columns to improve performance
        Schema::table('tagihan', function (Blueprint $table) {
            // Index for querying unpaid bills by specific resident
            $table->index(['id_penghuni', 'status_tagihan']);
            // Index for dashboard chart queries and filtering
            $table->index('tanggal_bayar');
            $table->index('status_tagihan');
        });

        Schema::table('transaksi', function (Blueprint $table) {
            // Order ID is queried heavily by Midtrans Webhooks
            $table->index('order_id');
            // Transaction status is queried often for summaries
            $table->index('status_transaksi');
            $table->index('waktu'); // Custom field added in another migration
        });
        
        Schema::table('penghuni', function (Blueprint $table) {
            $table->index('id_user');
            $table->index('id_kamar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tagihan', function (Blueprint $table) {
            $table->dropIndex(['id_penghuni', 'status_tagihan']);
            $table->dropIndex(['tanggal_bayar']);
            $table->dropIndex(['status_tagihan']);
        });

        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
            $table->dropIndex(['status_transaksi']);
            $table->dropIndex(['waktu']);
        });
        
        Schema::table('penghuni', function (Blueprint $table) {
            $table->dropIndex(['id_user']);
            $table->dropIndex(['id_kamar']);
        });
    }
};
