<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu — Kopgun</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html { scroll-behavior: smooth; }
        .scroll-hide::-webkit-scrollbar { display: none; }
        .scroll-hide { -ms-overflow-style: none; scrollbar-width: none; }
        section[id] { scroll-margin-top: 5rem; }
    </style>
</head>
<body class="bg-white font-sans antialiased text-gray-900">
{{-- ======================== NAV ======================== --}}
<nav id="main-nav" class="fixed top-0 left-0 right-0 z-40 bg-transparent transition-colors duration-300">
    <div class="max-w-6xl mx-auto px-4 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-[#1A1A2E] flex items-center justify-center flex-shrink-0 p-1">
                <img src="{{ asset('images/kopgun-logo-icon.png') }}" alt="Kopgun" class="w-full h-full object-contain">
            </div>
            <span id="nav-brand-text" class="font-extrabold text-[16px] tracking-tight text-white drop-shadow transition-colors duration-300">KOPGUN</span>
        </div>

        {{-- MENU DESKTOP & SEARCH BAR --}}
        <div class="hidden md:flex items-center gap-7 text-[12px] font-semibold uppercase tracking-wider">
            @if(!$weatherData['is_offline'] && $menuRekomendasi->isNotEmpty())
                <a href="#rekomendasi" class="nav-link text-white/90 drop-shadow hover:text-[#2C4870] transition-colors">Rekomendasi</a>
            @endif
            <a href="#menu-reguler" class="nav-link text-white/90 drop-shadow hover:text-[#2C4870] transition-colors">Menu</a>
            <a href="#retail" class="nav-link text-white/90 drop-shadow hover:text-[#2C4870] transition-colors">Retail</a>
            <span id="nav-divider" class="w-px h-4 bg-white/30 transition-colors duration-300"></span>
            <a href="#" class="nav-link text-white/90 drop-shadow hover:text-[#2C4870] transition-colors">Kontak</a>
            <a href="{{ route('event.public') }}" class="nav-link text-white/90 drop-shadow hover:text-[#2C4870] transition-colors">Event</a>
            <a href="{{ route('area.public') }}" class="nav-link text-white/90 drop-shadow hover:text-[#2C4870] transition-colors">Area</a>
            
            {{-- Search Bar Desktop --}}
            {{-- Search Bar Desktop --}}
            <div class="relative group flex items-center ml-2">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="search-desktop" oninput="jalankanFilterPencarian(this.value)" placeholder="Cari menu..." class="w-32 lg:w-48 text-[12px] pl-9 pr-3 py-1.5 rounded-full bg-white/90 border border-transparent text-gray-900 placeholder-gray-400 focus:bg-white focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#2C4870]/20 transition-all duration-300 backdrop-blur-md shadow-sm">
            </div>
        </div>

        <button onclick="toggleMobileNav()" id="nav-hamburger" class="md:hidden text-white drop-shadow transition-colors duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- MENU MOBILE --}}
    <div id="mobile-nav" class="hidden md:hidden border-t border-gray-100 px-4 py-3 space-y-1 bg-white">
        {{-- Search Bar Mobile --}}
        <div class="relative mb-3 mt-1">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="search-mobile" oninput="jalankanFilterPencarian(this.value)" placeholder="Cari menu atau biji kopi..." class="w-full text-[12px] pl-9 pr-3 py-2.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 focus:outline-none focus:border-[#2C4870] transition-colors">
        </div>
        
        @if(!$weatherData['is_offline'] && $menuRekomendasi->isNotEmpty())
            <a href="#rekomendasi" onclick="toggleMobileNav()" class="block py-2 text-[12px] font-semibold uppercase tracking-wider text-gray-600">Rekomendasi</a>
        @endif
        <a href="#menu-reguler" onclick="toggleMobileNav()" class="block py-2 text-[12px] font-semibold uppercase tracking-wider text-gray-600">Menu</a>
        <a href="#retail" onclick="toggleMobileNav()" class="block py-2 text-[12px] font-semibold uppercase tracking-wider text-gray-600">Retail</a>
        <div class="h-px bg-gray-100 my-1"></div>
        <a href="{{ route('event.public') }}" class="block py-2 text-[12px] font-semibold uppercase tracking-wider text-gray-600">Event</a>
        <a href="{{ route('area.public') }}" class="block py-2 text-[12px] font-semibold uppercase tracking-wider text-gray-600">Area</a>
    </div>
