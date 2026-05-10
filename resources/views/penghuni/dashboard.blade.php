@extends('layouts.penghuni')

@section('title', 'Dashboard Penghuni - Dthanasha Kost')

@section('search_input')
<div class="relative w-96">
    <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 text-lg"></i>
    <input type="text" placeholder="Cari riwayat atau bantuan..." class="w-full pl-10 pr-4 py-2 bg-white border border-zinc-300 rounded-lg focus:outline-none focus:border-[#334155] focus:ring-1 focus:ring-[#334155] transition-all text-sm">
</div>
@endsection

@section('content')
    <h1 class="text-2xl font-black text-gray-900 mb-8">Selamat datang, {{ $nama }}!</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Card Status Tagihan -->
       <x-card-tagihan :tagihan="$tagihanSaatIni" />

        <!-- Card Informasi Hunian -->
        <div class="bg-white p-8 rounded-3xl card-shadow border border-gray-50 h-72">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-zinc-100 rounded-xl flex items-center justify-center border border-zinc-200">
                    <i class="ph ph-door text-xl text-black"></i>
                </div>
                <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">Informasi Hunian</h3>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between items-center border-b border-zinc-50 pb-2">
                    <span class="text-sm font-medium text-zinc-500">Nomor Kamar</span>
                    <span class="text-sm font-black text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded">{{ $kamar->nomor_kamar }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-zinc-50 pb-2">
                    <span class="text-sm font-medium text-zinc-500">Tipe Kamar</span>
                    <span class="text-sm font-bold text-zinc-900">{{ $kamar->jenis_kamar }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-zinc-500">Tanggal Masuk</span>
                    <span class="text-sm font-bold text-zinc-900">{{ $penghuni->created_at?->format('d/m/y') ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Tabel Riwayat Pembayaran -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl card-shadow border border-gray-50 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">Riwayat Pembayaran</h3>
                    <i class="ph ph-clock-counter-clockwise text-zinc-400 text-lg"></i>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-zinc-50 text-zinc-400 text-[10px] uppercase tracking-widest border-b border-zinc-100">
                        <tr>
                            <th class="px-6 py-4">Transaksi</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50">
                        <tr class="hover:bg-zinc-50/50 transition-all cursor-pointer">
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">Sewa Kost Maret</td>
                            <td class="px-6 py-4 text-center"><span class="bg-green-50 text-green-600 text-[10px] font-black px-2 py-1 rounded-md border border-green-100 uppercase">Berhasil</span></td>
                            <td class="px-6 py-4 text-sm text-zinc-500">12 Mar 2026</td>
                            <td class="px-6 py-4 text-sm font-black text-zinc-900 text-right">Rp 1.200.000</td>
                        </tr>
                        <tr class="hover:bg-zinc-50/50 transition-all cursor-pointer">
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">Sewa Kost Februari</td>
                            <td class="px-6 py-4 text-center"><span class="bg-green-50 text-green-600 text-[10px] font-black px-2 py-1 rounded-md border border-green-100 uppercase">Berhasil</span></td>
                            <td class="px-6 py-4 text-sm text-zinc-500">12 Feb 2026</td>
                            <td class="px-6 py-4 text-sm font-black text-zinc-900 text-right">Rp 1.200.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-3xl card-shadow border border-gray-50 flex flex-col gap-4">
                <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide mb-2">Aksi Cepat</h3>
                <a href="{{ route('penghuni.pembayaran') }}" class="group bg-[#18181B] hover:bg-[#334155] p-5 rounded-2xl transition-all shadow-md active:scale-95 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-zinc-800 rounded-xl flex items-center justify-center text-white group-hover:bg-zinc-700 transition-colors">
                            <i class="ph ph-wallet text-xl"></i>
                        </div>
                        <span class="text-white font-bold text-sm">Bayar Kost</span>
                    </div>
                    <i class="ph ph-caret-right text-zinc-500"></i>
                </a>
                <a href={{ $waAdmin? "https://wa.me/".$waAdmin->nilai : "6281384700455"}} target="_blank" class="group bg-zinc-50 hover:bg-zinc-100 border border-zinc-200 p-5 rounded-2xl transition-all active:scale-95 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-zinc-900 border border-zinc-200">
                            <i class="ph ph-chat-centered-text text-xl"></i>
                        </div>
                        <span class="text-zinc-900 font-bold text-sm">Lapor Keluhan</span>
                    </div>
                    <i class="ph ph-caret-right text-zinc-400"></i>
                </a>
            </div>
        </div>
    </div>
@endsection