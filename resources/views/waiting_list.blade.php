<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting List - Dthanasha Kost</title>
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
            <a href="{{ url('/data_penghuni') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="fas fa-user text-sm"></i> Data Penghuni
            </a>
            <a href="{{ url('/waiting_list') }}" class="bg-black text-white px-5 py-2 rounded-full flex items-center gap-2 shrink-0 font-semibold shadow-sm transition-transform active:scale-95">
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
                <i class="fas fa-plus text-lg"></i> Tambah data waiting list
            </button>
        </div>

        <h2 class="text-lg font-bold mb-3">Data Waiting list</h2>
        <div class="overflow-x-auto rounded-md border border-black table-bg">
            <table class="w-full text-center border-collapse text-[13px] font-medium">
                <thead class="border-b border-black font-bold">
                    <tr>
                        <th class="py-4 px-4 border-r border-black w-12">NO</th>
                        <th class="py-4 px-4 border-r border-black text-left">Nama</th>
                        <th class="py-4 px-4 border-r border-black">Jenis kelamin</th>
                        <th class="py-4 px-4 border-r border-black">Kontak</th>
                        <th class="py-4 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-black hover:bg-gray-300 transition">
                        <td class="py-3 px-4 border-r border-black font-bold cursor-pointer" onclick="bukaModalEdit('1', 'Dimas Anggara', 'Pria', '081234567890')">1</td>
                        <td class="py-3 px-4 border-r border-black text-left cursor-pointer" onclick="bukaModalEdit('1', 'Dimas Anggara', 'Pria', '081234567890')">Dimas Anggara</td>
                        <td class="py-3 px-4 border-r border-black cursor-pointer" onclick="bukaModalEdit('1', 'Dimas Anggara', 'Pria', '081234567890')">Pria</td>
                        <td class="py-3 px-4 border-r border-black cursor-pointer" onclick="bukaModalEdit('1', 'Dimas Anggara', 'Pria', '081234567890')">081234567890</td>
                        <td class="py-3 px-4 flex items-center justify-center gap-2">
                            <button onclick="bukaModalEdit('1', 'Dimas Anggara', 'Pria', '081234567890')" class="bg-[#8CBF99] hover:bg-[#77a683] text-white w-7 h-7 rounded shadow-sm transition active:scale-95"><i class="fas fa-plus text-xs"></i></button>
                            <form action="{{ url('/hapus-waiting-list') }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <input type="hidden" name="id" value="1">
                                <button type="submit" class="bg-[#DF8A8A] hover:bg-[#c67676] text-white w-7 h-7 rounded shadow-sm transition active:scale-95"><i class="fas fa-times text-xs"></i></button>
                            </form>
                        </td>
                    </tr>
                    
                    <tr class="border-b border-black hover:bg-gray-300 transition">
                        <td class="py-3 px-4 border-r border-black font-bold cursor-pointer" onclick="bukaModalEdit('2', 'Putri Larasati', 'Wanita', '081384700111')">2</td>
                        <td class="py-3 px-4 border-r border-black text-left cursor-pointer" onclick="bukaModalEdit('2', 'Putri Larasati', 'Wanita', '081384700111')">Putri Larasati</td>
                        <td class="py-3 px-4 border-r border-black cursor-pointer" onclick="bukaModalEdit('2', 'Putri Larasati', 'Wanita', '081384700111')">Wanita</td>
                        <td class="py-3 px-4 border-r border-black cursor-pointer" onclick="bukaModalEdit('2', 'Putri Larasati', 'Wanita', '081384700111')">081384700111</td>
                        <td class="py-3 px-4 flex items-center justify-center gap-2">
                            <button onclick="bukaModalEdit('2', 'Putri Larasati', 'Wanita', '081384700111')" class="bg-[#8CBF99] hover:bg-[#77a683] text-white w-7 h-7 rounded shadow-sm transition active:scale-95"><i class="fas fa-plus text-xs"></i></button>
                            <form action="{{ url('/hapus-waiting-list') }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <input type="hidden" name="id" value="2">
                                <button type="submit" class="bg-[#DF8A8A] hover:bg-[#c67676] text-white w-7 h-7 rounded shadow-sm transition active:scale-95"><i class="fas fa-times text-xs"></i></button>
                            </form>
                        </td>
                    </tr>

                    <tr class="border-b border-black hover:bg-gray-300 transition">
                        <td class="py-3 px-4 border-r border-black font-bold cursor-pointer" onclick="bukaModalEdit('3', 'Reza Rahadian', 'Pria', '081555666777')">3</td>
                        <td class="py-3 px-4 border-r border-black text-left cursor-pointer" onclick="bukaModalEdit('3', 'Reza Rahadian', 'Pria', '081555666777')">Reza Rahadian</td>
                        <td class="py-3 px-4 border-r border-black cursor-pointer" onclick="bukaModalEdit('3', 'Reza Rahadian', 'Pria', '081555666777')">Pria</td>
                        <td class="py-3 px-4 border-r border-black cursor-pointer" onclick="bukaModalEdit('3', 'Reza Rahadian', 'Pria', '081555666777')">081555666777</td>
                        <td class="py-3 px-4 flex items-center justify-center gap-2">
                            <button onclick="bukaModalEdit('3', 'Reza Rahadian', 'Pria', '081555666777')" class="bg-[#8CBF99] hover:bg-[#77a683] text-white w-7 h-7 rounded shadow-sm transition active:scale-95"><i class="fas fa-plus text-xs"></i></button>
                            <form action="{{ url('/hapus-waiting-list') }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <input type="hidden" name="id" value="3">
                                <button type="submit" class="bg-[#DF8A8A] hover:bg-[#c67676] text-white w-7 h-7 rounded shadow-sm transition active:scale-95"><i class="fas fa-times text-xs"></i></button>
                            </form>
                        </td>
                    </tr>

                    <tr class="border-b border-black hover:bg-gray-300 transition">
                        <td class="py-3 px-4 border-r border-black font-bold cursor-pointer" onclick="bukaModalEdit('4', 'Ayu Lestari', 'Wanita', '081999888777')">4</td>
                        <td class="py-3 px-4 border-r border-black text-left cursor-pointer" onclick="bukaModalEdit('4', 'Ayu Lestari', 'Wanita', '081999888777')">Ayu Lestari</td>
                        <td class="py-3 px-4 border-r border-black cursor-pointer" onclick="bukaModalEdit('4', 'Ayu Lestari', 'Wanita', '081999888777')">Wanita</td>
                        <td class="py-3 px-4 border-r border-black cursor-pointer" onclick="bukaModalEdit('4', 'Ayu Lestari', 'Wanita', '081999888777')">081999888777</td>
                        <td class="py-3 px-4 flex items-center justify-center gap-2">
                            <button onclick="bukaModalEdit('4', 'Ayu Lestari', 'Wanita', '081999888777')" class="bg-[#8CBF99] hover:bg-[#77a683] text-white w-7 h-7 rounded shadow-sm transition active:scale-95"><i class="fas fa-plus text-xs"></i></button>
                            <form action="{{ url('/hapus-waiting-list') }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <input type="hidden" name="id" value="4">
                                <button type="submit" class="bg-[#DF8A8A] hover:bg-[#c67676] text-white w-7 h-7 rounded shadow-sm transition active:scale-95"><i class="fas fa-times text-xs"></i></button>
                            </form>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-300 transition">
                        <td class="py-3 px-4 border-r border-black font-bold cursor-pointer" onclick="bukaModalEdit('5', 'Kevin Sanjaya', 'Pria', '082111222333')">5</td>
                        <td class="py-3 px-4 border-r border-black text-left cursor-pointer" onclick="bukaModalEdit('5', 'Kevin Sanjaya', 'Pria', '082111222333')">Kevin Sanjaya</td>
                        <td class="py-3 px-4 border-r border-black cursor-pointer" onclick="bukaModalEdit('5', 'Kevin Sanjaya', 'Pria', '082111222333')">Pria</td>
                        <td class="py-3 px-4 border-r border-black cursor-pointer" onclick="bukaModalEdit('5', 'Kevin Sanjaya', 'Pria', '082111222333')">082111222333</td>
                        <td class="py-3 px-4 flex items-center justify-center gap-2">
                            <button onclick="bukaModalEdit('5', 'Kevin Sanjaya', 'Pria', '082111222333')" class="bg-[#8CBF99] hover:bg-[#77a683] text-white w-7 h-7 rounded shadow-sm transition active:scale-95"><i class="fas fa-plus text-xs"></i></button>
                            <form action="{{ url('/hapus-waiting-list') }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <input type="hidden" name="id" value="5">
                                <button type="submit" class="bg-[#DF8A8A] hover:bg-[#c67676] text-white w-7 h-7 rounded shadow-sm transition active:scale-95"><i class="fas fa-times text-xs"></i></button>
                            </form>
                        </td>
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
            <h2 class="text-center text-lg font-bold mb-6">Data Waiting List</h2>
            <form action="{{ url('/tambah-waiting-list') }}" method="POST">
                @csrf
                <div class="space-y-4 mb-8">
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Nama</label>
                        <input type="text" name="nama" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Jenis Kelamin</label>
                        <input type="text" name="jenis_kelamin" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Nomor Telepon</label>
                        <input type="text" name="telepon" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required>
                    </div>
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="tutupModal('modalTambah')" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Kembali</button>
                    <button type="submit" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Tambah data Waiting List</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEdit" class="fixed inset-0 bg-white/40 backdrop-blur-[2px] z-50 hidden flex items-center justify-center">
        <div class="bg-white w-[90%] max-w-md p-8 shadow-2xl relative">
            <h2 class="text-center text-lg font-bold mb-6">Data Waiting List</h2>
            <form action="{{ url('/edit-waiting-list') }}" method="POST">
                @csrf 
                @method('PUT') 
                
                <input type="hidden" id="edit_id" name="id">
                
                <div class="space-y-4 mb-8">
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Nama</label>
                        <input type="text" id="edit_nama" name="nama" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Jenis Kelamin</label>
                        <input type="text" id="edit_jk" name="jenis_kelamin" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Nomor Telepon</label>
                        <input type="text" id="edit_telepon" name="telepon" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" required>
                    </div>
                </div>
                <div class="flex justify-between gap-4">
                    <button type="button" onclick="tutupModal('modalEdit')" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Kembali</button>
                    <button type="submit" class="flex-1 bg-[#E5E7EB] hover:bg-gray-400 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">Edit Waiting List</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function bukaModalTambah() { 
            document.getElementById('modalTambah').classList.remove('hidden'); 
        }

        // Buka modal edit sekalian narik data dari baris tabel
        function bukaModalEdit(id, nama, jk, telepon) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_jk').value = jk;
            document.getElementById('edit_telepon').value = telepon;
            
            document.getElementById('modalEdit').classList.remove('hidden');
        }

        function tutupModal(modalId) { 
            document.getElementById(modalId).classList.add('hidden'); 
        }
    </script>
</body>
</html>