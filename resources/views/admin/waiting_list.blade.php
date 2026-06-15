@extends('layouts.admin')

@section('title', 'Waiting List - Dthanasha Kost')
@section('search_placeholder', 'Cari nama calon penghuni...')

@section('content')

    <!-- KARTU SUMMARY GENDER -->
    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 mb-8 sm:mb-10">
        <div class="bg-white p-5 sm:p-6 rounded-2xl card-shadow border border-gray-50 flex items-center gap-4 w-full sm:w-60 group transition-all">
            <div class="w-14 h-14 bg-zinc-100 rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors shrink-0">
                <i class="ph ph-gender-male text-3xl text-black"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Pria</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalPria ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white p-5 sm:p-6 rounded-2xl card-shadow border border-gray-50 flex items-center gap-4 w-full sm:w-60 group transition-all">
            <div class="w-14 h-14 bg-zinc-100 rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors shrink-0">
                <i class="ph ph-gender-female text-3xl text-black"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Wanita</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalWanita ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- TABEL DATA WAITING LIST -->
    <div class="bg-white rounded-3xl card-shadow border border-gray-50 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gray-50 gap-4">
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide shrink-0">Data Waiting List</h3>
            <div class="flex flex-wrap sm:flex-nowrap gap-3 w-full sm:w-auto">
                <select id="filterGender" onchange="filterTabelGender()"
                    class="text-sm border border-zinc-200 bg-white rounded-lg px-3 py-2 outline-none font-semibold text-gray-600 cursor-pointer focus:ring-2 focus:ring-[#334155] flex-1 sm:flex-none">
                    <option value="Semua">Semua Gender</option>
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                </select>
                <button onclick="bukaModalTambah()"
                    class="flex-1 sm:flex-none bg-[#18181B] hover:bg-[#334155] text-white px-5 py-2 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2 shadow-md active:scale-95">
                    <i class="ph ph-plus-circle text-lg"></i> Tambah <span class="hidden sm:inline">Antrean</span>
                </button>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="overflow-x-auto hidden sm:block">
            <table class="w-full text-left border-collapse">
                <thead class="bg-zinc-100 text-zinc-500 text-[10px] uppercase tracking-widest border-b border-zinc-200">
                    <tr>
                        <!-- KACAMATA SKEPTIS: Persentase w-[...] udah gua atur ulang biar pas 100% -->
                        <th class="px-6 py-4 text-center w-[5%]">NO</th>
                        <th class="px-6 py-4 w-[25%]">Nama Lengkap</th>
                        <th class="px-6 py-4 w-[20%]">Jenis Kelamin</th>
                        <th class="px-6 py-4 w-[20%]">Nomor Kontak</th>
                        <th class="px-6 py-4 text-center w-[15%]">Hubungi</th>
                        <th class="px-6 py-4 text-right w-[15%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($antrean as $index => $a)
                        <tr class="hover:bg-zinc-50 transition-colors group searchable-item waiting-list-row" data-gender="{{ $a->jenis_kelamin }}">
                            <td class="px-6 py-4 text-sm font-bold text-zinc-400 text-center">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-zinc-900 group-hover:text-[#334155] transition-colors">
                                {{ $a->nama }}
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600">{{ $a->jenis_kelamin }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-zinc-600">{{ $a->no_telepon }}</td>
                            
                            <!-- KOLOM BARU: TOMBOL WA -->
                            <td class="px-6 py-4 text-center">
                                <a href="https://wa.me/{{ $a->no_telepon }}" target="_blank" 
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-zinc-200 hover:border-[#18181B] hover:bg-[#18181B] hover:text-zinc-400 text-zinc-700 rounded-lg text-xs font-bold transition-all shadow-sm active:scale-95 group/wa">
                                    <i class="ph-fill ph-whatsapp-logo text-zinc-800 group-hover/wa:text-white text-sm group-hover/wa:scale-110 transition-all"></i>
                                    Chat
                                </a>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        onclick="bukaModalEdit('{{ $a->id }}', '{{ $a->nama }}', '{{ $a->jenis_kelamin }}', '{{ $a->no_telepon }}')"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-zinc-100 hover:bg-zinc-200 text-zinc-600 transition-colors shadow-sm"
                                        title="Edit">
                                        <i class="ph ph-pencil-simple text-base"></i>
                                    </button>
                                    <button type="button" onclick="bukaModalHapus({{ $a->id }}, '{{ $a->nama }}', '{{ $a->jenis_kelamin }}', '{{ $a->no_telepon ?? '-' }}')" 
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 hover:bg-red-100 text-red-500 transition-colors shadow-sm"
                                        title="Hapus">
                                        <i class="ph ph-trash text-base"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <!-- KACAMATA SKEPTIS: colspan diganti jadi 6 karena nambah 1 kolom -->
                            <td colspan="6" class="px-6 py-8 text-center text-sm font-bold text-zinc-400">Belum ada data antrean.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="sm:hidden divide-y divide-zinc-100">
            @forelse($antrean as $index => $a)
                <div class="p-4 hover:bg-zinc-50 transition-colors group relative searchable-item waiting-list-row" data-gender="{{ $a->jenis_kelamin }}">
                    <div class="flex justify-between items-start mb-2">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-zinc-900 truncate">{{ $a->nama }}</p>
                            <p class="text-[11px] text-zinc-500 mt-0.5">{{ $a->jenis_kelamin }}</p>
                        </div>
                        <span class="text-xs font-medium text-zinc-600 bg-zinc-100 px-2 py-1 rounded-md shrink-0 ml-2">{{ $a->no_telepon }}</span>
                    </div>
                    <div class="flex gap-2 justify-end mt-3">
                        <button onclick="bukaModalEdit('{{ $a->id }}', '{{ $a->nama }}', '{{ $a->jenis_kelamin }}', '{{ $a->no_telepon }}')" class="px-3 py-1.5 rounded-lg bg-zinc-100 text-zinc-600 text-xs font-bold transition-colors"><i class="ph ph-pencil-simple"></i> Edit</button>
                        <form action="{{ url('/admin/hapus_waiting_list/' . $a->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus antrean ini?')" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-500 text-xs font-bold transition-colors"><i class="ph ph-trash"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-sm font-bold text-zinc-400">Belum ada data antrean.</div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="p-4 sm:p-6 border-t border-zinc-100 bg-white flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs font-semibold text-zinc-400 text-center w-full md:w-auto">Total: {{ $antrean->total() }} Antrean</p>
            <div class="w-full md:w-auto overflow-x-auto no-scrollbar flex justify-center">
                {{ $antrean->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div id="modalTambah" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl p-6 sm:p-8 shadow-2xl scale-95 transition-all max-h-[90vh] overflow-y-auto no-scrollbar">
            <h2 class="text-lg sm:text-xl font-black text-gray-900 mb-6 text-center uppercase tracking-wide">Tambah Waiting List</h2>
            <form action="{{ url('/admin/tambah_waiting_list') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nama
                        Lengkap</label>
                    <input type="text" name="nama"
                        class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900"
                        required>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Jenis
                        Kelamin</label>
                    <select name="jenis_kelamin"
                        class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900"
                        required>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nomor
                        Telepon</label>
                    <input type="text" name="telepon" placeholder="Awali dengan 628..."
                        class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900"
                        required>
                </div>

                <div class="flex gap-3 pt-6 border-t border-zinc-100">
                    <button type="button" onclick="tutupModal('modalTambah')"
                        class="flex-1 px-4 py-3.5 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase tracking-wide">Batal</button>
                    <button type="submit" onclick="if(this.form.checkValidity()){ this.innerHTML='<i class=\'ph ph-spinner animate-spin text-lg\'></i> Menyimpan...'; this.classList.remove('hover:bg-[#334155]', 'active:scale-95'); this.disabled=true; this.form.submit(); }"
                        class="flex-1 px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide">Simpan
                        Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div id="modalEdit" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl p-6 sm:p-8 shadow-2xl scale-95 transition-all max-h-[90vh] overflow-y-auto no-scrollbar">
            <h2 class="text-lg sm:text-xl font-black text-gray-900 mb-6 text-center uppercase tracking-wide">Edit Waiting List</h2>
            <form id="formEdit" method="POST" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nama
                        Lengkap</label>
                    <input type="text" id="edit_nama" name="nama"
                        class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900"
                        required>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Jenis
                        Kelamin</label>
                    <select id="edit_jk" name="jenis_kelamin"
                        class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900"
                        required>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nomor
                        Telepon</label>
                    <input type="text" id="edit_telepon" name="telepon" placeholder="Awali dengan 628..."
                        class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900"
                        required>
                </div>

                <div class="flex gap-3 pt-6 border-t border-zinc-100">
                    <button type="button" onclick="tutupModal('modalEdit')"
                        class="flex-1 px-4 py-3.5 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase tracking-wide">Batal</button>
                    <button type="submit" onclick="if(this.form.checkValidity()){ this.innerHTML='<i class=\'ph ph-spinner animate-spin text-lg\'></i> Menyimpan...'; this.classList.remove('hover:bg-[#334155]', 'active:scale-95'); this.disabled=true; this.form.submit(); }"
                        class="flex-1 px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide">Update
                        Data</button>
                </div>
            </form>
        </div>
    </div>
    <div id="modalHapus" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl max-h-[90vh] overflow-y-auto no-scrollbar">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-zinc-100 text-zinc-800 border border-zinc-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fas fa-user"></i>
                </div>
                <h2 class="text-xl font-black text-gray-900 uppercase tracking-wide">Hapus Penghuni</h2>
            </div>
            
            <form id="formHapusWaitingList" method="POST" class="space-y-4">
                @csrf @method('DELETE')
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-1">Nama</label>
                        <input type="text" id="hapus_nama" class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-100 text-zinc-900 font-bold text-sm" readonly>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-1">Usia</label>
                        <input type="text" id="hapus_jk" class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-100 text-zinc-900 font-bold text-sm" readonly>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-1">No. Kamar</label>
                        <input type="text" id="hapus_telepon" class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-100 text-zinc-900 font-bold text-sm" readonly>
                    </div>
                </div>
                <div class="flex gap-3 pt-6 border-t border-zinc-100">
                    <button type="button" onclick="tutupModal('modalHapus')" class="flex-1 px-4 py-3 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase">Batal</button>
                    <button type="submit" onclick="if(this.form.checkValidity()){ this.innerHTML='<i class=\'ph ph-spinner animate-spin text-lg\'></i> Menyimpan...'; this.classList.remove('hover:bg-red-100', 'active:scale-95'); this.disabled=true; this.form.submit(); }" class="flex-1 px-4 py-3 rounded-xl bg-red-50 text-red-600 font-bold hover:bg-red-100 border border-red-100 transition-all active:scale-95 flex items-center justify-center gap-2 text-sm uppercase">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function bukaModalTambah() {
            document.getElementById('modalTambah').classList.remove('hidden');
        }

        function bukaModalEdit(id, nama, jk, telepon) {
            document.getElementById('formEdit').action = '/admin/edit_waiting_list/' + id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_jk').value = jk;
            document.getElementById('edit_telepon').value = telepon;

            document.getElementById('modalEdit').classList.remove('hidden');
        }

        function bukaModalHapus(id, nama, jk, telepon) {
            document.getElementById('formHapusWaitingList').action = '/admin/hapus_waiting_list/' + id;
            document.getElementById('hapus_nama').value = nama;
            document.getElementById('hapus_jk').value = jk;
            document.getElementById('hapus_telepon').value = telepon;
            document.getElementById('modalHapus').classList.remove('hidden');
        }

        function tutupModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function filterTabelGender() {
            const filterValue = document.getElementById('filterGender').value;
            const rows = document.querySelectorAll('.waiting-list-row');
            
            rows.forEach(row => {
                const gender = row.getAttribute('data-gender');
                if (filterValue === 'Semua' || filterValue === gender) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
@endsection