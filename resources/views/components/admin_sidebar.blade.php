<aside id="adminSidebar" class="sidebar-panel w-64 bg-[#09090b] text-zinc-400 flex flex-col fixed h-full z-50 border-r border-zinc-900">
    <div class="p-6 border-b border-zinc-900 flex items-center justify-between">
        <div>
            <a href="{{ route('landing') }}" class="hover:text-amber-500 transition-colors block">
                <h2 class="text-white text-xl font-bold tracking-tight uppercase">Dthanasha <span class="text-amber-500">Kost</span></h2>
            </a>
            <p class="text-[10px] text-zinc-500 tracking-[0.2em] mt-1 uppercase">Pemilik Kost</p>
        </div>
        <!-- Tombol Close (Mobile only) -->
        <button onclick="toggleSidebar()" class="md:hidden w-8 h-8 flex items-center justify-center rounded-lg hover:bg-zinc-700 text-zinc-400 hover:text-white transition-all">
            <i class="ph ph-x text-xl"></i>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto no-scrollbar">
        <a href="{{ route('admin.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active-link font-semibold' : 'font-medium hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all">
            <i class="ph ph-squares-four text-lg {{ request()->routeIs('admin.dashboard') ? 'text-white' : '' }}"></i>
            Dashboard
        </a>
        <a href="{{ route('admin.data-penghuni') }}"
            class="sidebar-link {{ request()->routeIs('admin.data-penghuni') ? 'active-link font-semibold' : 'font-medium hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all">
            <i class="ph ph-users text-lg {{ request()->routeIs('admin.data-penghuni') ? 'text-white' : '' }}"></i> Data
            Penghuni
        </a>
        <a href="{{ route('admin.waiting-list') }}"
            class="sidebar-link {{ request()->routeIs('admin.waiting-list') ? 'active-link font-semibold' : 'font-medium hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all">
            <i class="ph ph-clock text-lg {{ request()->routeIs('admin.waiting-list') ? 'text-white' : '' }}"></i>
            Waiting List
        </a>
        <a href="{{ route('admin.manajemen-kamar') }}"
            class="sidebar-link {{ request()->routeIs('admin.manajemen-kamar') ? 'active-link font-semibold' : 'font-medium hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all">
            <i class="ph ph-door text-lg {{ request()->routeIs('admin.manajemen-kamar') ? 'text-white' : '' }}"></i>
            Manajemen Kamar
        </a>
        <a href="{{ route('admin.pembayaran') }}"
            class="sidebar-link {{ request()->routeIs('admin.pembayaran') ? 'active-link font-semibold' : 'font-medium hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all">
            <i class="ph ph-receipt text-lg {{ request()->routeIs('admin.pembayaran') ? 'text-white' : '' }}"></i>
            Pembayaran
        </a>
        <a href="{{ route('admin.riwayat') }}"
            class="sidebar-link {{ request()->routeIs('admin.riwayat') ? 'active-link font-semibold' : 'font-medium hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all">
            <i
                class="ph ph-clock-counter-clockwise text-lg {{ request()->routeIs('admin.riwayat') ? 'text-white' : '' }}"></i>
            Riwayat
        </a>

        <a href="{{ route('admin.keluhan') }}"
            class="sidebar-link {{ request()->routeIs('admin.keluhan') ? 'active-link font-semibold' : 'font-medium hover:text-white' }} flex items-center justify-between px-4 py-3 rounded-lg text-sm transition-all">
            <div class="flex items-center gap-3">
                <i class="ph ph-chat-teardrop-text text-lg {{ request()->routeIs('admin.keluhan') ? 'text-white' : '' }}"></i>
                <span>Keluhan</span>
            </div>
            @php
                $menungguCount = \App\Models\Keluhan::where('status_keluhan', 'Menunggu')->count();
            @endphp
            @if($menungguCount > 0)
                <span class="bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0">
                    {{ $menungguCount }}
                </span>
            @endif
        </a>

        <!-- MENU PENGATURAN -->
        <a href="{{ route('admin.pengaturan') }}"
            class="sidebar-link {{ request()->routeIs('admin.pengaturan') ? 'active-link font-semibold' : 'font-medium hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all mt-4 border-t border-zinc-900 pt-4">
            <i class="ph ph-gear text-lg {{ request()->routeIs('admin.pengaturan') ? 'text-white' : '' }}"></i>
            Pengaturan
        </a>
    </nav>

    <div class="p-6 border-t border-zinc-900">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    onclick="this.innerHTML='<i class=\'ph ph-spinner animate-spin text-lg\'></i> Keluar...'; this.classList.remove('hover:text-red-400'); this.disabled=true; this.form.submit();"
                    class="flex items-center gap-3 text-sm font-medium text-zinc-400 hover:text-red-400 transition-all uppercase tracking-wider w-full disabled:text-zinc-500 disabled:cursor-not-allowed">
                <i class="ph ph-sign-out text-lg"></i> Keluar
            </button>
        </form>
    </div>
</aside>