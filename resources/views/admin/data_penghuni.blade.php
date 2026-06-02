@extends('layouts.admin')

@section('title', 'Data Penghuni - Dthanasha Kost')
@section('search_placeholder', 'Cari data penghuni...')

@section('extra_head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
    <!-- KARTU SUMMARY GENDER -->
    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 mb-8 sm:mb-10">
        <div class="bg-white p-5 sm:p-6 rounded-2xl card-shadow border border-gray-50 flex items-center gap-4 w-full sm:w-60 group transition-all">
            <div class="w-14 h-14 bg-zinc-100 rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors shrink-0">
                <i class="fas fa-mars text-2xl text-black"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Pria</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalPria ?? 0 }}</p>
            </div>
        </div>
        <div class="bg-white p-5 sm:p-6 rounded-2xl card-shadow border border-gray-50 flex items-center gap-4 w-full sm:w-60 group transition-all">
            <div class="w-14 h-14 bg-zinc-100 rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors shrink-0">
                <i class="fas fa-venus text-2xl text-black"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Wanita</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalWanita ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- TABEL DATA -->
    <div class="bg-white rounded-3xl card-shadow border border-gray-50 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gray-50 gap-4">
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide shrink-0">Daftar Penghuni Aktif</h3>
            <div class="flex flex-wrap sm:flex-nowrap gap-3 w-full sm:w-auto">
                <select id="filterGender" onchange="filterTabelGender()" class="text-sm border border-zinc-200 bg-white rounded-lg px-3 py-2 outline-none font-semibold text-gray-600 cursor-pointer focus:ring-2 focus:ring-[#334155] flex-1 sm:flex-none">
                    <option value="Semua">Semua Gender</option>
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                </select>
                <button onclick="bukaModalImport()" class="flex-1 sm:flex-none bg-zinc-100 hover:bg-zinc-200 text-zinc-700 px-4 py-2 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2 border border-zinc-200 active:scale-95">
                    <i class="fas fa-file-import"></i> Import <span class="hidden sm:inline">Waiting List</span>
                </button>
                <button onclick="bukaModalTambah()" class="flex-1 sm:flex-none bg-[#18181B] hover:bg-[#334155] text-white px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2 shadow-md active:scale-95">
                    <i class="fas fa-plus"></i> Tambah <span class="hidden sm:inline">Akun</span>
                </button>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="overflow-x-auto hidden sm:block">
            <table class="w-full text-left">
                <thead class="bg-zinc-100 text-zinc-500 text-[10px] uppercase tracking-widest border-b border-zinc-200">
                    <tr>
                        <th class="px-6 py-4 text-center">NO</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4 text-center">Usia</th>
                        <th class="px-6 py-4 text-center">Kamar</th>
                        <th class="px-6 py-4">Gender</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">No. Orangtua</th>
                        <th class="px-6 py-4">Akun & Email</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200">
                    @forelse($penghunis as $index => $p)
                        <tr class="hover:bg-zinc-50 transition-colors group penghuni-row" data-gender="{{ $p->jenis_kelamin == 'L' ? 'Pria' : 'Wanita' }}">
                            <td class="px-6 py-4 text-sm font-bold text-gray-400 text-center">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 group-hover:text-[#334155] transition-colors">{{ $p->nama_penghuni }}</td>
                            <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $p->usia }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($p->id_kamar)
                                    <span class="bg-blue-100 text-blue-800 text-[11px] font-black px-2.5 py-1 rounded-md">{{ $p->kamar->nomor_kamar }}</span>
                                @else
                                    <span class="bg-zinc-200 text-zinc-800 text-[11px] font-black px-2.5 py-1 rounded-md">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $p->jenis_kelamin == 'L' ? 'Pria' : 'Wanita' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $p->no_telepon }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $p->no_telepon_orangtua }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs font-bold text-zinc-700 bg-zinc-100 px-2 py-0.5 rounded-md border border-zinc-200 w-max">{{ '@' . ($p->user->username ?? 'tidak_ada') }}</span>
                                    <span class="text-[10px] font-medium text-zinc-500 truncate max-w-[150px]" title="{{ $p->user->email ?? 'Belum ada email' }}">{{ $p->user->email ?? 'Belum ada email' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 flex justify-center gap-2">
                                <button onclick="bukaModalEditPenghuni({{ $p->id }}, '{{ $p->nama_penghuni }}', '{{ $p->id_kamar }}', '{{ $p->jenis_kelamin }}', '{{ $p->usia }}', '{{ $p->no_telepon }}', '{{ $p->no_telepon_orangtua }}', '{{ $p->user->email ?? '' }}')" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-2 rounded-xl text-xs font-bold transition-all active:scale-95"><i class="fas fa-edit"></i> Edit</button>
                                <button onclick="bukaModalHapus({{ $p->id }}, '{{ $p->nama_penghuni }}', '{{ $p->usia }}', '{{ $p->kamar->nomor_kamar ?? '-' }}')" 
                                        class="bg-red-50 text-red-600 hover:bg-red-100 px-3 py-2 rounded-xl text-xs font-bold transition-all active:scale-95"><i class="fas fa-trash"></i> Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-sm font-bold text-zinc-400">Belum ada data penghuni. Silakan tambah data baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="sm:hidden divide-y divide-zinc-200">
            @forelse($penghunis as $index => $p)
                <div class="p-4 hover:bg-zinc-50 transition-colors group penghuni-row" data-gender="{{ $p->jenis_kelamin == 'L' ? 'Pria' : 'Wanita' }}">
                    <div class="flex items-start justify-between mb-3">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $p->nama_penghuni }}</p>
                            <p class="text-[11px] text-gray-500 mt-0.5 truncate">{{ '@' . ($p->user->username ?? 'tidak_ada') }}</p>
                        </div>
                        @if($p->id_kamar)
                            <span class="bg-blue-100 text-blue-800 text-[10px] font-black px-2 py-1 rounded-md shrink-0 ml-2">Kamar {{ $p->kamar->nomor_kamar }}</span>
                        @else
                            <span class="bg-zinc-200 text-zinc-800 text-[10px] font-black px-2 py-1 rounded-md shrink-0 ml-2">Belum ada kamar</span>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600 mb-3">
                        <div class="flex flex-col">
                            <span class="font-bold text-[9px] uppercase tracking-widest text-zinc-400 mb-0.5">Gender & Usia</span>
                            <span class="font-medium">{{ $p->jenis_kelamin == 'L' ? 'Pria' : 'Wanita' }} · {{ $p->usia }} Thn</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-[9px] uppercase tracking-widest text-zinc-400 mb-0.5">Kontak Pribadi</span>
                            <span class="font-medium truncate">{{ $p->no_telepon }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-2">
                        <button onclick="bukaModalEditPenghuni({{ $p->id }}, '{{ $p->nama_penghuni }}', '{{ $p->id_kamar }}', '{{ $p->jenis_kelamin }}', '{{ $p->usia }}', '{{ $p->no_telepon }}', '{{ $p->no_telepon_orangtua }}', '{{ $p->user->email ?? '' }}')" class="flex-1 bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1 active:scale-95"><i class="fas fa-edit"></i> Edit</button>
                        <button onclick="bukaModalHapus({{ $p->id }}, '{{ $p->nama_penghuni }}', '{{ $p->usia }}', '{{ $p->kamar->nomor_kamar ?? '-' }}')" class="flex-1 bg-red-50 text-red-600 hover:bg-red-100 px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1 active:scale-95"><i class="fas fa-trash"></i> Hapus</button>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-sm font-bold text-zinc-400">Belum ada data penghuni. Silakan tambah data baru.</div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="p-4 sm:p-6 border-t border-zinc-100 bg-white flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs font-semibold text-zinc-400 text-center w-full md:w-auto">Total: {{ $penghunis->total() }} Penghuni</p>
            <div class="w-full md:w-auto overflow-x-auto no-scrollbar flex justify-center">
                {{ $penghunis->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div id="modalTambah" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-3xl p-6 sm:p-8 shadow-2xl scale-95 transition-all max-h-[90vh] overflow-y-auto no-scrollbar">
            <h2 class="text-lg sm:text-xl font-black text-gray-900 mb-6 text-center uppercase tracking-wide">Tambah Akun Baru</h2>
            <form id="formTambahAkun" action="{{ route('admin.tambah-akun') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="waiting_list_id" id="tambah_wl_id" value="">
                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" id="tambah_nama" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Usia</label>
                        <input type="number" name="usia" id="tambah_usia" min="0" max="200" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Gender</label>
                        <select name="jk" id="tambah_jk" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                            <option value="L">Pria</option>
                            <option value="P">Wanita</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Kontak Penghuni</label>
                        <input type="text" name="kontak" id="tambah_kontak" placeholder="CTH: 628..." class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">No. Orang Tua</label>
                        <input type="text" name="kontak_ortu" placeholder="CTH: 628..." class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">No. Kamar</label>
                        <input type="text" name="nomor_kamar" min="0" max="100" placeholder="Akan disambungkan nanti" class="w-full px-4 py-3 rounded-xl bg-zinc-100 border border-zinc-200 text-zinc-500 font-bold text-sm cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nama Akun (Username)</label>
                        <input type="text" name="nama_akun" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Password Login</label>
                    <input type="password" name="password" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                </div>
                <div class="flex gap-3 pt-4 border-t border-zinc-100">
                    <button type="button" onclick="tutupModal('modalTambah')" class="flex-1 px-4 py-3.5 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase tracking-wide">Batal</button>
                    <button type="submit" onclick="if(this.form.checkValidity()){ this.innerHTML='<i class=\'ph ph-spinner animate-spin text-lg\'></i> Menyimpan...'; this.classList.remove('hover:bg-[#334155]', 'active:scale-95'); this.disabled=true; this.form.submit(); }" class="flex-1 px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide">Simpan Penghuni</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT PENGHUNI -->
    <div id="modalEditPenghuni" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl p-6 sm:p-8 shadow-2xl scale-95 transition-all max-h-[90vh] overflow-y-auto no-scrollbar">
            <h2 class="text-lg sm:text-xl font-black text-zinc-900 mb-6 text-center uppercase tracking-wide">Edit Data Penghuni</h2>
            <form id="formEditPenghuni" method="POST" class="space-y-4">
                @csrf @method('PUT')
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Nama Penghuni</label>
                        <input type="text" id="edit_nama" name="nama" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Usia</label>
                        <input type="number" id="edit_usia" name="usia" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Gender</label>
                        <select id="edit_jk" name="jk" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all text-sm font-bold text-zinc-900" required>
                            <option value="L">Pria</option>
                            <option value="P">Wanita</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Kontak</label>
                        <input type="text" id="edit_kontak" name="kontak" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">No. Orang Tua</label>
                        <input type="text" id="edit_kontak_ortu" name="kontak_ortu" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Email</label>
                        <input type="email" id="edit_email" name="email" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Pilih Kamar</label>
                    <select id="edit_kamar_id" name="kamar_id" class="w-full px-4 py-3 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#334155] transition-all font-bold text-zinc-900 text-sm">
                    </select>
                    <p class="text-[10px] text-zinc-400 mt-2 ml-1">*Hanya menampilkan kamar yang kosong.</p>
                </div>

                <div class="flex gap-3 pt-6 border-t border-zinc-100">
                    <button type="button" onclick="tutupModal('modalEditPenghuni')" class="flex-1 px-4 py-3.5 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase tracking-wide">Batal</button>
                    <button type="submit" onclick="if(this.form.checkValidity()){ this.innerHTML='<i class=\'ph ph-spinner animate-spin text-lg\'></i> Menyimpan...'; this.classList.remove('hover:bg-[#334155]', 'active:scale-95'); this.disabled=true; this.form.submit(); }" class="flex-1 px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide">Update & Sinkron</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DETAIL / HAPUS -->
    <div id="modalHapus" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto no-scrollbar">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-zinc-100 text-zinc-800 border border-zinc-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                    <i class="fas fa-user"></i>
                </div>
                <h2 class="text-lg sm:text-xl font-black text-gray-900 uppercase tracking-wide">Hapus Penghuni</h2>
            </div>
            
            <form id="formHapusPenghuni" method="POST" class="space-y-4">
                @csrf @method('DELETE')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-1">Nama</label>
                        <input type="text" id="hapus_nama" class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-100 text-zinc-900 font-bold text-sm" readonly>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-1">Jenis Kelamin</label>
                        <input type="text" id="hapus_usia" class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-100 text-zinc-900 font-bold text-sm" readonly>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-1">Telepon</label>
                        <input type="text" id="hapus_kamar" class="w-full px-4 py-3 rounded-xl bg-zinc-50 border border-zinc-100 text-zinc-900 font-bold text-sm" readonly>
                    </div>
                </div>
                <div class="flex gap-3 pt-6 border-t border-zinc-100">
                    <button type="button" onclick="tutupModal('modalHapus')" class="flex-1 px-4 py-3 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase">Batal</button>
                    <button type="submit" onclick="if(this.form.checkValidity()){ this.innerHTML='<i class=\'ph ph-spinner animate-spin text-lg\'></i> Menyimpan...'; this.classList.remove('hover:bg-[#334155]', 'active:scale-95'); this.disabled=true; this.form.submit(); }" class="flex-1 px-4 py-3 rounded-xl bg-red-50 text-red-600 font-bold hover:bg-red-100 border border-red-100 transition-all active:scale-95 flex items-center justify-center gap-2 text-sm uppercase">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- MODAL IMPORT WAITING LIST -->
    <div id="modalImport" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-3xl p-6 sm:p-8 shadow-2xl scale-95 transition-all max-h-[90vh] overflow-y-auto no-scrollbar">
            <h2 class="text-lg sm:text-xl font-black text-gray-900 mb-6 text-center uppercase tracking-wide">Import dari Waiting List</h2>
            <p class="text-sm text-zinc-500 mb-4 text-center">Pilih calon penghuni untuk dibuatkan akun.</p>
            <div class="space-y-3 max-h-60 overflow-y-auto">
                @forelse($waitingList as $wl)
                    <button type="button" onclick="pilihWaitingList({{ $wl->id }}, '{{ $wl->nama }}', '{{ $wl->jenis_kelamin }}', '{{ $wl->no_telepon }}')"
                        class="w-full text-left p-4 rounded-2xl border border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50 transition-all flex justify-between items-center group">
                        <div>
                            <p class="text-sm font-bold text-zinc-900 group-hover:text-[#334155]">{{ $wl->nama }}</p>
                            <p class="text-xs text-zinc-500">{{ $wl->jenis_kelamin }} · {{ $wl->no_telepon }}</p>
                        </div>
                        <i class="fas fa-arrow-right text-zinc-300 group-hover:text-zinc-600 transition-colors"></i>
                    </button>
                @empty
                    <div class="text-center py-6">
                        <p class="text-sm text-zinc-400 font-medium">Waiting list kosong.</p>
                    </div>
                @endforelse
            </div>
            <button type="button" onclick="tutupModal('modalImport')" class="w-full mt-6 px-4 py-3 rounded-xl bg-zinc-100 text-zinc-600 font-bold hover:bg-zinc-200 transition-all text-sm uppercase tracking-wide">Tutup</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const semuaKamar = @json($semuaKamar ?? []);

        function bukaModalTambah() { 
            // Reset form
            document.getElementById('formTambahAkun').reset();
            document.getElementById('tambah_wl_id').value = '';
            document.getElementById('modalTambah').classList.remove('hidden'); 
        }

        function bukaModalImport() {
            document.getElementById('modalImport').classList.remove('hidden');
        }

        // Pilih dari Waiting List → auto-fill form Tambah
        function pilihWaitingList(id, nama, gender, telepon) {
            tutupModal('modalImport');
            document.getElementById('tambah_wl_id').value = id;
            document.getElementById('tambah_nama').value = nama;
            document.getElementById('tambah_jk').value = (gender === 'Pria') ? 'L' : 'P';
            document.getElementById('tambah_kontak').value = telepon;
            document.getElementById('modalTambah').classList.remove('hidden');
        }

        // Edit Modal - semua field
        function bukaModalEditPenghuni(id, nama, kamarIdSaatIni, jenisKelamin, usia, kontak, kontakOrtu, email) {
            document.getElementById('formEditPenghuni').action = '/admin/edit_penghuni/' + id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_jk').value = jenisKelamin;
            document.getElementById('edit_usia').value = usia;
            document.getElementById('edit_kontak').value = kontak;
            document.getElementById('edit_kontak_ortu').value = kontakOrtu;
            document.getElementById('edit_email').value = email;

            const selectKamar = document.getElementById('edit_kamar_id');
            selectKamar.innerHTML = '<option value="">-- Tidak Memilih Kamar --</option>';

            semuaKamar.forEach(kamar => {
                if (kamar.status_kamar === 'Kosong' || kamar.id == kamarIdSaatIni) {
                    let option = document.createElement('option');
                    option.value = kamar.id;
                    option.text = `Kamar ${kamar.nomor_kamar} (${kamar.jenis_kamar})`;
                    if (kamar.id == kamarIdSaatIni) option.selected = true;
                    selectKamar.appendChild(option);
                }
            });

            document.getElementById('modalEditPenghuni').classList.remove('hidden');
        }

        function bukaModalHapus(id, nama, usia, kamar) {
            document.getElementById('formHapusPenghuni').action = '/admin/hapus_penghuni/' + id;
            document.getElementById('hapus_nama').value = nama;
            document.getElementById('hapus_usia').value = usia;
            document.getElementById('hapus_kamar').value = kamar;
            document.getElementById('modalHapus').classList.remove('hidden');
        }

        function tutupModal(modalId) { 
            document.getElementById(modalId).classList.add('hidden'); 
        }

        function filterTabelGender() {
            const filterValue = document.getElementById('filterGender').value;
            const rows = document.querySelectorAll('.penghuni-row');
            rows.forEach(row => {
                const gender = row.getAttribute('data-gender');
                row.style.display = (filterValue === 'Semua' || filterValue === gender) ? '' : 'none';
            });
        }
    </script>
@endsection