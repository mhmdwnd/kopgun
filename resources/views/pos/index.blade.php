<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kasir (POS) — Kopgun</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #toast-container { position:fixed; top:24px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:8px; pointer-events:none; }
        .toast { display:flex; align-items:center; gap:10px; padding:12px 16px; border-radius:12px; font-size:13px; font-weight:500; box-shadow:0 4px 20px rgba(0,0,0,0.12); pointer-events:all; animation: toastIn 0.22s ease-out; max-width:320px; }
        .toast.success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
        .toast.error   { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; }
        .toast.info    { background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af; }

        .scroll-hide::-webkit-scrollbar { display: none; }
        .scroll-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .menu-card { transition: all 0.18s cubic-bezier(0.4,0,0.2,1); }
        .menu-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.07); }
        .menu-card:active { transform: scale(0.97); }

        @keyframes toastIn { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes toastOut { from { opacity:1; } to { opacity:0; transform:translateY(-8px); } }

        /* Styling Khusus Struk Cetak (Thermal Printer) */
        @media print {
            body > *:not(#struk-cetak-wrapper) { display:none !important; }
            #struk-cetak-wrapper { display:block !important; }
            @page { margin:0; size:80mm auto; }
        }
        #struk-cetak-wrapper { display:none; }
        .modal-panel { transition: transform 0.2s cubic-bezier(0.4,0,0.2,1), opacity 0.2s; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800 overflow-hidden h-screen flex flex-col">

{{-- TOAST CONTAINER --}}
<div id="toast-container"></div>

{{-- STRUK CETAK (HIDDEN PADA LAYAR NORMAL) --}}
<div id="struk-cetak-wrapper">
    <div id="struk-cetak" style="font-family:monospace; font-size:12px; width:100%; padding:16px; color:#000;">
        {{-- Diisi dinamis oleh JS saat tombol cetak ditekan --}}
    </div>
</div>

{{-- ======================== HEADER ======================== --}}
<header class="h-14 bg-white border-b border-gray-100 flex items-center justify-between px-6 flex-shrink-0 z-20 gap-4">

    {{-- KIRI: identitas + aksi navigasi --}}
    <div class="flex items-center gap-3 flex-shrink-0">
        <div class="w-11 h-11 rounded-lg bg-[#1A1A2E] flex items-center justify-center flex-shrink-0 p-2">
            <img src="{{ asset('images/kopgun-logo-icon.png') }}" alt="Kopgun" class="w-full h-full object-contain">
        </div>
        <div>
            <h1 class="text-[14px] font-semibold text-gray-900 leading-tight">Kopgun POS</h1>
            <p class="text-[11px] text-gray-400">Terminal Kasir</p>
    </div>

        <button onclick="bukaRiwayat()" class="ml-3 flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-[12px] font-medium rounded-lg transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Riwayat
        </button>

        <button onclick="bukaModalKas()" class="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-[12px] font-medium rounded-lg transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 10v-2m0-8a9 9 0 100 18 9 9 0 000-18z"/></svg>
            Kas Masuk/Keluar
        </button>
    </div>

    {{-- TENGAH: widget cuaca --}}
    <div class="flex items-center gap-2.5 bg-gray-50 border border-gray-100 px-3 py-1.5 rounded-xl">
        <div class="w-7 h-7 bg-white border border-gray-100 rounded-lg flex items-center justify-center text-[14px]">
            @if($weatherData['rekomendasi_suhu'] === 'panas') ⛅ @else ❄️ @endif
        </div>
        <div>
            <p class="text-[12px] font-semibold text-gray-800 leading-tight">{{ $weatherData['suhu'] ?? '--' }}°C · Bandung</p>
            <p class="text-[10px] text-gray-400 capitalize">{{ $weatherData['kondisi'] }}</p>
        </div>
        <span class="w-2 h-2 rounded-full {{ $weatherData['is_offline'] ? 'bg-amber-400 animate-pulse' : 'bg-green-400' }}"></span>
    </div>

    {{--logout--}}
    <div class="flex items-center flex-shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-[12px] font-medium rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>
</header>

{{-- ======================== MAIN WORKSPACE ======================== --}}
<div class="flex-1 flex overflow-hidden">

   {{-- ===== PANEL KIRI: KATALOG ===== --}}
       {{-- ===== PANEL KIRI: KATALOG ===== --}}
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50 p-4 gap-3">

            {{-- Banner Analisis Cuaca --}}
            <div class="relative bg-gradient-to-r from-[#1a1a2e] to-blue-900 rounded-2xl p-5 shadow-lg overflow-hidden flex-shrink-0">
                <div class="absolute top-0 right-0 bg-blue-500 text-white text-[9px] font-black tracking-widest px-3 py-1.5 rounded-bl-xl uppercase shadow-md flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    API Weather Active
                </div>
                <div class="relative z-10 flex items-center gap-4 text-white">
                    <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20 flex-shrink-0 text-2xl shadow-inner">
                        @if($weatherData['rekomendasi_suhu'] === 'panas') 🌧️ @else ☀️ @endif
                    </div>
                    <div>
                        <h3 class="text-[14px] font-bold text-white mb-0.5 flex items-center gap-1.5">
                            Analisis Cuaca Real-Time
                            <span class="text-blue-300 text-[11px] font-medium border border-blue-300/30 px-1.5 py-0.5 rounded">{{ $weatherData['suhu'] ?? '--' }}°C</span>
                        </h3>
                        <p class="text-[12px] text-gray-300 leading-snug">
                            @if($weatherData['rekomendasi_suhu'] === 'panas')
                                Sistem mendeteksi cuaca <span class="font-semibold text-white capitalize">{{ $weatherData['kondisi'] }}</span>. Segera tawarkan menu <span class="text-orange-400 font-bold uppercase tracking-wide">Hangat & Berkuah</span>.
                            @elseif($weatherData['rekomendasi_suhu'] === 'dingin')
                                Sistem mendeteksi cuaca <span class="font-semibold text-white capitalize">{{ $weatherData['kondisi'] }}</span>. Segera tawarkan menu <span class="text-sky-400 font-bold uppercase tracking-wide">Dingin & Menyegarkan</span>.
                            @else
                                Mode offline aktif. Silakan tawarkan menu andalan (*signature*) terbaik Kopgun.
                            @endif
                        </p>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-8 w-24 h-24 bg-white opacity-5 rounded-full blur-2xl"></div>
            </div>

            {{-- area scroll --}}
            <div class="flex-1 overflow-y-auto scroll-hide space-y-5">

            {{-- KOLOM PENCARIAN GLOBAL --}}
            <div class="relative group bg-white border border-gray-200 rounded-2xl p-1 shadow-sm transition-all duration-300 hover:border-gray-300 focus-within:border-[#1a1a2e] focus-within:ring-4 focus-within:ring-[#1a1a2e]/10 flex items-center mx-1 mb-2">
                
                <!-- Ikon Kaca Pembesar (Berubah warna saat diketik) -->
                <div class="pl-3 pr-2 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-400 transition-colors duration-300 group-focus-within:text-[#1a1a2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                
                <!-- Area Input Teks -->
                <input type="text" id="input-pencarian" oninput="jalankanFilterPencarian()" placeholder="Cari nama menu atau biji kopi..." class="w-full text-[13px] text-gray-800 bg-transparent py-2 focus:outline-none placeholder-gray-400 font-medium">
                
                <!-- Lencana/Badge Visual (Opsional untuk estetika) -->
                <div class="hidden sm:flex pr-3 flex-shrink-0">
                    <span class="px-2 py-1 bg-gray-50 border border-gray-200 rounded-lg text-[9px] font-bold text-gray-400 uppercase tracking-wider group-focus-within:bg-[#1a1a2e] group-focus-within:text-white group-focus-within:border-[#1a1a2e] transition-colors">
                        Cari
                    </span>
                </div>
            </div>

            {{-- ===== SECTION 1: REKOMENDASI CUACA (aksen amber/oranye) ===== --}}
            @if(!$weatherData['is_offline'] && $menuRekomendasi->isNotEmpty())
            <div class="bg-gradient-to-br from-amber-50 via-orange-50 to-amber-100 border border-amber-200/60 rounded-2xl p-4">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center text-[11px] flex-shrink-0">✦</span>
                    <h2 class="text-[13px] font-bold text-amber-900">Rekomendasi Hari Ini</h2>
                    <span class="text-[10px] text-amber-700/70">
                        {{ $weatherData['rekomendasi_suhu'] === 'panas' ? 'Cuaca sejuk, cocok yang hangat' : 'Cuaca panas, cocok yang dingin' }}
                    </span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3">
                    @foreach($menuRekomendasi as $menu)
                        @php $isHabis = $menu->status === 'habis'; @endphp
                        <div class="menu-card bg-white border border-amber-200/50 rounded-xl overflow-hidden flex flex-col select-none shadow-sm {{ $isHabis ? 'opacity-50 pointer-events-none' : 'cursor-pointer' }}"
                             onclick="{{ $isHabis ? '' : "bukaModalOpsi('{$menu->id}','".addslashes($menu->nama_menu)."',{$menu->harga},'".($menu->foto ? asset('storage/'.$menu->foto) : '')."','{$menu->tipe_suhu}', '{$menu->kategori}')" }}">
                            <div class="relative aspect-video w-full bg-amber-50 overflow-hidden flex-shrink-0 border-b border-amber-100">
                                @if($menu->foto)
                                    <img src="{{ asset('storage/'.$menu->foto) }}" class="w-full h-full object-contain p-2">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"><svg class="w-8 h-8 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                                @endif
                                @if($isHabis)
                                    <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                                        <span class="text-[10px] font-semibold text-red-600 bg-red-50 border border-red-100 px-2 py-0.5 rounded-full">Habis</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3 flex-1 flex flex-col justify-between">
                                <div>
                                    <p class="text-[10px] text-amber-600 uppercase tracking-wider font-medium mb-0.5">{{ str_replace('_', ' ', $menu->sub_kategori) }}</p>
                                    <h3 class="text-[13px] font-semibold text-gray-800 line-clamp-2 leading-snug">{{ $menu->nama_menu }}</h3>
                                </div>
                                <p class="text-[13px] font-bold text-gray-900 mt-2 pt-2 border-t border-amber-100">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ===== SECTION 2: MENU REGULER (tenang, tanpa tint — fokus utama) ===== --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                <h2 class="text-[13px] font-bold text-gray-800 mb-3">Menu Reguler</h2>

                <div class="flex items-center gap-2 overflow-x-auto scroll-hide flex-shrink-0 pb-2">
                    <button onclick="filterSubKategori('semua')" id="btn-tab-semua" class="tab-pill flex-shrink-0 px-4 py-1.5 text-[12px] font-medium rounded-lg border bg-[#1a1a2e] text-white border-[#1a1a2e] transition-all">Semua</button>
                    @foreach($menusBySubKategori as $subKat => $items)
                        <button onclick="filterSubKategori('{{ $subKat }}')" id="btn-tab-{{ $subKat }}" class="tab-pill flex-shrink-0 px-4 py-1.5 text-[12px] font-medium rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 transition-all whitespace-nowrap">
                            {{ ucwords(str_replace('_', ' ', $subKat)) }}
                        </button>
                    @endforeach
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3">
                    @forelse($menus as $menu)
                        @php $isHabis = $menu->status === 'habis'; @endphp
                        <div class="menu-card menu-reguler-card bg-white rounded-xl border border-gray-100 overflow-hidden flex flex-col select-none {{ $isHabis ? 'opacity-50 pointer-events-none' : 'cursor-pointer' }}"
                             data-subkategori="{{ $menu->sub_kategori }}"
                             onclick="{{ $isHabis ? '' : "bukaModalOpsi('{$menu->id}','".addslashes($menu->nama_menu)."',{$menu->harga},'".($menu->foto ? asset('storage/'.$menu->foto) : '')."','{$menu->tipe_suhu}', '{$menu->kategori}')" }}">
                            <div class="relative aspect-video w-full bg-gray-100 overflow-hidden flex-shrink-0 border-b border-gray-50">
                                @if($menu->foto)
                                    <img src="{{ asset('storage/'.$menu->foto) }}" class="w-full h-full object-contain p-2 transition-transform duration-300 hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"><svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                                @endif
                                <div class="absolute bottom-2 left-2">
                                    @if($menu->tipe_suhu === 'panas')
                                        <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-orange-500 text-white shadow-sm">HOT</span>
                                    @elseif($menu->tipe_suhu === 'dingin')
                                        <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-sky-500 text-white shadow-sm">ICE</span>
                                    @endif
                                </div>
                                @if($isHabis)
                                    <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                                        <span class="text-[10px] font-semibold text-red-600 bg-red-50 border border-red-100 px-2 py-0.5 rounded-full">Habis</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3 flex-1 flex flex-col justify-between">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-medium mb-0.5">{{ str_replace('_', ' ', $menu->sub_kategori) }}</p>
                                    <h3 class="text-[13px] font-semibold text-gray-800 line-clamp-2 leading-snug">{{ $menu->nama_menu }}</h3>
                                </div>
                                <p class="text-[13px] font-bold text-gray-900 mt-2 pt-2 border-t border-gray-50">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center text-[13px] text-gray-400">Belum ada menu tersedia.</div>
                    @endforelse
                </div>
            </div>

            {{-- ===== SECTION 3: RETAIL / BIJI KOPI  ===== --}}
            <div class="bg-gradient-to-br from-stone-100 via-stone-50 to-stone-200 border border-stone-300/50 rounded-2xl p-4">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-6 h-6 rounded-full bg-stone-700 text-white flex items-center justify-center text-[11px] flex-shrink-0">☕</span>
                    <h2 class="text-[13px] font-bold text-stone-800">Etalase Biji Kopi</h2>
                    <span class="text-[10px] text-stone-600 bg-stone-200/70 px-2 py-0.5 rounded-full">{{ $retails->count() }} item</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3">
                    @forelse($retails as $retail)
                        <div class="menu-card bg-white border border-stone-200 rounded-xl overflow-hidden flex flex-col cursor-pointer select-none shadow-sm"
                             onclick="bukaModalOpsi('{{ $retail->id }}','{{ addslashes($retail->nama_produk) }}',{{ $retail->harga }},'{{ $retail->foto ? asset('storage/'.$retail->foto) : '' }}','netral','retail','retail')">
                            <div class="relative aspect-video w-full bg-stone-100 overflow-hidden flex-shrink-0 border-b border-stone-100">
                                @if($retail->foto)
                                    <img src="{{ asset('storage/'.$retail->foto) }}" class="w-full h-full object-contain p-2">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"><svg class="w-8 h-8 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                                @endif
                            </div>
                            <div class="p-3 flex-1 flex flex-col justify-between">
                                <div>
                                    <p class="text-[10px] text-stone-500 uppercase tracking-wider font-medium mb-0.5">Biji Kopi</p>
                                    <h3 class="text-[13px] font-semibold text-gray-800 line-clamp-2 leading-snug">{{ $retail->nama_produk }}</h3>
                                    @if($retail->detail_spesifik)
                                        <p class="text-[10px] text-gray-400 mt-0.5 line-clamp-1">{{ $retail->detail_spesifik }}</p>
                                    @endif
                                </div>
                                <p class="text-[13px] font-bold text-gray-900 mt-2 pt-2 border-t border-stone-100">Rp {{ number_format($retail->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-8 text-center text-[13px] text-gray-400">Belum ada produk retail.</div>
                    @endforelse
                </div>
            </div>
        </div>
           
        </div>

    {{-- ===== PANEL KANAN: KERANJANG ===== --}}
    <div class="w-[320px] flex-shrink-0 bg-white border-l border-gray-100 flex flex-col h-full">
        
        <div class="px-4 py-3 border-b border-gray-100 flex-shrink-0 grid grid-cols-2 gap-2">
            <div>
                <label class="block text-[11px] font-medium text-gray-400 mb-1">Pelanggan</label>
                <input id="nama_pelanggan" type="text" placeholder="Anonim" class="w-full text-[12px] px-2.5 py-1.5 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1a1a2e] transition">
            </div>
            <div>
                <label class="block text-[11px] font-medium text-gray-400 mb-1">No. Meja <span class="text-red-400">*</span></label>
                <input id="nomor_meja" type="text" placeholder="cth. 04" class="w-full text-[12px] px-2.5 py-1.5 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1a1a2e] transition">
            </div>
        </div>

        <div id="container-keranjang" class="flex-1 overflow-y-auto scroll-hide p-4 space-y-2">
            <div id="keranjang-kosong" class="h-full flex flex-col items-center justify-center text-center py-12">
                <svg class="w-9 h-9 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <p class="text-[12px] text-gray-400">Keranjang kosong</p>
                <p class="text-[11px] text-gray-300 mt-0.5">Pilih menu dari katalog</p>
            </div>
        </div>

        <div class="p-4 border-t border-gray-100 flex-shrink-0 space-y-3">
            <div class="flex justify-between text-[14px] font-semibold text-gray-900 pt-1.5 border-t border-dashed border-gray-100">
                <span>Total</span>
                <span id="txt-total">Rp 0</span>
            </div>
            <button onclick="bukaModalPembayaran()" class="w-full flex items-center justify-center gap-2 text-[13px] font-semibold bg-[#1a1a2e] hover:bg-[#2a2a42] text-white py-3 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Simpan & Cetak
            </button>
        </div>
    </div>
</div>

{{-- ======================== MODAL: OPSI MENU ======================== --}}
<div id="modal-opsi-menu" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="tutupModalOpsi()"></div>
    <div class="relative z-10 flex justify-center px-4 py-10 min-h-full">
        <div class="modal-panel bg-white rounded-xl border border-gray-100 shadow-2xl w-full max-w-sm h-fit">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                <h2 class="text-[13px] font-semibold text-gray-800">Opsi Pesanan</h2>
                <button onclick="tutupModalOpsi()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-5 py-4">
                <div class="flex flex-col gap-3 mb-4 pb-4 border-b border-gray-100">
                <div id="opsi-foto-wrapper" class="w-full h-40 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0 flex items-center justify-center border border-gray-100">
                </div>
                <div>
                    <h3 id="opsi-nama-menu" class="text-[18px] font-bold text-gray-900 leading-tight break-words"></h3>
                    <p id="opsi-harga-menu" class="text-[12px] text-gray-400 font-medium mt-0.5"></p>
                </div>
            </div>
                <form id="form-opsi" onsubmit="event.preventDefault(); simpanKeKeranjang();">
                    <input type="hidden" id="opsi-id-menu"><input type="hidden" id="opsi-foto-menu"><input type="hidden" id="opsi-harga-asli"><input type="hidden" id="opsi-tipe-suhu"><input type="hidden" id="opsi-tipe-item" value="menu">
                    <div id="area-suhu" class="mb-4 hidden">
                        <label class="block text-[12px] font-medium text-gray-600 mb-2">Pilih Suhu Penyajian <span class="text-red-400">*</span></label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center justify-center gap-2 p-2.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-orange-50 hover:border-orange-200 transition-colors">
                                <input type="radio" name="pilihan_suhu" value="Panas" class="text-orange-500">
                                <span class="text-[12px] font-medium text-gray-700">☕ Panas</span>
                            </label>
                            <label class="flex items-center justify-center gap-2 p-2.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-sky-50 hover:border-sky-200 transition-colors">
                                <input type="radio" name="pilihan_suhu" value="Dingin" class="text-sky-500">
                                <span class="text-[12px] font-medium text-gray-700">🧊 Dingin</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Catatan <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <textarea id="opsi-catatan" rows="2" placeholder="Cth: kurangi manis, tanpa es..." class="w-full text-[12px] px-3 py-2 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition resize-none"></textarea>
                    </div>
                    <div class="flex gap-2.5">
                        <button type="button" onclick="tutupModalOpsi()" class="flex-1 border border-gray-200 text-gray-500 text-[13px] py-2.5 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                        <button type="submit" class="flex-1 bg-[#1a1a2e] hover:bg-[#2a2a42] text-white text-[13px] font-medium py-2.5 rounded-lg transition-colors">Tambah ke Pesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ======================== MODAL: PEMBAYARAN ======================== --}}
<div id="modal-pembayaran" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="tutupModalPembayaran()"></div>
    <div class="relative z-10 flex justify-center px-4 py-10 min-h-full">
        <div class="modal-panel bg-white rounded-xl border border-gray-100 shadow-2xl w-full max-w-sm h-fit">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                <h2 class="text-[13px] font-semibold text-gray-800">Konfirmasi Pembayaran</h2>
                <button onclick="tutupModalPembayaran()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-5 py-4 space-y-4">
                <div class="bg-gray-50 border border-gray-100 rounded-lg p-3 space-y-1">
                    <div class="flex justify-between text-[12px]"><span class="text-gray-400">Meja</span><span id="pay-meja" class="font-medium text-gray-800"></span></div>
                    <div class="flex justify-between text-[12px]"><span class="text-gray-400">Pelanggan</span><span id="pay-nama" class="font-medium text-gray-800"></span></div>
                    <div id="pay-items" class="pt-2 border-t border-gray-100 space-y-0.5 max-h-28 overflow-y-auto scroll-hide"></div>
                    <div class="flex justify-between text-[13px] font-semibold text-gray-900 pt-2 border-t border-dashed border-gray-100"><span>Total</span><span id="pay-total"></span></div>
                </div>
                <div>
                    <label class="block text-[12px] font-medium text-gray-600 mb-2">Metode Pembayaran</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button onclick="pilihMetode('tunai')" data-metode="tunai" class="metode-btn aktif flex flex-col items-center gap-1 py-2.5 rounded-lg border text-[11px] font-medium transition-all bg-[#1a1a2e] text-white border-[#1a1a2e]"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2"/></svg>Tunai</button>
                        <button onclick="pilihMetode('qris')" data-metode="qris" class="metode-btn flex flex-col items-center gap-1 py-2.5 rounded-lg border border-gray-200 bg-white text-gray-500 text-[11px] font-medium transition-all hover:bg-gray-50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>QRIS</button>
                        <button onclick="pilihMetode('debit')" data-metode="debit" class="metode-btn flex flex-col items-center gap-1 py-2.5 rounded-lg border border-gray-200 bg-white text-gray-500 text-[11px] font-medium transition-all hover:bg-gray-50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>Debit</button>
                    </div>
                </div>
                <div id="section-tunai" class="space-y-2">
                    <div>
                        <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Uang Diterima (Rp)</label>
                        <input id="uang-diterima" type="number" min="0" placeholder="0" oninput="hitungKembalian()" class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                    </div>
                    <div id="nominal-cepat" class="grid grid-cols-4 gap-1.5"></div>
                    <div class="flex justify-between text-[12px] pt-1"><span class="text-gray-500">Kembalian</span><span id="txt-kembalian" class="font-semibold text-[#1a1a2e]">Rp —</span></div>
                </div>
            </div>
            <div class="flex gap-2.5 px-5 pb-5">
                <button onclick="tutupModalPembayaran()" class="flex-1 border border-gray-200 text-gray-500 text-[13px] py-2.5 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                <button id="btn-proses" onclick="eksekusiPembayaran()" class="flex-1 bg-[#1a1a2e] hover:bg-[#2a2a42] text-white text-[13px] font-semibold py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Proses & Cetak</button>
            </div>
        </div>
    </div>
</div>

{{-- ======================== MODAL: RIWAYAT ======================== --}}
<div id="modal-riwayat" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="tutupRiwayat()"></div>
    <div class="relative z-10 flex justify-center px-4 py-10 min-h-full">
        <div class="modal-panel bg-white rounded-xl border border-gray-100 shadow-2xl w-full max-w-2xl h-fit">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                <h2 class="text-[13px] font-semibold text-gray-800">Riwayat Transaksi Hari Ini</h2>
                <button onclick="tutupRiwayat()" class="text-gray-400 hover:text-gray-600 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div id="container-riwayat" class="p-5 max-h-[60vh] overflow-y-auto scroll-hide space-y-3"></div>
        </div>
    </div>
</div>
{{-- ======================== MODAL: KAS MASUK/KELUAR ======================== --}}
<div id="modal-kas" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="tutupModalKas()"></div>
    <div class="relative z-10 flex justify-center px-4 py-10 min-h-full">
        <div class="modal-panel bg-white rounded-xl border border-gray-100 shadow-2xl w-full max-w-sm h-fit">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                <h2 class="text-[13px] font-semibold text-gray-800">Catat Kas Masuk/Keluar</h2>
                <button onclick="tutupModalKas()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-5 py-4 space-y-4">
                <div>
                    <label class="block text-[12px] font-medium text-gray-600 mb-2">Jenis</label>
                    <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="pilihTipeKas('modal')" data-tipe-kas="modal" class="tipe-kas-btn flex flex-col items-center justify-center gap-1 py-2.5 rounded-lg border border-gray-200 bg-white text-gray-500 text-[10.5px] font-medium transition-all hover:bg-gray-50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Modal Awal
                    </button>
                    <button type="button" onclick="pilihTipeKas('masuk')" data-tipe-kas="masuk" class="tipe-kas-btn flex flex-col items-center justify-center gap-1 py-2.5 rounded-lg border text-[10.5px] font-medium transition-all bg-emerald-600 text-white border-emerald-600">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8l-8 8-8-8"/></svg>
                        Kas Masuk
                    </button>
                    <button type="button" onclick="pilihTipeKas('keluar')" data-tipe-kas="keluar" class="tipe-kas-btn flex flex-col items-center justify-center gap-1 py-2.5 rounded-lg border border-gray-200 bg-white text-gray-500 text-[10.5px] font-medium transition-all hover:bg-gray-50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20V4m-8 8l8-8 8 8"/></svg>
                        Kas Keluar
                    </button>
                </div>
                </div>
                <div>
                    <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Nominal (Rp) <span class="text-red-400">*</span></label>
                    <input id="kas-jumlah" type="number" min="1" placeholder="0" class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                </div>
                <div>
                    <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Keterangan <span class="text-red-400">*</span></label>
                    <textarea id="kas-keterangan" rows="2" placeholder="Cth: beli galon air, setor ke bank..." class="w-full text-[12px] px-3 py-2 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition resize-none"></textarea>
                </div>
            </div>
            <div class="flex gap-2.5 px-5 pb-5">
                <button onclick="tutupModalKas()" class="flex-1 border border-gray-200 text-gray-500 text-[13px] py-2.5 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                <button id="btn-simpan-kas" onclick="simpanKas()" class="flex-1 bg-[#1a1a2e] hover:bg-[#2a2a42] text-white text-[13px] font-semibold py-2.5 rounded-lg transition-colors">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- ======================== CORE JAVASCRIPT ======================== --}}
<script>
let keranjang   = [];
let metodeBayar = 'tunai';

// ─── TOAST NOTIFICATION ──────────────────────────────────────────────
function showToast(pesan, tipe = 'success') {
    const tc   = document.getElementById('toast-container');
    const el   = document.createElement('div');
    const icon = tipe === 'success'
        ? '<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
        : tipe === 'error'
        ? '<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>'
        : '<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';

    el.className = `toast ${tipe}`;
    el.innerHTML = icon + `<span>${pesan}</span>`;
    tc.appendChild(el);
    setTimeout(() => {
        el.style.animation = 'toastOut 0.2s ease-in forwards';
        setTimeout(() => el.remove(), 200);
    }, 3000);
}

// ─── FILTER KATEGORI MENU ──────────────────────────────────────────
function filterSubKategori(subKat) {
    document.querySelectorAll('.tab-pill').forEach(btn => {
        btn.classList.remove('bg-[#1a1a2e]','text-white','border-[#1a1a2e]');
        btn.classList.add('bg-white','text-gray-500','border-gray-200');
    });
    const aktif = document.getElementById('btn-tab-' + subKat);
    if (aktif) {
        aktif.classList.add('bg-[#1a1a2e]','text-white','border-[#1a1a2e]');
        aktif.classList.remove('bg-white','text-gray-500','border-gray-200');
    }
    document.querySelectorAll('.menu-reguler-card').forEach(c => {
        c.style.display = (subKat === 'semua' || c.dataset.subkategori === subKat) ? '' : 'none';
    });
}

// ─── LOGIKA MODAL OPSI MENU ──────────────────────────────────────────
/**
 * Fungsi untuk membuka modal opsi menu
 * @param {string|number} id - ID Menu
 * @param {string} nama - Nama Menu
 * @param {number} harga - Harga Menu
 * @param {string} fotoUrl - URL Foto
 * @param {string} tipeSuhu - Tipe suhu dari database (panas, dingin, atau netral)
 * @param {string} kategori - Kategori menu dari database (makanan atau minuman)
 */
function bukaModalOpsi(id, nama, harga, fotoUrl, tipeSuhu, kategori, tipeItem = 'menu') {
    document.getElementById('opsi-id-menu').value       = id;
    document.getElementById('opsi-harga-asli').value    = harga;
    document.getElementById('opsi-foto-menu').value     = fotoUrl;
    document.getElementById('opsi-tipe-suhu').value     = tipeSuhu;
    document.getElementById('opsi-tipe-item').value     = tipeItem;
    document.getElementById('opsi-nama-menu').textContent      = nama;
    document.getElementById('opsi-harga-menu').textContent     = 'Rp ' + parseInt(harga).toLocaleString('id-ID');
    document.getElementById('opsi-catatan').value = '';

    const fw = document.getElementById('opsi-foto-wrapper');
    fw.innerHTML = fotoUrl
        ? `<img src="${fotoUrl}" class="w-full h-full object-contain p-2">`
        : `<svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>`;

    const areaSuhu = document.getElementById('area-suhu');
    document.querySelectorAll('input[name="pilihan_suhu"]').forEach(r => { r.checked = false; });

    if (kategori === 'minuman' && tipeSuhu === 'netral') {
        areaSuhu.classList.remove('hidden');
        document.querySelectorAll('input[name="pilihan_suhu"]').forEach(r => r.required = true);
    } else {
        areaSuhu.classList.add('hidden');
        document.querySelectorAll('input[name="pilihan_suhu"]').forEach(r => r.required = false);
    }

    document.getElementById('modal-opsi-menu').classList.remove('hidden');
    document.getElementById('modal-opsi-menu').scrollTop = 0;
}

function tutupModalOpsi() {
    document.getElementById('modal-opsi-menu').classList.add('hidden');
}

function simpanKeKeranjang() {
    const id       = document.getElementById('opsi-id-menu').value;
    const nama     = document.getElementById('opsi-nama-menu').textContent;
    const harga    = parseInt(document.getElementById('opsi-harga-asli').value);
    const fotoUrl  = document.getElementById('opsi-foto-menu').value;
    const catatan  = document.getElementById('opsi-catatan').value.trim();
    const tipeItem = document.getElementById('opsi-tipe-item').value;

    let suhuPilihan = null;
    const areaSuhu = document.getElementById('area-suhu');
    if (!areaSuhu.classList.contains('hidden')) {
        const checked = document.querySelector('input[name="pilihan_suhu"]:checked');
        if (!checked) {
            showToast('Pilih suhu penyajian (Panas/Dingin) terlebih dahulu.', 'error');
            return;
        }
        suhuPilihan = checked.value;
    }

    keranjang.push({ cart_id: Date.now().toString(), id, nama, harga, fotoUrl, kuantitas: 1, suhu_pilihan: suhuPilihan, catatan, tipe_item: tipeItem });
    tutupModalOpsi();
    renderKeranjang();
    showToast(`${nama} ditambahkan ke pesanan.`, 'success');
}

// ─── LOGIKA KERANJANG BELANJA ────────────────────────────────────────────────
function ubahKuantitas(cartId, delta) {
    const idx = keranjang.findIndex(i => i.cart_id === cartId);
    if (idx === -1) return;
    keranjang[idx].kuantitas += delta;
    if (keranjang[idx].kuantitas <= 0) keranjang.splice(idx, 1);
    renderKeranjang();
}

function getTotal() {
    return keranjang.reduce((s, i) => s + i.harga * i.kuantitas, 0);
}

function renderKeranjang() {
    const container = document.getElementById('container-keranjang');

    if (keranjang.length === 0) {
        container.innerHTML = `
            <div id="keranjang-kosong" class="h-full flex flex-col items-center justify-center text-center py-12">
                <svg class="w-9 h-9 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <p class="text-[12px] text-gray-400">Keranjang kosong</p>
                <p class="text-[11px] text-gray-300 mt-0.5">Pilih menu dari katalog</p>
            </div>`;
        document.getElementById('txt-total').textContent = 'Rp 0';
        return;
    }

    container.innerHTML = '';
    keranjang.forEach(item => {
        const extra = [
            item.suhu_pilihan ? `<span class="text-[9px] font-semibold border border-gray-200 px-1.5 py-0.5 rounded text-gray-500">${item.suhu_pilihan}</span>` : '',
            item.catatan ? `<span class="text-[10px] text-gray-400 italic">"${item.catatan}"</span>` : ''
        ].filter(Boolean).join(' ');

        const el = document.createElement('div');
        el.className = 'flex items-start gap-2.5 bg-gray-50 border border-gray-100 p-2.5 rounded-xl';
        el.innerHTML = `
            <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                ${item.fotoUrl
                    ? `<img src="${item.fotoUrl}" class="w-full h-full object-cover">`
                    : `<div class="w-full h-full flex items-center justify-center"><svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>`
                }
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[12px] font-semibold text-gray-800 truncate leading-tight">${item.nama}</p>
                <p class="text-[11px] text-gray-400 mt-0.5 mb-1">Rp ${item.harga.toLocaleString('id-ID')}</p>
                ${extra ? `<div class="flex items-center gap-1 flex-wrap">${extra}</div>` : ''}
            </div>
            <div class="flex items-center gap-1.5 flex-shrink-0 mt-0.5">
                <button onclick="ubahKuantitas('${item.cart_id}',-1)" class="w-6 h-6 rounded-md bg-white border border-gray-200 text-gray-500 text-sm font-medium flex items-center justify-center hover:bg-gray-50 transition-colors">−</button>
                <span class="text-[12px] font-bold text-gray-800 w-4 text-center">${item.kuantitas}</span>
                <button onclick="ubahKuantitas('${item.cart_id}',1)" class="w-6 h-6 rounded-md bg-white border border-gray-200 text-gray-500 text-sm font-medium flex items-center justify-center hover:bg-gray-50 transition-colors">+</button>
            </div>`;
        container.appendChild(el);
    });
    document.getElementById('txt-total').textContent = 'Rp ' + getTotal().toLocaleString('id-ID');
}

// ─── LOGIKA PEMBAYARAN & KEMBALIAN ─────────────────────────────────────────
function bukaModalPembayaran() {
    if (keranjang.length === 0) { showToast('Keranjang masih kosong!', 'error'); return; }
    const meja = document.getElementById('nomor_meja').value.trim();
    const nama = document.getElementById('nama_pelanggan').value.trim() || 'Anonim';
    if (!meja) { showToast('Nomor meja wajib diisi.', 'error'); return; }

    document.getElementById('pay-meja').textContent = meja;
    document.getElementById('pay-nama').textContent = nama;
    document.getElementById('pay-total').textContent = 'Rp ' + getTotal().toLocaleString('id-ID');

    const payItems = document.getElementById('pay-items');
    payItems.innerHTML = '';
    keranjang.forEach(item => {
        const suhu = item.suhu_pilihan ? ` [${item.suhu_pilihan}]` : '';
        payItems.insertAdjacentHTML('beforeend', `
            <div class="flex justify-between text-[11px] text-gray-500">
                <span class="truncate mr-2">${item.kuantitas}× ${item.nama}${suhu}</span>
                <span class="flex-shrink-0 font-medium">Rp ${(item.harga * item.kuantitas).toLocaleString('id-ID')}</span>
            </div>`);
    });

    const total = getTotal();
    const noms  = [...new Set([5000,10000,20000,50000,100000,total].filter(n => n >= total || n <= 100000))].slice(0,3);
    const nc    = document.getElementById('nominal-cepat');
    nc.innerHTML = '';
    noms.forEach(n => nc.insertAdjacentHTML('beforeend', `<button onclick="isiNominal(${n})" class="text-[11px] font-medium border border-gray-200 bg-gray-50 hover:bg-gray-100 text-gray-600 py-1.5 rounded-lg transition-colors">${n.toLocaleString('id-ID')}</button>`));
    nc.insertAdjacentHTML('beforeend', `<button onclick="isiNominal(${total})" class="text-[11px] font-medium border border-[#1a1a2e] bg-[#1a1a2e]/5 hover:bg-[#1a1a2e]/10 text-[#1a1a2e] py-1.5 rounded-lg transition-colors">Pas</button>`);

    document.getElementById('uang-diterima').value = '';
    document.getElementById('txt-kembalian').textContent = 'Rp —';
    pilihMetode('tunai');
    document.getElementById('modal-pembayaran').classList.remove('hidden');
    document.getElementById('modal-pembayaran').scrollTop = 0;
}

function tutupModalPembayaran() { document.getElementById('modal-pembayaran').classList.add('hidden'); }

function pilihMetode(m) {
    metodeBayar = m;
    document.querySelectorAll('.metode-btn').forEach(btn => {
        const aktif = btn.dataset.metode === m;
        btn.classList.toggle('bg-[#1a1a2e]', aktif);
        btn.classList.toggle('text-white', aktif);
        btn.classList.toggle('border-[#1a1a2e]', aktif);
        btn.classList.toggle('bg-white', !aktif);
        btn.classList.toggle('text-gray-500', !aktif);
        btn.classList.toggle('border-gray-200', !aktif);
    });
    document.getElementById('section-tunai').style.display = m === 'tunai' ? '' : 'none';
}

function isiNominal(n) { document.getElementById('uang-diterima').value = n; hitungKembalian(); }

function hitungKembalian() {
    const total    = getTotal();
    const diterima = parseInt(document.getElementById('uang-diterima').value, 10) || 0;
    const kembalian = diterima - total;
    const el = document.getElementById('txt-kembalian');
    if (!diterima)         { el.textContent = 'Rp —'; el.className = 'font-semibold text-[#1a1a2e]'; }
    else if (kembalian < 0){ el.textContent = '− Rp ' + Math.abs(kembalian).toLocaleString('id-ID'); el.className = 'font-semibold text-red-500'; }
    else                   { el.textContent = 'Rp ' + kembalian.toLocaleString('id-ID'); el.className = 'font-semibold text-green-600'; }
}

// ─── PROSES PEMBAYARAN  ────────────────────────────────────────────
async function eksekusiPembayaran() {
    if (metodeBayar === 'tunai') {
        const diterima = parseInt(document.getElementById('uang-diterima').value, 10) || 0;
        if (diterima < getTotal()) { showToast('Uang yang diterima kurang dari total!', 'error'); return; }
    }

    const btn = document.getElementById('btn-proses');
    btn.disabled = true;
    btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Menyimpan...';

    const payload = {
        nama_pelanggan    : document.getElementById('nama_pelanggan').value.trim() || 'Anonim',
        nomor_meja        : document.getElementById('nomor_meja').value.trim(),
        total_pembayaran  : getTotal(),
        metode_pembayaran : metodeBayar,
        items: keranjang.map(i => ({
        menu_id      : i.tipe_item === 'retail' ? null : i.id,
        retail_id    : i.tipe_item === 'retail' ? i.id : null,
        nama         : i.nama,
        harga        : i.harga,
        kuantitas    : i.kuantitas,
        suhu_pilihan : i.suhu_pilihan,
        catatan      : i.catatan,
    }))
    };

    try {
        const res = await fetch("{{ route('pos.simpan') }}", {
            method : 'POST',
            headers: {
                'Content-Type' : 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (res.ok && data.success) {
            // 1. Tutup modal & tampilkan toast sukses DULU,
            //    supaya kasir langsung dapat konfirmasi meski ada error lain setelah ini.
            tutupModalPembayaran();
            showToast('Transaksi berhasil disimpan ke riwayat!', 'success');

            // 2. Baru bersihkan keranjang & reset form
            keranjang = [];
            document.getElementById('nama_pelanggan').value = '';
            document.getElementById('nomor_meja').value = '';
            renderKeranjang();
        } else {
            showToast('Gagal: ' + (data.message || 'Server error'), 'error');
        }
    } catch (err) {
        console.error("Detail Eror JS:", err);
        showToast('Kesalahan sistem atau jaringan terputus.', 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Proses Pembayaran';
    }
}

{{--==FUNGSI CETAK STRUK THERMAL--==}} 
function cetakStruk(data) {
    const tgl = new Date().toLocaleString('id-ID', { dateStyle:'short', timeStyle:'short' });
    let baris = '';
    data.items.forEach(item => {
        const subtotal = item.harga * item.kuantitas;
        const extra = [item.suhu_pilihan, item.catatan].filter(Boolean).join(', ');
        baris += `
            <tr>
                <td style="padding:2px 0">${item.kuantitas}× ${item.nama}${extra ? `<br><small style="color:#666">${extra}</small>` : ''}</td>
                <td style="text-align:right;white-space:nowrap;padding:2px 0">Rp ${subtotal.toLocaleString('id-ID')}</td>
            </tr>`;
    });

    const kembalianRow = data.kembalian !== null
        ? `<tr><td style="padding-top:4px">Kembalian</td><td style="text-align:right;padding-top:4px">Rp ${Math.max(0, data.kembalian).toLocaleString('id-ID')}</td></tr>`
        : '';

    document.getElementById('struk-cetak').innerHTML = `
        <div style="text-align:center;margin-bottom:12px">
            <div style="font-size:18px;font-weight:700">KOPGUN</div>
            <div style="font-size:11px;color:#555">Sistem Kasir · Terminal POS</div>
            <div style="font-size:10px;color:#888;margin-top:2px">${tgl}</div>
        </div>
        <hr style="border:none;border-top:1px dashed #ccc;margin:8px 0">
        <table style="width:100%;font-size:11px;border-collapse:collapse">
            <tr><td>No. Transaksi</td><td style="text-align:right">#${data.id_trx}</td></tr>
            <tr><td>Meja</td><td style="text-align:right">${data.meja}</td></tr>
            <tr><td>Pelanggan</td><td style="text-align:right">${data.nama}</td></tr>
        </table>
        <hr style="border:none;border-top:1px dashed #ccc;margin:8px 0">
        <table style="width:100%;font-size:11px;border-collapse:collapse">${baris}</table>
        <hr style="border:none;border-top:1px dashed #ccc;margin:8px 0">
        <table style="width:100%;font-size:12px;font-weight:700;border-collapse:collapse">
            <tr><td>Total</td><td style="text-align:right">Rp ${data.total.toLocaleString('id-ID')}</td></tr>
            <tr style="font-weight:400;font-size:11px"><td>Metode</td><td style="text-align:right">${data.metode.toUpperCase()}</td></tr>
            ${kembalianRow}
        </table>
        <hr style="border:none;border-top:1px dashed #ccc;margin:8px 0">
        <div style="text-align:center;font-size:10px;color:#888;margin-top:8px">Terima kasih telah berkunjung!<br>Sampai jumpa di Kopgun ☕</div>`;

    setTimeout(() => window.print(), 100);
}

{{--==Riwayat==--}}
async function bukaRiwayat() {
    document.getElementById('modal-riwayat').classList.remove('hidden');
    document.getElementById('modal-riwayat').scrollTop = 0;
    const container = document.getElementById('container-riwayat');
    container.innerHTML = '<p class="text-center text-gray-400 py-10 text-[13px]">Memuat...</p>';

    try {
        const res  = await fetch("{{ route('pos.riwayat') }}", { headers: { 'Accept': 'application/json' }});
        const data = await res.json();

        if (!res.ok) throw new Error(data.message || 'Gagal memuat');
        if (!data.length) { container.innerHTML = '<p class="text-center text-gray-400 py-10 text-[13px]">Belum ada transaksi hari ini.</p>'; return; }

        container.innerHTML = '';
        data.forEach(item => {
            if (item.tipe_riwayat === 'kas') {
            let warna, label, ikon, tandaOperator;

            if (item.tipe_kas === 'modal') {
                warna = { border: 'border-blue-100', bg: 'bg-blue-50', text: 'text-blue-600' };
                label = 'Modal Awal';
                ikon  = '●';
                tandaOperator = '';
            } else if (item.tipe_kas === 'masuk') {
                warna = { border: 'border-emerald-100', bg: 'bg-emerald-50', text: 'text-emerald-600' };
                label = 'Kas Masuk';
                ikon  = '↓';
                tandaOperator = '+';
            } else {
                warna = { border: 'border-red-100', bg: 'bg-red-50', text: 'text-red-600' };
                label = 'Kas Keluar';
                ikon  = '↑';
                tandaOperator = '−';
            }

            container.insertAdjacentHTML('beforeend', `
                <div class="bg-white border ${warna.border} rounded-xl p-4">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg ${warna.bg} ${warna.text} flex items-center justify-center text-[12px] font-bold flex-shrink-0">${ikon}</span>
                            <div>
                                <p class="text-[13px] font-semibold text-gray-800">${label}</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">${item.keterangan}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[14px] font-bold ${warna.text}">${tandaOperator} Rp ${parseInt(item.jumlah).toLocaleString('id-ID')}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">${item.created_at}</p>
                        </div>
                    </div>
                </div>`);
            return;
        }
            

            let detail = '';
            item.items.forEach(i => {
                const suhu = i.suhu_pilihan ? ` [${i.suhu_pilihan}]` : '';
                const note = i.catatan ? ` <em style="font-size:10px">(${i.catatan})</em>` : '';
                detail += `<div class="flex justify-between text-[11px] text-gray-500 mt-1"><span>${i.kuantitas}× ${i.nama}${suhu}${note}</span><span class="font-medium flex-shrink-0 ml-2">Rp ${(i.harga * i.kuantitas).toLocaleString('id-ID')}</span></div>`;
            });

            container.insertAdjacentHTML('beforeend', `
                <div class="bg-white border border-gray-100 rounded-xl p-4">
                    <div class="flex justify-between items-start pb-2 mb-2 border-b border-gray-50">
                        <div>
                            <p class="text-[13px] font-semibold text-gray-800">Meja ${item.nomor_meja} · ${item.nama_pelanggan}</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">${item.created_at}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[14px] font-bold text-gray-900">Rp ${parseInt(item.total_pembayaran).toLocaleString('id-ID')}</p>
                            <span class="text-[10px] font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">${item.metode_pembayaran.toUpperCase()}</span>
                        </div>
                    </div>
                    <div>${detail}</div>
                </div>`);
        });
    } catch(e) { container.innerHTML = `<p class="text-center text-red-400 py-10 text-[13px]">Gagal memuat riwayat: ${e.message}</p>`; }
}

function tutupRiwayat() { document.getElementById('modal-riwayat').classList.add('hidden'); }

let tipeKasAktif = 'masuk';

function bukaModalKas() {
    document.getElementById('kas-jumlah').value = '';
    document.getElementById('kas-keterangan').value = '';
    pilihTipeKas('masuk');
    document.getElementById('modal-kas').classList.remove('hidden');
    document.getElementById('modal-kas').scrollTop = 0;
}

function tutupModalKas() {
    document.getElementById('modal-kas').classList.add('hidden');
}

function pilihTipeKas(tipe) {
    tipeKasAktif = tipe;
    const warnaAktif = {
        modal:  ['bg-blue-600', 'border-blue-600'],
        masuk:  ['bg-emerald-600', 'border-emerald-600'],
        keluar: ['bg-red-600', 'border-red-600'],
    };

    document.querySelectorAll('.tipe-kas-btn').forEach(btn => {
        const btnTipe = btn.dataset.tipeKas;
        const isIni   = btnTipe === tipe;

        Object.values(warnaAktif).flat().forEach(cls => btn.classList.remove(cls));

        if (isIni) {
            btn.classList.add(...warnaAktif[btnTipe], 'text-white');
            btn.classList.remove('bg-white', 'text-gray-500', 'border-gray-200');
        } else {
            btn.classList.add('bg-white', 'text-gray-500', 'border-gray-200');
            btn.classList.remove('text-white');
        }
    });
}

async function simpanKas() {
    const jumlah     = parseInt(document.getElementById('kas-jumlah').value, 10) || 0;
    const keterangan = document.getElementById('kas-keterangan').value.trim();

    if (jumlah <= 0)   { showToast('Nominal harus diisi dan lebih dari 0.', 'error'); return; }
    if (!keterangan)   { showToast('Keterangan wajib diisi.', 'error'); return; }

    const btn = document.getElementById('btn-simpan-kas');
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    try {
        const res = await fetch("{{ route('pos.kas') }}", {
            method : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ tipe: tipeKasAktif, jumlah, keterangan })
        });
        const data = await res.json();

        if (res.ok && data.success) {
            tutupModalKas();
            showToast(`Kas ${tipeKasAktif} berhasil dicatat.`, 'success');
        } else {
            showToast('Gagal: ' + (data.message || 'Server error'), 'error');
        }
    } catch (err) {
        console.error('Detail Eror JS:', err);
        showToast('Kesalahan sistem atau jaringan terputus.', 'error');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Simpan';
    }
}
let stateKategoriAktif = 'semua';

function filterSubKategori(subKat) {
    stateKategoriAktif = subKat;
    
    // Ubah warna tombol tab
    document.querySelectorAll('.tab-pill').forEach(btn => {
        btn.classList.remove('bg-[#1a1a2e]','text-white','border-[#1a1a2e]');
        btn.classList.add('bg-white','text-gray-500','border-gray-200');
    });
    
    const aktif = document.getElementById('btn-tab-' + subKat);
    if (aktif) {
        aktif.classList.add('bg-[#1a1a2e]','text-white','border-[#1a1a2e]');
        aktif.classList.remove('bg-white','text-gray-500','border-gray-200');
    }
    
    // Kosongkan kolom teks setiap kali kasir berpindah tab (opsional)
    const inputSearch = document.getElementById('input-pencarian');
    if (inputSearch) inputSearch.value = '';
    
    jalankanFilterPencarian();
}

function jalankanFilterPencarian() {
    const input = document.getElementById('input-pencarian');
    const query = input ? input.value.toLowerCase() : '';
    
    document.querySelectorAll('.menu-card').forEach(card => {
        // Ambil teks dari elemen h3 dengan aman
        const elemenJudul = card.querySelector('h3');
        if (!elemenJudul) return; 
        
        const namaMenu = elemenJudul.textContent.toLowerCase();
        const cocokTeks = namaMenu.includes(query);
        
        // Logika untuk Menu Reguler (punya class menu-reguler-card)
        if (card.classList.contains('menu-reguler-card')) {
            if (query !== '') {
                // JIKA SEDANG MENCARI TEKS: Tampilkan semua yang namanya cocok (abaikan tab kategori)
                card.style.display = cocokTeks ? '' : 'none';
            } else {
                // JIKA TEKS KOSONG: Tampilkan sesuai tab kategori yang sedang diklik
                const cocokKategori = (stateKategoriAktif === 'semua' || card.dataset.subkategori === stateKategoriAktif);
                card.style.display = cocokKategori ? '' : 'none';
            }
        } 
        // Logika untuk Menu Rekomendasi Cuaca dan Retail
        else {
            card.style.display = cocokTeks ? '' : 'none';
        }
    });
}
// Escape button menutupi semua jendela modal terbuka
document.addEventListener('keydown', e => {
    if (e.key !== 'Escape') return;
    ['modal-opsi-menu','modal-pembayaran','modal-riwayat', 'modal-kas'].forEach(id => document.getElementById(id).classList.add('hidden'));
});
</script>
</body>
</html>