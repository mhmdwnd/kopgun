<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>DASHBOARD - Kopgun Admin</title>
    @vite(['resources/css/app.css', 'resouces/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <div class="flex h-screen overflow-hidden">

        {{--==========  SIDEBAR ==========--}}
        <aside class="w-[210px] flex-shrink-0 bg-white border-r border-gray-100 flex flex-col">
            {{--LOGO--}}
            <div class="flex items-center gap-2.5 px-4 py-4 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg bg-[#1a1a2e] flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M13 10V3L4 14h7v7l9-11h-7z">
                    </svg>
                </div>
                <div>
                    <p class="text-[14px] font-semibold text-gray-900 leading-tight">Kopgun                      
                    </p>
                    <p class="text-[11px] text-gray-400">Admin Panel</p>
                </div>
            </div>
            {{--Nav--}}
            <nav class="flex-1 px-2.5 py-3 overflow-y-auto space-y-0.5">
                <p class="px-2 pt-1 pb-1 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Utama</p>
                <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium bg-[#1a1a2e] text-white">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>   
                    DashBoard
                </a>
                <p class="px-2 pt-3 pb-1 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Aplikasi</p>
                <a href="{{ route('admin.menu.index') }}"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Kelola Menu
            </a>
            <a href="#"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Laporan Transaksi
            </a>
            </nav>
            {{--User--}}
            <div class="px-3 py-3 border-t border-gray-100">
            <div class="flex items-center gap-2.5 px-2 py-1.5">
                <div class="w-7 h-7 rounded-full bg-[#1a1a2e] flex items-center justify-center text-[11px] font-semibold text-white flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[12px] font-medium text-gray-800 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-[11px] text-gray-400 capitalize truncate">{{ auth()->user()->role ?? 'administrator' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full mt-1 flex items-center gap-2.5 px-3 py-2 rounded-lg text-[12px] text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
        </aside>

        {{--==========  Main   ==========--}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{--    topbar  --}}
            <header class="h-[52px] bg-white border-b border-gray-100 px-5 flex items-center justify-between flex-shrink-0">
                <div>
                <h1 class="text-[15px] font-semibold text-gray-900">Dashboard</h1>
                <p class="text-[11px] text-gray-400">Selamat datang kembali, {{ auth()->user()->name ?? 'Admin' }}</p>
            </div>
            <div class="flex items-center gap-2">
                {{-- Notif --}}
                <button class="relative p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                </button>
                 {{-- Tanggal --}}
                <div class="hidden sm:flex items-center gap-1.5 text-[12px] text-gray-400 bg-gray-50 border border-gray-100 px-3 py-1.5 rounded-lg">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ now()->locale('id')->isoFormat('dddd, D MMM Y') }}
                </div>
            </div>
            </header>
                {{-- Content --}}
        <div class="flex-1 overflow-y-auto p-5 space-y-4">

            {{-- ===== STAT CARDS ===== --}}
            <div class="grid grid-cols-2 xl:grid-cols-4 gap-3">

                {{-- Pendapatan --}}
                <div class="bg-white border border-gray-100 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-medium bg-green-50 text-green-700 px-2 py-0.5 rounded-full">+25%</span>
                    </div>
                    <p class="text-[22px] font-semibold text-gray-900 leading-none mb-1">
                        Rp {{ number_format($totalPendapatan ?? 4579000, 0, ',', '.') }}
                    </p>
                    <p class="text-[11px] text-gray-400">Pendapatan hari ini</p>
                </div>

                {{-- Transaksi --}}
                <div class="bg-white border border-gray-100 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-medium bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full">+12%</span>
                    </div>
                    <p class="text-[22px] font-semibold text-gray-900 leading-none mb-1">{{ $totalTransaksi ?? 184 }}</p>
                    <p class="text-[11px] text-gray-400">Total transaksi</p>
                </div>

                {{-- Menu Aktif --}}
                <div class="bg-white border border-gray-100 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-medium bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full">Aktif</span>
                    </div>
                    <p class="text-[22px] font-semibold text-gray-900 leading-none mb-1">{{ $menus->count() ?? 0 }}</p>
                    <p class="text-[11px] text-gray-400">Menu aktif</p>
                </div>

                {{-- Cuaca --}}
                <div class="bg-white border border-gray-100 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-8 h-8 rounded-lg bg-teal-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-medium bg-teal-50 text-teal-700 px-2 py-0.5 rounded-full">
                            @if(($cuaca ?? 26) >= 28) Panas
                            @elseif(($cuaca ?? 26) <= 22) Dingin
                            @else Sedang
                            @endif
                        </span>
                    </div>
                    <p class="text-[22px] font-semibold text-gray-900 leading-none mb-1">{{ $cuaca ?? 26 }}°C</p>
                    <p class="text-[11px] text-gray-400">
                        Rekomendasi:
                        @if(($cuaca ?? 26) >= 28) menu dingin
                        @elseif(($cuaca ?? 26) <= 22) menu panas
                        @else semua menu
                        @endif
                    </p>
                </div>

            </div>

            {{-- ===== ROW 2: Grafik + Donut ===== --}}
            <div class="grid grid-cols-1 xl:grid-cols-[1fr_280px] gap-4">

                {{-- Grafik Penjualan --}}
                <div class="bg-white border border-gray-100 rounded-xl">
                    <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                        <h2 class="text-[13px] font-semibold text-gray-900">Penjualan mingguan</h2>
                        <div class="flex gap-1.5">
                            <button onclick="setTab(this,'Mingguan')"
                                class="tab-btn text-[11px] px-3 py-1 rounded-lg bg-[#1a1a2e] text-white border border-[#1a1a2e] transition-colors">
                                Mingguan
                            </button>
                            <button onclick="setTab(this,'Bulanan')"
                                class="tab-btn text-[11px] px-3 py-1 rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors">
                                Bulanan
                            </button>
                            <button onclick="setTab(this,'Tahunan')"
                                class="tab-btn text-[11px] px-3 py-1 rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 transition-colors">
                                Tahunan
                            </button>
                        </div>
                    </div>

                    {{-- Bar Chart --}}
                    <div class="px-5 pt-4 pb-2">
                        <div class="flex items-end gap-2 h-32 border-b border-l border-gray-100 pl-1 pb-0">
                            @php
                                $bars = [
                                    ['Sn', 38, '#B5D4F4'],
                                    ['Sl', 55, '#85B7EB'],
                                    ['Rb', 70, '#378ADD'],
                                    ['Km', 88, '#185FA5'],
                                    ['Jm', 60, '#85B7EB'],
                                    ['Sb', 100, '#0C447C'],
                                    ['Mg', 44, '#B5D4F4'],
                                ];
                            @endphp
                            @foreach($bars as [$label, $pct, $color])
                                <div class="flex flex-col items-center gap-1 flex-1 h-full justify-end group">
                                    <div class="relative w-full flex justify-center">
                                        <div class="w-full rounded-t transition-opacity group-hover:opacity-75"
                                            style="height: {{ $pct }}%; background: {{ $color }}; min-height: 4px;"></div>
                                    </div>
                                    <span class="text-[9px] text-gray-400 -mb-0.5">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Mini Tabel Menu Terlaris --}}
                    <div class="px-1 pb-1 mt-1">
                        <div class="px-4 py-2 border-t border-gray-50">
                            <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Menu terlaris</p>
                        </div>
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-left text-[10px] font-medium text-gray-400 uppercase tracking-wider px-4 py-2">Menu</th>
                                    <th class="text-left text-[10px] font-medium text-gray-400 uppercase tracking-wider px-4 py-2">Kategori</th>
                                    <th class="text-left text-[10px] font-medium text-gray-400 uppercase tracking-wider px-4 py-2">Terjual</th>
                                    <th class="text-left text-[10px] font-medium text-gray-400 uppercase tracking-wider px-4 py-2">Suhu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($topMenus ?? [] as $menu)
                                    <tr class="hover:bg-gray-50/60 transition-colors">
                                        <td class="px-4 py-2.5 text-[12px] font-medium text-gray-800">{{ $menu->nama_menu }}</td>
                                        <td class="px-4 py-2.5 text-[12px] text-gray-400 capitalize">{{ $menu->kategori }}</td>
                                        <td class="px-4 py-2.5 text-[12px] text-gray-800">{{ $menu->total_terjual ?? 0 }}</td>
                                        <td class="px-4 py-2.5">
                                            @php
                                                $suhuClass = match($menu->tipe_suhu ?? 'netral') {
                                                    'panas'  => 'bg-orange-50 text-orange-700',
                                                    'dingin' => 'bg-sky-50 text-sky-700',
                                                    default  => 'bg-gray-100 text-gray-500',
                                                };
                                                $suhuLabel = match($menu->tipe_suhu ?? 'netral') {
                                                    'panas'  => 'Panas',
                                                    'dingin' => 'Dingin',
                                                    default  => 'Netral',
                                                };
                                            @endphp
                                            <span class="text-[10px] font-medium px-2 py-0.5 rounded-full {{ $suhuClass }}">
                                                {{ $suhuLabel }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Contoh data statis jika belum ada data --}}
                                    @foreach([
                                        ['Es Kopi Susu','minuman',48,'dingin'],
                                        ['Nasi Goreng Spesial','makanan',41,'panas'],
                                        ['Mie Ayam Bakso','makanan',35,'panas'],
                                        ['Air Mineral','minuman',29,'netral'],
                                    ] as [$nm,$kat,$jml,$suhu])
                                        <tr class="hover:bg-gray-50/60 transition-colors">
                                            <td class="px-4 py-2.5 text-[12px] font-medium text-gray-800">{{ $nm }}</td>
                                            <td class="px-4 py-2.5 text-[12px] text-gray-400 capitalize">{{ $kat }}</td>
                                            <td class="px-4 py-2.5 text-[12px] text-gray-800">{{ $jml }}</td>
                                            <td class="px-4 py-2.5">
                                                @php
                                                    $sc = match($suhu) {
                                                        'panas'  => 'bg-orange-50 text-orange-700',
                                                        'dingin' => 'bg-sky-50 text-sky-700',
                                                        default  => 'bg-gray-100 text-gray-500',
                                                    };
                                                @endphp
                                                <span class="text-[10px] font-medium px-2 py-0.5 rounded-full {{ $sc }}">
                                                    {{ ucfirst($suhu) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Donut Chart --}}
                <div class="bg-white border border-gray-100 rounded-xl">
                    <div class="px-5 py-3.5 border-b border-gray-100">
                        <h2 class="text-[13px] font-semibold text-gray-900">Persentase penjualan</h2>
                    </div>
                    <div class="flex flex-col items-center p-6 gap-6">
                        {{-- SVG Donut --}}
                        <svg viewBox="0 0 120 120" class="w-36 h-36">
                            {{-- Track --}}
                            <circle cx="60" cy="60" r="46" fill="none" stroke="#E6F1FB" stroke-width="14"/>
                            {{-- Minuman Dingin 48% ≈ 138.7° --}}
                            <circle cx="60" cy="60" r="46" fill="none" stroke="#378ADD" stroke-width="14"
                                stroke-dasharray="138.8 150.3" stroke-dashoffset="36" stroke-linecap="butt"/>
                            {{-- Makanan 30% ≈ 86.7° --}}
                            <circle cx="60" cy="60" r="46" fill="none" stroke="#185FA5" stroke-width="14"
                                stroke-dasharray="86.7 202.4" stroke-dashoffset="-102.8" stroke-linecap="butt"/>
                            {{-- Minuman Panas 22% ≈ 63.5° --}}
                            <circle cx="60" cy="60" r="46" fill="none" stroke="#9FE1CB" stroke-width="14"
                                stroke-dasharray="63.5 225.6" stroke-dashoffset="-189.5" stroke-linecap="butt"/>
                            <text x="60" y="55" text-anchor="middle" font-size="17" font-weight="500" fill="#1a1a2e">184</text>
                            <text x="60" y="69" text-anchor="middle" font-size="9.5" fill="#9ca3af">transaksi</text>
                        </svg>

                        {{-- Legenda --}}
                        <div class="w-full space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-[#378ADD]"></div>
                                    <span class="text-[12px] text-gray-500">Minuman dingin</span>
                                </div>
                                <span class="text-[12px] font-semibold text-gray-900">48%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-[#185FA5]"></div>
                                    <span class="text-[12px] text-gray-500">Makanan</span>
                                </div>
                                <span class="text-[12px] font-semibold text-gray-900">30%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-[#9FE1CB]"></div>
                                    <span class="text-[12px] text-gray-500">Minuman panas</span>
                                </div>
                                <span class="text-[12px] font-semibold text-gray-900">22%</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            {{-- end row 2 --}}

        </div>
        {{--    end main --}}
        </div>
        <script>
            function setTab(el, label) {
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('bg-[#1a1a2e]', 'text-white', 'border-[#1a1a2e]');
                    btn.classList.add('border-gray-200', 'text-gray-400');
                });
                el.classList.add('bg-[#1a1a2e]', 'text-white', 'border-[#1a1a2e]');
                el.classList.remove('border-gray-200', 'text-gray-400');
            }
        </script>

 
</body>
</html>