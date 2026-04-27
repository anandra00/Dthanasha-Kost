<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik - Dthanasha Kost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; }
        .card-bg { background-color: #F3F4F6; }
    </style>
</head>
<body class="text-gray-900 p-4 md:p-6 lg:px-10">
    <div class="max-w-6xl mx-auto">
        
        <header class="flex items-center justify-between mb-8">
            <div class="flex-1 hidden md:block"></div> 
            <div class="flex items-center justify-center gap-3 flex-1">
                <div class="w-10 h-10 rounded-full bg-[#7D5A50] flex items-center justify-center text-black font-semibold text-sm">PE</div>
                <h1 class="text-lg md:text-xl font-bold">Selamat datang pemilik</h1>
            </div>
            <div class="flex-1 flex justify-end">
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-[#E5E7EB] hover:bg-[#D1D5DB] transition text-black font-bold py-2 px-5 text-sm rounded-lg active:scale-95 shadow-sm">Log out</button>
                </form>
            </div>
        </header>

        <nav class="mx-auto card-bg rounded-full p-1.5 w-fit flex overflow-x-auto gap-1 mb-10 items-center no-scrollbar text-[13px]">
            <a href="{{ url('/dashboard') }}" class="bg-black text-white px-5 py-2 rounded-full flex items-center gap-2 shrink-0 font-semibold shadow-sm transition-transform active:scale-95">
                <i class="fas fa-home text-sm"></i> Dashboard
            </a>
            <a href="{{ url('/data_penghuni') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="fas fa-user text-sm"></i> Data Penghuni
            </a>
            <a href="{{ url('/waiting_list') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="far fa-clock text-sm"></i> Waiting List
            </a>
            <a href="{{ url('/manajemen_kamar') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="fas fa-bed text-sm"></i> Manajemen kamar
            </a>
            <a href="{{ url('/pembayaran') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="fas fa-money-bill-wave text-sm"></i> Pembayaran
            </a>
            <a href="{{ url('/riwayat') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="fas fa-history text-sm"></i> Riwayat
            </a>
        </nav>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
            <div class="card-bg rounded-2xl p-4 flex flex-col items-center justify-center gap-1.5 shadow-sm">
                <div class="bg-black text-white w-9 h-9 rounded-full flex items-center justify-center"><i class="fas fa-user text-sm"></i></div>
                <div class="text-center"><p class="text-[11px] font-bold text-gray-700">Penghuni</p><p class="text-lg font-bold">80</p></div>
            </div>
            <div class="card-bg rounded-2xl p-4 flex flex-col items-center justify-center gap-1.5 shadow-sm">
                <div class="bg-black text-white w-9 h-9 rounded-full flex items-center justify-center"><i class="fas fa-bed text-sm"></i></div>
                <div class="text-center"><p class="text-[11px] font-bold text-gray-700">Kamar</p><p class="text-lg font-bold">100</p></div>
            </div>
            <div class="card-bg rounded-2xl p-4 flex flex-col items-center justify-center gap-1.5 shadow-sm">
                <div class="bg-black text-white w-9 h-9 rounded-full flex items-center justify-center"><i class="fas fa-door-open text-sm"></i></div>
                <div class="text-center"><p class="text-[11px] font-bold text-gray-700">Kamar Tersedia</p><p class="text-lg font-bold">20</p></div>
            </div>
            <div class="card-bg rounded-2xl p-4 flex flex-col items-center justify-center gap-1.5 shadow-sm">
                <div class="bg-black text-white w-9 h-9 rounded-full flex items-center justify-center"><i class="fas fa-sack-dollar text-sm"></i></div>
                <div class="text-center"><p class="text-[11px] font-bold text-gray-700">Keuntungan</p><p class="text-lg font-bold text-green-600">1.200.000</p></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <h2 class="text-lg font-bold mb-3">Pemasukan dan Pegeluaran Mingguan</h2>
                    <div class="card-bg rounded-2xl p-5 relative w-full h-[260px] shadow-sm"><canvas id="barChart"></canvas></div>
                </div>

                <div>
                    <h2 class="text-lg font-bold mb-3">Transaksi Terakhir</h2>
                    <div class="card-bg rounded-xl overflow-hidden shadow-sm">
                        <table class="w-full text-left border-collapse">
                            <tbody>
                                <tr class="border-b border-gray-200">
                                    <td class="py-3 px-4 text-[13px] font-medium">Pembayaran bulanan kost</td>
                                    <td class="py-3 px-4 text-[13px] font-bold">Misael Feodora</td>
                                    <td class="py-3 px-4 text-[13px] font-medium text-gray-600">12 Jan 2026</td>
                                    <td class="py-3 px-4 text-[13px] font-bold text-green-600">RP 1.200.000</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="py-3 px-4 text-[13px] font-medium">Pembayaran bulanan kost</td>
                                    <td class="py-3 px-4 text-[13px] font-bold">Misael Feodora</td>
                                    <td class="py-3 px-4 text-[13px] font-medium text-gray-600">12 Jan 2026</td>
                                    <td class="py-3 px-4 text-[13px] font-bold text-green-600">RP 1.200.000</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 text-[13px] font-medium">Pembayaran bulanan kost</td>
                                    <td class="py-3 px-4 text-[13px] font-bold">Misael Feodora</td>
                                    <td class="py-3 px-4 text-[13px] font-medium text-gray-600">12 Jan 2026</td>
                                    <td class="py-3 px-4 text-[13px] font-bold text-green-600">RP 1.200.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h2 class="text-lg font-bold mb-3">Lewat Jatuh Tempo</h2>
                    <div class="card-bg rounded-2xl p-5 flex flex-col gap-4 shadow-sm">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="bg-[#1A1A1A] w-8 h-8 rounded-full flex items-center justify-center text-white"><i class="fas fa-user text-[11px]"></i></div>
                                <div><p class="text-[13px] font-bold">Michael</p><p class="text-[10px] text-gray-500">2 hari yang lalu</p></div>
                            </div>
                            <span class="font-bold text-[13px]">120</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="bg-[#1A1A1A] w-8 h-8 rounded-full flex items-center justify-center text-white"><i class="fas fa-user text-[11px]"></i></div>
                                <div><p class="text-[13px] font-bold">Michael</p><p class="text-[10px] text-gray-500">5 hari yang lalu</p></div>
                            </div>
                            <span class="font-bold text-[13px]">100</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-bold mb-3">Kamar</h2>
                    <div class="card-bg rounded-2xl p-5 flex flex-col items-center justify-center shadow-sm">
                        <div class="relative w-32 h-32 mb-5 mt-2"><canvas id="donutChart"></canvas></div>
                        <div class="w-full flex flex-col gap-3 pl-2">
                            <div class="flex items-center gap-2.5"><div class="w-3.5 h-3.5 rounded-full bg-[#C2E0FF]"></div><span class="text-[13px] font-medium">Tersedia</span></div>
                            <div class="flex items-center gap-2.5"><div class="w-3.5 h-3.5 rounded-full bg-[#1A1A1A]"></div><span class="text-[13px] font-medium">Terisi</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                datasets: [
                    { label: 'Pemasukan', data: [4500000, 3200000, 3100000, 4800000, 1500000, 3800000, 3700000], backgroundColor: '#1A1A1A', borderRadius: 6, barPercentage: 0.5, categoryPercentage: 0.4 },
                    { label: 'Pengeluaran', data: [2000000, 1000000, 2500000, 3500000, 2100000, 2300000, 3000000], backgroundColor: '#C2E0FF', borderRadius: 6, barPercentage: 0.5, categoryPercentage: 0.4 }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 6, font: { family: 'Inter', size: 11, weight: '500' } } },
                    tooltip: { callbacks: { label: function(c) { return c.dataset.label + ': ' + formatRupiah(c.parsed.y); } } }
                },
                scales: { y: { beginAtZero: true, grid: { display: false, drawBorder: false }, ticks: { display: false } }, x: { grid: { display: false, drawBorder: false }, ticks: { font: { family: 'Inter', size: 11 } } } }
            }
        });

        const donutCtx = document.getElementById('donutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: { labels: ['Tersedia', 'Terisi'], datasets: [{ data: [20, 80], backgroundColor: ['#C2E0FF', '#1A1A1A'], borderWidth: 0, hoverOffset: 3 }] },
            options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { display: false }, tooltip: { callbacks: { label: function(c) { return c.label + ': ' + c.parsed + ' Kamar'; } } } } }
        });
    </script>
</body>
</html>