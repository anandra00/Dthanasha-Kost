@extends('layouts.penghuni')

@section('title', 'Pembayaran Kost - Dthanasha Kost')
@section('header_title', 'Sisi Penghuni / Pembayaran')

@section('content')
    <!-- Button Tester -->
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl flex gap-4 items-center">
        <p class="text-sm font-bold text-blue-700 flex-1"><i class="ph ph-info text-lg align-middle mr-2"></i> Area Tes Simulasi Callback Gateway:</p>
        <button onclick="bukaModalBerhasil()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition-all shadow-sm">Test Modal Berhasil</button>
        <button onclick="bukaModalGagal()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg transition-all shadow-sm">Test Modal Gagal</button>
    </div>

    <!-- Status Tagihan & Aksi Cepat -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <div class="bg-white p-8 rounded-3xl card-shadow border border-gray-50 flex flex-col justify-between h-72">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 flex items-center gap-2">Status Tagihan Bulan Ini <i class="ph ph-wallet"></i></h3>
                    <div class="flex items-center gap-2 mt-4"><i class="ph ph-calendar-blank text-zinc-400"></i><p class="text-sm font-bold text-zinc-700">Periode : <span class="font-black">April 2026</span></p></div>
                    <div class="flex items-center gap-2 mt-2"><i class="ph ph-clock-countdown text-zinc-400"></i><p class="text-sm font-bold text-zinc-700">Jatuh Tempo : <span class="text-red-500 font-black">10 April 2026</span></p></div>
                </div>
                <span class="bg-red-50 text-red-600 text-[10px] font-black px-3 py-1.5 rounded-lg border border-red-100 uppercase tracking-widest flex items-center gap-1.5"><div class="w-1.5 h-1.5 bg-red-600 rounded-full animate-pulse"></div> Belum Lunas</span>
            </div>
            <div class="mt-auto pt-6 border-t border-zinc-100 flex justify-between items-end">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nominal Tagihan</p>
                    <p class="text-4xl font-black text-red-600">Rp 1.200.000</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl card-shadow border border-gray-50 h-72 flex flex-col justify-center">
            <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide mb-6">Aksi Cepat</h3>
            <div class="flex gap-6 h-full">
                <button id="pay-button" class="flex-1 bg-[#18181B] hover:bg-[#334155] text-white rounded-2xl flex flex-col items-center justify-center gap-3 transition-all active:scale-95 shadow-md">
                    <i class="ph ph-wallet text-3xl"></i>
                    <span class="font-bold text-sm tracking-wide">Bayar Sekarang</span>
                </button>
                <a href="https://wa.me/6281234567890" target="_blank" class="flex-1 bg-zinc-50 hover:bg-zinc-100 text-zinc-900 border border-zinc-200 rounded-2xl flex flex-col items-center justify-center gap-3 transition-all active:scale-95">
                    <i class="ph ph-chat-centered-text text-3xl"></i>
                    <span class="font-bold text-sm tracking-wide text-center px-4">Hubungi Pemilik</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Riwayat Pembayaran -->
    <div class="bg-white rounded-3xl card-shadow border border-gray-50 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-zinc-50/50">
            <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide">Riwayat Pembayaran Anda</h3>
            <i class="ph ph-clock-counter-clockwise text-zinc-400 text-lg"></i>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-zinc-100 text-zinc-500 text-[10px] uppercase tracking-widest border-b border-zinc-200">
                    <tr>
                        <th class="px-6 py-4">Periode Pembayaran</th>
                        <th class="px-6 py-4">Tanggal Pembayaran</th>
                        <th class="px-6 py-4 text-center">Status Pembayaran</th>
                        <th class="px-6 py-4 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    <tr class="hover:bg-zinc-50/80 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">Juni 2026</td>
                        <td class="px-6 py-4 text-sm font-medium text-zinc-600">-</td>
                        <td class="px-6 py-4 text-center"><span class="text-amber-500 font-bold text-sm">Belum Lunas</span></td>
                        <td class="px-6 py-4 text-sm font-black text-zinc-900 text-right">Rp 1.000.000</td>
                    </tr>
                    <tr class="hover:bg-zinc-50/80 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">Mei 2026</td>
                        <td class="px-6 py-4 text-sm font-medium text-zinc-600">1 Mei 2026</td>
                        <td class="px-6 py-4 text-center"><span class="text-green-500 font-bold text-sm">Lunas</span></td>
                        <td class="px-6 py-4 text-sm font-black text-zinc-900 text-right">Rp 1.000.000</td>
                    </tr>
                    <tr class="hover:bg-zinc-50/80 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">April 2026</td>
                        <td class="px-6 py-4 text-sm font-medium text-zinc-600">1 April 2026</td>
                        <td class="px-6 py-4 text-center"><span class="text-green-500 font-bold text-sm">Lunas</span></td>
                        <td class="px-6 py-4 text-sm font-black text-zinc-900 text-right">Rp 1.000.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modals -->
    <div id="modalBerhasil" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-95 transition-all text-center">
            <h2 class="text-xl font-black text-gray-900 mb-6">Pembayaran Berhasil</h2>
            <div class="flex justify-center mb-6"><i class="ph-fill ph-check-circle text-green-600 text-7xl"></i></div>
            <div class="space-y-4 mb-8 text-left bg-zinc-50 p-4 rounded-xl border border-zinc-100">
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Order ID</span><span class="text-sm font-medium text-zinc-700">{{ isset($modalData) ? $modalData->order_id : 'TRX-DUMMY-123' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Periode Pembayaran</span><span class="text-sm font-medium text-zinc-700">{{ isset($modalData) && $modalData->tagihan ? $modalData->tagihan->periode_bulan : 'Juni 2026' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Tanggal Transaksi</span><span class="text-sm font-medium text-zinc-700">{{ isset($modalData) ? \Carbon\Carbon::parse($modalData->created_at)->format('d M Y, H:i') : '1 Juni 2026' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Status Pembayaran</span><span class="text-sm font-bold text-green-600">{{$modalStatus}}</span></div>
                <div class="flex justify-between items-center pt-2 border-t border-zinc-200"><span class="text-sm font-bold text-zinc-900">Nominal</span><span class="text-base font-black text-zinc-900">Rp {{ isset($modalData) && $modalData->tagihan ? number_format($modalData->tagihan->nominal_tagihan, 0, ',', '.') : '1.000.000' }}</span></div>
            </div>
            <button onclick="tutupModal('modalBerhasil')" class="w-full px-4 py-3 rounded-xl bg-zinc-200 text-zinc-700 font-bold hover:bg-zinc-300 transition-all text-sm">Kembali</button>
        </div>
    </div>

    <div id="modalGagal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-95 transition-all text-center">
            <h2 class="text-xl font-black text-gray-900 mb-6">Pembayaran Gagal</h2>
            <div class="flex justify-center mb-6"><i class="ph-fill ph-warning-circle text-red-600 text-7xl"></i></div>
            <div class="space-y-4 mb-8 text-left bg-zinc-50 p-4 rounded-xl border border-zinc-100">
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Order ID</span><span class="text-sm font-medium text-zinc-700">{{ isset($modalData) ? $modalData->order_id : 'TRX-DUMMY-123' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Periode Pembayaran</span><span class="text-sm font-medium text-zinc-700">{{ isset($modalData) && $modalData->tagihan ? $modalData->tagihan->periode_bulan : 'Juni 2026' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Status Pembayaran</span><span class="text-sm font-bold text-red-600">Gagal / Dibatalkan</span></div>
            </div>
            <div class="flex gap-3">
                <button onclick="tutupModal('modalGagal')" class="flex-1 px-4 py-3 rounded-xl bg-zinc-200 text-zinc-700 font-bold hover:bg-zinc-300 transition-all text-sm">Kembali</button>
                <a href="{{ url('/penghuni/pembayaran-manual') }}" class="flex-1 px-4 py-3 rounded-xl bg-blue-500 text-white font-bold hover:bg-blue-600 shadow-md transition-all text-sm active:scale-95 flex items-center justify-center">Pembayaran Manual</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    
    <script>

        function bukaModalBerhasil() { 
            tutupSemuaModal();
            document.getElementById('modalBerhasil').classList.remove('hidden'); 
        }
        function bukaModalGagal() { 
            tutupSemuaModal();
            document.getElementById('modalGagal').classList.remove('hidden'); 
        }
        function tutupModal(id) { 
            document.getElementById(id).classList.add('hidden'); 
        }
        function tutupSemuaModal() {
            document.getElementById('modalBerhasil').classList.add('hidden');
            document.getElementById('modalGagal').classList.add('hidden');
        }
        // LOGIKA AUTO-OPEN MODAL JIKA ADA PARAMETER DARI MIDTRANS
        document.addEventListener('DOMContentLoaded', function() {
            let statusDariUrl = "{{ $modalStatus ?? '' }}";
            console.log("CCTV: Status dari Controller = '" + statusDariUrl + "'");

            if (statusDariUrl === 'success' || statusDariUrl === 'pending') {
                console.log("CCTV: Modal Berhasil harusnya kebuka sekarang!");
                bukaModalBerhasil();
                // MATIIN SEMENTARA BIAR URL BISA KITA BACA
                // window.history.replaceState(null, null, window.location.pathname);
            } else if (statusDariUrl === 'failed') {
                console.log("CCTV: Modal Gagal harusnya kebuka sekarang!");
                bukaModalGagal();
                // MATIIN SEMENTARA BIAR URL BISA KITA BACA
                // window.history.replaceState(null, null, window.location.pathname);
            }
        });

        document.getElementById('pay-button').onclick = async function(e) {
            e.preventDefault();
            
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = 'Sedang memproses...';
            btn.disabled = true;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                const response = await fetch('{{ route('penghuni.proses-bayar') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();
                btn.innerHTML = originalText;
                btn.disabled = false;

                if(data.status === 'success') {
                    // DI SINI KUNCI REDIRECT-NYA BRO!
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result){
                            window.location.href = "{{ route('penghuni.pembayaran') }}?order_id=" + result.order_id + "&status=success";
                        },
                        onPending: function(result){
                            window.location.href = "{{ route('penghuni.pembayaran') }}?order_id=" + result.order_id + "&status=pending";
                        },
                        onError: function(result){
                            window.location.href = "{{ route('penghuni.pembayaran') }}?order_id=" + result.order_id + "&status=failed";
                        },
                        onClose: function(){
                            alert("Lu nutup popup belom kelar bayar woy!");
                        }
                    });
                } else if (data.status === 'error'){
                    alert(data.message);
                } else {
                    alert("Gagal memproses token, coba lagi.");
                }

            } catch (error) {
                console.error(error);
                alert("Ada gangguan di server nih!");
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        };
    </script>
@endsection