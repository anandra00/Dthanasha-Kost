<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dthanasha Kost</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <!-- Panggil Vite buat nge-load Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-cursive { font-family: 'Great Vibes', cursive; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-cover bg-center flex items-center justify-center relative" style="background-image: url('https://images.unsplash.com/photo-1554995207-c18c203602cb?q=80&w=2070&auto=format&fit=crop');"> 

    <div class="absolute inset-0 bg-white/20 backdrop-blur-[2px]"></div>

    <div class="relative z-10 bg-white w-[90%] max-w-sm py-16 px-8 flex flex-col items-center shadow-2xl">
        <h1 class="font-cursive text-6xl mb-2 text-black tracking-wide">Welcome</h1>
        <h2 class="text-xl font-bold mb-8 text-black uppercase tracking-tight">Dthanasha Kost</h2>

        <!-- Session Status (Misal abis reset password) -->
        <x-auth-session-status class="mb-4 text-xs font-bold text-green-600 text-center" :status="session('status')" />

        <form action="{{ route('login') }}" method="POST" class="w-full flex flex-col items-center">
            @csrf 
            
            <div class="w-full max-w-[250px] mb-4">
                <label for="login" class="block text-[11px] font-bold text-black mb-1 ml-3">Username</label>
                <!-- Tambahin value old('username') biar inputan gak ilang kalo salah password -->
                <input type="text" id="login" name="login" value="{{ old('username') }}" required autofocus autocomplete="username" class="w-full bg-black text-white rounded-full px-6 py-2.5 text-sm outline-none focus:ring-2 focus:ring-gray-300 transition-all">
                <!-- Komponen Error Breeze yang udah disesuaikan ukurannya -->
                <x-input-error :messages="$errors->get('login')" class="mt-1 ml-3 text-[10px] text-red-500 font-bold" />
            </div>

            <div class="w-full max-w-[250px] mb-4">
                <label for="password" class="block text-[11px] font-bold text-black mb-1 ml-3">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password" class="w-full bg-black text-white rounded-full px-6 py-2.5 text-sm outline-none focus:ring-2 focus:ring-gray-300 transition-all">
                <x-input-error :messages="$errors->get('password')" class="mt-1 ml-3 text-[10px] text-red-500 font-bold" />
            </div>

            <!-- Fitur Remember Me bawaan Breeze gua adaptasi ke style lu -->
            <div class="w-full max-w-[250px] flex items-center mb-8 ml-3">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-400 text-black focus:ring-black bg-gray-100" name="remember">
                    <span class="ms-2 text-[11px] font-bold text-gray-600">Remember me</span>
                </label>
            </div>

            <button type="submit" class="bg-[#e0e0e0] text-black font-bold text-sm py-2 px-14 rounded-md hover:bg-[#d1d1d1] active:scale-95 transition-all shadow-sm">
                Login
            </button>
        </form>
    </div>
</body>
</html>