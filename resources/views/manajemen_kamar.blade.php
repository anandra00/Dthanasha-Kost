<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kamar - Dthanasha Kost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; }
        .card-bg { background-color: #F3F4F6; }
        .room-card { background-color: #E6E6E6; }
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
            <a href="{{ url('/manajemen_kamar') }}" class="bg-black text-white px-5 py-2 rounded-full flex items-center gap-2 shrink-0 font-semibold shadow-sm transition-transform active:scale-95">
                <i class="fas fa-bed text-sm"></i> Manajemen kamar
            </a>
            <a href="{{ url('pembayaran') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="fas fa-money-bill-wave text-sm"></i> Pembayaran
            </a>
            <a href="{{ url('/riwayat') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="fas fa-history text-sm"></i> Riwayat
            </a>
        </nav>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10 max-w-3xl mx-auto">
            <div class="card-bg rounded-2xl p-4 flex items-center justify-center gap-4 shadow-sm">
                <div class="bg-[#1A1A1A] w-10 h-10 rounded-full flex items-center justify-center text-white"><i class="fas fa-bed text-sm"></i></div>
                <div><p class="text-[10px] font-bold text-gray-700">Terisi</p><p class="text-xl font-bold">100</p></div>
            </div>
            <div class="card-bg rounded-2xl p-4 flex items-center justify-center gap-4 shadow-sm">
                <div class="bg-[#1A1A1A] w-10 h-10 rounded-full flex items-center justify-center text-white"><i class="fas fa-door-closed text-sm"></i></div>
                <div><p class="text-[10px] font-bold text-gray-700">Kosong</p><p class="text-xl font-bold">20</p></div>
            </div>
            <div class="card-bg rounded-2xl p-4 flex items-center justify-center gap-4 shadow-sm">
                <div class="bg-[#1A1A1A] w-10 h-10 rounded-full flex items-center justify-center text-white"><i class="fas fa-user-friends text-sm"></i></div>
                <div><p class="text-[10px] font-bold text-gray-700">Reguler</p><p class="text-xl font-bold">60</p></div>
            </div>
            <div class="card-bg rounded-2xl p-4 flex items-center justify-center gap-4 shadow-sm">
                <div class="bg-[#1A1A1A] w-10 h-10 rounded-full flex items-center justify-center text-white"><i class="fas fa-crown text-sm"></i></div>
                <div><p class="text-[10px] font-bold text-gray-700">VIP</p><p class="text-xl font-bold">60</p></div>
            </div>
        </div>

        <div class="flex items-center gap-4 mb-8">
            <div class="relative">
                <select class="room-card px-5 py-2.5 rounded-lg text-[13px] font-semibold outline-none shadow-sm appearance-none pr-8 cursor-pointer">
                    <option>Jenis Kamar</option>
                    <option>Reguler</option>
                    <option>VIP</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-sm pointer-events-none"></i>
            </div>
            <div class="relative">
                <select class="room-card px-5 py-2.5 rounded-lg text-[13px] font-semibold outline-none shadow-sm appearance-none pr-8 cursor-pointer">
                    <option>Ketersediaan Kamar</option>
                    <option>Terisi</option>
                    <option>Kosong</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-sm pointer-events-none"></i>
            </div>
            <button onclick="bukaModalTambah()" class="room-card hover:bg-gray-300 transition px-5 py-2.5 rounded-lg text-[13px] font-semibold shadow-sm flex items-center gap-2 active:scale-95">
                <i class="fas fa-plus text-lg"></i> Menejemen Kamar
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-8 gap-x-4">
            
            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1">
                    <div class="bg-[#18181B] text-white w-[70px] h-[70px] rounded-2xl flex items-center justify-center font-bold text-2xl shadow-sm tracking-wide">001</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Terisi</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">Reguler</p>
                    </div>
                </div>
                <div class="flex gap-3 h-11 mt-1">
                    <button onclick="bukaModalDetail('001', 'Dimas Anggara', 'Terisi', 'Reguler', 'Pria')" class="bg-white hover:bg-gray-50 text-black font-bold rounded-xl flex-1 text-[14px] shadow-sm transition active:scale-95">Detail</button>
                    <form action="{{ url('/hapus-kamar') }}" method="POST" class="h-full">
                        @csrf @method('DELETE')
                        <input type="hidden" name="nomor_kamar" value="001">
                        <button type="submit" class="bg-[#DF8A8A] hover:bg-[#c67676] text-white w-[50px] h-full rounded-xl flex items-center justify-center shadow-sm transition active:scale-95"><i class="fas fa-trash-alt text-[15px]"></i></button>
                    </form>
                </div>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1">
                    <div class="bg-[#18181B] text-white w-[70px] h-[70px] rounded-2xl flex items-center justify-center font-bold text-2xl shadow-sm tracking-wide">002</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Kosong</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">Reguler</p>
                    </div>
                </div>
                <div class="flex gap-3 h-11 mt-1">
                    <button onclick="bukaModalDetail('002', '', 'Kosong', 'Reguler', '')" class="bg-white hover:bg-gray-50 text-black font-bold rounded-xl flex-1 text-[14px] shadow-sm transition active:scale-95">Detail</button>
                    <form action="{{ url('/hapus-kamar') }}" method="POST" class="h-full">
                        @csrf @method('DELETE')
                        <input type="hidden" name="nomor_kamar" value="002">
                        <button type="submit" class="bg-[#DF8A8A] hover:bg-[#c67676] text-white w-[50px] h-full rounded-xl flex items-center justify-center shadow-sm transition active:scale-95"><i class="fas fa-trash-alt text-[15px]"></i></button>
                    </form>
                </div>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1">
                    <div class="bg-[#18181B] text-white w-[70px] h-[70px] rounded-2xl flex items-center justify-center font-bold text-2xl shadow-sm tracking-wide">003</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Terisi</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">Reguler</p>
                    </div>
                </div>
                <div class="flex gap-3 h-11 mt-1">
                    <button onclick="bukaModalDetail('003', 'Ayu Lestari', 'Terisi', 'Reguler', 'Wanita')" class="bg-white hover:bg-gray-50 text-black font-bold rounded-xl flex-1 text-[14px] shadow-sm transition active:scale-95">Detail</button>
                    <form action="{{ url('/hapus-kamar') }}" method="POST" class="h-full">
                        @csrf @method('DELETE')
                        <input type="hidden" name="nomor_kamar" value="003">
                        <button type="submit" class="bg-[#DF8A8A] hover:bg-[#c67676] text-white w-[50px] h-full rounded-xl flex items-center justify-center shadow-sm transition active:scale-95"><i class="fas fa-trash-alt text-[15px]"></i></button>
                    </form>
                </div>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1">
                    <div class="bg-[#18181B] text-white w-[70px] h-[70px] rounded-2xl flex items-center justify-center font-bold text-2xl shadow-sm tracking-wide">004</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Kosong</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">VIP</p>
                    </div>
                </div>
                <div class="flex gap-3 h-11 mt-1">
                    <button onclick="bukaModalDetail('004', '', 'Kosong', 'VIP', '')" class="bg-white hover:bg-gray-50 text-black font-bold rounded-xl flex-1 text-[14px] shadow-sm transition active:scale-95">Detail</button>
                    <form action="{{ url('/hapus-kamar') }}" method="POST" class="h-full">
                        @csrf @method('DELETE')
                        <input type="hidden" name="nomor_kamar" value="004">
                        <button type="submit" class="bg-[#DF8A8A] hover:bg-[#c67676] text-white w-[50px] h-full rounded-xl flex items-center justify-center shadow-sm transition active:scale-95"><i class="fas fa-trash-alt text-[15px]"></i></button>
                    </form>
                </div>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1">
                    <div class="bg-[#18181B] text-white w-[70px] h-[70px] rounded-2xl flex items-center justify-center font-bold text-2xl shadow-sm tracking-wide">005</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Terisi</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">VIP</p>
                    </div>
                </div>
                <div class="flex gap-3 h-11 mt-1">
                    <button onclick="bukaModalDetail('005', 'Reza Rahadian', 'Terisi', 'VIP', 'Pria')" class="bg-white hover:bg-gray-50 text-black font-bold rounded-xl flex-1 text-[14px] shadow-sm transition active:scale-95">Detail</button>
                    <form action="{{ url('/hapus-kamar') }}" method="POST" class="h-full">
                        @csrf @method('DELETE')
                        <input type="hidden" name="nomor_kamar" value="005">
                        <button type="submit" class="bg-[#DF8A8A] hover:bg-[#c67676] text-white w-[50px] h-full rounded-xl flex items-center justify-center shadow-sm transition active:scale-95"><i class="fas fa-trash-alt text-[15px]"></i></button>
                    </form>
                </div>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1">
                    <div class="bg-[#18181B] text-white w-[70px] h-[70px] rounded-2xl flex items-center justify-center font-bold text-2xl shadow-sm tracking-wide">006</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Terisi</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">VIP</p>
                    </div>
                </div>
                <div class="flex gap-3 h-11 mt-1">
                    <button onclick="bukaModalDetail('006', 'Putri Larasati', 'Terisi', 'VIP', 'Wanita')" class="bg-white hover:bg-gray-50 text-black font-bold rounded-xl flex-1 text-[14px] shadow-sm transition active:scale-95">Detail</button>
                    <form action="{{ url('/hapus-kamar') }}" method="POST" class="h-full">
                        @csrf @method('DELETE')
                        <input type="hidden" name="nomor_kamar" value="006">
                        <button type="submit" class="bg-[#DF8A8A] hover:bg-[#c67676] text-white w-[50px] h-full rounded-xl flex items-center justify-center shadow-sm transition active:scale-95"><i class="fas fa-trash-alt text-[15px]"></i></button>
                    </form>
                </div>
            </div>

        </div>

        <div class="flex justify-end items-center gap-4 mt-8 font-bold text-[15px]">
            <button class="hover:text-gray-500"><i class="fas fa-chevron-left"></i></button>
            <button class="hover:underline">1</button>
            <button class="hover:underline">2</button>
            <button class="hover:underline">3</button>
            <button class="hover:text-gray-500"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

    <div id="modalTambah" class="fixed inset-0 bg-white/40 backdrop-blur-[2px] z-50 hidden flex items-center justify-center">
        <div class="bg-white w-[90%] max-w-md p-8 shadow-2xl relative">
            <h2 class="text-center text-lg font-bold mb-6">Data Manajemen Kamar</h2>
            <form action="{{ url('/tambah-kamar') }}" method="POST">
                @csrf
                <div class="space-y-4 mb-8">
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Nomor kamar</label>
                        <input type="text" name="nomor_kamar" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Nama Penghuni</label>
                        <input type="text" name="nama_penghuni" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" placeholder="Kosongkan jika belum ada">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Status kamar</label>
                        <input type="text" name="status_kamar" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Jenis kamar</label>
                        <input type="text" name="jenis_kamar" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Jenis Kelamin</label>
                        <input type="text" name="jenis_kelamin" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" placeholder="Pria / Wanita">
                    </div>
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="tutupModal('modalTambah')" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Kembali</button>
                    <button type="submit" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Tambah Manajemen Kamar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalDetail" class="fixed inset-0 bg-white/40 backdrop-blur-[2px] z-50 hidden flex items-center justify-center">
        <div class="bg-white w-[90%] max-w-md p-8 shadow-2xl relative">
            <h2 class="text-center text-lg font-bold mb-6">Detail Kamar</h2>
            <form action="{{ url('/edit-kamar') }}" method="POST">
                @csrf @method('PUT')
                <div class="space-y-4 mb-8">
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Nomor kamar</label>
                        <input type="text" id="detail_nomor" name="nomor_kamar" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none readonly:bg-gray-800" readonly>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Nama Penghuni</label>
                        <input type="text" id="detail_nama" name="nama_penghuni" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Status kamar</label>
                        <input type="text" id="detail_status" name="status_kamar" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Jenis kamar</label>
                        <input type="text" id="detail_jenis" name="jenis_kamar" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Jenis Kelamin</label>
                        <input type="text" id="detail_kelamin" name="jenis_kelamin" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none">
                    </div>
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="tutupModal('modalDetail')" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Kembali</button>
                    <button type="submit" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function bukaModalTambah() { 
            document.getElementById('modalTambah').classList.remove('hidden'); 
        }

        function bukaModalDetail(nomor, nama, status, jenis, kelamin) {
            document.getElementById('detail_nomor').value = nomor;
            document.getElementById('detail_nama').value = nama;
            document.getElementById('detail_status').value = status;
            document.getElementById('detail_jenis').value = jenis;
            document.getElementById('detail_kelamin').value = kelamin;

            document.getElementById('modalDetail').classList.remove('hidden');
        }

        function tutupModal(modalId) { 
            document.getElementById(modalId).classList.add('hidden'); 
        }
    </script>
</body>
</html>