<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dthanasha Kost')</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2230%22 fill=%22%23F59E0B%22/><text y=%22.75em%22 x=%22.18em%22 font-size=%2270%22 font-weight=%22900%22 fill=%22%2309090B%22 font-family=%22Plus Jakarta Sans, sans-serif%22>D</text></svg>">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @yield('extra_head')
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        .sidebar-link:hover { background-color: rgba(255,255,255,0.1); }
        .active-link { background-color: #334155; color: white !important; }
        .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); }
        .no-scrollbar::-webkit-scrollbar { display: none; }

        /* Sidebar: hidden on mobile, visible on md+ */
        @media (max-width: 767px) {
            .sidebar-panel {
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .sidebar-panel.sidebar-open {
                transform: translateX(0);
            }
        }

        /* Overlay */
        .sidebar-overlay {
            transition: opacity 0.3s ease;
            pointer-events: none;
            opacity: 0;
        }
        .sidebar-overlay.active {
            pointer-events: auto;
            opacity: 1;
        }
    </style>
</head>
<body class="flex min-h-screen text-zinc-800">

    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 bg-black/50 backdrop-blur-sm z-40 md:hidden" onclick="toggleSidebar()"></div>

    @include('components.admin_sidebar')

    <main class="flex-1 ml-0 md:ml-64 p-4 sm:p-6 md:p-8">
        <header class="flex items-center justify-between mb-8 pb-4 border-b border-zinc-200 gap-4">
            <!-- Hamburger Button (Mobile only) -->
            <button id="hamburgerBtn" onclick="toggleSidebar()" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-zinc-200 card-shadow text-zinc-700 hover:bg-zinc-50 transition-all active:scale-95 shrink-0">
                <i class="ph ph-list text-xl"></i>
            </button>

            <div class="relative w-full max-w-md md:w-96">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-zinc-500 text-lg"></i>
                <input type="text" id="globalSearch" placeholder="@yield('search_placeholder', 'Cari data...')" class="w-full pl-10 pr-4 py-2.5 bg-white border border-zinc-200 rounded-xl focus:outline-none focus:border-[#334155] focus:ring-1 focus:ring-[#334155] transition-all text-sm card-shadow font-medium">
            </div>
            
            <div class="flex items-center gap-4 shrink-0">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-zinc-900 uppercase">Pemilik Kost</p>
                    <p class="text-xs text-zinc-500 uppercase tracking-widest">Administrator</p>
                </div>
                <div class="w-11 h-11 rounded-lg bg-[#334155] flex items-center justify-center text-white font-bold shadow-lg border border-zinc-700">PE</div>
            </div>
        </header>

        <!-- Success/Error Notifications -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-bold text-sm flex items-center gap-2">
                <i class="ph-fill ph-check-circle text-lg"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                <div class="flex items-center gap-2 mb-2 font-bold">
                    <i class="ph-fill ph-warning-circle text-lg"></i>
                    <span>Terjadi kesalahan:</span>
                </div>
                <ul class="list-disc pl-8 font-medium text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('globalSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    
                    // Filter Desktop Tables and Mobile Cards that have class .searchable-item
                    const items = document.querySelectorAll('.searchable-item');
                    items.forEach(item => {
                        const text = item.textContent.toLowerCase();
                        if (text.includes(filter) && item.getAttribute('data-hide-by-filter') !== 'true') {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // Re-numbering table rows that are visible
                    const tables = document.querySelectorAll('table tbody');
                    tables.forEach(tbody => {
                        let counter = 1;
                        const rows = tbody.querySelectorAll('tr.searchable-item');
                        rows.forEach(row => {
                            if (row.style.display !== 'none') {
                                const firstTd = row.querySelector('td:first-child');
                                if (firstTd && firstTd.children.length === 0) {
                                    const num = parseInt(firstTd.textContent.trim());
                                    if (!isNaN(num)) {
                                        firstTd.textContent = counter++;
                                    }
                                }
                            }
                        });
                    });
                });
            }
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('sidebar-open');
            overlay.classList.toggle('active');
            document.body.classList.toggle('overflow-hidden');
        }
    </script>
</body>
</html>