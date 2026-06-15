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
        try {
            Schema::table('tagihan', function (Blueprint $table) {
                $table->index(['id_penghuni', 'status_tagihan']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('tagihan', function (Blueprint $table) {
                $table->index('tanggal_bayar');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('tagihan', function (Blueprint $table) {
                $table->index('status_tagihan');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->index('order_id');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->index('status_transaksi');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->index('waktu');
            });
        } catch (\Exception $e) {}
        
        try {
            Schema::table('penghuni', function (Blueprint $table) {
                $table->index('id_user');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('penghuni', function (Blueprint $table) {
                $table->index('id_kamar');
            });
        } catch (\Exception $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('tagihan', function (Blueprint $table) {
                $table->dropIndex(['id_penghuni', 'status_tagihan']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('tagihan', function (Blueprint $table) {
                $table->dropIndex(['tanggal_bayar']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('tagihan', function (Blueprint $table) {
                $table->dropIndex(['status_tagihan']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->dropIndex(['order_id']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->dropIndex(['status_transaksi']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('transaksi', function (Blueprint $table) {
                $table->dropIndex(['waktu']);
            });
        } catch (\Exception $e) {}
        
        try {
            Schema::table('penghuni', function (Blueprint $table) {
                $table->dropIndex(['id_user']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('penghuni', function (Blueprint $table) {
                $table->dropIndex(['id_kamar']);
            });
        } catch (\Exception $e) {}
    }
};
