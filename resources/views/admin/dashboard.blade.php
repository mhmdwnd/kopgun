<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Admin - Kopgun</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col">
        <div class="h-20 flex items-center px-8 border-b border-gray-50">
            <div class="flex items-center gap-2 text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <span class="text-xl font-bold text-gray-800">Kopgun</span>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-blue-600 bg-blue-50 rounded-lg font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            
            <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Aplikasi</div>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-blue-600 hover:bg-gray-50 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Kelola Menu
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-blue-600 hover:bg-gray-50 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Laporan Transaksi
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <header class="h-20 bg-white flex items-center justify-between px-8 border-b border-gray-100 shadow-sm z-10">
            <div class="relative w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" class="w-full bg-gray-50 border border-transparent text-gray-800 text-sm rounded-full focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5" placeholder="Cari menu, transaksi, atau pelanggan...">
            </div>

            <div class="flex items-center gap-6">
                <button class="text-gray-400 hover:text-gray-600 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                </button>
                <div class="flex items-center gap-3 border-l pl-6">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200">
                        A
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500" title="Keluar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-blue-600 rounded-xl p-6 shadow-sm text-white">
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Pendapatan</p>
                    <h3 class="text-3xl font-bold mb-4">Rp 4.579.000</h3>
                    <p class="text-xs text-blue-200">Naik 25% dari minggu lalu</p>
                </div>

                <div class="bg-blue-400 rounded-xl p-6 shadow-sm text-white">
                    <p class="text-blue-50 text-sm font-medium mb-1">Total Transaksi</p>
                    <h3 class="text-3xl font-bold mb-4">184</h3>
                    <p class="text-xs text-blue-100">Naik 12% dari minggu lalu</p>
                </div>

                <div class="bg-purple-500 rounded-xl p-6 shadow-sm text-white">
                    <p class="text-purple-100 text-sm font-medium mb-1">Total Menu Aktif</p>
                    <h3 class="text-3xl font-bold mb-4">{{ $menus->count() ?? 0 }}</h3>
                    <p class="text-xs text-purple-200">Makanan & Minuman</p>
                </div>

                <div class="bg-green-400 rounded-xl p-6 shadow-sm text-white">
                    <p class="text-green-50 text-sm font-medium mb-1">Suhu Cuaca Saat Ini</p>
                    <h3 class="text-3xl font-bold mb-4">26°C</h3>
                    <p class="text-xs text-green-100">Rekomendasi: Menu Dingin</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-gray-800 font-bold">Grafik Penjualan Mingguan</h3>
                        <div class="flex gap-2">
                            <span class="text-xs bg-gray-100 px-3 py-1 rounded text-gray-600 cursor-pointer">Bulanan</span>
                            <span class="text-xs bg-gray-100 px-3 py-1 rounded text-gray-600 cursor-pointer">Tahunan</span>
                        </div>
                    </div>
                    <div class="h-64 flex items-end justify-between gap-2 border-b border-l border-gray-200 pb-2 pl-2">
                        <div class="w-1/12 bg-blue-400 rounded-t h-2/6 hover:bg-blue-500 transition"></div>
                        <div class="w-1/12 bg-purple-400 rounded-t h-4/6 hover:bg-purple-500 transition"></div>
                        <div class="w-1/12 bg-blue-600 rounded-t h-3/6 hover:bg-blue-700 transition"></div>
                        <div class="w-1/12 bg-green-400 rounded-t h-5/6 hover:bg-green-500 transition"></div>
                        <div class="w-1/12 bg-blue-400 rounded-t h-2/6 hover:bg-blue-500 transition"></div>
                        <div class="w-1/12 bg-purple-400 rounded-t h-full hover:bg-purple-500 transition"></div>
                        <div class="w-1/12 bg-blue-600 rounded-t h-3/6 hover:bg-blue-700 transition"></div>
                        <div class="w-1/12 bg-green-400 rounded-t h-1/6 hover:bg-green-500 transition"></div>
                    </div>
                    <div class="flex justify-between mt-2 text-xs text-gray-400">
                        <span>Senin</span><span>Selasa</span><span>Rabu</span><span>Kamis</span><span>Jumat</span><span>Sabtu</span><span>Minggu</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-gray-800 font-bold mb-6 text-center">Persentase Penjualan Menu</h3>
                    <div class="flex justify-center items-center h-48 relative">
                        <div class="w-32 h-32 rounded-full border-8 border-blue-500 border-t-purple-500 border-r-green-400 flex items-center justify-center shadow-inner">
                            <span class="text-2xl font-bold text-gray-700">100%</span>
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-6 text-xs text-gray-500">
                        <div class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Minuman Dingin</div>
                        <div class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-purple-500"></span> Minuman Panas</div>
                    </div>
                </div>
            </div>

        </main>
    </main>
</body>
</html>