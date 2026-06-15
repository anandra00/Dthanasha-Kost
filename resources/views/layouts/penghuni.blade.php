<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dthanasha Kost')</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2230%22 fill=%22%23F59E0B%22/><text y=%22.75em%22 x=%22.18em%22 font-size=%2270%22 font-weight=%22900%22 fill=%22%2309090B%22 font-family=%22Plus Jakarta Sans, sans-serif%22>D</text></svg>">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .active-link {
            background-color: #334155;
            color: white !important;
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Sidebar: hidden on mobile (<768px), visible on md+ */
        @media (max-width: 767px) {
            .sidebar-panel {
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .sidebar-panel.sidebar-open {
                transform: translateX(0);
            }
        }

        .sidebar-overlay {
            transition: opacity 0.3s ease;
            pointer-events: none;
            opacity: 0;
        }

        .sidebar-overlay.active {
            pointer-events: auto;
            opacity: 1;
        }

        @yield('extra_css')
    </style>
</head>

<body class="flex min-h-screen text-zinc-800">

    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 bg-black/50 backdrop-blur-sm z-40 md:hidden"
        onclick="toggleSidebar()"></div>

    @include('components.penghuni_sidebar')

    <main class="flex-1 ml-0 md:ml-64 p-4 sm:p-6 md:p-8">
        <!-- Header Penghuni -->
        <header class="flex items-center justify-between mb-8 md:mb-10 pb-4 border-b border-zinc-200 gap-4">
            <!-- Hamburger Button (Mobile only) -->
            <button onclick="toggleSidebar()"
                class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-zinc-200 card-shadow text-zinc-700 hover:bg-zinc-50 transition-all active:scale-95 shrink-0">
                <i class="ph ph-list text-xl"></i>
            </button>

            @hasSection('search_input')
                @yield('search_input')
            @else
                <div class="text-zinc-400 text-sm font-medium uppercase tracking-widest">
                    @yield('header_title', 'Sisi Penghuni')
                </div>
            @endif

            <div class="flex items-center gap-4 shrink-0">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-zinc-900 uppercase">Penghuni</p>
                    <p class="text-xs text-zinc-500 uppercase tracking-widest">{{ Auth::user()->name ?? '-' }}</p>
                </div>
                <div
                    class="w-10 h-10 rounded-lg bg-[#334155] flex items-center justify-center text-white font-bold border border-zinc-700">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                </div>
            </div>
        </header>

        <!-- Success/Error Notifications -->
        @if(session('success'))
            <div
                class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-bold text-sm flex items-center gap-2">
                <i class="ph-fill ph-check-circle text-lg"></i> {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('penghuniSidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.toggle('sidebar-open');
            overlay.classList.toggle('active');
            document.body.classList.toggle('overflow-hidden');
        }
    </script>
</body>

</html>