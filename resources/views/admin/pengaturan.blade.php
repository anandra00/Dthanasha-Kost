@extends('layouts.admin')

@section('title', 'Pengaturan Sistem - Dthanasha Kost')
@section('search_placeholder', 'Cari pengaturan...')

@section('content')
    <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 bg-zinc-900 rounded-xl flex items-center justify-center text-white shadow-md">
            <i class="ph ph-gear text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-gray-900 uppercase tracking-wide">Pengaturan Kost</h1>
            <p class="text-sm font-medium text-zinc-500">Atur tenggat waktu pembayaran dan kontak admin utama.</p>
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl card-shadow border border-gray-50 max-w-3xl">
        <form action="{{ route('admin.update-pengaturan') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Setting Deadline -->
            <div class="p-6 bg-zinc-50 border border-zinc-100 rounded-2xl">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-white border border-zinc-200 rounded-lg flex items-center justify-center text-zinc-600 shadow-sm mt-1">
                        <i class="ph ph-calendar-x text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-zinc-900 mb-1">Tenggat Waktu Pembayaran (Deadline)</label>
                        <p class="text-[11px] font-semibold text-zinc-500 mb-3">Tentukan tanggal jatuh tempo pembayaran kost setiap bulannya (cth: 10).</p>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-bold text-zinc-600">Tanggal</span>
                            <input type="number" value="{{ old('deadline', $pengaturan['deadline'] ?? '') }}" id="deadline" name="deadline" min="5" max="28" class="w-24 px-4 py-2.5 rounded-xl bg-white border border-zinc-300 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900 text-center shadow-sm" required>
                        </div>
                        @error('deadline')
                            <p class="text-xs font-bold text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="p-6 bg-zinc-50 border border-zinc-100 rounded-2xl">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-white border border-zinc-200 rounded-lg flex items-center justify-center text-green-600 shadow-sm mt-1">
                        <i class="ph ph-whatsapp-logo text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-zinc-900 mb-1">Nomor WhatsApp Admin</label>
                        <p class="text-[11px] font-semibold text-zinc-500 mb-3">Nomor ini akan digunakan sebagai kontak darurat dan pengirim notifikasi tagihan.</p>
                        <input type="text" value="{{ old('wa_admin', $pengaturan['wa_admin'] ?? '') }}" id="wa-admin" name="wa_admin" maxlength="15" pattern="^628[0-9]{7,12}$" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-300 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900 shadow-sm" placeholder="Awali dengan 628..." required>
                        @error('wa_admin')
                            <p class="text-xs font-bold text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="p-6 bg-zinc-50 border border-zinc-100 rounded-2xl">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-white border border-zinc-200 rounded-lg flex items-center justify-center text-blue-600 shadow-sm mt-1">
                        <i class="ph ph-envelope-simple text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-zinc-900 mb-1">Alamat Email Admin</label>
                        <p class="text-[11px] font-semibold text-zinc-500 mb-3">Email utama untuk menerima laporan sistem atau keluhan penghuni via email.</p>
                        <input type="email" value="{{ old('email_admin', $pengaturan['email_admin'] ?? '') }}" id="email-admin" name="email_admin" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-300 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900 shadow-sm" placeholder="admin@email.com" required>
                        @error('email_admin')
                            <p class="text-xs font-bold text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-zinc-100 flex justify-end">
                <button type="submit" class="px-8 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide flex items-center gap-2">
                    <i class="ph ph-floppy-disk text-lg"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection