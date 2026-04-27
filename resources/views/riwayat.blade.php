<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembayaran - Dthanasha Kost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; }
        .card-bg { background-color: #F3F4F6; }
        .table-bg { background-color: #EAEAEA; }
    </style>
</head>
<body class="text-gray-900 p-4 md:p-6 lg:px-10 relative">
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
            <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
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
            <a href="{{ url('/riwayat') }}" class="bg-black text-white px-5 py-2 rounded-full flex items-center gap-2 shrink-0 font-semibold shadow-sm transition-transform active:scale-95">
                <i class="fas fa-history text-sm"></i> Riwayat
            </a>
        </nav>

        <div class="flex justify-center gap-6 mb-8">
            <div class="card-bg rounded-2xl w-48 p-3 flex items-center justify-center gap-4 shadow-sm">
                <div class="bg-[#1A1A1A] w-9 h-9 rounded-full flex items-center justify-center text-white"><i class="fas fa-sack-dollar text-sm"></i></div>
                <div class="text-center"><p class="text-[9px] font-bold text-gray-700">Pemasukan</p><p class="text-[15px] font-bold text-green-500">2.700.000</p></div>
            </div>
            <div class="card-bg rounded-2xl w-48 p-3 flex items-center justify-center gap-4 shadow-sm">
                <div class="bg-[#1A1A1A] w-9 h-9 rounded-full flex items-center justify-center text-white"><i class="fas fa-sack-dollar text-sm"></i></div>
                <div class="text-center"><p class="text-[9px] font-bold text-gray-700">Pengeluaran</p><p class="text-[15px] font-bold text-red-500">1.500.000</p></div>
            </div>
            <div class="card-bg rounded-2xl w-48 p-3 flex items-center justify-center gap-4 shadow-sm">
                <div class="bg-[#1A1A1A] w-9 h-9 rounded-full flex items-center justify-center text-white"><i class="fas fa-sack-dollar text-sm"></i></div>
                <div class="text-center"><p class="text-[9px] font-bold text-gray-700">Keuntungan</p><p class="text-[15px] font-bold text-green-500">1.200.000</p></div>
            </div>
        </div>

        <h2 class="text-lg font-bold mb-3 max-w-4xl mx-auto">Pemasukan dan Pegeluaran Mingguan</h2>
        <div class="card-bg rounded-2xl p-5 relative w-full max-w-4xl mx-auto h-[260px] shadow-sm mb-10">
            <canvas id="barChart"></canvas>
        </div>

        <div class="flex items-center gap-4 mb-6">
            <div class="relative">
                <select class="card-bg px-4 py-2.5 rounded-lg text-[13px] font-semibold outline-none shadow-sm appearance-none pr-8 cursor-pointer">
                    <option>Jenis Transaksi</option>
                    <option>Pemasukan</option>
                    <option>Pengeluaran</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-sm pointer-events-none"></i>
            </div>
            <button onclick="bukaModalTambah()" class="card-bg hover:bg-gray-300 transition px-5 py-2.5 rounded-lg text-[13px] font-semibold shadow-sm flex items-center gap-2 active:scale-95">
                <i class="fas fa-plus text-lg"></i> Riwayat Pembayaran
            </button>
        </div>

        <h2 class="text-lg font-bold mb-3">Riwayat Transaksi</h2>
        <div class="overflow-x-auto rounded-md border border-gray-400 table-bg">
            <table class="w-full text-center border-collapse text-[12px] font-medium">
                <thead class="border-b border-gray-400 font-bold text-gray-700">
                    <tr>
                        <th class="py-4 px-3 border-r border-gray-400 text-left pl-4">Nama Kegiatan</th>
                        <th class="py-4 px-3 border-r border-gray-400 text-left">Nama</th>
                        <th class="py-4 px-3 border-r border-gray-400">Waktu Pelaksanaan</th>
                        <th class="py-4 px-3 border-r border-gray-400">Metode<br>Pembayaran</th>
                        <th class="py-4 px-3 border-r border-gray-400 text-left pl-4">Nominal</th>
                        <th class="py-4 px-3 border-r border-gray-400">Status</th>
                        <th class="py-4 px-3">Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-400 hover:bg-gray-300 cursor-pointer transition" onclick="bukaModalEdit('Perbaikan kamar mandi', 'Pemilik', '12 Jan 2026', 'Cash', 'RP 1.200.000', 'Berhasil', 'trx_001')">
                        <td class="py-4 px-3 border-r border-gray-400 text-left pl-4">Perbaikan kamar mandi</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-left">Pemilik</td>
                        <td class="py-4 px-3 border-r border-gray-400">12 Jan 2026</td>
                        <td class="py-4 px-3 border-r border-gray-400">Cash</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-left pl-4 text-red-500 font-bold">RP 1.200.000</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-green-600 font-bold">Berhasil</td>
                        <td class="py-4 px-3"><span class="bg-white border border-gray-400 px-3 py-1 rounded-full text-[10px] font-bold shadow-sm">Bukti</span></td>
                    </tr>
                    
                    <tr class="border-b border-gray-400 hover:bg-gray-300 cursor-pointer transition" onclick="bukaModalEdit('Pembayaran bulanan kost', 'Misael Feodora', '12 Jan 2026', 'Transfer', 'RP 1.200.000', 'Gagal', 'trx_002')">
                        <td class="py-4 px-3 border-r border-gray-400 text-left pl-4">Pembayaran bulanan kost</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-left">Misael Feodora</td>
                        <td class="py-4 px-3 border-r border-gray-400">12 Jan 2026</td>
                        <td class="py-4 px-3 border-r border-gray-400">Transfer</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-left pl-4 text-green-500 font-bold">RP 1.200.000</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-red-500 font-bold">Gagal</td>
                        <td class="py-4 px-3"><span class="bg-white border border-gray-400 px-3 py-1 rounded-full text-[10px] font-bold shadow-sm">Bukti</span></td>
                    </tr>

                    <tr class="border-b border-gray-400 hover:bg-gray-300 cursor-pointer transition" onclick="bukaModalEdit('Pembayaran Keamanan', 'Pemilik', '12 Jan 2026', 'Transfer', 'RP 1.200.000', 'Berhasil', 'trx_003')">
                        <td class="py-4 px-3 border-r border-gray-400 text-left pl-4">Pembayaran Keamanan</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-left">Pemilik</td>
                        <td class="py-4 px-3 border-r border-gray-400">12 Jan 2026</td>
                        <td class="py-4 px-3 border-r border-gray-400">Transfer</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-left pl-4 text-green-500 font-bold">RP 1.200.000</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-green-600 font-bold">Berhasil</td>
                        <td class="py-4 px-3"><span class="bg-white border border-gray-400 px-3 py-1 rounded-full text-[10px] font-bold shadow-sm">Bukti</span></td>
                    </tr>

                    <tr class="border-b border-gray-400 hover:bg-gray-300 cursor-pointer transition" onclick="bukaModalEdit('Pembayaran bulanan kost', 'Misael Feodora', '12 Jan 2026', 'Transfer', 'RP 1.200.000', 'Berhasil', 'trx_004')">
                        <td class="py-4 px-3 border-r border-gray-400 text-left pl-4">Pembayaran bulanan kost</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-left">Misael Feodora</td>
                        <td class="py-4 px-3 border-r border-gray-400">12 Jan 2026</td>
                        <td class="py-4 px-3 border-r border-gray-400">Transfer</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-left pl-4 text-green-500 font-bold">RP 1.200.000</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-green-600 font-bold">Berhasil</td>
                        <td class="py-4 px-3"><span class="bg-white border border-gray-400 px-3 py-1 rounded-full text-[10px] font-bold shadow-sm">Bukti</span></td>
                    </tr>

                    <tr class="border-b border-gray-400 hover:bg-gray-300 cursor-pointer transition" onclick="bukaModalEdit('Perbaikan Atap', 'Pemilik', '12 Jan 2026', 'Cash', 'RP 1.200.000', 'Berhasil', 'trx_005')">
                        <td class="py-4 px-3 border-r border-gray-400 text-left pl-4">Perbaikan Atap</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-left">Pemilik</td>
                        <td class="py-4 px-3 border-r border-gray-400">12 Jan 2026</td>
                        <td class="py-4 px-3 border-r border-gray-400">Cash</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-left pl-4 text-red-500 font-bold">RP 1.200.000</td>
                        <td class="py-4 px-3 border-r border-gray-400 text-green-600 font-bold">Berhasil</td>
                        <td class="py-4 px-3"><span class="bg-white border border-gray-400 px-3 py-1 rounded-full text-[10px] font-bold shadow-sm">Bukti</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end items-center gap-4 mt-6 font-bold text-[15px]">
            <button class="hover:text-gray-500"><i class="fas fa-chevron-left"></i></button>
            <button class="hover:underline">1</button>
            <button class="hover:underline">2</button>
            <button class="hover:underline">3</button>
            <button class="hover:text-gray-500"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

    <div id="modalTambah" class="fixed inset-0 bg-white/40 backdrop-blur-[2px] z-50 hidden flex items-center justify-center">
        <div class="bg-white w-[90%] max-w-md p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto no-scrollbar">
            <h2 class="text-center text-lg font-bold mb-6">Data Riwayat Transaksi</h2>
            <form action="{{ url('/tambah_riwayat') }}" method="POST">
                @csrf
                <div class="space-y-3 mb-8">
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nama kegiatan</label><input type="text" name="kegiatan" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nama</label><input type="text" name="nama" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Waktu Pelaksanaan</label><input type="text" name="waktu" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Metode Pembayaran</label><input type="text" name="metode" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nominal</label><input type="text" name="nominal" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Status</label><input type="text" name="status" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Bukti Pembayaran</label><input type="text" name="bukti" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required placeholder="Link file"></div>
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="tutupModal('modalTambah')" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Kembali</button>
                    <button type="submit" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Tambah Riwayat Pembayaran</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEdit" class="fixed inset-0 bg-white/40 backdrop-blur-[2px] z-50 hidden flex items-center justify-center">
        <div class="bg-white w-[90%] max-w-md p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto no-scrollbar">
            <h2 class="text-center text-lg font-bold mb-6">Data Riwayat Transaksi</h2>
            
            <form action="{{ url('/edit_riwayat') }}" method="POST" id="formEditRiwayat">
                @csrf @method('PUT')
                <input type="hidden" id="edit_id" name="id">
                
                <div class="space-y-3 mb-6">
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nama kegiatan</label><input type="text" id="edit_kegiatan" name="kegiatan" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none"></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nama</label><input type="text" id="edit_nama" name="nama" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none"></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Waktu Pelaksanaan</label><input type="text" id="edit_waktu" name="waktu" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none"></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Metode Pembayaran</label><input type="text" id="edit_metode" name="metode" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none"></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nominal</label><input type="text" id="edit_nominal" name="nominal" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none"></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Status</label><input type="text" id="edit_status" name="status" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none"></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Bukti Pembayaran</label><input type="text" id="edit_bukti" name="bukti" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none"></div>
                </div>

                <div class="flex justify-between gap-4 mb-3">
                    <button type="button" onclick="tutupModal('modalEdit')" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Kembali</button>
                    <button type="submit" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Edit Riwayat Pembayaran</button>
                </div>
            </form>

            <form action="{{ url('/hapus_riwayat') }}" method="POST">
                @csrf @method('DELETE')
                <input type="hidden" id="hapus_id" name="id">
                <button type="submit" class="w-full bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">
                    Hapus Riwayat Pembayaran
                </button>
            </form>
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

        function bukaModalTambah() { document.getElementById('modalTambah').classList.remove('hidden'); }
        
        function bukaModalEdit(kegiatan, nama, waktu, metode, nominal, status, id) {
            document.getElementById('edit_kegiatan').value = kegiatan;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_waktu').value = waktu;
            document.getElementById('edit_metode').value = metode;
            document.getElementById('edit_nominal').value = nominal;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_bukti').value = "bukti_" + id + ".pdf"; 
            
            document.getElementById('edit_id').value = id;
            document.getElementById('hapus_id').value = id;

            document.getElementById('modalEdit').classList.remove('hidden');
        }
        
        function tutupModal(modalId) { document.getElementById(modalId).classList.add('hidden'); }
    </script>
</body>
</html>