</nav>
{{-- ======================== HERO  ======================== --}}
<section class="relative overflow-hidden min-h-[600px] md:min-h-[720px] lg:min-h-[820px] flex items-center">

    <img src="{{ asset('images/kopgun-hero.jpg') }}"
         alt="Suasana teras Kopgun Coffee dengan pemandangan gunung"
         class="absolute inset-0 w-full h-full object-cover object-[center_32%]">

    <div class="absolute inset-0 bg-gradient-to-r from-[#101F36]/75 via-[#1A2E4A]/45 to-[#1A2E4A]/15"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 md:px-8 pt-24 pb-14 md:pt-28 md:pb-20 w-full">

        <div class="max-w-xl">

            <div class="w-10 h-0.5 bg-white/70 mb-4"></div>

            <p class="text-[13px] font-bold uppercase tracking-[0.2em] text-white/90 mb-1 flex items-center gap-2 drop-shadow">
                <span class="w-1.5 h-1.5 rounded-full {{ $weatherData['is_offline'] ? 'bg-amber-400 animate-pulse' : 'bg-emerald-400' }}"></span>
                @if(!$weatherData['is_offline'])
                    {{ $weatherData['suhu'] }}°C DI BANDUNG
                @else
                    MODE OFFLINE
                @endif
            </p>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.05] tracking-tight text-white drop-shadow-md">
                @if(!$weatherData['is_offline'])
                    @if($weatherData['rekomendasi_suhu'] === 'panas')
                        SAATNYA<br>YANG HANGAT
                    @else
                        SAATNYA<br>YANG DINGIN
                    @endif
                @else
                    MENU<br>ANDALAN KAMI
                @endif
            </h1>
            <p class="mt-5 max-w-md text-[14px] text-white/95 leading-relaxed drop-shadow">

                Menu Kopgun menyesuaikan diri dengan cuaca hari ini, supaya kamu selalu dapat rekomendasi yang paling pas untuk dinikmati.
            </p>

            <div class="mt-9 flex flex-wrap items-center gap-3">
                @if(!$weatherData['is_offline'] && $menuRekomendasi->isNotEmpty())
                    <a href="#rekomendasi" class="inline-block px-6 py-3 bg-[#2C4870] text-white rounded text-[12px] font-bold uppercase tracking-wider hover:bg-[#233A5C] transition-colors shadow-lg">
                        Lihat Rekomendasi
                    </a>
                @endif
                <a href="#menu-reguler" class="inline-block px-6 py-3 border border-white text-white rounded text-[12px] font-bold uppercase tracking-wider hover:bg-white hover:text-[#1A2E4A] transition-colors">
                    Menu Lengkap
                </a>
            </div>
        </div>
    </div>
