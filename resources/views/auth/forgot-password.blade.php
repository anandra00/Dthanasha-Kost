<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Dthanasha Kost</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2230%22 fill=%22%23F59E0B%22/><text y=%22.75em%22 x=%22.18em%22 font-size=%2270%22 font-weight=%22900%22 fill=%22%2309090B%22 font-family=%22Plus Jakarta Sans, sans-serif%22>D</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-cursive { font-family: 'Great Vibes', cursive; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-cover bg-center flex items-center justify-center relative" style="background-image: url('https://images.unsplash.com/photo-1554995207-c18c203602cb?q=80&w=2070&auto=format&fit=crop');">

    <div class="absolute inset-0 bg-white/20 backdrop-blur-[2px]"></div>

    <div class="relative z-10 bg-white w-[90%] max-w-sm py-12 px-8 flex flex-col items-center shadow-2xl">
        <h1 class="font-cursive text-5xl mb-2 text-black tracking-wide">Reset</h1>
        <h2 class="text-lg font-bold mb-4 text-black uppercase tracking-tight">Lupa Password</h2>
        <p class="text-[11px] text-gray-500 text-center mb-6 px-4">Masukkan email yang terdaftar di akun Anda. Kami akan mengirim link untuk reset password.</p>

        <x-auth-session-status class="mb-4 text-xs font-bold text-green-600 text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="w-full flex flex-col items-center">
            @csrf
            <div class="w-full max-w-[250px] mb-6">
                <label for="email" class="block text-[11px] font-bold text-black mb-1 ml-3">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="w-full bg-black text-white rounded-full px-6 py-2.5 text-sm outline-none focus:ring-2 focus:ring-gray-300 transition-all">
                <x-input-error :messages="$errors->get('email')" class="mt-1 ml-3 text-[10px] text-red-500 font-bold" />
            </div>

            <button type="submit" class="bg-[#e0e0e0] text-black font-bold text-sm py-2 px-10 rounded-md hover:bg-[#d1d1d1] active:scale-95 transition-all shadow-sm mb-4">
                Kirim Link Reset
            </button>

            <a href="{{ route('login') }}" class="text-[11px] font-bold text-gray-500 hover:text-black transition-colors">← Kembali ke Login</a>
        </form>
    </div>
</body>
</html>
