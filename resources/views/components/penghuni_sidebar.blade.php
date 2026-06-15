<aside id="penghuniSidebar" class="sidebar-panel w-64 bg-[#18181B] text-zinc-400 flex flex-col fixed h-full z-50 border-r border-zinc-800">
    <div class="p-6 border-b border-gray-800 flex items-center justify-between">
        <div class="text-center flex-1">
            <a href="{{ route('landing') }}" class="hover:text-amber-500 transition-colors block">
                <h2 class="text-white text-xl font-bold tracking-tight uppercase">DTHANASHA KOST</h2>
            </a>
            <p class="text-[10px] text-zinc-500 tracking-[0.2em] mt-1 uppercase">Penghuni</p>
        </div>
        <!-- Close button (mobile) -->
        <button onclick="toggleSidebar()" class="md:hidden w-8 h-8 flex items-center justify-center rounded-lg hover:bg-zinc-700 text-zinc-400 hover:text-white transition-all">
            <i class="ph ph-x text-xl"></i>
        </button>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto no-scrollbar">
        <a href="{{ route('penghuni.dashboard') }}" class="sidebar-link {{ request()->routeIs('penghuni.dashboard') ? 'active-link font-semibold' : 'font-medium hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all">
            <i class="ph ph-squares-four text-lg {{ request()->routeIs('penghuni.dashboard') ? 'text-white' : '' }}"></i> Dashboard
        </a>
        <a href="{{ route('penghuni.pembayaran') }}" class="sidebar-link {{ request()->routeIs('penghuni.pembayaran') || request()->routeIs('penghuni.pembayaran-manual') ? 'active-link font-semibold' : 'font-medium hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all">
            <i class="ph ph-receipt text-lg {{ request()->routeIs('penghuni.pembayaran') || request()->routeIs('penghuni.pembayaran-manual') ? 'text-white' : '' }}"></i> Pembayaran Kost
        </a>
        <a href="{{ route('penghuni.profile') }}" class="sidebar-link {{ request()->routeIs('penghuni.profile') ? 'active-link font-semibold' : 'font-medium hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-lg text-sm transition-all">
            <i class="ph ph-user text-lg {{ request()->routeIs('penghuni.profile') ? 'text-white' : '' }}"></i> Profil Saya
        </a>
    </nav>

    <div class="p-6 border-t border-zinc-800">
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