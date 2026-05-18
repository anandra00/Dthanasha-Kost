@extends('layouts.admin')

@section('title', 'Manajemen Kamar - Dthanasha Kost')
@section('search_placeholder', 'Cari nomor kamar...')

@section('content')
    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl card-shadow border border-gray-50 flex items-center justify-between group">
            <div>
                <p class="text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-1">Terisi</p>
                <p class="text-3xl font-black text-zinc-900">{{ $terisi }}</p>
            </div>
            <div class="w-14 h-14 bg-zinc-100 rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors">
                <i class="ph-fill ph-user-check text-2xl text-black"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl card-shadow border border-gray-50 flex items-center justify-between group">
            <div>
                <p class="text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-1">Kosong</p>
                <p class="text-3xl font-black text-zinc-900">{{ $kosong }}</p>
            </div>
            <div class="w-14 h-14 bg-zinc-100 rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors">
                <i class="ph-fill ph-door-open text-2xl text-black"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl card-shadow border border-gray-50 flex items-center justify-between group">
            <div>
                <p class="text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-1">Reguler</p>
                <p class="text-3xl font-black text-zinc-900">{{ $reguler }}</p>
            </div>
            <div class="w-14 h-14 bg-zinc-100 rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors">
                <i class="ph-fill ph-bed text-2xl text-black"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl card-shadow border border-gray-50 flex items-center justify-between group">
            <div>
                <p class="text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-1">VIP</p>
                <p class="text-3xl font-black text-zinc-900">{{ $vip }}</p>
            </div>
            <div class="w-14 h-14 bg-zinc-100 rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors">
                <i class="ph-fill ph-crown text-2xl text-black"></i>
            </div>
        </div>
    </div>

    <!-- FILTER & ADD BUTTON -->
    <div class="flex items-center gap-4 mb-8">
        <button onclick="bukaModalTambah()" class="bg-[#18181B] hover:bg-[#334155] transition-all px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-md flex items-center gap-2 active:scale-95 ml-auto">
            <i class="ph ph-plus-circle text-lg"></i> Tambah Kamar
        </button>
    </div>

    <!-- GRID KAMAR -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($kamars as $kamar)
        <div class="bg-white w-full rounded-[1.25rem] p-5 card-shadow border border-zinc-100 flex flex-col gap-5 hover:shadow-lg hover:border-zinc-200 transition-all group">
            <div class="flex justify-between items-start">
                <div class="bg-[#18181B] text-white w-[65px] h-[65px] rounded-2xl flex items-center justify-center font-bold text-2xl shadow-sm tracking-wide">{{ $kamar->nomor_kamar }}</div>
                <div class="text-right flex flex-col items-end">
                    @if($kamar->status_kamar == 'Terisi')
                        <span class="text-[10px] font-black tracking-widest text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg mb-1.5 uppercase">Terisi</span>
                    @else
                        <span class="text-[10px] font-black tracking-widest text-orange-600 bg-orange-50 px-2.5 py-1 rounded-lg mb-1.5 uppercase">Kosong</span>
                    @endif
                    <p class="text-[15px] font-bold text-zinc-900">{{ $kamar->jenis_kamar }}</p>
                    <p class="text-[12px] font-medium text-zinc-500">Rp {{ number_format($kamar->harga_kamar, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="flex gap-2 h-11">
                <button onclick='bukaModalDetail({{ $kamar->id }}, "{{ $kamar->nomor_kamar }}", "{{ $kamar->status_kamar }}", "{{ $kamar->jenis_kamar }}", "{{ $kamar->harga_kamar }}", @json($kamar->penghuni))' class="bg-zinc-100 hover:bg-zinc-200 text-zinc-700 font-bold rounded-xl flex-1 text-[13px] transition-all active:scale-95">Detail</button>
                <form action="{{ url('/admin/hapus_kamar/'.$kamar->id) }}" method="POST" class="h-full">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin ingin menghapus kamar ini?')" class="bg-red-50 hover:bg-red-100 text-red-500 w-11 h-full rounded-xl flex items-center justify-center transition-all active:scale-95"><i class="ph ph-trash text-lg"></i></button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-10">
            <p class="text-zinc-500 font-medium">Belum ada data kamar.</p>
        </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="mt-10">
        {{ $kamars->links() }}
    </div>

    <!-- MODAL TAMBAH -->
    <div id="modalTambah" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-95 transition-all max-h-[90vh] overflow-y-auto no-scrollbar">
            <h2 class="text-xl font-black text-zinc-900 mb-6 text-center uppercase tracking-wide">Tambah Kamar Baru</h2>
            <form action="{{ url('/admin/tambah_kamar') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nomor Kamar</label>
                        <input type="text" name="nomor_kamar" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Status Kamar</label>
                        <select name="status_kamar" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm" required>
                            <option value="Kosong">Kosong</option>
                            <option value="Terisi">Terisi</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Jenis Kamar</label>
                        <select name="jenis_kamar" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm" required>
                            <option value="Reguler">Reguler</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Harga Kamar</label>
                        <input type="number" name="harga_kamar" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm" required>
                    </div>
                </div>
                <div class="flex gap-3 pt-6 border-t border-zinc-100">
                    <button type="button" onclick="tutupModal('modalTambah')" class="flex-1 px-4 py-3.5 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase tracking-wide">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DETAIL / EDIT -->
    <div id="modalDetail" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-95 transition-all max-h-[90vh] overflow-y-auto no-scrollbar">
            <h2 class="text-xl font-black text-zinc-900 mb-6 text-center uppercase tracking-wide">Detail & Edit Kamar</h2>
            <form id="formEdit" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nomor Kamar</label>
                        <input type="text" id="detail_nomor" name="nomor_kamar" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Status Kamar</label>
                        <select id="detail_status" name="status_kamar" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm" required>
                            <option value="Kosong">Kosong</option>
                            <option value="Terisi">Terisi</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Jenis Kamar</label>
                        <select id="detail_jenis" name="jenis_kamar" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm" required>
                            <option value="Reguler">Reguler</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Harga Kamar</label>
                        <input type="number" id="detail_harga" name="harga_kamar" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm" required>
                    </div>
                </div>

                <!-- Bagian Informasi Penghuni (muncul jika ada penghuni) -->
                <div id="detail_penghuni_container" class="hidden mt-6 pt-6 border-t border-zinc-100">
                    <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide mb-4 flex items-center gap-2">
                        <i class="ph-fill ph-user-circle text-lg text-blue-500"></i> Informasi Penghuni
                    </h3>
                    <div class="bg-zinc-50 p-4 rounded-xl border border-zinc-100 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-zinc-500">Nama Lengkap</span>
                            <span class="text-sm font-bold text-zinc-900" id="info_nama"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-zinc-500">Usia & Gender</span>
                            <span class="text-sm font-bold text-zinc-900" id="info_usia_gender"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-zinc-500">Kontak Pribadi</span>
                            <span class="text-sm font-bold text-zinc-900" id="info_nohp"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-zinc-500">Kontak Darurat (Ortu)</span>
                            <span class="text-sm font-bold text-zinc-900" id="info_ortu"></span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 border-t border-zinc-100">
                    <button type="button" onclick="tutupModal('modalDetail')" class="flex-1 px-4 py-3.5 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase tracking-wide">Tutup</button>
                    <button type="submit" class="flex-1 px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function bukaModalTambah() { document.getElementById('modalTambah').classList.remove('hidden'); }
        
        function bukaModalDetail(id, nomor, status, jenis, harga, penghuni) {
            document.getElementById('formEdit').action = '/admin/edit_kamar/' + id;
            document.getElementById('detail_nomor').value = nomor;
            document.getElementById('detail_status').value = status;
            document.getElementById('detail_jenis').value = jenis;
            document.getElementById('detail_harga').value = harga;

            // Handle data penghuni
            const containerPenghuni = document.getElementById('detail_penghuni_container');
            if (penghuni) {
                containerPenghuni.classList.remove('hidden');
                document.getElementById('info_nama').textContent = penghuni.nama_penghuni || '-';
                
                const usia = penghuni.usia ? penghuni.usia + ' thn' : '';
                const gender = penghuni.jenis_kelamin || '';
                document.getElementById('info_usia_gender').textContent = (usia && gender) ? `${usia} - ${gender}` : (usia || gender || '-');
                
                document.getElementById('info_nohp').textContent = penghuni.no_telepon || '-';
                document.getElementById('info_ortu').textContent = penghuni.no_telepon_orangtua || '-';
            } else {
                containerPenghuni.classList.add('hidden');
            }

            document.getElementById('modalDetail').classList.remove('hidden');
        }
        
        function tutupModal(modalId) { document.getElementById(modalId).classList.add('hidden'); }
    </script>
@endsection