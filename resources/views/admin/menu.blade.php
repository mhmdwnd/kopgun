<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Menu — Kopgun Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">

<div class="flex h-screen overflow-hidden">

    {{-- ======================== SIDEBAR ======================== --}}
    <aside class="w-[220px] flex-shrink-0 bg-white border-r border-gray-100 flex flex-col">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
            <div class="w-9 h-9 rounded-lg bg-[#1a1a2e] flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900 leading-tight">Kopgun</p>
                <p class="text-[11px] text-gray-400">Admin Panel</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">

            <p class="px-2 pt-1 pb-1.5 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Utama</p>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Aplikasi</p>

            <a href="#"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium bg-[#1a1a2e] text-white">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Kelola Menu
            </a>

            <a href="{{ route('admin.orders.index') }}"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Pesanan
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Kategori
            </a>

            <a href="{{ route('admin.tables.index') }}"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
                </svg>
                Meja
            </a>

            <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Laporan</p>

            <a href="{{ route('admin.reports.index') }}"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Laporan Penjualan
            </a>

        </nav>

        {{-- User --}}
        <div class="px-3 py-4 border-t border-gray-100">
            <div class="flex items-center gap-2.5 px-3 py-2">
                <div class="w-7 h-7 rounded-full bg-[#1a1a2e] flex items-center justify-center text-[11px] font-bold text-white flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[12px] font-medium text-gray-800 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-[11px] text-gray-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full mt-1 flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition-colors">
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

        {{-- Topbar --}}
        <header class="h-14 bg-white border-b border-gray-100 flex items-center justify-between px-6 flex-shrink-0">
            <div>
                <h1 class="text-[15px] font-semibold text-gray-900">Kelola Menu</h1>
                <p class="text-[12px] text-gray-400">Tambah, ubah, atau hapus menu restoran</p>
            </div>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-1.5 text-[12px] text-gray-500 border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Dashboard
            </a>
        </header>

        {{-- Content --}}
        <div class="flex-1 overflow-y-auto p-5">
            <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-4 items-start">

                {{-- ===== FORM TAMBAH ===== --}}
                <div class="bg-white rounded-xl border border-gray-100">
                    <div class="flex items-center gap-2.5 px-5 py-3.5 border-b border-gray-100">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <h2 class="text-[13px] font-semibold text-gray-800">Tambah menu baru</h2>
                    </div>
                    <div class="p-5">

                        @if(session('success'))
                            <div class="flex items-center gap-2 bg-green-50 border border-green-100 text-green-700 text-[12px] font-medium px-3.5 py-2.5 rounded-lg mb-4">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Nama --}}
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Nama produk</label>
                                <input type="text" name="nama_menu" value="{{ old('nama_menu') }}" required
                                    placeholder="cth. Es Teh Tarik"
                                    class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-800 placeholder-gray-300 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                                @error('nama_menu')
                                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kategori --}}
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Kategori</label>
                                <select name="kategori" required
                                    class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-800 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                                    <option value="makanan" {{ old('kategori') === 'makanan' ? 'selected' : '' }}>Makanan</option>
                                    <option value="minuman" {{ old('kategori') === 'minuman' ? 'selected' : '' }}>Minuman</option>
                                </select>
                            </div>

                            {{-- Harga --}}
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Harga (Rp)</label>
                                <input type="number" name="harga" value="{{ old('harga') }}" required min="0"
                                    placeholder="0"
                                    class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-800 placeholder-gray-300 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                                @error('harga')
                                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tipe Suhu --}}
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Tipe suhu</label>
                                <select name="tipe_suhu" required
                                    class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-800 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                                    <option value="netral"  {{ old('tipe_suhu') === 'netral'  ? 'selected' : '' }}>Netral (cocok di segala cuaca)</option>
                                    <option value="panas"   {{ old('tipe_suhu') === 'panas'   ? 'selected' : '' }}>Panas / Hot</option>
                                    <option value="dingin"  {{ old('tipe_suhu') === 'dingin'  ? 'selected' : '' }}>Dingin / Ice</option>
                                </select>
                            </div>

                            {{-- Upload Foto --}}
                            <div class="mb-5">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Foto menu</label>
                                <label for="foto-upload"
                                    class="flex flex-col items-center justify-center gap-1.5 border border-dashed border-gray-200 rounded-lg p-5 bg-gray-50 hover:bg-gray-100 hover:border-gray-300 cursor-pointer transition-colors group">
                                    <svg class="w-7 h-7 text-gray-300 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-[12px] text-gray-500">Seret foto ke sini atau <span class="text-[#1a1a2e] font-medium">pilih file</span></p>
                                    <span class="text-[11px] text-gray-400">JPG, PNG · maks. 2MB</span>
                                </label>
                                <input id="foto-upload" type="file" name="foto" accept="image/*" class="hidden">
                                <p id="foto-name" class="text-[11px] text-gray-400 mt-1.5 truncate hidden"></p>
                            </div>

                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 bg-[#1a1a2e] hover:bg-[#2a2a42] text-white text-[13px] font-medium py-2.5 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Simpan menu
                            </button>
                        </form>

                    </div>
                </div>

                {{-- ===== TABEL MENU ===== --}}
                <div class="bg-white rounded-xl border border-gray-100">
                    <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            <h2 class="text-[13px] font-semibold text-gray-800">Daftar menu</h2>
                        </div>
                        <span class="text-[11px] text-gray-400 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">
                            {{ $menus->count() }} item
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3 w-14">Foto</th>
                                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Menu</th>
                                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Kategori</th>
                                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Suhu</th>
                                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Harga</th>
                                    <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($menus as $menu)
                                    <tr class="hover:bg-gray-50/60 transition-colors">

                                        {{-- Foto --}}
                                        <td class="px-5 py-3.5">
                                            @if($menu->foto)
                                                <img src="{{ asset('storage/' . $menu->foto) }}"
                                                    alt="{{ $menu->nama_menu }}"
                                                    class="w-11 h-11 object-cover rounded-lg border border-gray-100">
                                            @else
                                                <div class="w-11 h-11 rounded-lg bg-gray-100 border border-gray-100 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Nama --}}
                                        <td class="px-5 py-3.5">
                                            <p class="text-[13px] font-medium text-gray-900">{{ $menu->nama_menu }}</p>
                                        </td>

                                        {{-- Kategori --}}
                                        <td class="px-5 py-3.5">
                                            @if($menu->kategori === 'makanan')
                                                <span class="inline-flex items-center gap-1 text-[11px] font-medium px-2.5 py-1 rounded-full bg-green-50 text-green-700 border border-green-100">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/>
                                                    </svg>
                                                    Makanan
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-[11px] font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                                    </svg>
                                                    Minuman
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Suhu --}}
                                        <td class="px-5 py-3.5">
                                            @php
                                                $suhuMap = [
                                                    'panas'  => ['label' => 'Panas',  'class' => 'bg-orange-50 text-orange-700 border-orange-100'],
                                                    'dingin' => ['label' => 'Dingin', 'class' => 'bg-sky-50 text-sky-700 border-sky-100'],
                                                    'netral' => ['label' => 'Netral', 'class' => 'bg-gray-50 text-gray-500 border-gray-100'],
                                                ];
                                                $suhu = $suhuMap[$menu->tipe_suhu] ?? $suhuMap['netral'];
                                            @endphp
                                            <span class="inline-flex text-[11px] font-medium px-2.5 py-1 rounded-full border {{ $suhu['class'] }}">
                                                {{ $suhu['label'] }}
                                            </span>
                                        </td>

                                        {{-- Harga --}}
                                        <td class="px-5 py-3.5">
                                            <span class="text-[13px] font-semibold text-gray-900">
                                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center justify-end gap-2">
                                                {{-- Edit --}}
                                                <a href="{{ route('admin.menu.edit', $menu->id) }}"
                                                    class="inline-flex items-center gap-1.5 text-[12px] text-gray-500 border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-50 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Ubah
                                                </a>

                                                {{-- Delete --}}
                                                <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus menu {{ addslashes($menu->nama_menu) }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1.5 text-[12px] text-red-500 border border-red-100 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-16 text-center">
                                            <div class="flex flex-col items-center gap-2">
                                                <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                                <p class="text-[13px] text-gray-400">Belum ada menu yang ditambahkan.</p>
                                                <p class="text-[12px] text-gray-300">Gunakan form di sebelah kiri untuk menambah menu pertama.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                {{-- end tabel --}}

            </div>
        </div>
        {{-- end content --}}

    </div>
    {{-- end main --}}

</div>

<script>
    // Tampilkan nama file yang dipilih
    document.getElementById('foto-upload')?.addEventListener('change', function () {
        const nameEl = document.getElementById('foto-name');
        if (this.files.length > 0) {
            nameEl.textContent = this.files[0].name;
            nameEl.classList.remove('hidden');
        } else {
            nameEl.classList.add('hidden');
        }
    });
</script>

</body>
</html>