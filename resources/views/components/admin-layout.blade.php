<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin - Dthanasha Kost' }}</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2230%22 fill=%22%23F59E0B%22/><text y=%22.75em%22 x=%22.18em%22 font-size=%2270%22 font-weight=%22900%22 fill=%22%2309090B%22 font-family=%22Plus Jakarta Sans, sans-serif%22>D</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FAFAFA; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { background-color: rgba(245, 158, 11, 0.1); color: #f59e0b !important; }
        .active-link { background-color: #f59e0b !important; color: #09090b !important; font-weight: 800; }
        .active-link i { color: #09090b !important; }
        .card-shadow { box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.04); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="flex min-h-screen text-zinc-800">

    <aside class="w-64 bg-[#18181B] text-zinc-400 hidden md:flex flex-col fixed h-full z-50">
        <div class="p-6 border-b border-zinc-800">
            <a href="{{ route('landing') }}" class="hover:text-amber-500 transition-colors block">
                <h2 class="text-white text-xl font-bold tracking-tight uppercase">Dthanasha <span class="text-white">Kost</span></h2>
            </a>
            <p class="text-[10px] text-zinc-500 tracking-[0.2em] mt-1 uppercase">Pemilik Kost</p>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('admin.dashboard') ? 'active-link font-semibold' : 'font-medium hover:text-white' }}">
                <i class="ph ph-squares-four text-lg {{ request()->routeIs('admin.dashboard') ? 'text-white' : '' }}"></i> Dashboard
            </a>
            <a href="{{ route('admin.data-penghuni') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('admin.data-penghuni') ? 'active-link font-semibold' : 'font-medium hover:text-white' }}">
                <i class="ph ph-users text-lg {{ request()->routeIs('admin.data-penghuni') ? 'text-white' : '' }}"></i> Data Penghuni
            </a>
            <a href="{{ route('admin.waiting-list') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('admin.waiting-list') ? 'active-link font-semibold' : 'font-medium hover:text-white' }}">
                <i class="ph ph-clock text-lg {{ request()->routeIs('admin.waiting-list') ? 'text-white' : '' }}"></i> Waiting List
            </a>
            <a href="{{ route('admin.manajemen-kamar') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('admin.manajemen-kamar') ? 'active-link font-semibold' : 'font-medium hover:text-white' }}">
                <i class="ph ph-door text-lg {{ request()->routeIs('admin.manajemen-kamar') ? 'text-white' : '' }}"></i> Manajemen Kamar
            </a>
            <a href="{{ route('admin.pembayaran') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('admin.pembayaran') ? 'active-link font-semibold' : 'font-medium hover:text-white' }}">
                <i class="ph ph-receipt text-lg {{ request()->routeIs('admin.pembayaran') ? 'text-white' : '' }}"></i> Pembayaran
            </a>
            <a href="{{ route('admin.riwayat') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('admin.riwayat') ? 'active-link font-semibold' : 'font-medium hover:text-white' }}">
                <i class="ph ph-clock-counter-clockwise text-lg {{ request()->routeIs('admin.riwayat') ? 'text-white' : '' }}"></i> Riwayat
            </a>
        </nav>

        <div class="p-4 border-t border-zinc-800">
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button class="flex items-center gap-3 px-4 py-3 w-full text-left text-sm font-medium hover:text-white hover:bg-red-500/10 hover:text-red-400 transition-all uppercase tracking-wider rounded-lg">
                    <i class="ph ph-sign-out text-lg"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 min-w-0 ml-0 md:ml-64 p-4 md:p-8 w-full overflow-x-hidden">
        
        <header class="flex flex-col-reverse md:flex-row md:items-center justify-between gap-4 md:gap-0 mb-6 md:mb-10 pb-4 border-b border-zinc-200">
            
            <div class="relative w-full md:w-96">
                <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 text-lg"></i>
                <input type="text" placeholder="Cari data..." class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] bg-white card-shadow transition-all text-xs md:text-sm font-medium">
            </div>
            
            <div class="flex items-center justify-end gap-3 md:gap-4 w-full md:w-auto">
                <div class="text-right">
                    <p class="text-xs md:text-sm font-bold text-zinc-900 uppercase">Pemilik Kost</p>
                    <p class="text-[10px] md:text-xs text-zinc-500 uppercase tracking-widest">Administrator</p>
                </div>
                <div class="w-9 h-9 md:w-11 md:h-11 rounded-lg bg-[#334155] flex items-center justify-center text-white font-bold shadow-lg border border-zinc-700 text-xs md:text-base">PE</div>
            </div>

        </header>

        {{ $slot }}

    </main>

    {{ $scripts ?? '' }}

</body>
</html>