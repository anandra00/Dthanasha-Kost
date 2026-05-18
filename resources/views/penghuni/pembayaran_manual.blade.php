@extends('layouts.penghuni')

@section('title', 'Pembayaran Manual - Dthanasha Kost')
@section('header_title')
<div class="flex items-center gap-3">
    <a href="{{ route('penghuni.pembayaran') }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-zinc-200 hover:bg-zinc-50 transition-all text-zinc-600">
        <i class="ph ph-arrow-left font-bold"></i>
    </a>
    Sisi Penghuni / Pembayaran Manual
</div>
@endsection

@section('content')
    <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 bg-zinc-900 rounded-xl flex items-center justify-center text-white">
            <i class="ph ph-upload-simple text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-gray-900">Pembayaran Manual</h1>
            <p class="text-sm font-semibold text-zinc-500">Silakan transfer dan unggah bukti pembayaran Anda.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-8">
            <!-- Status Tagihan Saat Ini -->
            <div>
                <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide mb-4 flex items-center gap-2">Status Tagihan Saat Ini <i class="ph ph-wallet text-lg"></i></h3>
                <div class="bg-white p-6 rounded-3xl card-shadow border border-gray-50 flex flex-col justify-between">
                    @if($tagihanSaatIni)
                        <div class="bg-zinc-100/80 border border-zinc-200 text-red-600 font-extrabold text-sm py-3 rounded-xl flex justify-center items-center gap-2 w-full mx-auto mb-6">
                            <div class="w-2 h-2 bg-red-600 rounded-full animate-pulse"></div> Belum Lunas
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 text-sm"><span class="font-bold text-zinc-500 w-28 uppercase tracking-wider text-[11px]">Periode</span><span class="font-bold text-zinc-900">{{ $tagihanSaatIni->periode_bulan }}</span></div>
                            <div class="flex items-center gap-4 text-sm"><span class="font-bold text-zinc-500 w-28 uppercase tracking-wider text-[11px]">Jatuh Tempo</span><span class="font-bold text-zinc-900">{{ $tagihanSaatIni->jatuh_tempo ? \Carbon\Carbon::parse($tagihanSaatIni->jatuh_tempo)->translatedFormat('d M Y') : '-' }}</span></div>
                            <div class="flex items-center gap-4 pt-4 border-t border-zinc-100"><span class="font-bold text-zinc-500 w-28 uppercase tracking-wider text-[11px]">Nominal</span><span class="font-black text-2xl text-red-600">Rp {{ number_format($tagihanSaatIni->nominal_tagihan, 0, ',', '.') }}</span></div>
                        </div>
                    @else
                        <div class="flex justify-center items-center h-full">
                            <p class="text-zinc-500 font-bold text-sm">Tidak ada tagihan yang perlu dibayar.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detail Rekening Tujuan -->
            <div>
                <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide mb-4 flex items-center gap-2">Pembayaran Melalui <i class="ph ph-credit-card text-lg"></i></h3>
                <div class="bg-white rounded-3xl card-shadow border border-gray-50 overflow-hidden">
                    <div class="bg-zinc-100 px-6 py-4 border-b border-zinc-200"><span class="font-black text-zinc-900 uppercase tracking-widest text-xs">Transfer Bank</span></div>
                    <div class="p-6 space-y-4">
                        <div><span class="block text-[11px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Bank Tujuan</span><span class="font-bold text-zinc-900 text-lg">Bank BRI</span></div>
                        <div>
                            <span class="block text-[11px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Nomor Rekening</span>
                            <div class="flex items-center gap-4">
                                <span class="font-black text-zinc-900 text-2xl" id="norek">1234 5678 9012</span>
                                <button onclick="salinRekening()" class="bg-zinc-100 hover:bg-zinc-200 text-zinc-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-zinc-200 transition-all flex items-center gap-1">
                                    <i class="ph ph-copy"></i> <span id="text-salin">Salin</span>
                                </button>
                            </div>
                        </div>
                        <div><span class="block text-[11px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Nama Penerima</span><span class="font-bold text-zinc-900 text-lg">Pemilik Kost Dthanasha</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Upload -->
        <div>
            <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wide mb-4 flex items-center gap-2">Upload Bukti Pembayaran <i class="ph ph-upload-simple text-lg"></i></h3>
            <form action="{{ url('/proses_bayar_manual') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl card-shadow border border-gray-50 flex flex-col h-[calc(100%-2.5rem)]">
                @csrf
                <div class="flex-1 flex flex-col justify-center">
                    <div class="relative w-full h-64 border-2 border-dashed border-zinc-300 bg-zinc-50 rounded-2xl flex flex-col items-center justify-center text-center hover:bg-zinc-100 hover:border-zinc-400 transition-all cursor-pointer group">
                        <input type="file" name="bukti_transfer" id="fileInput" class="absolute inset-0 w-full h-full opacity-0 {{ !$tagihanSaatIni ? 'cursor-not-allowed' : 'cursor-pointer' }} z-10" {{ !$tagihanSaatIni ? 'disabled' : 'required' }} accept=".jpg,.jpeg,.png,.pdf" onchange="tampilkanNamaFile()">
                        <div class="flex flex-col items-center z-0 pointer-events-none" id="upload-content">
                            <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform"><i class="ph ph-plus text-2xl font-bold"></i></div>
                            <p class="text-sm font-bold text-zinc-900">{{ !$tagihanSaatIni ? 'Tidak ada tagihan' : 'Klik atau seret foto bukti transfer ke sini' }}</p>
                            <p class="text-xs font-medium text-zinc-500 mt-2">Format: JPG, PNG, atau PDF (Maks. 5 MB)</p>
                        </div>
                        <div class="flex flex-col items-center z-0 hidden pointer-events-none" id="file-selected">
                            <i class="ph-fill ph-file-image text-green-500 text-4xl mb-2"></i>
                            <p class="text-sm font-bold text-zinc-900" id="file-name">nama_file.jpg</p>
                            <p class="text-xs font-bold text-blue-600 mt-1">Klik untuk mengganti file</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 space-y-3">
                    <button type="submit" class="w-full py-4 rounded-xl {{ !$tagihanSaatIni ? 'bg-zinc-300 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700 active:scale-95' }} text-white font-black text-sm uppercase tracking-wide transition-all shadow-md flex justify-center items-center gap-2" {{ !$tagihanSaatIni ? 'disabled' : '' }}>
                        Konfirmasi Pembayaran <i class="ph ph-check-circle text-lg"></i>
                    </button>
                    <a href="{{ url('/penghuni/pembayaran') }}" class="w-full py-4 rounded-xl bg-zinc-100 hover:bg-zinc-200 text-zinc-600 font-bold text-sm uppercase tracking-wide transition-all flex justify-center items-center">
                        Kembali ke Daftar Tagihan
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function salinRekening() {
            const norek = "123456789012";
            navigator.clipboard.writeText(norek).then(() => {
                const textSalin = document.getElementById('text-salin');
                textSalin.innerText = "Tersalin!";
                textSalin.classList.add("text-green-600");
                setTimeout(() => {
                    textSalin.innerText = "Salin";
                    textSalin.classList.remove("text-green-600");
                }, 2000);
            });
        }

        function tampilkanNamaFile() {
            const input = document.getElementById('fileInput');
            const fileNameDisplay = document.getElementById('file-name');
            const defaultContent = document.getElementById('upload-content');
            const selectedContent = document.getElementById('file-selected');

            if (input.files && input.files.length > 0) {
                fileNameDisplay.innerText = input.files[0].name;
                defaultContent.classList.add('hidden');
                selectedContent.classList.remove('hidden');
            } else {
                defaultContent.classList.remove('hidden');
                selectedContent.classList.add('hidden');
            }
        }
    </script>
@endsection