<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Dthanasha Kost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; }
        .card-bg { background-color: #F3F4F6; }
        .room-card { background-color: #E6E6E6; }
        .btn-red { background-color: #D34B4B; }
        .btn-yellow { background-color: #D4A74A; }
        .btn-green { background-color: #3C9C4D; }
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
            <a href="{{ url('/pembayaran') }}" class="bg-black text-white px-5 py-2 rounded-full flex items-center gap-2 shrink-0 font-semibold shadow-sm transition-transform active:scale-95">
                <i class="fas fa-money-bill-wave text-sm"></i> Pembayaran
            </a>
            <a href="{{ url('/riwayat') }}" class="text-gray-600 hover:text-black px-4 py-2 rounded-full flex items-center gap-2 shrink-0 font-medium transition">
                <i class="fas fa-history text-sm"></i> Riwayat
            </a>
        </nav>

        <div class="flex justify-center gap-6 mb-10">
            <div class="card-bg rounded-2xl w-48 p-4 flex items-center justify-center gap-4 shadow-sm">
                <div class="bg-[#1A1A1A] w-10 h-10 rounded-full flex items-center justify-center text-white"><i class="fas fa-check text-sm"></i></div>
                <div class="text-center"><p class="text-[9px] font-bold text-gray-700">Sudah membayar</p><p class="text-lg font-bold">80</p></div>
            </div>
            <div class="card-bg rounded-2xl w-48 p-4 flex items-center justify-center gap-4 shadow-sm">
                <div class="bg-[#1A1A1A] w-10 h-10 rounded-full flex items-center justify-center text-white"><i class="fas fa-exclamation text-sm"></i></div>
                <div class="text-center"><p class="text-[9px] font-bold text-gray-700">Menunggu Pembayaran</p><p class="text-lg font-bold">10</p></div>
            </div>
            <div class="card-bg rounded-2xl w-48 p-4 flex items-center justify-center gap-4 shadow-sm">
                <div class="bg-[#1A1A1A] w-10 h-10 rounded-full flex items-center justify-center text-white"><i class="fas fa-times text-sm"></i></div>
                <div class="text-center"><p class="text-[9px] font-bold text-gray-700">Belum Membayar</p><p class="text-lg font-bold">10</p></div>
            </div>
        </div>

        <div class="flex items-center gap-4 mb-8">
            <div class="relative">
                <select class="room-card px-5 py-2.5 rounded-lg text-[13px] font-semibold outline-none shadow-sm appearance-none pr-8 cursor-pointer">
                    <option>Status Pembayaran</option>
                    <option>Sudah Membayar</option>
                    <option>Menunggu Pembayaran</option>
                    <option>Belum Membayar</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-sm pointer-events-none"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-8 gap-x-4">
            
            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1 mt-1">
                    <div class="bg-[#18181B] text-white w-[65px] h-[65px] rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm tracking-wide">120</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Misael</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">Reguler</p>
                    </div>
                </div>
                <button onclick="bukaModalKonfirmasi('Misael', '120', 'Belum Membayar')" class="btn-red hover:opacity-90 text-white font-bold py-2.5 rounded-xl w-full text-[13px] shadow-sm transition active:scale-95 mt-1">
                    Belum Membayar
                </button>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1 mt-1">
                    <div class="bg-[#18181B] text-white w-[65px] h-[65px] rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm tracking-wide">120</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Misael</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">Reguler</p>
                    </div>
                </div>
                <button onclick="bukaModalKonfirmasi('Misael', '120', 'Menunggu Pembayaran')" class="btn-yellow hover:opacity-90 text-white font-bold py-2.5 rounded-xl w-full text-[13px] shadow-sm transition active:scale-95 mt-1">
                    Menunggu Membayar
                </button>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1 mt-1">
                    <div class="bg-[#18181B] text-white w-[65px] h-[65px] rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm tracking-wide">120</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Misael</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">Reguler</p>
                    </div>
                </div>
                <button onclick="bukaModalKonfirmasi('Misael', '120', 'Sudah Membayar')" class="btn-green hover:opacity-90 text-white font-bold py-2.5 rounded-xl w-full text-[13px] shadow-sm transition active:scale-95 mt-1">
                    Sudah Membayar
                </button>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1 mt-1">
                    <div class="bg-[#18181B] text-white w-[65px] h-[65px] rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm tracking-wide">120</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Misael</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">Reguler</p>
                    </div>
                </div>
                <button onclick="bukaModalKonfirmasi('Misael', '120', 'Belum Membayar')" class="btn-red hover:opacity-90 text-white font-bold py-2.5 rounded-xl w-full text-[13px] shadow-sm transition active:scale-95 mt-1">
                    Belum Membayar
                </button>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1 mt-1">
                    <div class="bg-[#18181B] text-white w-[65px] h-[65px] rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm tracking-wide">120</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Misael</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">Reguler</p>
                    </div>
                </div>
                <button onclick="bukaModalKonfirmasi('Misael', '120', 'Sudah Membayar')" class="btn-green hover:opacity-90 text-white font-bold py-2.5 rounded-xl w-full text-[13px] shadow-sm transition active:scale-95 mt-1">
                    Sudah Membayar
                </button>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1 mt-1">
                    <div class="bg-[#18181B] text-white w-[65px] h-[65px] rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm tracking-wide">120</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Misael</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">Reguler</p>
                    </div>
                </div>
                <button onclick="bukaModalKonfirmasi('Misael', '120', 'Menunggu Pembayaran')" class="btn-yellow hover:opacity-90 text-white font-bold py-2.5 rounded-xl w-full text-[13px] shadow-sm transition active:scale-95 mt-1">
                    Menunggu Membayar
                </button>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1 mt-1">
                    <div class="bg-[#18181B] text-white w-[65px] h-[65px] rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm tracking-wide">120</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Misael</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">Reguler</p>
                    </div>
                </div>
                <button onclick="bukaModalKonfirmasi('Misael', '120', 'Sudah Membayar')" class="btn-green hover:opacity-90 text-white font-bold py-2.5 rounded-xl w-full text-[13px] shadow-sm transition active:scale-95 mt-1">
                    Sudah Membayar
                </button>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1 mt-1">
                    <div class="bg-[#18181B] text-white w-[65px] h-[65px] rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm tracking-wide">120</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Misael</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">Reguler</p>
                    </div>
                </div>
                <button onclick="bukaModalKonfirmasi('Misael', '120', 'Menunggu Pembayaran')" class="btn-yellow hover:opacity-90 text-white font-bold py-2.5 rounded-xl w-full text-[13px] shadow-sm transition active:scale-95 mt-1">
                    Menunggu Membayar
                </button>
            </div>

            <div class="room-card w-full max-w-[280px] mx-auto rounded-[1.25rem] p-4 shadow-sm flex flex-col gap-4">
                <div class="flex justify-between items-center px-1 mt-1">
                    <div class="bg-[#18181B] text-white w-[65px] h-[65px] rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm tracking-wide">120</div>
                    <div class="text-right flex flex-col justify-center">
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight">Misael</p>
                        <p class="text-[16px] font-semibold text-gray-900 leading-tight mt-1">Reguler</p>
                    </div>
                </div>
                <button onclick="bukaModalKonfirmasi('Misael', '120', 'Belum Membayar')" class="btn-red hover:opacity-90 text-white font-bold py-2.5 rounded-xl w-full text-[13px] shadow-sm transition active:scale-95 mt-1">
                    Belum Membayar
                </button>
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

    <div id="modalKonfirmasi" class="fixed inset-0 bg-white/40 backdrop-blur-[2px] z-50 hidden flex items-center justify-center">
        <div class="bg-white w-[90%] max-w-md p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto no-scrollbar">
            
            <h2 id="modal_judul" class="text-center text-lg font-bold mb-6">Konfirmasi Pembayaran</h2>
            
            <form action="{{ url('/proses-pembayaran') }}" method="POST" id="formPembayaran">
                @csrf
                <div class="space-y-3 mb-8">
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Nama</label>
                        <input type="text" id="modal_nama" name="nama" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Nomor Kamar</label>
                        <input type="text" id="modal_kamar" name="nomor_kamar" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Metode Pembayaran</label>
                        <input type="text" id="modal_metode" name="metode_pembayaran" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Nominal</label>
                        <input type="text" id="modal_nominal" name="nominal" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Status</label>
                        <input type="text" id="modal_status" name="status" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold ml-2 mb-1">Bukti Pembayaran</label>
                        <input type="text" id="modal_bukti" name="bukti_pembayaran" class="w-full bg-black text-white rounded-full px-5 py-2 text-sm outline-none" placeholder="Link/Nama file bukti">
                    </div>
                </div>

                <div id="modal_action_buttons" class="flex flex-col gap-3">
                    </div>
            </form>
        </div>
    </div>

    <script>
        function bukaModalKonfirmasi(nama, kamar, status) { 
            // 1. Isi form otomatis
            document.getElementById('modal_nama').value = nama;
            document.getElementById('modal_kamar').value = kamar;
            document.getElementById('modal_status').value = status;
            
            document.getElementById('modal_metode').value = "";
            document.getElementById('modal_nominal').value = "";
            document.getElementById('modal_bukti').value = "";

            // 2. Manipulasi Tombol Action berdasarkan Status
            const actionContainer = document.getElementById('modal_action_buttons');
            const judulModal = document.getElementById('modal_judul');

            if (status === 'Sudah Membayar') {
                // Kalau udah bayar: Cuma tombol KEMBALI
                judulModal.innerText = "Detail Pembayaran";
                
                // Form di set Readonly biar gak bisa diutak-atik (Opsional, tapi bagus buat UX)
                const inputs = document.querySelectorAll('#formPembayaran input');
                inputs.forEach(input => input.setAttribute('readonly', true));

                actionContainer.innerHTML = `
                    <button type="button" onclick="tutupModal('modalKonfirmasi')" class="w-full bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">
                        Kembali
                    </button>
                `;
            } else {
                // Kalau Belum Membayar / Menunggu Pembayaran: Ada tombol Notif & Konfirmasi
                judulModal.innerText = "Konfirmasi Pembayaran";
                
                // Balikin form jadi bisa di-edit (hapus atribut readonly)
                const inputs = document.querySelectorAll('#formPembayaran input');
                inputs.forEach(input => input.removeAttribute('readonly'));

                // Action form diubah mengarah ke route notifikasi
                const urlNotif = "{{ url('/kirim-notifikasi') }}";

                actionContainer.innerHTML = `
                    <div class="flex justify-between gap-4">
                        <button type="button" onclick="tutupModal('modalKonfirmasi')" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-black font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">
                            Kembali
                        </button>
                        <button type="submit" class="flex-1 bg-[#E5E7EB] hover:bg-gray-300 text-green-600 font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">
                            Konfirmasi Pembayaran
                        </button>
                    </div>
                    <button type="button" onclick="window.location.href='${urlNotif}'" class="w-full bg-[#E5E7EB] hover:bg-gray-300 text-yellow-600 font-bold text-[13px] py-2.5 rounded-md transition active:scale-95">
                        Kirim Notifikasi Pembayaran
                    </button>
                `;
            }

            // 3. Tampilkan Modal
            document.getElementById('modalKonfirmasi').classList.remove('hidden'); 
        }

        function tutupModal(modalId) { 
            document.getElementById(modalId).classList.add('hidden'); 
        }
    </script>
</body>
</html>