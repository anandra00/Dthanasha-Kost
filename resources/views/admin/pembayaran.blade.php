@extends('layouts.admin')

@section('title', 'Pembayaran - Dthanasha Kost')
@section('search_placeholder', 'Cari nama penghuni atau nomor kamar...')

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6 mb-8 md:mb-10 w-full">
        
        <div class="bg-white p-4 md:p-6 rounded-xl md:rounded-2xl card-shadow border border-zinc-50 flex items-center justify-between group transition-all">
            <div>
                <p class="text-[10px] md:text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5 md:mb-1">Sudah Membayar</p>
                <p class="text-xl md:text-3xl font-black text-zinc-900">{{ $sudahMembayar }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-zinc-100 rounded-lg md:rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors shrink-0">
                <i class="ph-fill ph-check-circle text-lg md:text-2xl text-emerald-500"></i>
            </div>
        </div>

        <div class="bg-white p-4 md:p-6 rounded-xl md:rounded-2xl card-shadow border border-zinc-50 flex items-center justify-between group transition-all">
            <div>
                <p class="text-[10px] md:text-[11px] font-bold text-zinc-400 uppercase tracking-widest mb-0.5 md:mb-1">Menunggu</p>
                <p class="text-xl md:text-3xl font-black text-zinc-900">{{ $menungguKonfirmasi }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-zinc-100 rounded-lg md:rounded-xl flex items-center justify-center border border-zinc-200 group-hover:bg-zinc-200 transition-colors shrink-0">
                <i class="ph-fill ph-clock-countdown text-lg md:text-2xl text-amber-500"></i>
            </div>
        </div>

        <div class="col-span-2 lg:col-span-1 bg-white p-4 md:p-6 rounded-xl md:rounded-2xl card-shadow border border-red-50 flex items-center justify-between group transition-all hover:border-red-100">
            <div>
                <p class="text-[10px] md:text-[11px] font-bold text-red-400 uppercase tracking-widest mb-0.5 md:mb-1">Belum Membayar</p>
                <p class="text-xl md:text-3xl font-black text-red-600">{{ $belumMembayar }}</p>
            </div>
            <div class="w-10 h-10 md:w-14 md:h-14 bg-red-50 rounded-lg md:rounded-xl flex items-center justify-center border border-red-100 group-hover:bg-red-100 transition-colors shrink-0">
                <i class="ph-fill ph-warning-circle text-lg md:text-2xl text-red-500"></i>
            </div>
        </div>

    </div>

    <div class="flex items-center gap-4 mb-8">
        <select class="px-5 py-2.5 rounded-xl border border-zinc-200 bg-white text-sm font-semibold outline-none card-shadow cursor-pointer text-zinc-700 focus:ring-2 focus:ring-[#334155]">
            <option>Semua Status</option>
            <option>Lunas</option>
            <option>Menunggu Konfirmasi</option>
            <option>Belum Lunas</option>
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($tagihans as $tagihan)
        @php
            $namaPenghuni = $tagihan->penghuni?->nama_penghuni ?? 'Unknown';
            $nomorKamar = $tagihan->penghuni?->kamar?->nomor_kamar ?? '-';
            $urlBuktiJS = $tagihan->bukti_transfer ? asset('storage/' . $tagihan->bukti_transfer) : '';
        @endphp
        
        <div class="bg-white w-full rounded-[1.25rem] p-5 card-shadow border border-zinc-100 flex flex-col gap-5 hover:shadow-lg hover:border-zinc-200 transition-all group">
            <div class="flex justify-between items-start">
                <div class="bg-[#18181B] text-white w-[65px] h-[65px] rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm tracking-wide">
                    {{ $nomorKamar }}
                </div>
                <div class="text-right flex flex-col items-end">
                    <p class="text-[15px] font-bold text-zinc-900 mb-1 group-hover:text-[#334155] transition-colors">{{ $namaPenghuni }}</p>
                    <span class="text-[10px] font-black uppercase tracking-widest text-zinc-500 bg-zinc-100 px-2.5 py-1 rounded-lg">{{ $tagihan->periode_bulan }}</span>
                </div>
            </div>

            <div class="flex justify-between items-center text-sm">
                <span class="font-medium text-zinc-500">Nominal</span>
                <span class="font-black text-zinc-900">Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</span>
            </div>

            @if($tagihan->jatuh_tempo)
            <div class="flex justify-between items-center text-sm">
                <span class="font-medium text-zinc-500">Jatuh Tempo</span>
                <span class="font-bold text-zinc-700">{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->translatedFormat('d M Y') }}</span>
            </div>
            @endif

            <div class="mt-auto pt-2">
                @if($tagihan->status_tagihan == 'Belum Lunas')
                    <button onclick="bukaModalKonfirmasi({{ $tagihan->id }}, '{{ addslashes($namaPenghuni) }}', '{{ $nomorKamar }}', 'Belum Lunas', '{{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}', '{{ $urlBuktiJS }}')" class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-xl w-full text-sm shadow-md transition-all active:scale-95 flex justify-center items-center gap-2">
                        <i class="ph-fill ph-warning-circle text-lg"></i> Belum Lunas
                    </button>
                @elseif($tagihan->status_tagihan == 'Menunggu Konfirmasi')
                    <button onclick="bukaModalKonfirmasi({{ $tagihan->id }}, '{{ addslashes($namaPenghuni) }}', '{{ $nomorKamar }}', 'Menunggu Konfirmasi', '{{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}', '{{ $urlBuktiJS }}')" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-xl w-full text-sm shadow-md transition-all active:scale-95 flex justify-center items-center gap-2">
                        <i class="ph-fill ph-clock-countdown text-lg"></i> Menunggu Konfirmasi
                    </button>
                @else
                    <button onclick="bukaModalKonfirmasi({{ $tagihan->id }}, '{{ addslashes($namaPenghuni) }}', '{{ $nomorKamar }}', 'Lunas', '{{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}', '{{ $urlBuktiJS }}')" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 rounded-xl w-full text-sm shadow-md transition-all active:scale-95 flex justify-center items-center gap-2">
                        <i class="ph-fill ph-check-circle text-lg"></i> Lunas
                    </button>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-10">
            <p class="text-zinc-500 font-medium">Belum ada data tagihan.</p>
        </div>
        @endforelse
    </div>

    <div id="modalKonfirmasi" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-95 transition-all max-h-[90vh] overflow-y-auto no-scrollbar relative">
            
            <button type="button" onclick="tutupModal('modalKonfirmasi')" class="absolute top-6 right-6 text-zinc-400 hover:text-zinc-900 transition-colors">
                <i class="ph ph-x text-xl font-bold"></i>
            </button>

            <h2 id="modal_judul" class="text-xl font-black text-zinc-900 mb-6 text-center uppercase tracking-wide">Detail Tagihan</h2>
            
            <form id="formPembayaran" method="POST" class="space-y-5">
                @csrf
                
                <div class="bg-zinc-50 p-5 rounded-2xl border border-zinc-100 space-y-3">
                    <div class="flex justify-between items-center border-b border-zinc-200 pb-2">
                        <span class="text-xs font-bold text-zinc-500 uppercase">Nama</span>
                        <span id="text_nama" class="text-sm font-black text-zinc-900"></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-zinc-200 pb-2">
                        <span class="text-xs font-bold text-zinc-500 uppercase">Kamar</span>
                        <span id="text_kamar" class="text-sm font-black text-zinc-900 bg-zinc-200 px-2 py-0.5 rounded"></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-zinc-200 pb-2">
                        <span class="text-xs font-bold text-zinc-500 uppercase">Nominal</span>
                        <span id="text_nominal" class="text-sm font-black text-zinc-900"></span>
                    </div>
                </div>

                <div id="area_link_bukti" class="hidden">
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Bukti Transfer (Klik untuk melihat)</label>
                    <a id="btn_link_bukti" href="#" target="_blank" class="w-full flex items-center justify-between px-4 py-3 bg-white border border-zinc-200 hover:bg-zinc-50 hover:border-zinc-300 rounded-xl transition-all group/btn active:scale-95">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="w-8 h-8 bg-zinc-100 border border-zinc-200 rounded-lg flex items-center justify-center text-zinc-500 group-hover/btn:text-zinc-900 transition-colors shrink-0">
                                <i class="ph ph-image text-lg"></i>
                            </div>
                            <span id="text_nama_file" class="text-[12px] font-bold text-zinc-600 truncate group-hover/btn:text-zinc-900 transition-colors">
                            </span>
                        </div>
                        <i class="ph ph-arrow-up-right text-zinc-400 group-hover/btn:text-zinc-900 transition-colors shrink-0 text-sm"></i>
                    </a>
                </div>

                <div id="area_no_bukti" class="hidden">
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Lampiran Bukti</label>
                    <div class="w-full px-4 py-3 bg-zinc-50 border border-zinc-100 rounded-xl flex items-center gap-3 text-zinc-400">
                        <i class="ph ph-file-dashed text-lg"></i>
                        <span class="text-[12px] font-medium">Tidak ada lampiran diunggah.</span>
                    </div>
                </div>

                <div id="area_edit_status">
                    <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Ubah Status Pembayaran</label>
                    <select id="modal_status" name="status_tagihan" class="w-full px-4 py-3.5 rounded-xl bg-white border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-[#18181B] transition-all text-sm font-bold text-zinc-900 cursor-pointer">
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>

                <div id="modal_action_buttons" class="flex flex-col gap-3 pt-4 border-t border-zinc-100">
                    </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function bukaModalKonfirmasi(id, nama, kamar, status, nominal, urlBukti) { 
            // 1. Set URL Form
            document.getElementById('formPembayaran').action = '/admin/proses_pembayaran/' + id;
            
            // 2. Isi teks statis
            document.getElementById('text_nama').innerText = nama;
            document.getElementById('text_kamar').innerText = kamar;
            document.getElementById('text_nominal').innerText = 'Rp ' + nominal;
            
            // 3. Set Dropdown Status ke posisi saat ini
            const selectStatus = document.getElementById('modal_status');
            selectStatus.value = status;
            
            // 4. KACAMATA SKEPTIS: Atur Tampilan Tombol Link di Dalem Modal
            const areaLink = document.getElementById('area_link_bukti');
            const areaNoLink = document.getElementById('area_no_bukti');
            const btnLink = document.getElementById('btn_link_bukti');
            const textNamaFile = document.getElementById('text_nama_file');
            
            if (urlBukti && urlBukti !== '') {
                areaLink.classList.remove('hidden');
                areaNoLink.classList.add('hidden');
                btnLink.href = urlBukti;
                
                // Ambil nama filenya aja dari ujung URL
                const fileName = urlBukti.substring(urlBukti.lastIndexOf('/') + 1);
                textNamaFile.innerText = fileName;
            } else {
                areaLink.classList.add('hidden');
                areaNoLink.classList.remove('hidden');
            }

            // 5. Atur Tombol berdasarkan Status Awal
            const actionContainer = document.getElementById('modal_action_buttons');
            const areaEditStatus = document.getElementById('area_edit_status');
            const urlNotif = "{{ url('/kirim_notifikasi') }}";

            if (status === 'Lunas') {
                document.getElementById('modal_judul').innerText = "Rincian Tagihan Lunas";
                areaEditStatus.classList.add('hidden');
                actionContainer.innerHTML = `
                    <button type="button" onclick="tutupModal('modalKonfirmasi')" class="w-full px-4 py-3.5 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide">
                        Tutup Jendela
                    </button>
                `;
            } else {
                document.getElementById('modal_judul').innerText = "Validasi Pembayaran";
                areaEditStatus.classList.remove('hidden');
                actionContainer.innerHTML = `
                    <button type="submit" class="w-full px-4 py-3.5 rounded-xl bg-emerald-500 text-white font-bold hover:bg-emerald-600 shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide flex items-center justify-center gap-2">
                        <i class="ph ph-floppy-disk text-lg"></i> Simpan Perubahan Status
                    </button>
                    <button type="button" 
                        onclick="window.location.href='${urlNotif}'" 
                        onclick="if(this.form.checkValidity()){ this.innerHTML='<i class=\'ph ph-spinner animate-spin text-lg\'></i> Menyimpan...'; this.classList.remove('hover:bg-[#334155]', 'active:scale-95'); this.disabled=true; this.form.submit(); }
                        class="w-full px-4 py-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 font-bold hover:bg-amber-100 transition-all active:scale-95 flex items-center justify-center gap-2 text-xs uppercase tracking-widest mt-1">
                        <i class="ph-fill ph-bell-ringing text-lg"></i> Kirim Notifikasi Tagihan
                    </button>
                `;
            }

            // 6. Buka Modalnya!
            document.getElementById('modalKonfirmasi').classList.remove('hidden'); 
        }

        function tutupModal(modalId) { 
            document.getElementById(modalId).classList.add('hidden'); 
        }
    </script>
@endsection