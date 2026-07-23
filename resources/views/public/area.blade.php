<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area — Kopgun</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased text-gray-900">

{{-- ======================== NAV ======================== --}}
<nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-sm border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-4 lg:px-8 h-16 flex items-center justify-between">
        <a href="{{ route('menu.public') }}" class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-[#1A1A2E] flex items-center justify-center flex-shrink-0 p-1">
                <img src="{{ asset('images/kopgun-logo-icon.png') }}" alt="Kopgun" class="w-full h-full object-contain">
            </div>
            <span class="font-extrabold text-[16px] tracking-tight">KOPGUN</span>
        </a>
        <div class="flex items-center gap-6 text-[12px] font-semibold uppercase tracking-wider text-gray-500">
            <a href="{{ route('menu.public') }}" class="hover:text-[#2C4870] transition-colors">Menu</a>
            <a href="{{ route('event.public') }}" class="text-[#2C4870]">Event</a>
            <a href="{{ route('area.public') }}" class="hover:text-[#2C4870] transition-colors">Area</a>
        </div>
    </div>
</nav>

<section class="max-w-6xl mx-auto px-4 md:px-8 py-14">
    <h1 class="text-2xl md:text-3xl font-extrabold text-center tracking-tight mb-10">AREA KOPGUN</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($areas as $area)
            <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                <img src="{{ asset('storage/' . $area->foto) }}" class="w-full aspect-video object-cover">
                @if($area->deskripsi)
                    <div class="p-4">
                        <p class="text-[13px] text-gray-600 leading-relaxed">{{ $area->deskripsi }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-[13px] text-gray-400">Belum ada area yang tersedia saat ini.</div>
        @endforelse
    </div>
</section>

<footer class="bg-[#1A1A2E] text-white py-8 mt-10">
    <p class="text-center text-[11px] text-white/40">&copy; {{ date('Y') }} Kopgun. Semua hak dilindungi.</p>
</footer>

</body>
</html>