@extends('layouts.penghuni')

@section('title', 'Dashboard Penghuni - Dthanasha Kost')



@section('content')
    <h1 class="text-2xl font-black text-gray-900 mb-8">Selamat datang, {{ $nama }}!</h1>

    @if(auth()->user()->is_locked)
        
        <x-lock-screen />

    @else
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
                    <span class="text-sm font-black text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded">{{ $kamar?->nomor_kamar ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-zinc-50 pb-2">
                    <span class="text-sm font-medium text-zinc-500">Tipe Kamar</span>
                    <span class="text-sm font-bold text-zinc-900">{{ $kamar?->jenis_kamar ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-zinc-50 pb-2">
                    <span class="text-sm font-medium text-zinc-500">Harga/Bulan</span>
                    <span class="text-sm font-bold text-zinc-900">{{ $kamar ? 'Rp ' . number_format($kamar->harga_kamar, 0, ',', '.') : '-' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-zinc-500">Tanggal Masuk</span>
                    <span class="text-sm font-bold text-zinc-900">{{ $penghuni?->created_at?->format('d/m/Y') ?? '-' }}</span>
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

                <!-- Desktop Table -->
                <div class="hidden sm:block">
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
                            @forelse($riwayatPembayaran as $tagihan)
                                <tr class="hover:bg-zinc-50/50 transition-all">
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900">Sewa Kost {{ $tagihan->periode_bulan }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($tagihan->status_tagihan == 'Lunas')
                                            <span class="bg-green-50 text-green-600 text-[10px] font-black px-2 py-1 rounded-md border border-green-100 uppercase">Lunas</span>
                                        @else
                                            <span class="bg-amber-50 text-amber-600 text-[10px] font-black px-2 py-1 rounded-md border border-amber-100 uppercase">{{ $tagihan->status_tagihan }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-zinc-500">{{ $tagihan->tanggal_bayar ? \Carbon\Carbon::parse($tagihan->tanggal_bayar)->translatedFormat('d M Y') : '-' }}</td>
                                    <td class="px-6 py-4 text-sm font-black text-zinc-900 text-right">Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm font-medium text-zinc-400">Belum ada riwayat pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="sm:hidden divide-y divide-zinc-50">
                    @forelse($riwayatPembayaran as $tagihan)
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-1">
                                <p class="text-sm font-bold text-gray-900">Sewa Kost {{ $tagihan->periode_bulan }}</p>
                                @if($tagihan->status_tagihan == 'Lunas')
                                    <span class="bg-green-50 text-green-600 text-[9px] font-black px-2 py-0.5 rounded border border-green-100 uppercase">Lunas</span>
                                @else
                                    <span class="bg-amber-50 text-amber-600 text-[9px] font-black px-2 py-0.5 rounded border border-amber-100 uppercase">{{ $tagihan->status_tagihan }}</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <p class="text-xs text-zinc-400">{{ $tagihan->tanggal_bayar ? \Carbon\Carbon::parse($tagihan->tanggal_bayar)->translatedFormat('d M Y') : '-' }}</p>
                                <p class="text-sm font-black text-zinc-900">Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-sm text-zinc-400">Belum ada riwayat.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Aksi Cepat & Keluhan -->
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
                @if($tagihanSaatIni)
                    <div class="group relative bg-zinc-100 border border-zinc-200 p-5 rounded-2xl flex items-center justify-between cursor-not-allowed opacity-60">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-zinc-400 border border-zinc-200">
                                <i class="ph ph-lock text-xl"></i>
                            </div>
                            <span class="text-zinc-400 font-bold text-sm">Lapor Keluhan</span>
                        </div>
                        <i class="ph ph-caret-right text-zinc-300"></i>
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-zinc-900 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                            Lunasi tagihan dulu ya 😊
                        </div>
                    </div>
                @else
                    <button type="button" onclick="document.getElementById('modalKeluhan').classList.remove('hidden')" class="w-full group bg-white border border-zinc-200 hover:bg-zinc-50 p-5 rounded-2xl transition-all shadow-sm active:scale-95 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-zinc-50 border border-zinc-200 rounded-xl flex items-center justify-center group-hover:bg-white transition-colors">
                                <i class="ph ph-whatsapp-logo text-xl text-zinc-700 group-hover:text-zinc-900 transition-colors"></i>
                            </div>
                            <span class="text-zinc-700 font-bold text-sm group-hover:text-zinc-900 transition-colors">Hubungi Owner</span>
                        </div>
                        <i class="ph ph-caret-right text-zinc-300 group-hover:text-zinc-500 transition-colors"></i>
                    </button>
                @endif
            </div>

            <!-- Riwayat Keluhan -->
            <div class="bg-white p-6 rounded-3xl card-shadow border border-gray-50 flex flex-col gap-4">
                <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">Status Keluhan Saya</h3>
                <div class="space-y-3">
                    @forelse($riwayatKeluhan as $keluhan)
                        <div class="p-4 border border-zinc-100 rounded-2xl bg-zinc-50/50 hover:bg-white transition-all">
                            <p class="text-xs text-zinc-700 font-semibold mb-3 leading-relaxed">
                                "{{ Str::limit($keluhan->isi_keluhan, 100) }}"
                            </p>
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="text-zinc-400 font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($keluhan->tanggal)->translatedFormat('d M Y') }}</span>
                                @if($keluhan->status_keluhan == 'Menunggu')
                                    <span class="bg-amber-50 text-amber-700 font-bold px-2 py-0.5 rounded border border-amber-200">Menunggu</span>
                                @elseif($keluhan->status_keluhan == 'Diproses')
                                    <span class="bg-sky-50 text-sky-700 font-bold px-2 py-0.5 rounded border border-sky-200">Diproses</span>
                                @else
                                    <span class="bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 rounded border border-emerald-200">Selesai</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-xs text-zinc-400 font-medium">Belum ada laporan keluhan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @if($errors->any())
        <div class="fixed top-4 right-4 z-[110] bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl shadow-lg">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline text-sm">{{ $errors->first() }}</span>
        </div>
    @endif

    @if(is_null(auth()->user()->email))
        
        <div class="fixed inset-0 bg-black/80 backdrop-blur-md z-[100] flex items-center justify-center">
            <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-100 transition-all mx-4">
                <div class="w-16 h-16 bg-zinc-100 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-zinc-200 shadow-inner">
                    <i class="ph ph-envelope-simple-open text-3xl text-zinc-900 font-bold"></i>
                </div>
                <h2 class="text-xl font-black text-gray-900 mb-2 text-center uppercase tracking-wide">Satu Langkah Lagi!</h2>
                <p class="text-[13px] text-zinc-500 font-medium text-center mb-8 leading-relaxed">
                    Untuk keamanan akun dan menerima notifikasi tagihan kos, wajib menghubungkan akun ini dengan email yang aktif.
                </p>
                <form action="{{ route('penghuni.submit-email') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Alamat Email</label>
                        <input type="email" name="email" placeholder="contoh@email.com" class="w-full px-4 py-3.5 rounded-xl bg-zinc-50 border border-zinc-200 focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#18181B] transition-all text-sm font-bold text-zinc-900" required>
                    </div>
                    <div class="flex flex-col gap-3 pt-2">
                        <button type="submit" class="w-full px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide flex justify-center items-center gap-2">
                            <span>Kirim Kode OTP</span>
                        </button>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-modal').submit();" class="w-full text-center px-4 py-3.5 rounded-xl bg-white border border-zinc-200 text-zinc-600 font-bold hover:bg-zinc-50 transition-all text-sm uppercase tracking-wide">
                            Kembali ke Login
                        </a>
                    </div>
                </form>
            </div>
        </div>

    @elseif(is_null(auth()->user()->email_verified_at))

        <div class="fixed inset-0 bg-black/80 backdrop-blur-md z-[100] flex items-center justify-center">
            <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-100 transition-all mx-4">
                <div class="w-16 h-16 bg-zinc-100 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-zinc-200 shadow-inner">
                    <i class="ph ph-shield-check text-3xl text-zinc-900 font-bold"></i>
                </div>
                <h2 class="text-xl font-black text-gray-900 mb-2 text-center uppercase tracking-wide">Verifikasi Email</h2>
                <p class="text-[13px] text-zinc-500 font-medium text-center mb-8 leading-relaxed">
                    Kode 6 digit telah dikirim ke <span class="font-bold text-zinc-900">{{ auth()->user()->email }}</span>. Masukkan kode di bawah ini.
                </p>
                <form action="{{ route('penghuni.verify-otp') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <input type="text" name="otp" maxlength="6" placeholder="• • • • • •" class="w-full text-center tracking-[1em] font-black text-2xl px-4 py-4 rounded-xl bg-zinc-50 border border-zinc-200 focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#18181B] transition-all text-zinc-900" required autocomplete="off">
                    </div>
                    <div class="flex flex-col gap-3 pt-2">
                        <button type="submit" class="w-full px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide flex justify-center items-center gap-2">
                            <span>Verifikasi Sekarang</span>
                        </button>
                        <button type="button" onclick="document.getElementById('reset-email-form').submit();" class="w-full text-center px-4 py-3.5 rounded-xl bg-white border border-zinc-200 text-zinc-600 font-bold hover:bg-zinc-50 transition-all text-[11px] uppercase tracking-widest">
                            Salah Email? Ganti Email
                        </button>
                    </div>
                </form>
                
                <form id="reset-email-form" action="{{ route('penghuni.reset-email') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>

    @endif

    <form id="logout-form-modal" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
    @endif
    <x-modal-keluhan />
@endsection