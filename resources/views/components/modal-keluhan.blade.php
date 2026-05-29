<div id="modalKeluhan" class="fixed inset-0 bg-black/80 backdrop-blur-md z-[100] hidden flex items-center justify-center">
    <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl scale-100 transition-all mx-4 relative">

        <div class="flex">
            <div class="w-16 h-16 bg-zinc-100 rounded-2xl flex items-center justify-center mb-6 border border-zinc-200 shadow-inner">
                <i class="ph ph-chat-teardrop-text text-3xl text-zinc-900 font-bold"></i>
            </div>

            <button type="button" onclick="document.getElementById('modalKeluhan').classList.add('hidden')" class="absolute top-6 right-6 text-zinc-400 hover:text-zinc-900 transition-colors">
                <i class="ph ph-x text-2xl font-bold"></i>
            </button>            
        </div>

        
        <h2 class="text-xl font-black text-gray-900 mb-2 uppercase tracking-wide">Tulis Pesanmu</h2>
        <p class="text-[13px] text-zinc-500 font-medium mb-6 leading-relaxed">
            Sampaikan kendala atau alasan kenapa kamu belum melunasi tagihan bulan ini ke Bapak Kos.
        </p>

        <form action="{{ route('penghuni.submit-keluhan') }}" method="POST" target="_blank" onsubmit="setTimeout(() => document.getElementById('modalKeluhan').classList.add('hidden'), 500)">
            @csrf
            <div class="mb-6">
                <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-widest ml-1 mb-2">Pesan/Alasan</label>
                <textarea name="isi_keluhan" rows="4" placeholder="Cth: Maaf Pak, kiriman dari orang tua saya telat masuk..." class="w-full px-4 py-3.5 rounded-xl bg-zinc-50 border border-zinc-200 focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#18181B] transition-all text-sm font-medium text-zinc-900 resize-none" required></textarea>
            </div>
            
            <button type="submit" class="w-full px-4 py-4 rounded-xl bg-[#18181B] text-white font-bold hover:bg-[#334155] shadow-lg transition-all active:scale-95 text-sm uppercase tracking-wide flex justify-center items-center gap-2">
                <i class="ph ph-paper-plane-tilt text-lg"></i>
                <span>Kirim & Buka WA</span>
            </button>
        </form>
    </div>
</div>