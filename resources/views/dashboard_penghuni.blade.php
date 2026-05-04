<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penghuni - Dthanasha Kost (Industrial Steel)</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #F8FAFC; 
        }
        .sidebar-link:hover { background-color: rgba(255,255,255,0.1); }
        .active-link { background-color: #334155; color: white !important; }
        .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="flex min-h-screen text-zinc-800">

    <aside class="w-64 bg-[#18181B] text-zinc-400 flex flex-col fixed h-full z-50 border-r border-zinc-800">
        <div class="p-6 border-b border-gray-800 text-center">
            <h2 class="text-white text-xl font-bold tracking-tight uppercase">DTHANASHA KOST</h2>
            <p class="text-[10px] text-zinc-500 tracking-[0.2em] mt-1 uppercase">Penghuni</p>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ url('/penghuni/dashboard') }}" class="sidebar-link active-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all">
                <i class="ph ph-squares-four text-lg"></i> Dashboard
            </a>
            <a href="{{ url('/penghuni/pembayaran') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all hover:text-white">
                <i class="ph ph-receipt text-lg text-white"></i> Pembayaran Kost
            </a>
            <a href="{{ url('/penghuni/profile') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all hover:text-white">
                <i class="ph ph-user text-lg text-white"></i> Profil Saya
            </a>
        </nav>

        <div class="p-6 border-t border-zinc-800">
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button class="flex items-center gap-3 text-sm font-medium hover:text-red-400 transition-all uppercase tracking-wider w-full">
                    <i class="ph ph-sign-out text-lg"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 ml-64 p-8">
        
        <header class="flex items-center justify-between mb-10 pb-4 border-b border-zinc-200">
            <div class="relative w-96">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 text-lg"></i>
                <input type="text" placeholder="Cari riwayat atau bantuan..." class="w-full pl-10 pr-4 py-2 bg-white border border-zinc-300 rounded-lg focus:outline-none focus:border-[#334155] focus:ring-1 focus:ring-[#334155] transition-all text-sm">
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-sm font-bold text-zinc-900 uppercase">Kamar 100</p>
                    <p class="text-xs text-zinc-500 uppercase tracking-widest">Misael Feodora</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-[#334155] flex items-center justify-center text-white font-bold border border-zinc-700">
                    MF
                </div>
            </div>
        </header>

        <h1 class="text-2xl font-black text-gray-900 mb-8">Selamat datang, Misael!</h1>
       <form action="{{ route('logout') }}" method="POST" class="inline">
    
    <!-- INI WAJIB ADA. Kalau ga ada, Laravel bakal nolak dan ngasih error 419 Page Expired -->
    @csrf

    <!-- Tombol lu di dalem sini, tambahin type="submit" -->
    <button type="submit" class="bg-[#e0e0e0] text-black font-bold text-sm py-2 px-14 rounded-md hover:bg-[#d1d1d1] active:scale-95 transition-all shadow-sm">
        Logout
    </button>

</form>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            
            <div class="bg-white p-8 rounded-3xl card-shadow border border-gray-50 flex flex-col justify-between h-72">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Status Tagihan Bulan Ini</h3>
                        <div class="flex items-center gap-2 mt-4">
                            <i class="ph ph-calendar-blank text-zinc-400"></i>
                            <p class="text-sm font-bold text-zinc-700">Periode : <span class="font-black">April 2026</span></p>
                        </div>
                        <div class="flex items-center gap-2 mt-2">
                            <i class="ph ph-clock-countdown text-zinc-400"></i>
                            <p class="text-sm font-bold text-zinc-700">Jatuh Tempo : <span class="text-red-500 font-black">10 April 2026</span></p>
                        </div>
                    </div>
                    <span class="bg-red-50 text-red-600 text-[10px] font-black px-3 py-1.5 rounded-lg border border-red-100 uppercase tracking-widest flex items-center gap-1.5">
                        <div class="w-1.5 h-1.5 bg-red-600 rounded-full"></div> Belum Lunas
                    </span>
                </div>

                <div class="mt-auto pt-6 border-t border-zinc-100">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Bayar</p>
                    <p class="text-4xl font-black text-zinc-900">Rp 1.200.000</p>
                </div>
            </div>

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
                        <span class="text-sm font-black text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded">100</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-zinc-50 pb-2">
                        <span class="text-sm font-medium text-zinc-500">Tipe Kamar</span>
                        <span class="text-sm font-bold text-zinc-900">Reguler</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-zinc-500">Tanggal Masuk</span>
                        <span class="text-sm font-bold text-zinc-900">12 Januari 2026</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
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

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-3xl card-shadow border border-gray-50 flex flex-col gap-4">
                    <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide mb-2">Aksi Cepat</h3>
                    
                    <a href="{{ url('/penghuni/pembayaran') }}" class="group bg-[#18181B] hover:bg-[#334155] p-5 rounded-2xl transition-all shadow-md active:scale-95 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-zinc-800 rounded-xl flex items-center justify-center text-white group-hover:bg-zinc-700 transition-colors">
                                <i class="ph ph-wallet text-xl"></i>
                            </div>
                            <span class="text-white font-bold text-sm">Bayar Kost</span>
                        </div>
                        <i class="ph ph-caret-right text-zinc-500"></i>
                    </a>

                    <a href="https://wa.me/6281234567890" target="_blank" class="group bg-zinc-50 hover:bg-zinc-100 border border-zinc-200 p-5 rounded-2xl transition-all active:scale-95 flex items-center justify-between">
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
    </main>
</body>
</html>