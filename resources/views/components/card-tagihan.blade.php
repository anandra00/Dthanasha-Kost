@props(['tagihan'])

@if($tagihan)
    @php
        // Cek lunas apa nggak
        $isLunas = $tagihan->status_tagihan == 'Lunas';
        
        // Set warna dinamis
        $warnaBadge  = $isLunas ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100';
        $warnaTitik  = $isLunas ? 'bg-green-600' : 'bg-red-600';
        $warnaTeks   = $isLunas ? 'text-green-600' : 'text-red-600';
        $warnaTempo  = $isLunas ? 'text-green-500' : 'text-red-500';
    @endphp

    <div class="bg-white p-8 rounded-3xl card-shadow border border-gray-50 flex flex-col justify-between h-72">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 flex items-center gap-2">Status Tagihan Bulan Ini <i class="ph ph-wallet"></i></h3>
                <div class="flex items-center gap-2 mt-4"><i class="ph ph-calendar-blank text-zinc-400"></i><p class="text-sm font-bold text-zinc-700">Periode : <span class="font-black">{{ $tagihan->periode_bulan }}</span></p></div>
                <div class="flex items-center gap-2 mt-2"><i class="ph ph-clock-countdown text-zinc-400"></i><p class="text-sm font-bold text-zinc-700">Jatuh Tempo : <span class="{{ $warnaTempo }} font-black">{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d M Y') }}</span></p></div>
            </div>
            
            <span class="{{ $warnaBadge }} text-[10px] font-black px-3 py-1.5 rounded-lg border uppercase tracking-widest flex items-center gap-1.5">
                <div class="w-1.5 h-1.5 {{ $warnaTitik }} rounded-full animate-pulse"></div> 
                {{ $tagihan->status_tagihan }}
            </span>
        </div>
        <div class="mt-auto pt-6 border-t border-zinc-100 flex justify-between items-end">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nominal Tagihan</p>
                <p class="text-4xl font-black {{ $warnaTeks }}">Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
@else
    <div class="bg-green-50 p-8 rounded-3xl card-shadow border border-green-100 flex flex-col justify-center items-center h-72 text-center">
        <i class="ph-fill ph-check-circle text-6xl text-green-500 mb-4"></i>
        <h3 class="text-lg font-black text-green-800 mb-2">Tagihan tidak ditemukan...</h3>
        <p class="text-sm text-green-600 font-medium">Anda tidak memiliki tagihan aktif bulan ini.</p>
    </div>
@endif