</section>
{{-- ======================== REKOMENDASI ======================== --}}
@if(!$weatherData['is_offline'] && $menuRekomendasi->isNotEmpty())
<section id="rekomendasi" class="relative bg-gradient-to-b from-[#E7EEF6] via-[#F3F7FB] to-white py-16 md:py-20">
    <div class="max-w-6xl mx-auto px-4 md:px-8">
        <h2 class="text-2xl md:text-3xl font-extrabold text-center tracking-tight mb-10">REKOMENDASI HARI INI</h2>

        {{-- Jarak Diperlebar: gap-x-10 md:gap-x-16 gap-y-20 md:gap-y-28 --}}
       <div class="grid grid-cols-2 md:grid-cols-4 gap-x-10 md:gap-x-16 gap-y-20 md:gap-y-28">
            @foreach($menuRekomendasi as $menu)
                    <div class="bg-white rounded-2xl shadow-lg p-5 md:p-6 text-center cursor-pointer hover:shadow-xl transition-shadow"
                     data-nama="{{ $menu->nama_menu }}"
                     data-foto="{{ $menu->foto ? asset('storage/'.$menu->foto) : '' }}"
                     data-subkategori="{{ str_replace('_', ' ', $menu->sub_kategori) }}"
                     data-harga="{{ number_format($menu->harga, 0, ',', '.') }}"
                     data-deskripsi="{{ $menu->deskripsi }}"
                     onclick="bukaDetailMenu(this)">
                    <div class="w-20 h-20 md:w-24 md:h-24 mx-auto rounded-full overflow-hidden border-4 border-[#E7EEF6] shadow">
                        @if($menu->foto)
                            <img src="{{ asset('storage/'.$menu->foto) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-[#E7EEF6] flex items-center justify-center">
                                <svg class="w-7 h-7 text-[#9DBADD]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <p class="mt-4 text-[9px] font-bold uppercase tracking-wider text-[#2C4870]">{{ str_replace('_', ' ', $menu->sub_kategori) }}</p>
                    <h3 class="mt-1 font-bold text-[13px] md:text-sm leading-snug line-clamp-2">{{ $menu->nama_menu }}</h3>
                    <p class="mt-2 text-[13px] font-extrabold text-gray-900">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ======================== MENU REGULER  ======================== --}}
@php $batasAwal = 8; @endphp
<section id="menu-reguler" class="max-w-6xl mx-auto px-4 md:px-8 py-16 md:py-20">
    <h2 class="text-2xl md:text-3xl font-extrabold text-center tracking-tight mb-8">MENU KAMI</h2>

    <div class="sticky top-16 z-20 bg-white py-2 flex items-center gap-2 overflow-x-auto scroll-hide mb-10 justify-center">
        <button onclick="filterSubKategori('semua')" id="btn-tab-semua" class="tab-pill flex-shrink-0 px-4 py-1.5 text-[11px] font-bold uppercase tracking-wider rounded-full border bg-[#2C4870] text-white border-[#2C4870] transition-all">Semua</button>
        @foreach($menusBySubKategori as $subKat => $items)
            <button onclick="filterSubKategori('{{ $subKat }}')" id="btn-tab-{{ $subKat }}" class="tab-pill flex-shrink-0 px-4 py-1.5 text-[11px] font-bold uppercase tracking-wider rounded-full border border-gray-200 bg-white text-gray-500 transition-all whitespace-nowrap">
                {{ ucwords(str_replace('_', ' ', $subKat)) }}
            </button>
        @endforeach
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-10 md:gap-x-16 lg:gap-x-20 gap-y-24 md:gap-y-32">
        @forelse($menus as $index => $menu)
            @php $isHabis = $menu->status === 'habis'; @endphp
            <div class="menu-reguler-card group relative overflow-hidden rounded-2xl shadow-lg aspect-square cursor-pointer {{ $index >= $batasAwal ? 'hidden-extra hidden' : '' }}"
             data-subkategori="{{ $menu->sub_kategori }}"
             data-nama="{{ $menu->nama_menu }}"
             data-foto="{{ $menu->foto ? asset('storage/'.$menu->foto) : '' }}"
             data-subkategori-label="{{ str_replace('_', ' ', $menu->sub_kategori) }}"
             data-harga="{{ number_format($menu->harga, 0, ',', '.') }}"
             data-deskripsi="{{ $menu->deskripsi }}"
             onclick="bukaDetailMenu(this)">
                @if($menu->foto)
                    <img src="{{ asset('storage/'.$menu->foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300 {{ $isHabis ? 'grayscale opacity-60' : '' }}">
                @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif

                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/10 to-transparent"></div>

                <div class="absolute top-2 left-2">
                    @if($isHabis)
                        <span class="text-[8px] font-bold uppercase px-1.5 py-0.5 rounded bg-red-500 text-white">Habis</span>
                    @elseif($menu->tipe_suhu === 'panas')
                        <span class="text-[8px] font-bold uppercase px-1.5 py-0.5 rounded bg-orange-500 text-white">Hot</span>
                    @elseif($menu->tipe_suhu === 'dingin')
                        <span class="text-[8px] font-bold uppercase px-1.5 py-0.5 rounded bg-sky-500 text-white">Ice</span>
                    @endif
                </div>

                <div class="absolute bottom-0 left-0 right-0 p-3 md:p-4 text-white">
                    <p class="text-[8px] font-bold uppercase tracking-wider opacity-70">{{ str_replace('_', ' ', $menu->sub_kategori) }}</p>
                    <h3 class="font-bold text-[12px] md:text-[13px] leading-snug line-clamp-2 mt-0.5">{{ $menu->nama_menu }}</h3>
                    <p class="text-[12px] md:text-[13px] font-extrabold mt-1">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-[13px] text-gray-400">Belum ada menu tersedia.</div>
        @endforelse
    </div>

    @if($menus->count() > $batasAwal)
        <div class="text-center mt-16">
            <button id="btn-lihat-lengkap" onclick="lihatMenuLengkap()"
                class="px-8 py-3 border border-[#2C4870] text-[#2C4870] rounded font-bold uppercase text-[12px] tracking-wider hover:bg-[#2C4870] hover:text-white transition-colors">
                Lihat Menu Lengkap ({{ $menus->count() }})
            </button>
        </div>
    @endif
