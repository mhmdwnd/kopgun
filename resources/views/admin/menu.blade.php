<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Menu — Kopgun Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Row hover: slide-in left border accent */
        .menu-row {
            position: relative;
            transition: background 0.15s;
        }
        .menu-row::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #1a1a2e;
            border-radius: 0 2px 2px 0;
            transform: scaleY(0);
            transform-origin: center;
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .menu-row:hover::before {
            transform: scaleY(1);
        }
        .menu-row:hover {
            background: #f9fafb;
        }

        /* Action button hover: fill sweep */
        .btn-action {
            position: relative;
            overflow: hidden;
            transition: color 0.2s, border-color 0.2s;
        }
        .btn-action::after {
            content: '';
            position: absolute;
            inset: 0;
            background: currentColor;
            opacity: 0;
            transition: opacity 0.18s;
        }
        .btn-action:hover::after {
            opacity: 0.07;
        }

        /* Modal entry animation */
        #editModalPanel {
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s;
            transform: translateY(12px) scale(0.98);
            opacity: 0;
        }
        #editModal:not(.hidden) #editModalPanel {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">

<div class="flex h-screen overflow-hidden">

    {{-- ======================== SIDEBAR ======================== --}}
    <aside class="w-[220px] flex-shrink-0 bg-white border-r border-gray-100 flex flex-col">

        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
            <div class="w-9 h-9 rounded-lg bg-[#1a1a2e] flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900 leading-tight">Kopgun</p>
                <p class="text-[11px] text-gray-400">Admin Panel</p>
            </div>
        </div>

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

            <a href="#"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Pesanan
            </a>

            <a href="#"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Kategori
            </a>

            <a href="#"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
                </svg>
                Meja
            </a>

            <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Retail</p>

            <a href="{{ route('admin.retail.index') }}"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Etalase Biji Kopi
            </a>

            <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Laporan</p>

            <a href="#"
                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Laporan Penjualan
            </a>
        </nav>

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

                            <div class="mb-4">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Nama produk</label>
                                <input type="text" name="nama_menu" value="{{ old('nama_menu') }}" required
                                    placeholder="cth. Es Teh Tarik"
                                    class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-800 placeholder-gray-300 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                                @error('nama_menu')
                                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Kategori</label>
                                <select name="kategori"  id="kategori" required
                                    class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-800 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                                    <option value="makanan" {{ old('kategori') === 'makanan' ? 'selected' : '' }}>Makanan</option>
                                    <option value="minuman" {{ old('kategori') === 'minuman' ? 'selected' : '' }}>Minuman</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Sub Kategori</label>
                                <select name="sub_kategori" id="sub_kategori" required
                                class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-800 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                                <option value="" disabled selected>Pilih sub kategori...</option>
                                <optgroup label="Kategori Makanan" data-kategori="makanan">
                                    <option value="snack" {{ old('sub_kategori') === 'snack' ? 'selected' : '' }}>Snack Kopgun</option>
                                    <option value="mie" {{ old('sub_kategori') === 'mie' ? 'selected' : '' }}>Mie</option>
                                    <option value="makanan_berat" {{ old('sub_kategori') === 'makanan_berat' ? 'selected' : '' }}>Makanan Berat</option>
                                    <option value="roti_bakar" {{ old('sub_kategori') === 'roti_bakar' ? 'selected' : '' }}>Roti Bakar</option>
                                </optgroup>
                                <optgroup label="Kategori Minuman" data-kategori="minuman">
                                    <option value="signature_coffee" {{ old('sub_kategori') === 'signature_coffee' ? 'selected' : '' }}>Signature Coffee</option>
                                    <option value="flavor_latte" {{ old('sub_kategori') === 'flavor_latte' ? 'selected' : '' }}>Flavor Latte</option>
                                    <option value="manual_brew" {{ old('sub_kategori') === 'manual_brew' ? 'selected' : '' }}>Manual Brew</option>
                                    <option value="soda" {{ old('sub_kategori') === 'soda' ? 'selected' : '' }}>Splitz Soda Base</option>
                                    <option value="spresso_mixology" {{ old('sub_kategori') === 'spresso_mixology' ? 'selected' : '' }}>Spresso Mixology</option>
                                    <option value="artisan_tea_mixology" {{ old('sub_kategori') === 'artisan_tea_mixology' ? 'selected' : '' }}>Artisan Tea Mixology</option>
                                    <option value="espresso_based" {{ old('sub_kategori') === 'espresso_based' ? 'selected' : '' }}>Espresso Based Mixology</option>
                                    <option value="non_coffee" {{ old('sub_kategori') === 'non_coffee' ? 'selected' : '' }}>Non Coffee</option>
                                    <option value="milk_based" {{ old('sub_kategori') === 'milk_based' ? 'selected' : '' }}>Milk Based</option>
                                </optgroup>
                            </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Harga (Rp)</label>
                                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden focus-within:border-[#1a1a2e] focus-within:ring-2 focus-within:ring-[#1a1a2e]/10 transition">
                                    <button type="button" onclick="stepHarga('harga', -1000)"
                                        class="flex-shrink-0 w-9 h-9 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-50 border-r border-gray-200 transition-colors select-none text-lg leading-none">
                                        −
                                    </button>
                                    <input type="number" id="harga" name="harga" value="{{ old('harga', 0) }}" required min="0" step="1000"
                                        class="flex-1 text-[13px] px-3 py-2 bg-white text-gray-800 text-center focus:outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none">
                                    <button type="button" onclick="stepHarga('harga', 1000)"
                                        class="flex-shrink-0 w-9 h-9 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-50 border-l border-gray-200 transition-colors select-none text-lg leading-none">
                                        +
                                    </button>
                                </div>
                                <p class="text-[11px] text-gray-400 mt-1">Kelipatan Rp 1.000</p>
                                @error('harga')
                                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                            <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Tipe suhu</label>
                            <select name="tipe_suhu" required
                                class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-800 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                                <option value="netral" {{ old('tipe_suhu') === 'netral' ? 'selected' : '' }}>Netral (cocok di segala cuaca)</option>
                                <option value="panas" {{ old('tipe_suhu') === 'panas' ? 'selected' : '' }}>Panas (direkomendasikan saat cuaca dingin/hujan)</option>
                                <option value="dingin" {{ old('tipe_suhu') === 'dingin' ? 'selected' : '' }}>Dingin (direkomendasikan saat cuaca panas)</option>
                            </select>
                            <p class="text-[11px] text-gray-400 mt-1">
                                "Panas" → direkomendasikan saat cuaca dingin/hujan.
                                "Dingin" → direkomendasikan saat cuaca panas.
                                "Netral" → cocok di segala cuaca, akan selalu tampil di rekomendasi.
                            </p>
                            @error('tipe_suhu')
                                <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                            <div class="mb-5">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Status Ketersediaan</label>
                                <select name="status" required
                                    class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-800 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                                    <option value="tersedia">Tersedia (Tampil di Kasir)</option>
                                    <option value="habis">Habis (Stok Kosong)</option>
                                    <option value="musiman">Baru (Sembunyikan sementara)</option>
                                </select>
                            </div>

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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
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
                                    <tr class="menu-row">

                                        {{-- Foto --}}
                                        <td class="px-5 py-3.5">
                                            @if($menu->foto)
                                                <img src="{{ asset('storage/' . $menu->foto) }}"
                                                    alt="{{ $menu->nama_menu }}"
                                                    class="w-11 h-11 object-cover rounded-lg border border-gray-100 transition-transform duration-200 group-hover:scale-105">
                                            @else
                                                <div class="w-11 h-11 rounded-lg bg-gray-100 border border-gray-100 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Nama & Status --}}
                                        <td class="px-5 py-3.5">
                                            <p class="text-[13px] font-medium text-gray-900 mb-1">{{ $menu->nama_menu }}</p>
                                            @if($menu->status === 'tersedia')
                                                <span class="inline-flex text-[10px] font-semibold px-2 py-0.5 rounded-full bg-green-100 text-green-700 border border-green-200">Tersedia</span>
                                            @elseif($menu->status === 'habis')
                                                <span class="inline-flex text-[10px] font-semibold px-2 py-0.5 rounded-full bg-red-100 text-red-700 border border-red-200">Habis</span>
                                            @else
                                                <span class="inline-flex text-[10px] font-semibold px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 border border-purple-200">Musiman</span>
                                            @endif
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
                                                <button type="button"
                                                    onclick="openEditModal(
                                                        '{{ $menu->id }}',
                                                        '{{ addslashes($menu->nama_menu) }}',
                                                        '{{ $menu->kategori }}',
                                                        '{{ $menu->sub_kategori }}',
                                                        '{{ $menu->harga }}',
                                                        '{{ $menu->tipe_suhu }}',
                                                        '{{ $menu->status }}',
                                                        '{{ $menu->foto ? asset('storage/' . $menu->foto) : '' }}'
                                                    )"
                                                    class="btn-action inline-flex items-center gap-1.5 text-[12px] text-gray-500 border border-gray-200 px-3 py-1.5 rounded-lg">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Ubah
                                                </button>

                                                <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus menu {{ addslashes($menu->nama_menu) }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn-action inline-flex items-center gap-1.5 text-[12px] text-red-500 border border-red-100 px-3 py-1.5 rounded-lg">
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

            </div>
        </div>

    </div>
</div>

{{-- ======================== MODAL EDIT ======================== --}}
{{-- Overlay: full screen, scroll dari atas ke bawah --}}
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeEditModal()"></div>

    {{-- Wrapper: posisi panel di tengah dengan margin atas-bawah --}}
    <div class="relative z-10 flex justify-center px-4 py-10 min-h-full">
    <div id="editModalPanel"
        class="bg-white rounded-xl border border-gray-100 shadow-2xl w-full max-w-md h-fit">

        {{-- Header: selalu terlihat, tidak ikut scroll --}}
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 bg-gray-50/50 flex-shrink-0 rounded-t-xl">
            <h2 class="text-[13px] font-semibold text-gray-800">Ubah Data Menu</h2>
            <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Semua field + tombol dalam satu scroll area --}}
            <div class="px-5 py-4 space-y-4">

                <div>
                    <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Nama produk</label>
                    <input type="text" id="edit_nama_menu" name="nama_menu" required
                        class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                </div>

                <div>
                    <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Kategori</label>
                    <select id="edit_kategori" name="kategori" required
                        class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Sub Kategori</label>
                    <select id="edit_sub_kategori" name="sub_kategori" required
                    class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                    <optgroup label="Kategori Makanan" data-kategori="makanan">
                        <option value="snack">Snack Kopgun</option>
                        <option value="mie">Mie</option>
                        <option value="makanan_berat">Makanan Berat</option>
                        <option value="roti_bakar">Roti Bakar</option>
                    </optgroup>
                    <optgroup label="Kategori Minuman" data-kategori="minuman">
                        <option value="signature_coffee">Signature Coffee</option>
                        <option value="flavor_latte">Flavor Latte</option>
                        <option value="manual_brew">Manual Brew</option>
                        <option value="soda">Splitz Soda Base</option>
                        <option value="spresso_mixology">Spresso Mixology</option>
                        <option value="artisan_tea_mixology">Artisan Tea Mixology</option>
                        <option value="espresso_based">Espresso Based Mixology</option>
                        <option value="non_coffee">Non Coffee</option>
                        <option value="milk_based">Milk Based</option>
                    </optgroup>
                </select>
                </div>

                <div>
                    <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Harga (Rp)</label>
                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden focus-within:border-[#1a1a2e] focus-within:ring-2 focus-within:ring-[#1a1a2e]/10 transition">
                        <button type="button" onclick="stepHarga('edit_harga', -1000)"
                            class="flex-shrink-0 w-9 h-9 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-50 border-r border-gray-200 transition-colors select-none text-lg leading-none">
                            −
                        </button>
                        <input type="number" id="edit_harga" name="harga" required min="0" step="1000"
                            class="flex-1 text-[13px] px-3 py-2 bg-white text-gray-800 text-center focus:outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none">
                        <button type="button" onclick="stepHarga('edit_harga', 1000)"
                            class="flex-shrink-0 w-9 h-9 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-50 border-l border-gray-200 transition-colors select-none text-lg leading-none">
                            +
                        </button>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">Kelipatan Rp 1.000</p>
                </div>

                <div>
                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Tipe suhu</label>
                <select id="edit_tipe_suhu" name="tipe_suhu" required
                    class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                    <option value="netral">Netral (cocok di segala cuaca)</option>
                    <option value="panas">Panas (direkomendasikan saat cuaca dingin/hujan)</option>
                    <option value="dingin">Dingin (direkomendasikan saat cuaca panas)</option>
                </select>
                <p class="text-[11px] text-gray-400 mt-1">
                    "Panas" → direkomendasikan saat cuaca dingin/hujan.
                    "Dingin" → direkomendasikan saat cuaca panas.
                    "Netral" → cocok di segala cuaca, akan selalu tampil di rekomendasi.
                </p>
            </div>

                <div>
                    <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Status Ketersediaan</label>
                    <select id="edit_status" name="status" required
                        class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-800 focus:outline-none focus:border-[#1a1a2e] focus:ring-2 focus:ring-[#1a1a2e]/10 transition">
                        <option value="tersedia">Tersedia (Tampil di Kasir)</option>
                        <option value="habis">Habis (Stok Kosong)</option>
                        <option value="musiman">Baru (Sembunyikan sementara)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[12px] font-medium text-gray-600 mb-1.5">
                        Foto menu
                        <span class="text-gray-400 font-normal">(kosongkan jika tidak diganti)</span>
                    </label>
                    <div id="edit_preview_container" class="mb-2 hidden">
                        <img id="edit_preview_img" src="" alt="Preview"
                            class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                    </div>
                    <input type="file" id="edit-foto-upload" name="foto" accept="image/*"
                        class="w-full text-[12px] text-gray-500 border border-gray-200 rounded-lg p-2 focus:outline-none focus:border-[#1a1a2e] transition">
                </div>

            </div>

                {{-- Tombol aksi — di dalam scroll, selalu bisa dijangkau --}}
                <div class="flex gap-2.5 pt-2 pb-1 border-t border-gray-100">
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 border border-gray-200 text-gray-500 text-[13px] py-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-[#1a1a2e] hover:bg-[#2a2a42] text-white text-[13px] py-2.5 rounded-lg transition-colors">
                        Simpan perubahan
                    </button>
                </div>

            </div>{{-- end scroll body --}}
        </form>
    </div>{{-- end panel --}}
    </div>{{-- end wrapper --}}
</div>{{-- end modal overlay --}}

<script>
    // Stepper harga kelipatan 1000
    function stepHarga(inputId, delta) {
        const input = document.getElementById(inputId);
        const current = parseInt(input.value, 10) || 0;
        const next = Math.max(0, current + delta);
        input.value = next;
    }

    // Cegah scroll mouse mengubah nilai input number harga
   document.addEventListener('DOMContentLoaded', () => {
    ['harga', 'edit_harga'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('wheel', e => e.preventDefault(), { passive: false });
    });

    // Tambahan baru: filter sub_kategori saat kategori berubah
    document.getElementById('kategori')?.addEventListener('change', () => {
        filterSubKategori('kategori', 'sub_kategori');
    });
    document.getElementById('edit_kategori')?.addEventListener('change', () => {
        filterSubKategori('edit_kategori', 'edit_sub_kategori');
    });

    // Jalankan sekali saat halaman dimuat, untuk form tambah
    // (menangani kasus validasi gagal dengan old() kategori sudah terisi)
    filterSubKategori('kategori', 'sub_kategori');
});
    // Preview file upload (form tambah)
    document.getElementById('foto-upload')?.addEventListener('change', function () {
        const nameEl = document.getElementById('foto-name');
        nameEl.textContent = this.files.length > 0 ? this.files[0].name : '';
        nameEl.classList.toggle('hidden', this.files.length === 0);
    });
    // Filter optgroup sub_kategori berdasarkan kategori terpilih
    function filterSubKategori(kategoriId, subKategoriId) {
        const kategoriValue = document.getElementById(kategoriId).value;
        const subKategoriSelect = document.getElementById(subKategoriId);
        const optgroups = subKategoriSelect.querySelectorAll('optgroup');

        let currentValueStillValid = false;

        optgroups.forEach(group => {
            const groupKategori = group.getAttribute('data-kategori');
            const isMatch = groupKategori === kategoriValue;
            group.hidden = !isMatch;

            // Cek apakah option yang sedang terpilih masih ada di optgroup yang cocok
            if (isMatch) {
                const options = group.querySelectorAll('option');
                options.forEach(opt => {
                    if (opt.value === subKategoriSelect.value) {
                        currentValueStillValid = true;
                    }
                });
            }
        });

        // Reset pilihan jika sub_kategori yang sekarang tidak sesuai kategori baru
        if (!currentValueStillValid) {
            subKategoriSelect.value = '';
        }
    }

    // Buka modal edit — parameter sesuai urutan onclick di atas
       function openEditModal(id, nama, kategori, subKategori, harga, tipeSuhu, status, fotoUrl) {
        document.getElementById('editForm').action = '/admin/menu/' + id;
        document.getElementById('edit_nama_menu').value = nama;
        document.getElementById('edit_kategori').value  = kategori;

        // Filter dulu optgroup-nya sesuai kategori menu ini
        filterSubKategori('edit_kategori', 'edit_sub_kategori');

        // Baru set value sub_kategori setelah optgroup yang benar sudah ditampilkan
        document.getElementById('edit_sub_kategori').value = subKategori;

        document.getElementById('edit_harga').value     = harga;
        document.getElementById('edit_tipe_suhu').value = tipeSuhu;
        document.getElementById('edit_status').value    = status;

        const previewContainer = document.getElementById('edit_preview_container');
        const previewImg       = document.getElementById('edit_preview_img');
        if (fotoUrl) {
            previewImg.src = fotoUrl;
            previewContainer.classList.remove('hidden');
        } else {
            previewContainer.classList.add('hidden');
        }

        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').scrollTop = 0;
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Tutup modal dengan Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeEditModal();
    });
</script>

</body>
</html>