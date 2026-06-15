<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dthanasha Kost - Hunian Kost Modern, Aman, & Nyaman</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2230%22 fill=%22%23F59E0B%22/><text y=%22.75em%22 x=%22.18em%22 font-size=%2270%22 font-weight=%22900%22 fill=%22%2309090B%22 font-family=%22Plus Jakarta Sans, sans-serif%22>D</text></svg>">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <!-- Vite CSS -->
    @vite('resources/css/app.css')
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAFAFA;
        }
        .glow-effect:hover {
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.15);
        }
        .card-shadow {
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.04);
        }
        .hero-pattern {
            background-color: #09090b;
            background-image: radial-gradient(at 0% 0%, rgba(39, 39, 42, 0.3) 0, transparent 50%), 
                              radial-gradient(at 50% 0%, rgba(245, 158, 11, 0.05) 0, transparent 50%),
                              radial-gradient(at 100% 100%, rgba(24, 24, 27, 0.3) 0, transparent 50%);
        }
    </style>
</head>
<body class="text-zinc-800 antialiased">

    <!-- HEADER / NAVIGATION -->
    <header class="fixed top-0 left-0 w-full bg-zinc-950/80 backdrop-blur-md border-b border-zinc-900 z-50 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="#" class="flex items-center gap-2">
                <span class="text-white text-xl font-extrabold tracking-tight uppercase">Dthanasha <span class="text-amber-500">Kost</span></span>
            </a>
            
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-zinc-400">
                <a href="#home" class="hover:text-white transition-colors">Home</a>
                <a href="#fasilitas" class="hover:text-white transition-colors">Fasilitas</a>
                <a href="#kamar" class="hover:text-white transition-colors">Daftar Kamar</a>
                <a href="#kontak" class="hover:text-white transition-colors">Hubungi Kami</a>
            </nav>

            <div class="hidden md:flex items-center gap-4">
                @auth
                    @if(auth()->user()->role == 'owner')
                        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-zinc-950 font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md active:scale-95 flex items-center gap-2">
                            <i class="ph ph-squares-four text-base"></i>
                            <span>Dashboard Admin</span>
                        </a>
                    @else
                        <a href="{{ route('penghuni.dashboard') }}" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-zinc-950 font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md active:scale-95 flex items-center gap-2">
                            <i class="ph ph-squares-four text-base"></i>
                            <span>Dashboard Saya</span>
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-zinc-900 border border-zinc-800 hover:border-zinc-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all active:scale-95">
                        Masuk / Login
                    </a>
                @endauth
            </div>

            <!-- Hamburger Button (Mobile only) -->
            <button onclick="toggleMobileMenu()" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white hover:bg-zinc-800 transition-all active:scale-95 shrink-0">
                <i id="mobileMenuIcon" class="ph ph-list text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu Panel -->
        <div id="mobileMenu" class="hidden md:hidden bg-zinc-950 border-b border-zinc-900 px-4 pt-2 pb-6 space-y-3">
            <a href="#home" onclick="toggleMobileMenu()" class="block text-zinc-400 hover:text-white py-2 px-3 rounded-lg font-semibold text-sm">Home</a>
            <a href="#fasilitas" onclick="toggleMobileMenu()" class="block text-zinc-400 hover:text-white py-2 px-3 rounded-lg font-semibold text-sm">Fasilitas</a>
            <a href="#kamar" onclick="toggleMobileMenu()" class="block text-zinc-400 hover:text-white py-2 px-3 rounded-lg font-semibold text-sm">Daftar Kamar</a>
            <a href="#kontak" onclick="toggleMobileMenu()" class="block text-zinc-400 hover:text-white py-2 px-3 rounded-lg font-semibold text-sm">Hubungi Kami</a>
            <div class="pt-4 border-t border-zinc-900 px-3">
                @auth
                    @if(auth()->user()->role == 'owner')
                        <a href="{{ route('admin.dashboard') }}" class="w-full justify-center px-5 py-3 bg-amber-500 hover:bg-amber-600 text-zinc-950 font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md active:scale-95 flex items-center gap-2">
                            <i class="ph ph-squares-four text-base"></i>
                            <span>Dashboard Admin</span>
                        </a>
                    @else
                        <a href="{{ route('penghuni.dashboard') }}" class="w-full justify-center px-5 py-3 bg-amber-500 hover:bg-amber-600 text-zinc-950 font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md active:scale-95 flex items-center gap-2">
                            <i class="ph ph-squares-four text-base"></i>
                            <span>Dashboard Saya</span>
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="w-full block text-center px-5 py-3 bg-zinc-900 border border-zinc-800 hover:border-zinc-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all active:scale-95">
                        Masuk / Login
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section id="home" class="hero-pattern pt-36 pb-24 md:pt-48 md:pb-36 text-white overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <span class="inline-flex items-center gap-2 bg-amber-500/10 border border-amber-500/20 text-amber-500 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                        <i class="ph ph-sparkle text-sm"></i> Hunian Kost Eksklusif & Modern
                    </span>
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-black tracking-tight leading-none text-white">
                        Kost Nyaman <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600">Teknologi Pintar</span>
                    </h1>
                    <p class="text-zinc-400 text-base sm:text-lg max-w-xl mx-auto lg:mx-0 font-medium leading-relaxed">
                        Nikmati kemudahan sewa kost bulanan di Dthanasha Kost. Dilengkapi dengan pembayaran otomatis via Midtrans, laporan keluhan online, serta kamar kost berfasilitas lengkap.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
                        <a href="#kamar" class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-zinc-950 font-extrabold text-sm uppercase tracking-wider rounded-2xl transition-all shadow-lg shadow-amber-500/15 active:scale-95 text-center flex items-center justify-center gap-2">
                            <span>Cari Kamar Tersedia</span>
                            <i class="ph ph-arrow-down text-lg"></i>
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waAdmin) }}?text=Halo%20Dthanasha%20Kost,%20saya%20tertarik%20tanya%20seputar%20kamar%20kost." target="_blank" class="px-8 py-4 bg-zinc-900 border border-zinc-800 hover:border-zinc-700 text-white font-extrabold text-sm uppercase tracking-wider rounded-2xl transition-all active:scale-95 text-center flex items-center justify-center gap-2">
                            <i class="ph ph-whatsapp-logo text-xl text-green-500"></i>
                            <span>Hubungi Owner</span>
                        </a>
                    </div>
                </div>
                
                <div class="lg:col-span-5 relative flex justify-center">
                    <div class="w-full max-w-sm bg-zinc-900/60 backdrop-blur-md border border-zinc-800 rounded-[2rem] p-8 card-shadow flex flex-col gap-6 relative">
                        <div class="absolute -top-4 -right-4 w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center shadow-lg transform rotate-12">
                            <i class="ph ph-door-open text-2xl text-zinc-950 font-bold"></i>
                        </div>
                        <h3 class="text-lg font-black tracking-wide uppercase text-white">Status Kost Saat Ini</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-zinc-950/40 border border-zinc-800/80 rounded-2xl">
                                <span class="text-xs font-bold text-zinc-400 uppercase tracking-widest">Kamar Kosong</span>
                                <span class="text-xl font-black text-amber-500">{{ $kamarKosong }} Unit</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-zinc-950/40 border border-zinc-800/80 rounded-2xl">
                                <span class="text-xs font-bold text-zinc-400 uppercase tracking-widest">Kamar Terisi</span>
                                <span class="text-xl font-black text-zinc-100">{{ $kamarTerisi }} Unit</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-zinc-950/40 border border-zinc-800/80 rounded-2xl">
                                <span class="text-xs font-bold text-zinc-400 uppercase tracking-widest">Total Kamar</span>
                                <span class="text-xl font-black text-zinc-100">{{ $totalKamar }} Unit</span>
                            </div>
                        </div>
                        <div class="text-center pt-2">
                            <p class="text-[11px] font-semibold text-zinc-500 uppercase tracking-widest leading-relaxed">
                                *Data diperbarui secara real-time dari sistem manajemen kost.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AMENITIES (FASILITAS) SECTION -->
    <section id="fasilitas" class="py-20 bg-white border-y border-zinc-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Kenapa Memilih Kami?</span>
                <h2 class="text-3xl font-black text-zinc-900 mt-2 uppercase tracking-wide">Fasilitas Kost Premium</h2>
                <div class="w-16 h-1 bg-amber-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 sm:gap-8">
                <div class="bg-zinc-50 p-6 rounded-3xl border border-zinc-100 text-center flex flex-col items-center gap-4 transition-all hover:bg-white glow-effect card-shadow">
                    <div class="w-14 h-14 bg-amber-50 border border-amber-200 rounded-2xl flex items-center justify-center text-amber-600">
                        <i class="ph ph-wifi-high text-3xl font-bold"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">WiFi Cepat</h4>
                        <p class="text-[11px] text-zinc-400 font-semibold mt-1">Hingga 100 Mbps</p>
                    </div>
                </div>

                <div class="bg-zinc-50 p-6 rounded-3xl border border-zinc-100 text-center flex flex-col items-center gap-4 transition-all hover:bg-white glow-effect card-shadow">
                    <div class="w-14 h-14 bg-amber-50 border border-amber-200 rounded-2xl flex items-center justify-center text-amber-600">
                        <i class="ph ph-thermometer-cold text-3xl font-bold"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">Pendingin AC</h4>
                        <p class="text-[11px] text-zinc-400 font-semibold mt-1">Setiap Kamar</p>
                    </div>
                </div>

                <div class="bg-zinc-50 p-6 rounded-3xl border border-zinc-100 text-center flex flex-col items-center gap-4 transition-all hover:bg-white glow-effect card-shadow">
                    <div class="w-14 h-14 bg-amber-50 border border-amber-200 rounded-2xl flex items-center justify-center text-amber-600">
                        <i class="ph ph-shower text-3xl font-bold"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">Kamar Mandi</h4>
                        <p class="text-[11px] text-zinc-400 font-semibold mt-1">Kloset & Shower</p>
                    </div>
                </div>

                <div class="bg-zinc-50 p-6 rounded-3xl border border-zinc-100 text-center flex flex-col items-center gap-4 transition-all hover:bg-white glow-effect card-shadow">
                    <div class="w-14 h-14 bg-amber-50 border border-amber-200 rounded-2xl flex items-center justify-center text-amber-600">
                        <i class="ph ph-eye text-3xl font-bold"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">CCTV & Aman</h4>
                        <p class="text-[11px] text-zinc-400 font-semibold mt-1">Keamanan 24 Jam</p>
                    </div>
                </div>

                <div class="bg-zinc-50 p-6 rounded-3xl border border-zinc-100 text-center flex flex-col items-center gap-4 transition-all hover:bg-white glow-effect card-shadow">
                    <div class="w-14 h-14 bg-amber-50 border border-amber-200 rounded-2xl flex items-center justify-center text-amber-600">
                        <i class="ph ph-cooking-pot text-3xl font-bold"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">Dapur Bersama</h4>
                        <p class="text-[11px] text-zinc-400 font-semibold mt-1">Alat Masak Lengkap</p>
                    </div>
                </div>

                <div class="bg-zinc-50 p-6 rounded-3xl border border-zinc-100 text-center flex flex-col items-center gap-4 transition-all hover:bg-white glow-effect card-shadow">
                    <div class="w-14 h-14 bg-amber-50 border border-amber-200 rounded-2xl flex items-center justify-center text-amber-600">
                        <i class="ph ph-park text-3xl font-bold"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">Parkir Luas</h4>
                        <p class="text-[11px] text-zinc-400 font-semibold mt-1">Motor & Mobil Aman</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ROOMS (KATALOG KAMAR) SECTION -->
    <section id="kamar" class="py-20 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Katalog Unit</span>
                    <h2 class="text-3xl font-black text-zinc-900 mt-2 uppercase tracking-wide">Daftar Kamar Kost</h2>
                </div>
                
                <!-- Client Side Filter Controls -->
                <div class="flex flex-wrap gap-3">
                    <button onclick="filterKamar('all')" id="btn-all" class="filter-btn px-5 py-2.5 rounded-xl bg-zinc-900 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm">
                        Semua Kamar
                    </button>
                    @foreach($types as $type)
                        <button onclick="filterKamar('{{ $type }}')" id="btn-{{ str_replace(' ', '-', $type) }}" class="filter-btn px-5 py-2.5 rounded-xl bg-white hover:bg-zinc-100 border border-zinc-200 text-zinc-700 font-bold text-xs uppercase tracking-wider transition-all shadow-sm">
                            Tipe {{ $type }}
                        </button>
                    @endforeach
                    <button onclick="filterKamar('Tersedia')" id="btn-Tersedia" class="filter-btn px-5 py-2.5 rounded-xl bg-white hover:bg-zinc-100 border border-zinc-200 text-zinc-700 font-bold text-xs uppercase tracking-wider transition-all shadow-sm">
                        Hanya Tersedia
                    </button>
                </div>
            </div>

            <!-- KAMAR GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($kamars as $kamar)
                    <div class="kamar-card bg-white rounded-3xl border border-zinc-200/60 p-5 flex flex-col gap-5 card-shadow transition-all hover:-translate-y-1 hover:shadow-lg" 
                         data-type="{{ $kamar->jenis_kamar }}" 
                         data-status="{{ $kamar->status_kamar == 'Kosong' ? 'Tersedia' : 'Terisi' }}">
                        
                        <!-- Header Card -->
                        <div class="flex justify-between items-start">
                            <div class="bg-zinc-950 text-white w-14 h-14 rounded-2xl flex items-center justify-center font-bold text-xl shadow-md">
                                {{ $kamar->nomor_kamar }}
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-black uppercase tracking-widest text-zinc-500 bg-zinc-100 px-3 py-1 rounded-lg border border-zinc-200/80">
                                    {{ $kamar->jenis_kamar }}
                                </span>
                            </div>
                        </div>

                        <!-- Detil Kamar -->
                        <div class="space-y-3 py-2 border-y border-zinc-100">
                            <div class="flex justify-between items-center text-xs font-semibold">
                                <span class="text-zinc-400">Harga Sewa</span>
                                <span class="text-zinc-900 font-bold">Rp {{ number_format($kamar->harga_kamar, 0, ',', '.') }}/bulan</span>
                            </div>
                            <div class="flex justify-between items-center text-xs font-semibold">
                                <span class="text-zinc-400">Status Ketersediaan</span>
                                @if($kamar->status_kamar == 'Kosong')
                                    <span class="text-emerald-600 font-bold flex items-center gap-1">
                                        <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></div> Tersedia
                                    </span>
                                @else
                                    <span class="text-red-500 font-bold flex items-center gap-1">
                                        <div class="w-1.5 h-1.5 bg-red-400 rounded-full"></div> Terisi
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div>
                            @if($kamar->status_kamar == 'Kosong')
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waAdmin) }}?text=Halo%20Dthanasha%20Kost,%20saya%20tertarik%20untuk%20memesan%20Kamar%20No%20{{ $kamar->nomor_kamar }}%20Tipe%20{{ $kamar->jenis_kamar }}." target="_blank" class="w-full py-3.5 bg-amber-500 hover:bg-amber-600 text-zinc-950 font-bold text-xs uppercase tracking-widest rounded-xl transition-all shadow-md active:scale-95 flex items-center justify-center gap-2">
                                    <i class="ph-fill ph-check-square-offset text-base"></i> Booking Sekarang
                                </a>
                            @else
                                <button disabled class="w-full py-3.5 bg-zinc-100 border border-zinc-200 text-zinc-400 font-bold text-xs uppercase tracking-widest rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                    <i class="ph ph-x-circle text-base"></i> Unit Penuh
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-zinc-200/60 card-shadow">
                        <i class="ph ph-door-open text-5xl text-zinc-300 mb-3"></i>
                        <p class="text-zinc-500 font-bold text-sm">Belum ada unit kamar terdaftar.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FOOTER / CONTACT SECTION -->
    <footer id="kontak" class="bg-zinc-950 text-white pt-16 pb-8 border-t border-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Tentang Dthanasha -->
                <div class="space-y-4">
                    <h4 class="text-white font-extrabold text-sm uppercase tracking-wider">Dthanasha Kost</h4>
                    <p class="text-zinc-400 text-xs leading-relaxed font-medium">
                        Kost modern dengan tata kelola digital untuk kenyamanan hidup Anda. Booking, bayar tagihan, dan kelola keluhan dalam satu platform terintegrasi.
                    </p>
                </div>

                <!-- Navigasi Cepat -->
                <div class="space-y-4">
                    <h4 class="text-white font-extrabold text-sm uppercase tracking-wider">Tautan Pintar</h4>
                    <ul class="text-zinc-400 text-xs space-y-2 font-semibold">
                        <li><a href="#home" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="#fasilitas" class="hover:text-white transition-colors">Fasilitas</a></li>
                        <li><a href="#kamar" class="hover:text-white transition-colors">Daftar Kamar</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Portal Login</a></li>
                    </ul>
                </div>

                <!-- Hubungi Kami -->
                <div class="space-y-4 col-span-2">
                    <h4 class="text-white font-extrabold text-sm uppercase tracking-wider">Hubungi Kami / Booking</h4>
                    <p class="text-zinc-400 text-xs leading-relaxed font-medium mb-4">
                        Ada pertanyaan atau ingin menjadwalkan survei kamar kost? Hubungi kami langsung melalui link di bawah:
                    </p>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waAdmin) }}?text=Halo%20Dthanasha%20Kost,%20saya%20ingin%20tanya%20seputar%20kost." target="_blank" class="inline-flex items-center gap-3 px-6 py-3.5 bg-green-500 hover:bg-green-600 text-zinc-950 font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md active:scale-95">
                        <i class="ph ph-whatsapp-logo text-xl"></i>
                        <span>Chat via WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-zinc-900 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-zinc-500 text-[11px] font-semibold uppercase tracking-wider">
                    &copy; 2026 Dthanasha Kost. Hak Cipta Dilindungi.
                </p>
                <div class="flex items-center gap-2 text-[10px] font-bold text-zinc-500 uppercase">
                    <span>Powered by</span>
                    <span class="text-zinc-400">Laravel & Tailwind</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- FILTER KAMAR JAVASCRIPT -->
    <script>
        function filterKamar(criteria) {
            // Update filter buttons appearance
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => {
                btn.className = 'filter-btn px-5 py-2.5 rounded-xl bg-white hover:bg-zinc-100 border border-zinc-200 text-zinc-700 font-bold text-xs uppercase tracking-wider transition-all shadow-sm';
            });
            
            // Set active button style
            let activeId = 'btn-all';
            if (criteria !== 'all') {
                activeId = 'btn-' + criteria.replace(/ /g, '-');
            }
            const activeBtn = document.getElementById(activeId);
            if (activeBtn) {
                activeBtn.className = 'filter-btn px-5 py-2.5 rounded-xl bg-zinc-900 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm';
            }

            // Filter cards
            const cards = document.querySelectorAll('.kamar-card');
            cards.forEach(card => {
                const type = card.getAttribute('data-type');
                const status = card.getAttribute('data-status');
                
                if (criteria === 'all') {
                    card.style.display = '';
                } else if (criteria === 'Tersedia') {
                    if (status === 'Tersedia') {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                } else {
                    if (type === criteria) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const icon = document.getElementById('mobileMenuIcon');
            menu.classList.toggle('hidden');
            if (menu.classList.contains('hidden')) {
                icon.className = 'ph ph-list text-xl';
            } else {
                icon.className = 'ph ph-x text-xl';
            }
        }
    </script>
</body>
</html>
