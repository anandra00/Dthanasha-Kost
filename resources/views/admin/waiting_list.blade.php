@extends('layouts.admin')

@section('title', 'Waiting List - Dthanasha Kost')
@section('search_placeholder', 'Cari nama calon penghuni...')

@section('content')

    <!-- KARTU SUMMARY GENDER -->
    <div class="flex gap-6 mb-10">
        <div
            class="bg-white p-6 rounded-2xl card-shadow border border-gray-50 flex items-center gap-4 w-60 group transition-all">
            <div
                class="w-14 h-14 bg-zinc-100 rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors">
                <i class="ph ph-gender-male text-3xl text-black"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Pria</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalPria ?? 0 }}</p>
            </div>
        </div>
        <div
            class="bg-white p-6 rounded-2xl card-shadow border border-gray-50 flex items-center gap-4 w-60 group transition-all">
            <div
                class="w-14 h-14 bg-zinc-100 rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors">
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
        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50">
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Data Waiting List</h3>
            <div class="flex gap-3">
                <select id="filterGender" onchange="filterTabelGender()"
                    class="text-sm border border-zinc-200 bg-white rounded-lg px-3 py-2 outline-none font-semibold text-gray-600 cursor-pointer focus:ring-2 focus:ring-[#334155]">
                    <option value="Semua">Semua Gender</option>
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                </select>
                <button onclick="bukaModalTambah()"
                    class="bg-[#18181B] hover:bg-[#334155] text-white px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 shadow-md active:scale-95">
                    <i class="ph ph-plus-circle text-lg"></i> Tambah Antrean
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-zinc-100 text-zinc-500 text-[10px] uppercase tracking-widest border-b border-zinc-200">
                    <tr>
                        <th class="px-6 py-4 text-center w-[10%]">NO</th>
                        <th class="px-6 py-4 w-[30%]">Nama Lengkap</th>
                        <th class="px-6 py-4 w-[20%]">Jenis Kelamin</th>
                        <th class="px-6 py-4 w-[25%]">Nomor Kontak</th>
                        <th class="px-6 py-4 text-right w-[15%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($antrean as $index => $a)
                        <tr class="hover:bg-zinc-50 transition-colors group waiting-list-row" data-gender="{{ $a->jenis_kelamin }}">
                            <td class="px-6 py-4 text-sm font-bold text-zinc-400 text-center">{{ $index + 1 }}</td>
                            <td
                                class="px-6 py-4 text-sm font-medium text-zinc-900 group-hover:text-[#334155] transition-colors">
                                {{ $a->nama }}
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600">{{ $a->jenis_kelamin }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-zinc-600">{{ $a->no_telepon }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        onclick="bukaModalEdit('{{ $a->id }}', '{{ $a->nama }}', '{{ $a->jenis_kelamin }}', '{{ $a->no_telepon }}')"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-zinc-100 hover:bg-zinc-200 text-zinc-600 transition-colors shadow-sm"
                                        title="Edit">
                                        <i class="ph ph-pencil-simple text-base"></i>
                                    </button>
                                    <form action="{{ url('/admin/hapus_waiting_list/' . $a->id) }}" method="POST"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus antrean ini?')"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 hover:bg-red-100 text-red-500 transition-colors shadow-sm"
                                            title="Hapus">
                                            <i class="ph ph-trash text-base"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm font-bold text-zinc-400">Belum ada data
                                antrean.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="p-6 border-t border-zinc-100 bg-white flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs font-semibold text-zinc-400">Total: {{ $antrean->total() }} Antrean</p>
            <div class="w-full md:w-auto overflow-x-auto no-scrollbar">
                {{ $antrean->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div id="modalTambah" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-95 transition-all">
            <h2 class="text-xl font-black text-gray-900 mb-6 text-center uppercase tracking-wide">Tambah Waiting List</h2>
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
                    <input type="text" name="telepon"
                        class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900"
                        required>
                </div>

                <div class="flex gap-3 pt-6 border-t border-zinc-100">
                    <button type="button" onclick="tutupModal('modalTambah')"
                        class="flex-1 px-4 py-3.5 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase tracking-wide">Batal</button>
                    <button type="submit"
                        class="flex-1 px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide">Simpan
                        Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div id="modalEdit" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-95 transition-all">
            <h2 class="text-xl font-black text-gray-900 mb-6 text-center uppercase tracking-wide">Edit Waiting List</h2>
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
                    <input type="text" id="edit_telepon" name="telepon"
                        class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900"
                        required>
                </div>

                <div class="flex gap-3 pt-6 border-t border-zinc-100">
                    <button type="button" onclick="tutupModal('modalEdit')"
                        class="flex-1 px-4 py-3.5 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase tracking-wide">Batal</button>
                    <button type="submit"
                        class="flex-1 px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide">Update
                        Data</button>
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