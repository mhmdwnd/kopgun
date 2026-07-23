<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Kopgun Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bar-harian { transition: height 0.4s cubic-bezier(0.4,0,0.2,1); }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">

<div class="flex h-screen overflow-hidden">

    {{-- ======================== SIDEBAR ======================== --}}
    <aside class="w-[220px] flex-shrink-0 bg-[#1A1A2E] border-r border-[#2A2A48] flex flex-col">
       <div class="flex items-center gap-3 px-5 py-4 border-b border-[#2A2A48]">
            <div class="w-9 h-9 rounded-lg bg-[#2C4870] flex items-center justify-center flex-shrink-0 p-1.5">
                <img src="{{ asset('images/kopgun-logo-icon.png') }}" alt="Kopgun" class="w-full h-full object-contain">
            </div>
            <div>
                <p class="text-sm font-semibold text-white leading-tight">Kopgun</p>
                <p class="text-[11px] text-slate-400">Admin Panel</p>
            </div>
        </div>

        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">
            <p class="px-2 pt-1 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Utama</p>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Aplikasi</p>

            <a href="#"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-semibold bg-[#2C4870]/30 text-[#9DBADD] border border-[#2C4870]/50">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Kelola Menu
            </a>

            <a href="#"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Pesanan
            </a>
            <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Konten Publik</p>

            <a href="{{ route('admin.event.index') }}"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Kelola Event
            </a>
            <a href="{{ route('admin.area.index') }}"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4M3 13v6l9 4 9-4v-6"/>
                </svg>
                Kelola Area
            </a>     
            <a href="#"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
                </svg>
                Meja
            </a>

            <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Retail</p>

            <a href="{{ route('admin.retail.index') }}"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Etalase Biji Kopi
            </a>

            <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Laporan</p>

            <a href="{{ route('admin.laporan.index') }}"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Laporan Penjualan
            </a>
        </nav>

        <div class="px-3 py-4 border-t border-[#2A2A48]">
            <div class="flex items-center gap-2.5 px-3 py-2">
                <div class="w-7 h-7 rounded-full bg-[#2C4870] flex items-center justify-center text-[11px] font-bold text-white flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[12px] font-medium text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-[11px] text-slate-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full mt-1 flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] text-slate-400 hover:bg-white/5 hover:text-slate-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>


    {{-- ======================== MAIN ======================== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        <header class="h-14 bg-white border-b border-gray-100 flex items-center justify-between px-6 flex-shrink-0 gap-4">
        <div class="flex-shrink-0">
                <h1 class="text-[15px] font-semibold text-gray-900">Dashboard</h1>
                <p class="text-[12px] text-gray-400">Ringkasan operasional Kopgun</p>
            </div>

            <div class="flex items-center gap-3">
                {{-- Widget Suhu Terkini --}}
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

                <span class="text-[12px] text-gray-400 whitespace-nowrap">{{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</span>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-5 space-y-4">

            {{-- ===== KARTU RINGKASAN CEPAT ===== --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="bg-white border border-gray-100 rounded-xl p-4">
                    <p class="text-[11px] text-gray-400 mb-1">Penjualan Hari Ini</p>
                    <p class="text-[18px] font-bold text-gray-900">Rp {{ number_format($totalPenjualanHariIni, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white border border-gray-100 rounded-xl p-4">
                    <p class="text-[11px] text-gray-400 mb-1">Transaksi Hari Ini</p>
                    <p class="text-[18px] font-bold text-gray-900">{{ $jumlahTransaksiHariIni }} <span class="text-[12px] font-normal text-gray-400">struk</span></p>
                </div>
                <div class="bg-[#2C4870] rounded-xl p-4">
                    <p class="text-[11px] text-[#C3D4E8] mb-1">Saldo Kas Saat Ini</p>
                    <p class="text-[18px] font-bold text-white">Rp {{ number_format($saldoKasHariIni, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white border {{ $menuHabis->count() > 0 ? 'border-red-200' : 'border-gray-100' }} rounded-xl p-4">
                    <p class="text-[11px] text-gray-400 mb-1">Menu Perlu Restock</p>
                    <p class="text-[18px] font-bold {{ $menuHabis->count() > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $menuHabis->count() }} <span class="text-[12px] font-normal text-gray-400">item</span></p>
                </div>
            </div>

            {{-- ===== GRAFIK PENJUALAN 7 HARI ===== --}}
            <div class="bg-white border border-gray-100 rounded-xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-[13px] font-semibold text-gray-800">Penjualan 7 Hari Terakhir</h2>
                    <a href="{{ route('admin.laporan.index') }}" class="text-[11px] text-gray-400 hover:text-[#2C4870] transition-colors">Lihat laporan lengkap →</a>
                </div>
                <div class="flex items-end gap-3 h-40 overflow-x-auto pb-1">
                    @foreach($grafikHarian as $hari)
                        @php $tinggiPersen = $maxHarian > 0 ? max(4, ($hari['total'] / $maxHarian) * 100) : 4; @endphp
                        <div class="flex-1 min-w-[36px] flex flex-col items-center justify-end h-full group">
                            <span class="text-[9px] font-semibold text-gray-600 mb-1 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                Rp {{ number_format($hari['total'], 0, ',', '.') }}
                            </span>
                            <div class="bar-harian w-full rounded-t-md hover:opacity-80 {{ $hari['is_hari_ini'] ? 'bg-gradient-to-t from-[#1A1A2E] to-[#2C4870]' : 'bg-gray-200' }}"
                                 style="height: {{ $tinggiPersen }}%"></div>
                            <span class="text-[9px] text-gray-400 mt-1.5 whitespace-nowrap">{{ $hari['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ===== MENU TERLARIS & PERLU RESTOCK (2 KOLOM) ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                {{-- Menu Paling Laris --}}
                <div class="bg-white border border-gray-100 rounded-xl">
                    <div class="px-5 py-3.5 border-b border-gray-100">
                        <h2 class="text-[13px] font-semibold text-gray-800">Menu Paling Laris</h2>
                        <p class="text-[11px] text-gray-400 mt-0.5">30 hari terakhir</p>
                    </div>
                    <div class="p-5 space-y-3">
                        @forelse($menuTerlaris as $index => $item)
                            @php $persen = $maxTerlaris > 0 ? ($item['qty'] / $maxTerlaris) * 100 : 0; @endphp
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center text-[11px] font-bold
                                    {{ $index === 0 ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-center mb-1">
                                        <p class="text-[12px] font-medium text-gray-800 truncate pr-2">{{ $item['nama'] }}</p>
                                        <span class="text-[11px] font-semibold text-gray-600 flex-shrink-0">{{ $item['qty'] }}× terjual</span>
                                    </div>
                                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#2C4870] rounded-full" style="width: {{ $persen }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-[12px] text-gray-400 text-center py-6">Belum ada data penjualan dalam 30 hari terakhir.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Menu Perlu Restock --}}
                <div class="bg-white border border-gray-100 rounded-xl">
                    <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                        <div>
                            <h2 class="text-[13px] font-semibold text-gray-800">Menu Perlu Restock</h2>
                            <p class="text-[11px] text-gray-400 mt-0.5">Status: Habis</p>
                        </div>
                        <a href="{{ route('admin.menu.index') }}" class="text-[11px] text-gray-400 hover:text-[#2C4870] transition-colors">Kelola menu →</a>
                    </div>
                    <div class="p-5 space-y-3 max-h-72 overflow-y-auto">
                        @forelse($menuHabis as $menu)
                            <div class="flex items-center gap-3">
                                @if($menu->foto)
                                    <img src="{{ asset('storage/'.$menu->foto) }}" class="w-9 h-9 rounded-lg object-cover border border-gray-100 flex-shrink-0">
                                @else
                                    <div class="w-9 h-9 rounded-lg bg-gray-100 border border-gray-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-[12px] font-medium text-gray-800 truncate">{{ $menu->nama_menu }}</p>
                                    <p class="text-[10px] text-gray-400">{{ ucwords(str_replace('_', ' ', $menu->sub_kategori)) }}</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded-full bg-red-50 text-red-600 border border-red-100 flex-shrink-0">Habis</span>
                            </div>
                        @empty
                            <p class="text-[12px] text-gray-400 text-center py-6">Semua menu tersedia. Tidak ada yang perlu di-restock. ✓</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>