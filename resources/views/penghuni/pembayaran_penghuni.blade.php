@extends('layouts.penghuni')

@section('title', 'Pembayaran Kost - Dthanasha Kost')
@section('header_title', 'Sisi Penghuni / Pembayaran')

@section('content')
    <!-- Status Tagihan & Aksi Cepat -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <x-card-tagihan :tagihan="$tagihanSaatIni" />

        <div class="bg-white p-8 rounded-3xl card-shadow border border-gray-50 h-72 flex flex-col justify-center">
            <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide mb-6">Aksi Cepat</h3>
            <div class="flex gap-6 h-full">
                @if($tagihanSaatIni)
                    <button id="pay-button" class="flex-1 bg-[#18181B] hover:bg-[#334155] text-white rounded-2xl flex flex-col items-center justify-center gap-3 transition-all active:scale-95 shadow-md">
                        <i class="ph ph-wallet text-3xl"></i>
                        <span class="font-bold text-sm tracking-wide">Bayar Sekarang</span>
                    </button>
                @else
                    <div class="flex-1 bg-zinc-100 text-zinc-400 rounded-2xl flex flex-col items-center justify-center gap-3 border border-zinc-200">
                        <i class="ph-fill ph-check-circle text-3xl"></i>
                        <span class="font-bold text-sm tracking-wide">Tidak Ada Tagihan</span>
                    </div>
                @endif
                <a href="{{ route('penghuni.pembayaran-manual') }}" class="flex-1 bg-zinc-50 hover:bg-zinc-100 text-zinc-900 border border-zinc-200 rounded-2xl flex flex-col items-center justify-center gap-3 transition-all active:scale-95">
                    <i class="ph ph-upload-simple text-3xl"></i>
                    <span class="font-bold text-sm tracking-wide text-center px-4">Bayar Manual</span>
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

        <!-- Desktop Table -->
        <div class="hidden sm:block overflow-x-auto">
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
                    @forelse($riwayatTagihan as $tagihan)
                        <tr class="hover:bg-zinc-50/80 transition-colors">
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $tagihan->periode_bulan }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-zinc-600">{{ $tagihan->tanggal_bayar ? \Carbon\Carbon::parse($tagihan->tanggal_bayar)->translatedFormat('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($tagihan->status_tagihan == 'Lunas')
                                    <span class="bg-green-50 text-green-600 text-[10px] font-black px-2 py-1 rounded-md border border-green-100 uppercase">Lunas</span>
                                @else
                                    <span class="bg-amber-50 text-amber-600 text-[10px] font-black px-2 py-1 rounded-md border border-amber-100 uppercase">{{ $tagihan->status_tagihan }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-black text-zinc-900 text-right">Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm font-medium text-zinc-400">Belum ada riwayat pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="sm:hidden divide-y divide-zinc-100">
            @forelse($riwayatTagihan as $tagihan)
                <div class="p-4">
                    <div class="flex justify-between items-start mb-1">
                        <p class="text-sm font-bold text-gray-900">{{ $tagihan->periode_bulan }}</p>
                        @if($tagihan->status_tagihan == 'Lunas')
                            <span class="bg-green-50 text-green-600 text-[9px] font-black px-2 py-0.5 rounded border border-green-100 uppercase">Lunas</span>
                        @else
                            <span class="bg-amber-50 text-amber-600 text-[9px] font-black px-2 py-0.5 rounded border border-amber-100 uppercase">{{ $tagihan->status_tagihan }}</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <p class="text-xs text-zinc-400">{{ $tagihan->tanggal_bayar ? \Carbon\Carbon::parse($tagihan->tanggal_bayar)->translatedFormat('d M Y') : '-' }}</p>
                        <p class="text-sm font-black text-zinc-900">Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-sm text-zinc-400">Belum ada riwayat.</div>
            @endforelse
        </div>
    </div>

    <!-- Modal Pembayaran Berhasil -->
    <div id="modalBerhasil" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-95 transition-all text-center">
            <h2 class="text-xl font-black text-gray-900 mb-6">Pembayaran Berhasil</h2>
            <div class="flex justify-center mb-6"><i class="ph-fill ph-check-circle text-green-600 text-7xl"></i></div>
            <div class="space-y-4 mb-8 text-left bg-zinc-50 p-4 rounded-xl border border-zinc-100">
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Order ID</span><span class="text-sm font-medium text-zinc-700">{{ isset($modalData) ? $modalData->order_id : '-' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Periode Pembayaran</span><span class="text-sm font-medium text-zinc-700">{{ isset($modalData) && $modalData->tagihan ? $modalData->tagihan->periode_bulan : '-' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Tanggal Transaksi</span><span class="text-sm font-medium text-zinc-700">{{ isset($modalData) ? \Carbon\Carbon::parse($modalData->created_at)->format('d M Y, H:i') : '-' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Status Pembayaran</span><span class="text-sm font-bold text-green-600">{{ ucfirst($modalStatus ?? '') }}</span></div>
                <div class="flex justify-between items-center pt-2 border-t border-zinc-200"><span class="text-sm font-bold text-zinc-900">Nominal</span><span class="text-base font-black text-zinc-900">Rp {{ isset($modalData) && $modalData->tagihan ? number_format($modalData->tagihan->nominal_tagihan, 0, ',', '.') : '-' }}</span></div>
            </div>
            <button onclick="window.location.href='{{ route('penghuni.pembayaran') }}'" class="w-full px-4 py-3 rounded-xl bg-zinc-200 text-zinc-700 font-bold hover:bg-zinc-300 transition-all text-sm">Kembali</button>
        </div>
    </div>

    <!-- Modal Pembayaran Gagal -->
    <div id="modalGagal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-95 transition-all text-center">
            <h2 class="text-xl font-black text-gray-900 mb-6">Pembayaran Gagal</h2>
            <div class="flex justify-center mb-6"><i class="ph-fill ph-warning-circle text-red-600 text-7xl"></i></div>
            <div class="space-y-4 mb-8 text-left bg-zinc-50 p-4 rounded-xl border border-zinc-100">
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Order ID</span><span class="text-sm font-medium text-zinc-700">{{ isset($modalData) ? $modalData->order_id : '-' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Periode Pembayaran</span><span class="text-sm font-medium text-zinc-700">{{ isset($modalData) && $modalData->tagihan ? $modalData->tagihan->periode_bulan : '-' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Status Pembayaran</span><span class="text-sm font-bold text-red-600">Gagal / Dibatalkan</span></div>
            </div>
            <div class="flex gap-3">
                <button onclick="window.location.href='{{ route('penghuni.pembayaran') }}'" class="flex-1 px-4 py-3 rounded-xl bg-zinc-200 text-zinc-700 font-bold hover:bg-zinc-300 transition-all text-sm">Kembali</button>
                <a href="{{ route('penghuni.pembayaran-manual') }}" class="flex-1 px-4 py-3 rounded-xl bg-blue-500 text-white font-bold hover:bg-blue-600 shadow-md transition-all text-sm active:scale-95 flex items-center justify-center">Bayar Manual</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    
    <script>
        function bukaModalBerhasil() { 
            document.getElementById('modalBerhasil').classList.remove('hidden'); 
        }
        function bukaModalGagal() { 
            document.getElementById('modalGagal').classList.remove('hidden'); 
        }
        function tutupModal(id) { 
            document.getElementById(id).classList.add('hidden'); 
        }

        // Auto-open modal dari callback
        document.addEventListener('DOMContentLoaded', function() {
            let statusDariUrl = "{{ $modalStatus ?? '' }}";
            if (statusDariUrl === 'success' || statusDariUrl === 'pending') {
                bukaModalBerhasil();
            } else if (statusDariUrl === 'failed') {
                bukaModalGagal();
            }
        });

        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.onclick = async function(e) {
                e.preventDefault();
                
                const btn = this;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="ph ph-spinner text-3xl animate-spin"></i><span class="font-bold text-sm">Memproses...</span>';
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
                                alert("Pembayaran belum selesai. Silakan coba lagi.");
                            }
                        });
                    } else if (data.status === 'error'){
                        alert(data.message);
                    } else {
                        alert("Gagal memproses token, coba lagi.");
                    }

                } catch (error) {
                    console.error(error);
                    alert("Ada gangguan di server!");
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            };
        }
    </script>
@endsection