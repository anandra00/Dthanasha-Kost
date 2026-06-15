@extends('layouts.admin')

@section('title', 'Manajemen Keluhan - Dthanasha Kost')
@section('search_placeholder', 'Cari nama penghuni atau isi keluhan...')

@section('content')
    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-8 md:mb-10 w-full">
        
        <div class="bg-white p-4 md:p-6 rounded-xl md:rounded-2xl card-shadow border border-zinc-50 flex items-center justify-between group transition-all">
            <div>
                <p class="text-[10px] md:text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5 md:mb-1">Total Keluhan</p>
                <p class="text-xl md:text-3xl font-black text-zinc-900">{{ $totalKeluhan }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-zinc-100 rounded-lg md:rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors shrink-0">
                <i class="ph ph-chat-teardrop text-lg md:text-2xl text-zinc-600"></i>
            </div>
        </div>

        <div class="bg-white p-4 md:p-6 rounded-xl md:rounded-2xl card-shadow border border-zinc-50 flex items-center justify-between group transition-all hover:border-amber-100">
            <div>
                <p class="text-[10px] md:text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5 md:mb-1">Menunggu</p>
                <p class="text-xl md:text-3xl font-black text-amber-600">{{ $menunggu }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-amber-50 rounded-lg md:rounded-xl flex items-center justify-center border border-amber-100 group-hover:bg-amber-100 transition-colors shrink-0">
                <i class="ph-fill ph-clock-countdown text-lg md:text-2xl text-amber-500"></i>
            </div>
        </div>

        <div class="bg-white p-4 md:p-6 rounded-xl md:rounded-2xl card-shadow border border-zinc-50 flex items-center justify-between group transition-all hover:border-sky-100">
            <div>
                <p class="text-[10px] md:text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5 md:mb-1">Diproses</p>
                <p class="text-xl md:text-3xl font-black text-sky-600">{{ $diproses }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-sky-50 rounded-lg md:rounded-xl flex items-center justify-center border border-sky-100 group-hover:bg-sky-100 transition-colors shrink-0">
                <i class="ph-fill ph-wrench text-lg md:text-2xl text-sky-500"></i>
            </div>
        </div>

        <div class="bg-white p-4 md:p-6 rounded-xl md:rounded-2xl card-shadow border border-zinc-50 flex items-center justify-between group transition-all hover:border-emerald-100">
            <div>
                <p class="text-[10px] md:text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5 md:mb-1">Selesai</p>
                <p class="text-xl md:text-3xl font-black text-emerald-600">{{ $selesai }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-emerald-50 rounded-lg md:rounded-xl flex items-center justify-center border border-emerald-100 group-hover:bg-emerald-100 transition-colors shrink-0">
                <i class="ph-fill ph-check-circle text-lg md:text-2xl text-emerald-500"></i>
            </div>
        </div>

    </div>

    <!-- FILTER & ACTION BAR -->
    <div class="flex items-center gap-4 mb-8">
        <select id="filterStatus" onchange="filterByStatus(this.value)" class="px-5 py-2.5 rounded-xl border border-zinc-200 bg-white text-sm font-semibold outline-none card-shadow cursor-pointer text-zinc-700 focus:ring-2 focus:ring-[#334155]">
            <option value="all" {{ $status == null ? 'selected' : '' }}>Semua Status</option>
            <option value="Menunggu" {{ $status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
            <option value="Diproses" {{ $status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="Selesai" {{ $status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
    </div>

    <!-- KELUHAN CARDS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($keluhans as $keluhan)
            @php
                $namaPenghuni = $keluhan->penghuni?->nama_penghuni ?? 'Unknown';
                $nomorKamar = $keluhan->penghuni?->kamar?->nomor_kamar ?? '-';
                $noWa = $keluhan->penghuni?->no_telepon ?? '';
            @endphp
            
            <div class="bg-white w-full rounded-[1.25rem] p-5 card-shadow border border-zinc-100 flex flex-col gap-5 hover:shadow-lg hover:border-zinc-200 transition-all group searchable-item">
                <div class="flex justify-between items-start">
                    <div class="bg-[#18181B] text-white w-[50px] h-[50px] rounded-2xl flex items-center justify-center font-bold text-lg shadow-sm shrink-0">
                        {{ $nomorKamar }}
                    </div>
                    <div class="text-right flex flex-col items-end min-w-0">
                        <p class="text-[14px] font-bold text-zinc-900 mb-1 group-hover:text-[#334155] transition-colors truncate w-full">{{ $namaPenghuni }}</p>
                        <span class="text-[10px] font-medium text-zinc-400">{{ \Carbon\Carbon::parse($keluhan->tanggal)->translatedFormat('d M Y - H:i') }}</span>
                    </div>
                </div>

                <div class="bg-zinc-50 p-4 rounded-xl border border-zinc-100 flex-1 min-h-[90px] flex flex-col">
                    <p class="text-xs text-zinc-600 font-medium leading-relaxed italic flex-1 break-words">
                        "{{ $keluhan->isi_keluhan }}"
                    </p>
                </div>

                <div class="flex justify-between items-center text-xs border-t border-zinc-100 pt-4 mt-auto">
                    <span class="font-medium text-zinc-400">Status</span>
                    @if($keluhan->status_keluhan == 'Menunggu')
                        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 font-bold rounded-lg border border-amber-200">Menunggu</span>
                    @elseif($keluhan->status_keluhan == 'Diproses')
                        <span class="px-2.5 py-1 bg-sky-50 text-sky-700 font-bold rounded-lg border border-sky-200">Diproses</span>
                    @else
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-lg border border-emerald-200">Selesai</span>
                    @endif
                </div>

                <div class="flex gap-2">
                    @if($noWa)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $noWa) }}" target="_blank" class="w-12 bg-zinc-100 hover:bg-zinc-200 text-zinc-800 rounded-xl flex items-center justify-center border border-zinc-200 transition-all active:scale-95 shadow-sm" title="Hubungi via WhatsApp">
                            <i class="ph ph-whatsapp-logo text-xl"></i>
                        </a>
                    @endif
                    <button onclick="bukaModalKeluhan({{ $keluhan->id }}, '{{ addslashes($namaPenghuni) }}', '{{ $nomorKamar }}', '{{ $keluhan->status_keluhan }}', '{{ addslashes($keluhan->isi_keluhan) }}')" class="flex-1 bg-[#18181B] hover:bg-[#334155] text-white font-bold py-3 rounded-xl text-xs shadow-md transition-all active:scale-95 flex justify-center items-center gap-2">
                        <i class="ph ph-note-pencil text-sm"></i> Detail & Tangani
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-zinc-100 card-shadow">
                <i class="ph ph-chats-teardrop text-4xl text-zinc-300 mb-3"></i>
                <p class="text-zinc-500 font-bold text-sm">Belum ada keluhan yang masuk.</p>
            </div>
        @endforelse
    </div>

    <!-- MODAL DETAIL & TANGANI -->
    <div id="modalKeluhan" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl p-6 sm:p-8 shadow-2xl scale-95 transition-all max-h-[90vh] overflow-y-auto no-scrollbar relative">
            
            <button type="button" onclick="tutupModal('modalKeluhan')" class="absolute top-6 right-6 text-zinc-400 hover:text-zinc-900 transition-colors">
                <i class="ph ph-x text-xl font-bold"></i>
            </button>

            <h2 class="text-xl font-black text-zinc-900 mb-6 text-center uppercase tracking-wide">Detail Keluhan</h2>
            
            <form id="formKeluhan" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                
                <div class="bg-zinc-50 p-5 rounded-2xl border border-zinc-100 space-y-3">
                    <div class="flex justify-between items-center border-b border-zinc-200 pb-2">
                        <span class="text-xs font-bold text-zinc-500 uppercase">Pengirim</span>
                        <span id="text_pengirim" class="text-sm font-black text-zinc-900"></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-zinc-200 pb-2">
                        <span class="text-xs font-bold text-zinc-500 uppercase">Kamar</span>
                        <span id="text_kamar" class="text-sm font-black text-zinc-900 bg-zinc-200 px-2 py-0.5 rounded"></span>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Isi Keluhan</label>
                    <div class="w-full px-4 py-3 bg-zinc-50 border border-zinc-200 rounded-xl">
                        <p id="text_isi" class="text-xs text-zinc-700 leading-relaxed font-semibold break-words"></p>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Tindakan / Status Keluhan</label>
                    <select id="modal_status" name="status_keluhan" class="w-full px-4 py-3.5 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#18181B] transition-all text-sm font-bold text-zinc-900 cursor-pointer">
                        <option value="Menunggu">Menunggu</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                <div class="flex flex-col gap-3 pt-4 border-t border-zinc-100">
                    <button type="submit" class="w-full px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide flex items-center justify-center gap-2">
                        <i class="ph ph-floppy-disk text-lg"></i> Simpan Status Baru
                    </button>
                    <button type="button" onclick="tutupModal('modalKeluhan')" class="w-full px-4 py-3 rounded-xl bg-zinc-100 hover:bg-zinc-200 text-zinc-600 font-bold transition-all text-xs uppercase tracking-widest mt-1">
                        Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function filterByStatus(val) {
            let url = new URL(window.location.href);
            if (val === 'all') {
                url.searchParams.delete('status');
            } else {
                url.searchParams.set('status', val);
            }
            window.location.href = url.toString();
        }

        function bukaModalKeluhan(id, pengirim, kamar, status, isi) {
            document.getElementById('formKeluhan').action = '/admin/keluhan/' + id;
            document.getElementById('text_pengirim').innerText = pengirim;
            document.getElementById('text_kamar').innerText = kamar;
            document.getElementById('text_isi').innerText = '"' + isi + '"';
            document.getElementById('modal_status').value = status;
            document.getElementById('modalKeluhan').classList.remove('hidden');
        }

        function tutupModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Live Search logic (matching layouts.admin search bar if applicable)
        const searchInput = document.getElementById('globalSearchInput'); // selector from main admin layout
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase().trim();
                const items = document.querySelectorAll('.searchable-item');
                
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    if (text.includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    </script>
@endsection
