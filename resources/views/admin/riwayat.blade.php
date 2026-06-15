@extends('layouts.admin')

@section('title', 'Riwayat Transaksi - Dthanasha Kost')
@section('search_placeholder', 'Cari riwayat transaksi...')

@section('extra_head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <!-- KARTU SUMMARY KEUANGAN -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6 mb-8 md:mb-10 w-full">
        
        <div class="bg-white p-4 md:p-6 rounded-xl md:rounded-2xl card-shadow border border-emerald-50 flex items-center justify-between group transition-all hover:border-emerald-100">
            <div class="min-w-0">
                <p class="text-[10px] md:text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5 md:mb-1">Pemasukan</p>
                <p class="text-xl md:text-3xl font-black text-emerald-600 truncate">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-emerald-50 text-emerald-600 rounded-lg md:rounded-xl flex items-center justify-center border border-emerald-100 group-hover:bg-emerald-100 transition-colors shrink-0">
                <i class="ph-fill ph-arrow-down-left text-lg md:text-2xl"></i>
            </div>
        </div>

        <div class="bg-white p-4 md:p-6 rounded-xl md:rounded-2xl card-shadow border border-red-50 flex items-center justify-between group transition-all hover:border-red-100">
            <div class="min-w-0">
                <p class="text-[10px] md:text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5 md:mb-1">Pengeluaran</p>
                <p class="text-xl md:text-3xl font-black text-red-600 truncate">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-red-50 text-red-600 rounded-lg md:rounded-xl flex items-center justify-center border border-red-100 group-hover:bg-red-100 transition-colors shrink-0">
                <i class="ph-fill ph-arrow-up-right text-lg md:text-2xl"></i>
            </div>
        </div>

        <div class="col-span-2 lg:col-span-1 bg-white p-4 md:p-6 rounded-xl md:rounded-2xl card-shadow border border-zinc-100 flex items-center justify-between group transition-all hover:border-zinc-200">
            <div class="min-w-0">
                <p class="text-[10px] md:text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5 md:mb-1">Keuntungan Bersih</p>
                <p class="text-xl md:text-3xl font-black text-zinc-900 truncate">Rp {{ number_format($keuntungan, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-zinc-100 text-[#334155] rounded-lg md:rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors shrink-0">
                <i class="ph-fill ph-wallet text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>
    
    <!-- GRAFIK MINGGUAN -->
    <div class="bg-white p-5 sm:p-8 rounded-3xl card-shadow border border-zinc-50 mb-8 sm:mb-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 sm:mb-8 gap-3">
            <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">Pemasukan & Pengeluaran Mingguan</h3>
            <div class="flex gap-4 text-xs font-bold text-zinc-500 uppercase tracking-widest">
                <span class="flex items-center gap-2"><div class="w-3 h-3 bg-emerald-600 rounded-full border border-zinc-300"></div> Pemasukan</span>
                <span class="flex items-center gap-2"><div class="w-3 h-3 bg-red-600 rounded-full border border-zinc-300"></div> Pengeluaran</span>
            </div>
        </div>
        <div class="flex justify-between items-center mb-4">
        <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">Statistik Keuangan</h3>
        
        <select id="chartFilter" onchange="updateChartData()" class="text-xs border border-zinc-200 bg-zinc-50 rounded-lg px-3 py-1.5 outline-none font-bold text-zinc-600 cursor-pointer focus:ring-2 focus:ring-[#334155] transition-all">
            <option value="hari">7 Hari Terakhir</option>
            <option value="bulan">6 Bulan Terakhir</option>
        </select>
    </div>

    <div class="h-64 w-full">
        <canvas id="barChart"></canvas>
    </div>
    </div>

    <!-- TABEL RIWAYAT TRANSAKSI -->
    <div class="bg-white rounded-3xl card-shadow border border-zinc-50 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-zinc-50 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-zinc-50/50 gap-3">
            <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">Riwayat Transaksi</h3>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <select class="text-sm border border-zinc-200 bg-white rounded-xl px-4 py-2 outline-none font-semibold text-zinc-600 cursor-pointer focus:ring-2 focus:ring-[#334155] w-full sm:w-auto">
                    <option>Semua Transaksi</option>
                    <option>Settlement</option>
                    <option>Pending</option>
                    <option>Expire</option>
                </select>
                <button onclick="bukaModalTambah()" class="bg-[#18181B] hover:bg-[#334155] text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2 shadow-md active:scale-95 w-full sm:w-auto">
                    <i class="ph ph-plus-circle text-lg"></i> Tambah Pengeluaran
                </button>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="overflow-x-auto hidden sm:block">
    <table class="w-full text-left">
        <thead class="bg-zinc-100 text-zinc-500 text-[10px] uppercase tracking-widest border-b border-zinc-200">
            <tr>
                <th class="px-6 py-4">Keterangan</th>
                <th class="px-6 py-4 text-center">Pihak Terkait</th>
                <th class="px-6 py-4 text-center">Tanggal</th>
                <th class="px-6 py-4 text-center">Metode</th>
                <th class="px-6 py-4 text-right">Nominal</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-100">
            @forelse($riwayats as $row)
                <tr class="hover:bg-zinc-50 transition-all group searchable-item">
                    <td class="px-6 py-4 text-sm font-bold text-zinc-900 group-hover:text-[#334155] transition-colors">
                        <span class="truncate block max-w-[180px]">{{ $row->keterangan }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-center text-zinc-600 font-medium">
                        {{ $row->pihak }}
                    </td>
                    <td class="px-6 py-4 text-sm text-center text-zinc-500 font-medium">
                        {{ $row->tanggal->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-zinc-100 border border-zinc-200 text-zinc-600 text-[10px] uppercase tracking-widest font-black px-3 py-1 rounded-lg">
                            {{ $row->metode }}
                        </span>
                    </td>
                    
                    <td class="px-6 py-4 text-sm font-black text-right {{ $row->tipe == 'pemasukan' ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $row->tipe == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($row->nominal, 0, ',', '.') }}
                    </td>
                    
                    <td class="px-6 py-4 text-center">
                        @if(in_array(strtolower($row->status), ['settlement', 'berhasil']))
                            <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-[10px] uppercase tracking-widest font-black px-3 py-1.5 rounded-lg">Berhasil</span>
                        @elseif(in_array(strtolower($row->status), ['pending', 'menunggu']))
                            <span class="bg-amber-50 text-amber-600 border border-amber-100 text-[10px] uppercase tracking-widest font-black px-3 py-1.5 rounded-lg">Pending</span>
                        @else
                            <span class="bg-red-50 text-red-600 border border-red-100 text-[10px] uppercase tracking-widest font-black px-3 py-1.5 rounded-lg">{{ $row->status }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <form action="{{ $row->tipe == 'pemasukan' ? url('/admin/hapus_riwayat/'.$row->id) : url('/admin/hapus_pengeluaran/'.$row->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus catatan ini?')" class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded-lg transition-colors">
                                    <i class="ph ph-trash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-sm font-bold text-zinc-400">
                        <i class="ph ph-empty text-4xl mb-2 block"></i>
                        Belum ada catatan keuangan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $riwayats->links() }}
</div>

        <!-- Mobile Cards -->
        <div class="sm:hidden flex flex-col">
            @forelse($riwayats as $row)
                <div class="p-4 border-b border-zinc-100 hover:bg-zinc-50 transition-all relative searchable-item">
                    <div class="flex justify-between items-start mb-2">
                        <!-- Info Kiri -->
                        <div class="pr-2 flex-1 min-w-0">
                            <p class="text-sm font-bold text-zinc-900 truncate">{{ $row->keterangan }}</p>
                            <p class="text-xs text-zinc-500 mt-0.5 truncate">
                                {{ $row->pihak }} 
                                @if($row->metode) • {{ $row->metode }} @endif
                            </p>
                        </div>
                        
                        <!-- Nominal & Tanggal Kanan -->
                        <div class="text-right shrink-0">
                            <p class="text-sm font-black {{ $row->tipe == 'pemasukan' ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $row->tipe == 'pemasukan' ? '+' : '-' }}Rp{{ number_format($row->nominal, 0, ',', '.') }}
                            </p>
                            <p class="text-[10px] text-zinc-400 mt-1 font-medium">
                                {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-3">
                        <!-- Status Badge -->
                        <div>
                            @if(in_array(strtolower($row->status), ['settlement', 'berhasil']))
                                <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-[9px] uppercase tracking-widest font-black px-2 py-1 rounded-md">Berhasil</span>
                            @elseif(in_array(strtolower($row->status), ['pending', 'menunggu']))
                                <span class="bg-amber-50 text-amber-600 border border-amber-100 text-[9px] uppercase tracking-widest font-black px-2 py-1 rounded-md">Pending</span>
                            @else
                                <span class="bg-red-50 text-red-600 border border-red-100 text-[9px] uppercase tracking-widest font-black px-2 py-1 rounded-md">{{ $row->status }}</span>
                            @endif
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex gap-2">
                            @if($row->tipe == 'pengeluaran')
                            <button onclick="bukaModalEdit('{{ $row->id }}', '{{ $row->order_id }}', '{{ addslashes($row->keterangan) }}', '{{ addslashes($row->pihak) }}', '{{ $row->tanggal }}', '{{ $row->metode }}', '{{ $row->nominal }}', '{{ $row->status }}')" 
                                class="text-blue-600 bg-blue-50 hover:bg-blue-100 p-1.5 rounded-lg transition-colors border border-blue-100 shadow-sm">
                                <i class="ph ph-pencil-simple text-sm"></i>
                            </button>
                            @endif
                            <form action="{{ $row->tipe == 'pemasukan' ? url('/admin/hapus_riwayat/'.$row->id) : url('/admin/hapus_pengeluaran/'.$row->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600 bg-red-50 hover:bg-red-100 p-1.5 rounded-lg transition-colors border border-red-100 shadow-sm">
                                    <i class="ph ph-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-sm font-bold text-zinc-400">
                    <i class="ph ph-empty text-3xl mb-2 block"></i>
                    Belum ada catatan keuangan.
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="p-4 sm:p-6 border-t border-zinc-100 bg-white overflow-x-auto no-scrollbar">
            {{ $riwayats->links() }}
        </div>
    </div>

    <!-- MODAL TAMBAH PENGELUARAN -->
    <div id="modalTambah" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-3xl p-6 sm:p-8 shadow-2xl scale-95 transition-all max-h-[90vh] overflow-y-auto no-scrollbar">
            <h2 class="text-lg sm:text-xl font-black text-zinc-900 mb-6 text-center uppercase tracking-wide">Catat Pengeluaran</h2>
            <form action="{{ route('admin.tambah-riwayat') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nama Kegiatan</label>
                    <input type="text" name="kegiatan" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required placeholder="Cth: Bayar Listrik, Perbaikan Atap">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Pihak Terkait / Tujuan</label>
                        <input type="text" name="nama" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required placeholder="Cth: PLN / Tukang / PDAM">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Tanggal</label>
                        <input type="date" name="waktu" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Metode Pembayaran</label>
                        <select name="metode" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                            <option value="Cash">Cash</option>
                            <option value="Transfer">Transfer</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nominal (Rp)</label>
                        <input type="number" name="nominal" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                    </div>
                </div>
                <div class="flex gap-3 pt-6 border-t border-zinc-100">
                    <button type="button" onclick="tutupModal('modalTambah')" class="flex-1 px-4 py-3.5 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase tracking-wide">Batal</button>
                    <button 
                        type="submit" 
                        onclick="if(this.form.checkValidity()){ this.innerHTML='<i class=\'ph ph-spinner animate-spin text-lg\'></i> Menyimpan...'; this.classList.remove('hover:bg-red-700', 'active:scale-95'); this.disabled=true; this.form.submit(); }" 
                        class="flex-1 px-4 py-3.5 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide flex items-center justify-center gap-2">
                        <i class="ph ph-minus-circle"></i> Catat Pengeluaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT PENGELUARAN -->
    <div id="modalEdit" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-3xl p-6 sm:p-8 shadow-2xl scale-95 transition-all max-h-[90vh] overflow-y-auto no-scrollbar">
            <h2 class="text-lg sm:text-xl font-black text-zinc-900 mb-6 text-center uppercase tracking-wide">Edit Pengeluaran</h2>
            <form id="formEditRiwayat" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Order ID</label>
                    <input type="text" id="edit_order_id" class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-100 text-sm font-bold text-zinc-500" readonly>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nama Kegiatan</label>
                    <input type="text" id="edit_kegiatan" name="kegiatan" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Pihak Terkait</label>
                        <input type="text" id="edit_nama" name="nama" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Tanggal</label>
                        <input type="date" id="edit_waktu" name="waktu" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Metode</label>
                        <select id="edit_metode" name="metode" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                            <option value="Cash">Cash</option>
                            <option value="Transfer">Transfer</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nominal (Rp)</label>
                        <input type="number" id="edit_nominal" name="nominal" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Status</label>
                    <select id="edit_status" name="status" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                        <option value="Settlement">Settlement</option>
                        <option value="Pending">Pending</option>
                        <option value="Expire">Expire</option>
                    </select>
                </div>
                <div class="flex gap-3 pt-6 border-t border-zinc-100">
                    <button type="button" onclick="tutupModal('modalEdit')" class="flex-1 px-4 py-3.5 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase tracking-wide">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide">Update Pengeluaran</button>
                </div>
            </form>
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

       let myChart; // Variabel penampung chart

        // 1. Inisialisasi awal (Pake data default dari backend biar pas pertama buka langsung ada isinya)
        const barCtx = document.getElementById('barChart').getContext('2d');
        
        myChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels), // Bawaan dari fungsi index() lu yang sekarang
                datasets: [
                    { label: 'Pemasukan', data: @json($chartPemasukan), backgroundColor: '#059669', borderRadius: 4, barPercentage: 0.6, categoryPercentage: 0.5 },
                    { label: 'Pengeluaran', data: @json($chartPengeluaran), backgroundColor: '#dc2626', borderRadius: 4, barPercentage: 0.6, categoryPercentage: 0.5 }
                ]
            },
            options: {
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { beginAtZero: true, grid: { color: '#F1F5F9', drawBorder: false }, ticks: { display: false } }, 
                    x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }, color: '#94A3B8' } } 
                }
            }
        });

        // 2. Fungsi sakti buat manggil data baru pake AJAX
        async function updateChartData() {
            const filter = document.getElementById('chartFilter').value;
            const filterElement = document.getElementById('chartFilter');
            
            // Bikin dropdown disabled bentar biar ga dispam klik
            filterElement.disabled = true;

            try {
                // Tarik data dari Route baru yang kita bikin
                const response = await fetch(`/admin/chart-data?filter=${filter}`);
                const data = await response.json();

                // Suntik data baru ke chart
                myChart.data.labels = data.labels;
                myChart.data.datasets[0].data = data.pemasukan;
                myChart.data.datasets[1].data = data.pengeluaran;
                
                // Animasiin perubahannya!
                myChart.update();
            } catch (error) {
                console.error("Gagal ngambil data chart:", error);
                alert("Gagal memuat grafik!");
            } finally {
                // Buka lagi dropdownnya
                filterElement.disabled = false;
            }
        }

        function bukaModalTambah() { document.getElementById('modalTambah').classList.remove('hidden'); }
        
        function bukaModalEdit(id, orderId, kegiatan, nama, waktu, metode, nominal, status) {
            document.getElementById('formEditRiwayat').action = '/admin/edit_riwayat/' + id;
            document.getElementById('edit_order_id').value = orderId;
            document.getElementById('edit_kegiatan').value = kegiatan;
            document.getElementById('edit_nama').value = nama;
            
            // Format waktu untuk input type="date"
            if(waktu) {
                // Ensure it's in YYYY-MM-DD format
                const d = new Date(waktu);
                if (!isNaN(d.getTime())) {
                    document.getElementById('edit_waktu').value = d.toISOString().split('T')[0];
                } else {
                    document.getElementById('edit_waktu').value = waktu.split(' ')[0];
                }
            }
            
            document.getElementById('edit_metode').value = metode;
            document.getElementById('edit_nominal').value = nominal;
            
            // Normalize status (berhasil -> Settlement, menunggu -> Pending)
            let normalizedStatus = status;
            if(status.toLowerCase() === 'berhasil') normalizedStatus = 'Settlement';
            if(status.toLowerCase() === 'menunggu') normalizedStatus = 'Pending';
            if(status.toLowerCase() === 'gagal') normalizedStatus = 'Expire';
            
            document.getElementById('edit_status').value = normalizedStatus;
            document.getElementById('modalEdit').classList.remove('hidden');
        }
        
        function tutupModal(modalId) { document.getElementById(modalId).classList.add('hidden'); }
    </script>
@endsection