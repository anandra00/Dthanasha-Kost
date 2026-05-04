<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pemilik - Dthanasha Kost</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@400;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        .font-cursive { font-family: 'Great Vibes', cursive; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-cover bg-center flex items-center justify-center relative" style="background-image: url('https://images.unsplash.com/photo-1554995207-c18c203602cb?q=80&w=2070&auto=format&fit=crop');"> 
    <div class="absolute inset-0 bg-white/20 backdrop-blur-[2px]"></div>

    <div class="relative z-10 bg-white w-[90%] max-w-sm py-16 px-8 flex flex-col items-center shadow-2xl">
        <h1 class="font-cursive text-6xl mb-2 text-black tracking-wide">Welcome</h1>
        <h2 class="text-xl font-bold mb-12 text-black uppercase tracking-tight">Dthanasha Kost</h2>

        <form action="{{ route('login') }}" method="POST" class="w-full flex flex-col items-center">
            @csrf 
            <div class="w-full max-w-[250px] mb-5">
                <label for="login" class="block text-[11px] font-bold text-black mb-1 ml-3">Username</label>
                <input type="text" id="login" name="login" required autofocus class="w-full bg-black text-white rounded-full px-6 py-2.5 text-sm outline-none focus:ring-2 focus:ring-gray-300 transition-all">
            </div>

            <div class="w-full max-w-[250px] mb-10">
                <label for="password" class="block text-[11px] font-bold text-black mb-1 ml-3">Password</label>
                <input type="password" id="password" name="password" required class="w-full bg-black text-white rounded-full px-6 py-2.5 text-sm outline-none focus:ring-2 focus:ring-gray-300 transition-all">
            </div>

            <button type="submit" class="bg-[#e0e0e0] text-black font-bold text-sm py-2 px-14 rounded-md hover:bg-[#d1d1d1] active:scale-95 transition-all shadow-sm">
                Login
            </button>
        </form>
    </div>
</body>
</html>