<div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4 animate-fade-in">
    <div class="w-20 h-20 bg-zinc-100 rounded-3xl flex items-center justify-center mb-6 border border-zinc-200 shadow-inner">
        <i class="ph ph-lock-key text-4xl text-zinc-900 font-bold"></i>
    </div>
    
    <h2 class="text-2xl font-black text-gray-900 mb-3 uppercase tracking-wider">Akses Ditangguhkan</h2>
    
    <p class="text-sm text-zinc-500 font-medium mb-10 max-w-sm mx-auto leading-relaxed">
        Sistem mendeteksi adanya tagihan yang belum diselesaikan. Silakan lunasi tunggakan untuk membuka kembali akses fitur dashboard.
    </p>
    
    <div class="flex flex-col sm:flex-row gap-4 w-full justify-center max-w-md">
        <a href="{{ route('penghuni.pembayaran') }}" class="flex-1 px-6 py-4 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide flex justify-center items-center gap-3">
            <i class="ph ph-wallet text-lg"></i>
            <span>Bayar Sekarang</span>
        </a>
        
        <button type="button" onclick="document.getElementById('modalKeluhan').classList.remove('hidden')" class="flex-1 w-full px-6 py-4 rounded-xl bg-white border border-zinc-200 text-zinc-600 font-bold hover:bg-zinc-50 transition-all text-sm uppercase tracking-wide flex justify-center items-center gap-3 active:scale-95">
            <i class="ph ph-whatsapp-logo text-lg text-zinc-700"></i>
            <span>Hubungi Owner</span>
        </button>
    </div>
</div>

<x-modal-keluhan />