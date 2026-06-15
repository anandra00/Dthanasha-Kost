@extends('layouts.admin')

@section('title', 'Dashboard Pemilik - Dthanasha Kost')
@section('search_placeholder', 'Cari data...')

@section('extra_head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 mb-8 sm:mb-10">
        <div class="bg-white p-4 rounded-xl card-shadow border border-zinc-100 group hover:border-zinc-200 transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-zinc-50 rounded-lg flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-100 transition-colors">
                    <i class="ph ph-users text-lg text-zinc-900 font-bold"></i>
                </div>
            </div>
            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5">Total Penghuni</p>
            <p class="text-2xl font-black text-zinc-900">{{ $totalPenghuni }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl card-shadow border border-zinc-100 group hover:border-zinc-200 transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-zinc-50 rounded-lg flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-100 transition-colors">
                    <i class="ph ph-door text-lg text-zinc-900"></i>
                </div>
            </div>
            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5">Total Kamar</p>
            <p class="text-2xl font-black text-zinc-900">{{ $totalKamar }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl card-shadow border border-zinc-100 group hover:border-zinc-200 transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-zinc-50 rounded-lg flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-100 transition-colors">
                    <i class="ph ph-door-open text-lg text-zinc-900"></i>
                </div>
            </div>
            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5">Kamar Kosong</p>
            <p class="text-2xl font-black text-zinc-900">{{ $kamarKosong }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl card-shadow border border-zinc-100 group hover:border-zinc-200 transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-zinc-50 rounded-lg flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-100 transition-colors">
                    <i class="ph ph-wallet text-lg text-zinc-900"></i>
                </div>
            </div>
            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5">Keuntungan</p>
            <p class="text-lg sm:text-xl font-black text-green-600 truncate">Rp {{ number_format($keuntungan, 0, ',', '.') }}</p>
        </div>

        <div class="col-span-2 md:col-span-1 bg-white p-4 rounded-xl card-shadow border border-zinc-100 group hover:border-zinc-200 transition-all cursor-pointer" onclick="window.location.href='{{ route('admin.keluhan') }}'">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-amber-50 rounded-lg flex items-center justify-center border border-amber-200 group-hover:bg-amber-100 transition-colors">
                    <i class="ph ph-chat-teardrop-text text-lg text-amber-600 font-bold"></i>
                </div>
            </div>
            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5">Keluhan Aktif</p>
            <p class="text-2xl font-black text-amber-600">{{ $keluhanMenunggu }}</p>
        </div>
    </div>

    <!-- MAIN DASHBOARD CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        
        <!-- KOLOM KIRI (Chart Bar & Tabel Transaksi) -->
        <div class="lg:col-span-2 space-y-6 lg:space-y-8">
            
            <!-- Bar Chart -->
            <div class="bg-white p-5 sm:p-8 rounded-3xl card-shadow border border-gray-50">
                <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide mb-6">Pemasukan & Pengeluaran Mingguan</h3>
                <div class="h-[220px] sm:h-[280px] w-full">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <!-- Tabel Transaksi -->
            <div class="bg-white rounded-3xl card-shadow border border-gray-50 overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">Transaksi Terakhir</h3>
                    <a href="{{ route('admin.riwayat') }}" class="text-xs font-bold text-[#334155] hover:underline uppercase">Lihat Semua</a>
                </div>

                <!-- Desktop Table (Muncul di layar gede) -->
                <div class="hidden sm:block">
                    <table class="w-full text-left">
                        <thead class="bg-zinc-50 text-zinc-400 text-[10px] uppercase tracking-widest border-b border-zinc-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Keterangan</th>
                                <th class="px-6 py-4 text-center font-bold">Nama</th>
                                <th class="px-6 py-4 font-bold">Tanggal</th>
                                <th class="px-6 py-4 text-right font-bold">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-50">
                            @forelse($transaksiTerakhir as $trx)
                                <tr class="hover:bg-zinc-50/50 transition-all cursor-pointer searchable-item">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $trx->id_tagihan ? $trx->order_id : $trx->kegiatan }}</td>
                                    <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $trx->id_tagihan ? ($trx->tagihan?->penghuni?->nama_penghuni ?? '-') : ($trx->nama ?? 'Pemilik') }}</td>
                                    <td class="px-6 py-4 text-sm text-zinc-500">{{ $trx->id_tagihan ? $trx->created_at->translatedFormat('d M Y') : \Carbon\Carbon::parse($trx->waktu)->translatedFormat('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-right {{ $trx->id_tagihan ? 'text-green-600' : 'text-red-500' }}">Rp {{ number_format($trx->id_tagihan ? ($trx->tagihan?->nominal_tagihan ?? 0) : $trx->nominal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-zinc-400 font-medium">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards (Muncul di layar HP) -->
                <div class="sm:hidden divide-y divide-zinc-50">
                    @forelse($transaksiTerakhir as $trx)
                        <div class="p-4 searchable-item">
                            <div class="flex justify-between items-start mb-1">
                                <p class="text-sm font-medium text-gray-900 truncate flex-1">{{ $trx->id_tagihan ? $trx->order_id : $trx->kegiatan }}</p>
                                <p class="text-sm font-bold ml-2 {{ $trx->id_tagihan ? 'text-green-600' : 'text-red-500' }}">Rp {{ number_format($trx->id_tagihan ? ($trx->tagihan?->nominal_tagihan ?? 0) : $trx->nominal, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-xs text-gray-500">{{ $trx->id_tagihan ? ($trx->tagihan?->penghuni?->nama_penghuni ?? '-') : ($trx->nama ?? 'Pemilik') }}</p>
                                <p class="text-xs text-zinc-400">{{ $trx->id_tagihan ? $trx->created_at->translatedFormat('d M Y') : \Carbon\Carbon::parse($trx->waktu)->translatedFormat('d M Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-sm text-zinc-400">Belum ada transaksi.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN (Jatuh Tempo & Okupansi) -->
        <div class="space-y-6 lg:space-y-8">
            
            <!-- List Jatuh Tempo -->
            <div class="bg-white p-5 sm:p-6 rounded-3xl card-shadow border border-gray-50">
                <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide mb-6">Lewat Jatuh Tempo</h3>
                <div class="space-y-3">
                    @forelse($lewatJatuhTempo as $tagihan)
                        <div class="flex items-center justify-between p-3 border border-zinc-100 rounded-2xl bg-zinc-50/50 hover:bg-white transition-all searchable-item">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-zinc-200 flex items-center justify-center text-zinc-600 font-bold shrink-0">
                                    {{ strtoupper(substr($tagihan->penghuni?->nama_penghuni ?? '?', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-zinc-900 truncate">{{ $tagihan->penghuni?->nama_penghuni ?? '-' }}</p>
                                    <p class="text-[10px] font-bold text-zinc-400 uppercase">{{ $tagihan->jatuh_tempo ? \Carbon\Carbon::parse($tagihan->jatuh_tempo)->diffForHumans() : '-' }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-white border border-zinc-200 text-xs font-black text-gray-900 rounded-lg shadow-sm shrink-0 ml-2">
                                {{ $tagihan->periode_bulan }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-sm text-zinc-400 font-medium">Tidak ada yang lewat jatuh tempo 🎉</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Chart Okupansi Kamar -->
            <div class="bg-white p-5 sm:p-8 rounded-3xl card-shadow border border-gray-50 flex flex-col items-center">
                <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide mb-8 self-start">Okupansi Kamar</h3>
                <div class="relative w-32 h-32 sm:w-40 sm:h-40 mb-8">
                    <canvas id="donutChart"></canvas>
                </div>
                <div class="w-full space-y-2">
                    <div class="flex items-center justify-between px-3 py-2 bg-zinc-50 rounded-xl">
                        <span class="flex items-center gap-2 text-xs font-bold text-zinc-600 uppercase tracking-wider">
                            <div class="w-2 h-2 bg-zinc-300 rounded-sm"></div> Tersedia
                        </span>
                        <span class="text-sm font-black text-zinc-900">{{ $kamarKosong }}</span>
                    </div>
                    <div class="flex items-center justify-between px-3 py-2 bg-amber-500 rounded-xl">
                        <span class="flex items-center gap-2 text-xs font-bold text-zinc-950 uppercase tracking-wider">
                            <div class="w-2 h-2 bg-zinc-950 rounded-sm"></div> Terisi
                        </span>
                        <span class="text-sm font-black text-zinc-950">{{ $kamarTerisi }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

        // Chart data dari controller
        const chartLabels = @json($chartLabels);
        const chartPemasukan = @json($chartPemasukan);
        const chartPengeluaran = @json($chartPengeluaran);

        // Config Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [
                    { label: 'Masuk', data: chartPemasukan, backgroundColor: '#f59e0b', borderRadius: 6, barPercentage: 0.6, categoryPercentage: 0.5 },
                    { label: 'Keluar', data: chartPengeluaran, backgroundColor: '#27272a', borderRadius: 6, barPercentage: 0.6, categoryPercentage: 0.5 }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { beginAtZero: true, grid: { color: '#F1F5F9', drawBorder: false }, ticks: { display: false } }, 
                    x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }, color: '#94A3B8' } } 
                }
            }
        });

        // Config Donut Chart
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: { 
                labels: ['Tersedia', 'Terisi'], 
                datasets: [{ 
                    data: [{{ $kamarKosong }}, {{ $kamarTerisi }}], 
                    backgroundColor: ['#e4e4e7', '#f59e0b'], 
                    borderWidth: 0, 
                    hoverOffset: 10,
                    cutout: '75%'
                }] 
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                plugins: { legend: { display: false } } 
            }
        });
    </script>
@endsection