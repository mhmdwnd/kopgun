<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Kopgun</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased min-h-screen flex">

    {{-- Sisi Kiri: Branding --}}
    <div class="hidden lg:flex lg:w-1/2 bg-[#1a1a2e] flex-col justify-between p-12">
       <div class="flex items-center gap-3">
       <div class="w-16 h-16 rounded-lg bg-white/10 flex items-center justify-center p-3">
        <img src="{{ asset('images/kopgun-logo-icon.png') }}" alt="Kopgun" class="w-full h-full object-contain">
    </div>
        <span class="text-white font-semibold text-[15px]">Kopgun</span>
    </div>

        <div>
            <h1 class="text-white text-3xl font-semibold leading-snug mb-4">
               Coffee, Friends, Family.
            </h1>
            <p class="text-white/50 text-[14px] leading-relaxed max-w-sm">
                Sistem pemesanan menu terintegrasi untuk admin dan kasir Kopgun.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-white/20"></div>
            <div class="w-2 h-2 rounded-full bg-white/40"></div>
            <div class="w-6 h-2 rounded-full bg-white/70"></div>
        </div>
    </div>

    {{-- Sisi Kanan: Form --}}
    <div class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-sm">
            {{-- Logo Mobile --}}
            <div class="flex justify-center mb-8 lg:hidden">
    <img src="{{ asset('images/kopgun-logo-full.png') }}" alt="Kopgun" class="h-28 w-auto object-contain">
</div>      
                            <div class="mb-7">
                <h2 class="text-[22px] font-semibold text-gray-900">Selamat datang</h2>
                <p class="text-[13px] text-gray-400 mt-1">Masuk ke panel manajemen Kopgun</p>
            </div>

            @if (session('status'))
                <div class="flex items-center gap-2 bg-green-50 border border-green-100 text-green-700 text-[12px] px-3.5 py-2.5 rounded-lg mb-5">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-[12px] font-medium text-gray-600 mb-1.5">Alamat email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        required autofocus autocomplete="username"
                        placeholder="admin@kopgun.id"
                        class="w-full text-[13px] px-3 py-2.5 rounded-lg border
                               {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-white' }}
                               text-gray-800 placeholder-gray-300
                               focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                    @error('email')
                        <p class="text-[11px] text-red-500 mt-1.5 flex items-center gap-1">
                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="text-[12px] font-medium text-gray-600">Kata sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-[11px] text-gray-400 hover:text-[#1a1a2e] transition-colors">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input id="password" type="password" name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full text-[13px] px-3 py-2.5 pr-10 rounded-lg border
                                   {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-white' }}
                                   text-gray-800 placeholder-gray-300
                                   focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 hover:text-gray-500 transition-colors">
                            <svg id="icon-eye" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="icon-eye-off" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-[11px] text-red-500 mt-1.5 flex items-center gap-1">
                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center gap-2">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="w-3.5 h-3.5 rounded border-gray-300 text-[#1a1a2e]
                               focus:ring-[#1a1a2e] focus:ring-offset-0 cursor-pointer">
                    <label for="remember_me" class="text-[12px] text-gray-500 cursor-pointer select-none">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-[#1a1a2e] hover:bg-[#2a2a42]
                           text-white text-[13px] font-medium py-2.5 rounded-lg transition-colors mt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Masuk
                </button>
            </form>

            <p class="text-center text-[11px] text-gray-300 mt-8">
                &copy; {{ date('Y') }} Kopgun. Sistem manajemen kafe.
            </p>

        </div>
    </div>

</body>
<script>
    function togglePassword() {
        const input  = document.getElementById('password');
        const eyeOn  = document.getElementById('icon-eye');
        const eyeOff = document.getElementById('icon-eye-off');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        eyeOn.classList.toggle('hidden', isHidden);
        eyeOff.classList.toggle('hidden', !isHidden);
    }
</script>
</html>