</section>

{{-- ======================== RETAIL / BIJI KOPI (abu, sekunder) ======================== --}}
<section id="retail" class="bg-gradient-to-b from-gray-100 via-gray-50 to-white py-16 md:py-20">
    <div class="max-w-6xl mx-auto px-4 md:px-8">
        <h2 class="text-2xl md:text-3xl font-extrabold text-center tracking-tight mb-10">ETALASE BIJI KOPI</h2>
        
        {{-- Jarak Diperlebar: gap-x-10 md:gap-x-16 lg:gap-x-20 gap-y-20 md:gap-y-28 --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-10 md:gap-x-16 lg:gap-x-20 gap-y-20 md:gap-y-28">      
            @forelse($retails as $retail)
                <div class="group relative overflow-hidden rounded-2xl shadow-lg aspect-square">
                    @if($retail->foto)
                        <img src="{{ asset('storage/'.$retail->foto) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 md:p-4 text-white">
                        <p class="text-[8px] font-bold uppercase tracking-wider opacity-70">Biji Kopi</p>
                        <h3 class="font-bold text-[12px] md:text-[13px] leading-snug line-clamp-2 mt-0.5">{{ $retail->nama_produk }}</h3>
                        <p class="text-[12px] md:text-[13px] font-extrabold mt-1">Rp {{ number_format($retail->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-[13px] text-gray-400">Belum ada produk retail.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ======================== FOOTER (navy — jangkar brand) ======================== --}}
<footer class="bg-[#1A1A2E] text-white pt-14 pb-8">
    <div class="max-w-6xl mx-auto px-4 md:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 pb-10 border-b border-white/10">
            <div>
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center p-1.5">
                        <img src="{{ asset('images/kopgun-logo-icon.png') }}" alt="Kopgun" class="w-full h-full object-contain">
                    </div>
                    <span class="font-extrabold text-[16px]">KOPGUN</span>
                </div>
                <p class="text-[12px] text-white/50 leading-relaxed max-w-xs">
                    Kedai kopi dengan rekomendasi menu yang menyesuaikan cuaca hari ini.
                </p>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-white/40 mb-3">Jelajahi</p>
                <div class="space-y-2 text-[13px] text-white/60">
                    <a href="#menu-reguler" class="block hover:text-white transition-colors">Menu</a>
                    <a href="#retail" class="block hover:text-white transition-colors">Retail</a>
                    <a href="#" class="block hover:text-white transition-colors">Event</a>
                    <a href="#" class="block hover:text-white transition-colors">Area</a>
                </div>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-white/40 mb-3">Kontak</p>
                <div class="space-y-2 text-[13px] text-white/60">
                    <p>Kota Bandung, Jawa Barat</p>
                    <p>halo@kopgun.id</p>
                    <p>+62 812 3456 7890</p>
                </div>
            </div>
        </div>
        <p class="text-center text-[11px] text-white/30 pt-6">&copy; {{ date('Y') }} Kopgun. Semua hak dilindungi.</p>
    </div>
</footer>
{{-- ======================== MODAL: DETAIL MENU ======================== --}}
<div id="modal-detail-menu" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="tutupDetailMenu()"></div>
    <div class="relative z-10 flex justify-center items-center px-4 py-10 min-h-full">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
            <div class="relative">
                <img id="dm-foto" src="" alt="" class="w-full aspect-square object-cover">
                <button onclick="tutupDetailMenu()" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 flex items-center justify-center text-gray-600 hover:bg-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-5">
                <p id="dm-subkategori" class="text-[10px] font-bold uppercase tracking-wider text-[#2C4870] mb-1"></p>
                <h3 id="dm-nama" class="text-lg font-extrabold text-gray-900 mb-1"></h3>
                <p id="dm-harga" class="text-[15px] font-bold text-gray-900 mb-3"></p>
                <p id="dm-deskripsi" class="text-[13px] text-gray-600 leading-relaxed"></p>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleMobileNav() {
        document.getElementById('mobile-nav').classList.toggle('hidden');
    }

    let stateKategoriAktif = 'semua';

        function filterSubKategori(subKat) {
            stateKategoriAktif = subKat;
            
            document.querySelectorAll('.tab-pill').forEach(btn => {
                btn.classList.remove('bg-[#2C4870]','text-white','border-[#2C4870]');
                btn.classList.add('bg-white','text-gray-500','border-gray-200');
            });
            const aktif = document.getElementById('btn-tab-' + subKat);
            if (aktif) {
                aktif.classList.add('bg-[#2C4870]','text-white','border-[#2C4870]');
                aktif.classList.remove('bg-white','text-gray-500','border-gray-200');
            }

            // Kosongkan form pencarian jika user mengklik Tab Menu
            if(document.getElementById('search-desktop')) document.getElementById('search-desktop').value = '';
            if(document.getElementById('search-mobile')) document.getElementById('search-mobile').value = '';
            
            jalankanFilterPencarian('');
        }

        function jalankanFilterPencarian(query) {
            query = query.toLowerCase();

            // Sinkronisasi teks antara form Mobile dan Desktop
            if(document.getElementById('search-desktop') && document.getElementById('search-desktop').value.toLowerCase() !== query) {
                document.getElementById('search-desktop').value = query;
            }
            if(document.getElementById('search-mobile') && document.getElementById('search-mobile').value.toLowerCase() !== query) {
                document.getElementById('search-mobile').value = query;
            }

            // Jika user mulai mengetik, paksa perluas (expand) tombol "Lihat Menu Lengkap" agar semua bisa dicari
            const btnLengkap = document.getElementById('btn-lihat-lengkap');
            if (query !== '' && btnLengkap && !btnLengkap.classList.contains('hidden')) {
                lihatMenuLengkap();
            }

            // Seleksi global: Kartu Rekomendasi, Kartu Menu Reguler, dan Kartu Retail Biji Kopi
            document.querySelectorAll('#rekomendasi .bg-white.rounded-2xl, .menu-reguler-card, #retail .group.relative').forEach(card => {
                const elemenJudul = card.querySelector('h3');
                if (!elemenJudul) return;
                
                const namaMenu = elemenJudul.textContent.toLowerCase();
                const cocokTeks = namaMenu.includes(query);
                
                // Logika untuk Menu Reguler (berhubungan dengan filter Tab)
                if (card.classList.contains('menu-reguler-card')) {
                    if (query !== '') {
                        // Cari secara global, hiraukan tab saat ini
                        card.style.display = cocokTeks ? '' : 'none';
                    } else {
                        // Jika kolom teks dikosongkan, kembali pada settingan tab 
                        const cocokKategori = (stateKategoriAktif === 'semua' || card.dataset.subkategori === stateKategoriAktif);
                        card.style.display = cocokKategori ? '' : 'none';
                    }
                } 
                // Logika untuk Rekomendasi & Retail
                else {
                    card.style.display = cocokTeks ? '' : 'none';
                }
            });
        }

    function lihatMenuLengkap() {
        document.querySelectorAll('.hidden-extra').forEach(el => el.classList.remove('hidden'));
        document.getElementById('btn-lihat-lengkap').classList.add('hidden');
    }
    function updateNavStyle() {
        const nav = document.getElementById('main-nav');
        const scrolled = window.scrollY > 40;
        const brand = document.getElementById('nav-brand-text');
        const hamburger = document.getElementById('nav-hamburger');
        const divider = document.getElementById('nav-divider');

        if (scrolled) {
            nav.classList.remove('bg-transparent');
            nav.classList.add('bg-white/95', 'backdrop-blur-sm', 'shadow-sm');
            document.querySelectorAll('.nav-link').forEach(el => {
                el.classList.remove('text-white/90');
                el.classList.add('text-gray-800');
            });
            brand?.classList.remove('text-white');
            brand?.classList.add('text-black');
            hamburger?.classList.remove('text-white');
            hamburger?.classList.add('text-gray-800');
            divider?.classList.remove('bg-white/30');
            divider?.classList.add('bg-gray-300');
        } else {
            nav.classList.add('bg-transparent');
            nav.classList.remove('bg-white/95', 'backdrop-blur-sm', 'shadow-sm');
            document.querySelectorAll('.nav-link').forEach(el => {
                el.classList.add('text-white/90');
                el.classList.remove('text-gray-800');
            });
            brand?.classList.add('text-white');
            brand?.classList.remove('text-black');
            hamburger?.classList.add('text-white');
            hamburger?.classList.remove('text-gray-800');
            divider?.classList.add('bg-white/30');
            divider?.classList.remove('bg-gray-300');
        }
    }
function bukaDetailMenu(el) {
    const nama        = el.dataset.nama;
    const foto        = el.dataset.foto;
    const subkategori = el.dataset.subkategoriLabel || el.dataset.subkategori;
    const harga       = el.dataset.harga;
    const deskripsi   = el.dataset.deskripsi;

    document.getElementById('dm-nama').textContent = nama;
    document.getElementById('dm-subkategori').textContent = subkategori;
    document.getElementById('dm-harga').textContent = 'Rp ' + harga;
    document.getElementById('dm-deskripsi').textContent = deskripsi && deskripsi.trim()
        ? deskripsi
        : 'Belum ada deskripsi untuk menu ini.';

    const fotoEl = document.getElementById('dm-foto');
    if (foto) {
        fotoEl.src = foto;
        fotoEl.classList.remove('hidden');
    } else {
        fotoEl.src = '';
        fotoEl.classList.add('hidden');
    }

    document.getElementById('modal-detail-menu').classList.remove('hidden');
}

function tutupDetailMenu() {
    document.getElementById('modal-detail-menu').classList.add('hidden');
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') tutupDetailMenu();
});
document.addEventListener('DOMContentLoaded', updateNavStyle);
window.addEventListener('scroll', updateNavStyle);
</script>

</body>
</html>