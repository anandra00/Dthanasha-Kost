@props(['tagihan'])

@if($tagihan)
    @php
        // Ambil status biar ga ngetik panjang-panjang
        $status = $tagihan->status_tagihan;
        
        // Pake match() buat handle 3 kondisi sekaligus, super clean!
        $warnaBadge = match($status) {
            'Lunas'               => 'bg-emerald-50 text-emerald-600 border-emerald-100',
            'Menunggu Konfirmasi' => 'bg-amber-50 text-amber-600 border-amber-100',
            default               => 'bg-red-50 text-red-600 border-red-100', // Belum Lunas
        };
        
        $warnaTitik = match($status) {
            'Lunas'               => 'bg-emerald-600',
            'Menunggu Konfirmasi' => 'bg-amber-500',
            default               => 'bg-red-600',
        };
        
        $warnaTeks = match($status) {
            'Lunas'               => 'text-emerald-600',
            'Menunggu Konfirmasi' => 'text-amber-500',
            default               => 'text-red-600',
        };
        
        $warnaTempo = match($status) {
            'Lunas'               => 'text-emerald-500',
            'Menunggu Konfirmasi' => 'text-amber-500',
            default               => 'text-red-500',
        };
    @endphp

    <div class="bg-white p-8 rounded-3xl card-shadow border border-zinc-50 flex flex-col justify-between h-72">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xs font-bold text-zinc-400 uppercase tracking-widest mb-1 flex items-center gap-2">Status Tagihan Aktif <i class="ph ph-wallet"></i></h3>
                <div class="flex items-center gap-2 mt-4"><i class="ph ph-calendar-blank text-zinc-400"></i><p class="text-sm font-bold text-zinc-700">Periode : <span class="font-black">{{ $tagihan->periode_bulan }}</span></p></div>
                <div class="flex items-center gap-2 mt-2"><i class="ph ph-clock-countdown text-zinc-400"></i><p class="text-sm font-bold text-zinc-700">Jatuh Tempo : <span class="{{ $warnaTempo }} font-black">{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d M Y') }}</span></p></div>
            </div>
            
            <span class="{{ $warnaBadge }} text-[10px] font-black px-3 py-1.5 rounded-lg border uppercase tracking-widest flex items-center gap-1.5 shadow-sm">
                <div class="w-1.5 h-1.5 {{ $warnaTitik }} rounded-full animate-pulse"></div> 
                {{ $status }}
            </span>
        </div>
        <div class="mt-auto pt-6 border-t border-zinc-100 flex justify-between items-end">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-widest mb-1">Nominal Tagihan</p>
                <p class="text-4xl font-black {{ $warnaTeks }}">Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
@else
    <div class="bg-emerald-50 p-8 rounded-3xl card-shadow border border-emerald-100 flex flex-col justify-center items-center h-72 text-center">
        <i class="ph-fill ph-check-circle text-6xl text-emerald-500 mb-4"></i>
        <h3 class="text-lg font-black text-emerald-800 mb-2">Tagihan tidak ditemukan...</h3>
        <p class="text-sm text-emerald-600 font-medium">Anda tidak memiliki tagihan aktif bulan ini.</p>
    </div>
@endif