<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penghuni - Dthanasha Kost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            <a href="{{ url('/data_penghuni') }}" class="bg-black text-white px-5 py-2 rounded-full flex items-center gap-2 shrink-0 font-semibold shadow-sm transition-transform active:scale-95">
                <i class="fas fa-user text-sm"></i> Data Penghuni
            </a>
            <a href="{{ url('/waiting_list') }}"class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="far fa-clock text-sm"></i> Waiting List
            </a>
            <a href="{{ url('/manajemen_kamar') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="fas fa-bed text-sm"></i> Manajemen kamar
            </a>
            <a href="{{ url('pembayaran') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="fas fa-money-bill-wave text-sm"></i> Pembayaran
            </a>
            <a href="{{ url('/riwayat') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="fas fa-history text-sm"></i> Riwayat
            </a>
        </nav>

        <div class="flex justify-center gap-6 mb-10">
            <div class="card-bg rounded-xl w-36 py-3 px-4 flex items-center justify-center gap-3 shadow-sm">
                <div class="bg-[#1A1A1A] w-9 h-9 rounded-full flex items-center justify-center text-white"><i class="fas fa-mars text-sm"></i></div>
                <div class="text-center"><p class="text-[10px] font-bold text-gray-700">Pria</p><p class="text-lg font-bold">50</p></div>
            </div>
            <div class="card-bg rounded-xl w-36 py-3 px-4 flex items-center justify-center gap-3 shadow-sm">
                <div class="bg-[#1A1A1A] w-9 h-9 rounded-full flex items-center justify-center text-white"><i class="fas fa-venus text-sm"></i></div>
                <div class="text-center"><p class="text-[10px] font-bold text-gray-700">Wanita</p><p class="text-lg font-bold">50</p></div>
            </div>
        </div>

        <div class="flex items-center gap-4 mb-6">
            <div class="relative">
                <select class="card-bg px-4 py-2.5 rounded-lg text-[13px] font-semibold outline-none shadow-sm appearance-none pr-8 cursor-pointer">
                    <option>Jenis Kelamin</option>
                    <option>Pria</option>
                    <option>Wanita</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-sm pointer-events-none"></i>
            </div>
            <button onclick="bukaModalTambah()" class="card-bg hover:bg-gray-300 transition px-5 py-2.5 rounded-lg text-[13px] font-semibold shadow-sm flex items-center gap-2 active:scale-95">
                <i class="fas fa-plus text-lg"></i> Tambah Akun
            </button>
        </div>

        <h2 class="text-lg font-bold mb-3">Data Penghuni</h2>
        <div class="overflow-x-auto rounded-md border border-black table-bg">
            <table class="w-full text-center border-collapse text-[13px] font-medium">
                <thead class="border-b border-black font-bold">
                    <tr>
                        <th class="py-4 px-3 border-r border-black w-10">NO</th>
                        <th class="py-4 px-3 border-r border-black">Nama</th>
                        <th class="py-4 px-3 border-r border-black">Usia</th>
                        <th class="py-4 px-3 border-r border-black">Nomor<br>kamar</th>
                        <th class="py-4 px-3 border-r border-black">Jenis kelamin</th>
                        <th class="py-4 px-3 border-r border-black">Kontak</th>
                        <th class="py-4 px-3 border-r border-black">Nomor orangtua</th>
                        <th class="py-4 px-3">Akun</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-black hover:bg-gray-300 cursor-pointer transition" onclick="bukaModalHapus('Dimas Anggara', '21', '012', 'Pria', '081234567890', '085234567890', 'dimas_ang')">
                        <td class="py-4 px-3 border-r border-black font-bold">1</td>
                        <td class="py-4 px-3 border-r border-black text-left pl-4">Dimas Anggara</td>
                        <td class="py-4 px-3 border-r border-black">21</td>
                        <td class="py-4 px-3 border-r border-black">012</td>
                        <td class="py-4 px-3 border-r border-black">Pria</td>
                        <td class="py-4 px-3 border-r border-black">081234567890</td>
                        <td class="py-4 px-3 border-r border-black">085234567890</td>
                        <td class="py-4 px-3">dimas_ang</td>
                    </tr>
                    <tr class="border-b border-black hover:bg-gray-300 cursor-pointer transition" onclick="bukaModalHapus('Putri Larasati', '20', '045', 'Wanita', '081384700111', '08777000322', 'putrilaras')">
                        <td class="py-4 px-3 border-r border-black font-bold">2</td>
                        <td class="py-4 px-3 border-r border-black text-left pl-4">Putri Larasati</td>
                        <td class="py-4 px-3 border-r border-black">20</td>
                        <td class="py-4 px-3 border-r border-black">045</td>
                        <td class="py-4 px-3 border-r border-black">Wanita</td>
                        <td class="py-4 px-3 border-r border-black">081384700111</td>
                        <td class="py-4 px-3 border-r border-black">08777000322</td>
                        <td class="py-4 px-3">putrilaras</td>
                    </tr>
                    <tr class="border-b border-black hover:bg-gray-300 cursor-pointer transition" onclick="bukaModalHapus('Reza Rahadian', '24', '115', 'Pria', '081555666777', '081222333444', 'reza_r')">
                        <td class="py-4 px-3 border-r border-black font-bold">3</td>
                        <td class="py-4 px-3 border-r border-black text-left pl-4">Reza Rahadian</td>
                        <td class="py-4 px-3 border-r border-black">24</td>
                        <td class="py-4 px-3 border-r border-black">115</td>
                        <td class="py-4 px-3 border-r border-black">Pria</td>
                        <td class="py-4 px-3 border-r border-black">081555666777</td>
                        <td class="py-4 px-3 border-r border-black">081222333444</td>
                        <td class="py-4 px-3">reza_r</td>
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
        <div class="bg-white w-[90%] max-w-md p-8 shadow-2xl relative">
            <h2 class="text-center text-lg font-bold mb-6">Tambah Akun</h2>
            <form action="{{ url('/tambah-akun') }}" method="POST">
                @csrf
                <div class="space-y-4 mb-8">
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nama</label><input type="text" name="nama" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nama Akun</label><input type="text" name="nama_akun" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Password</label><input type="password" name="password" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nomor Kamar</label><input type="text" name="nomor_kamar" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required></div>
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="tutupModal('modalTambah')" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Kembali</button>
                    <button type="submit" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Tambah Data Akun</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalHapus" class="fixed inset-0 bg-white/40 backdrop-blur-[2px] z-50 hidden flex items-center justify-center">
        <div class="bg-white w-[90%] max-w-md p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto no-scrollbar">
            <h2 class="text-center text-lg font-bold mb-6">Data Penghuni</h2>
            <form action="{{ url('/hapus-penghuni') }}" method="POST">
                @csrf @method('DELETE')
                <input type="hidden" id="hapus_id_akun" name="akun">
                <div class="space-y-3 mb-8">
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nama</label><input type="text" id="hapus_nama" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" readonly></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Usia</label><input type="text" id="hapus_usia" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" readonly></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nomor kamar</label><input type="text" id="hapus_kamar" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" readonly></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Jenis kelamin</label><input type="text" id="hapus_jk" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" readonly></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Kontak</label><input type="text" id="hapus_kontak" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" readonly></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nomor Orangtua</label><input type="text" id="hapus_ortu" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" readonly></div>
                    <div><label class="block text-[11px] font-bold ml-2 mb-1">Nama akun</label><input type="text" id="hapus_akun" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" readonly></div>
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="tutupModal('modalHapus')" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Kembali</button>
                    <button type="submit" class="flex-1 bg-[#E5E7EB] hover:bg-gray-400 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Hapus Data Penghuni</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function bukaModalTambah() { document.getElementById('modalTambah').classList.remove('hidden'); }
        function bukaModalHapus(nama, usia, kamar, jk, kontak, ortu, akun) {
            document.getElementById('hapus_nama').value = nama; document.getElementById('hapus_usia').value = usia;
            document.getElementById('hapus_kamar').value = kamar; document.getElementById('hapus_jk').value = jk;
            document.getElementById('hapus_kontak').value = kontak; document.getElementById('hapus_ortu').value = ortu;
            document.getElementById('hapus_akun').value = akun; document.getElementById('hapus_id_akun').value = akun;
            document.getElementById('modalHapus').classList.remove('hidden');
        }
        function tutupModal(modalId) { document.getElementById(modalId).classList.add('hidden'); }
    </script>
</body>
</html>