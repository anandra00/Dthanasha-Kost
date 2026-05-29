@props(['modalData', 'modalStatus'])

<div id="modalStatusPembayaran" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center">
    <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-95 transition-all text-center">
        
        @if($modalStatus === 'success')
            <h2 class="text-xl font-black text-gray-900 mb-6">Pembayaran Berhasil</h2>
            <div class="flex justify-center mb-6"><i class="ph-fill ph-check-circle text-green-600 text-7xl"></i></div>
            
            <div class="space-y-4 mb-8 text-left bg-zinc-50 p-4 rounded-xl border border-zinc-100">
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Order ID</span><span class="text-sm font-medium text-zinc-700">{{ $modalData->order_id ?? '-' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Periode Pembayaran</span><span class="text-sm font-medium text-zinc-700">{{ $modalData->nama ?? '-' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Tanggal Transaksi</span><span class="text-sm font-medium text-zinc-700">{{ isset($modalData) ? \Carbon\Carbon::parse($modalData->created_at)->format('d M Y, H:i') : '-' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Status Pembayaran</span><span class="text-sm font-bold text-green-600">Berhasil</span></div>
                <div class="flex justify-between items-center pt-2 border-t border-zinc-200"><span class="text-sm font-bold text-zinc-900">Nominal</span><span class="text-base font-black text-zinc-900">Rp {{ isset($modalData) && $modalData->nominal ? number_format($modalData->nominal, 0, ',', '.') : '-' }}</span></div>
            </div>
            
            <button onclick="window.location.href='{{ route('penghuni.pembayaran') }}'" class="w-full px-4 py-3 rounded-xl bg-zinc-200 text-zinc-700 font-bold hover:bg-zinc-300 transition-all text-sm">Tutup</button>
        
        @elseif($modalStatus === 'pending')
            <h2 class="text-xl font-black text-gray-900 mb-6">Menunggu Pembayaran</h2>
            <div class="flex justify-center mb-6"><i class="ph-fill ph-clock-countdown text-amber-500 text-7xl"></i></div>
            
            <p class="text-sm text-zinc-500 font-medium mb-6 leading-relaxed">
                Segera selesaikan pembayaran.
            </p>

            <div class="space-y-4 mb-8 text-left bg-zinc-50 p-4 rounded-xl border border-zinc-100">
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Order ID</span><span class="text-sm font-medium text-zinc-700">{{ $modalData->order_id ?? '-' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Status</span><span class="text-sm font-bold text-amber-500">Tertunda (Pending)</span></div>
                <div class="flex justify-between items-center pt-2 border-t border-zinc-200"><span class="text-sm font-bold text-zinc-900">Total Tagihan</span><span class="text-base font-black text-zinc-900">Rp {{ isset($modalData) && $modalData->nominal ? number_format($modalData->nominal, 0, ',', '.') : '-' }}</span></div>
            </div>
            
            <button onclick="window.location.href='{{ route('penghuni.pembayaran') }}'" class="w-full px-4 py-3 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all text-sm active:scale-95">Tutup & Cek Status Berkala</button>

        @elseif($modalStatus === 'failed')
            <h2 class="text-xl font-black text-gray-900 mb-6">Pembayaran Gagal</h2>
            <div class="flex justify-center mb-6"><i class="ph-fill ph-warning-circle text-red-600 text-7xl"></i></div>
            
            <div class="space-y-4 mb-8 text-left bg-zinc-50 p-4 rounded-xl border border-zinc-100">
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Order ID</span><span class="text-sm font-medium text-zinc-700">{{ $modalData->order_id ?? '-' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Periode Pembayaran</span><span class="text-sm font-medium text-zinc-700">{{ $modalData->nama ?? '-' }}</span></div>
                <div class="flex justify-between items-center"><span class="text-sm font-bold text-zinc-900">Status</span><span class="text-sm font-bold text-red-600">Gagal / Dibatalkan</span></div>
            </div>
            
            <div class="flex gap-3">
                <button onclick="window.location.href='{{ route('penghuni.pembayaran') }}'" class="flex-1 px-4 py-3 rounded-xl bg-zinc-200 text-zinc-700 font-bold hover:bg-zinc-300 transition-all text-sm">Kembali</button>
                <a href="{{ route('penghuni.pembayaran-manual') }}" class="flex-1 px-4 py-3 rounded-xl bg-blue-500 text-white font-bold hover:bg-blue-600 shadow-md transition-all text-sm active:scale-95 flex items-center justify-center">Bayar Manual</a>
            </div>
        @endif

    </div>
</div>