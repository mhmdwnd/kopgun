<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Etalase Biji Kopi — Kopgun Admin</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Row hover: slide-in aksen kiri, sama seperti Kelola Menu */
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
            background: #2C4870;
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
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">

<div class="flex h-screen overflow-hidden">

    {{-- ======================== SIDEBAR ======================== --}}
    <aside class="w-[220px] flex-shrink-0 bg-[#1A1A2E] border-r border-[#2A2A48] flex flex-col">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 py-4 border-b border-[#2A2A48]">
        <div class="w-9 h-9 rounded-lg bg-[#2C4870] flex items-center justify-center flex-shrink-0 p-1.5">
            <img src="{{ asset('images/kopgun-logo-icon.png') }}" alt="Kopgun" class="w-full h-full object-contain">
        </div>
        <div>
            <p class="text-sm font-semibold text-white leading-tight">Kopgun</p>
            <p class="text-[11px] text-slate-400">Admin Panel</p>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">

        <p class="px-2 pt-1 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Utama</p>

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Aplikasi</p>

        <a href="{{ route('admin.menu.index') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            Kelola Menu
        </a>

        <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Pesanan
        </a>

        <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Kategori
        </a>

        <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
            </svg>
            Meja
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

        <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Retail</p>

        {{-- ETALASE RETAIL (AKTIF) --}}
        <a href="{{ route('admin.retail.index') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-semibold bg-[#2C4870]/30 text-[#9DBADD] border border-[#2C4870]/50 transition-colors">
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

    {{-- User --}}
    <div class="px-3 py-4 border-t border-[#2A2A48]">
        <div class="flex items-center gap-2.5 px-3 py-2">
            <div class="w-7 h-7 rounded-full bg-[#2C4870] flex items-center justify-center text-[11px] font-bold text-white flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[12px] font-medium text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full mt-1 flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] text-slate-400 hover:bg-white/5 hover:text-slate-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
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
                <h1 class="text-[15px] font-semibold text-gray-900">Etalase Biji Kopi</h1>
                <p class="text-[12px] text-gray-400">Kelola katalog produk retail kafe</p>
            </div>
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
                        <h2 class="text-[13px] font-semibold text-gray-800">Tambah produk baru</h2>
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

                        <form action="{{ route('admin.retail.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Nama Produk --}}
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Nama produk</label>
                                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required
                                    placeholder="cth. Arabica Gayo 200gr"
                                    class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white focus:outline-none focus:border-[#2C4870] focus:ring-2 focus:ring-[#E7EEF6] transition">
                            </div>

                            {{-- Harga --}}
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Harga (Rp)</label>
                                <input type="number" name="harga" value="{{ old('harga') }}" required min="0"
                                    placeholder="0"
                                    class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white focus:outline-none focus:border-[#2C4870] focus:ring-2 focus:ring-[#E7EEF6] transition">
                            </div>

                            {{-- Detail Spesifik --}}
                            <div class="mb-5">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Detail / Notes (Opsional)</label>
                                <input type="text" name="detail_spesifik" value="{{ old('detail_spesifik') }}"
                                    placeholder="cth. Medium Roast, Fruity"
                                    class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white focus:outline-none focus:border-[#2C4870] focus:ring-2 focus:ring-[#E7EEF6] transition">
                            </div>

                            {{-- Upload Foto --}}
                            <div class="mb-5">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Foto produk</label>
                                <label for="foto-upload"
                                    class="flex flex-col items-center justify-center gap-1.5 border border-dashed border-gray-200 rounded-lg p-5 bg-gray-50 hover:bg-gray-100 hover:border-gray-300 cursor-pointer transition-colors group">
                                    <svg class="w-7 h-7 text-gray-300 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-[12px] text-gray-500">Pilih file foto</p>
                                </label>
                                <input id="foto-upload" type="file" name="foto" accept="image/*" class="hidden">
                                <p id="foto-name" class="text-[11px] text-gray-400 mt-1.5 truncate hidden"></p>
                            </div>

                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 bg-[#1a1a2e] hover:bg-[#2a2a42] text-white text-[13px] font-medium py-2.5 rounded-lg transition-colors">
                                Simpan Produk
                            </button>
                        </form>

                    </div>
                </div>

                {{-- ===== TABEL DAFTAR PRODUK RETAIL ===== --}}
                <div class="bg-white rounded-xl border border-gray-100">
                    <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                        <div class="flex items-center gap-2.5">
                            <h2 class="text-[13px] font-semibold text-gray-800">Daftar Biji Kopi</h2>
                        </div>
                        <span class="text-[11px] text-gray-400 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">
                            {{ $retails->count() }} item
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3 w-14">Foto</th>
                                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Nama Produk</th>
                                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Detail / Notes</th>
                                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Harga</th>
                                    <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($retails as $retail)
                                    <tr class="menu-row">

                                        {{-- Foto --}}
                                        <td class="px-5 py-3.5">
                                            @if($retail->foto)
                                                <img src="{{ asset('storage/' . $retail->foto) }}"
                                                    alt="{{ $retail->nama_produk }}"
                                                    class="w-11 h-11 object-cover rounded-lg border border-gray-100">
                                            @else
                                                <div class="w-11 h-11 rounded-lg bg-gray-100 border border-gray-100 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Nama Produk --}}
                                        <td class="px-5 py-3.5">
                                            <p class="text-[13px] font-medium text-gray-900">{{ $retail->nama_produk }}</p>
                                        </td>

                                        {{-- Detail Spesifik --}}
                                        <td class="px-5 py-3.5">
                                            <p class="text-[12px] text-gray-500">{{ $retail->detail_spesifik ?? '-' }}</p>
                                        </td>

                                        {{-- Harga --}}
                                        <td class="px-5 py-3.5">
                                            <span class="text-[13px] font-semibold text-gray-900">
                                                Rp {{ number_format($retail->harga, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center justify-end gap-2">
                                                {{-- Tombol Edit (Pemicu Modal) --}}
                                                <button type="button"
                                                    onclick="openEditModal('{{ $retail->id }}', '{{ addslashes($retail->nama_produk) }}', '{{ $retail->harga }}', '{{ addslashes($retail->detail_spesifik ?? '') }}', '{{ $retail->foto ? asset('storage/' . $retail->foto) : '' }}')"
                                                    class="inline-flex items-center gap-1.5 text-[12px] text-gray-500 border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-50 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    Ubah
                                                </button>

                                                {{-- Form Delete --}}
                                                <form action="{{ route('admin.retail.destroy', $retail->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus produk {{ addslashes($retail->nama_produk) }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1.5 text-[12px] text-red-500 border border-red-100 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-16 text-center">
                                            <div class="flex flex-col items-center gap-2">
                                                <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                                </svg>
                                                <p class="text-[13px] text-gray-400">Belum ada biji kopi di etalase.</p>
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

{{-- ======================== MODAL EDIT RETAIL (POPUP) ======================== --}}
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeEditModal()"></div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-2xl w-full max-w-md mx-4 z-10 overflow-hidden transform transition-all">
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-[13px] font-semibold text-gray-800">Ubah Data Produk</h2>
            <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-5">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Nama produk</label>
                    <input type="text" id="edit_nama_produk" name="nama_produk" required class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#2C4870] focus:ring-2 focus:ring-[#E7EEF6]">
                </div>

                <div class="mb-4">
                    <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Harga (Rp)</label>
                    <input type="number" id="edit_harga" name="harga" required class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#2C4870] focus:ring-2 focus:ring-[#E7EEF6]">
                </div>

                <div class="mb-4">
                    <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Detail / Notes (Opsional)</label>
                    <input type="text" id="edit_detail_spesifik" name="detail_spesifik" class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#2C4870] focus:ring-2 focus:ring-[#E7EEF6]">
                </div>

                <div class="mb-5">
                    <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Foto produk (Kosongkan jika tidak diganti)</label>
                    <div id="edit_preview_container" class="mb-2 hidden">
                        <img id="edit_preview_img" src="" class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                    </div>
                    <input type="file" id="edit-foto-upload" name="foto" accept="image/*" class="w-full text-[12px] text-gray-500 border border-gray-200 rounded-lg p-2">
                </div>

                <div class="flex gap-2.5 mt-6">
                    <button type="button" onclick="closeEditModal()" class="flex-1 border border-gray-200 text-gray-500 text-[13px] py-2 rounded-lg hover:bg-gray-50">Batal</button>
                    <button type="submit" class="flex-1 bg-[#1a1a2e] text-white text-[13px] py-2 rounded-lg hover:bg-[#2a2a42]">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('foto-upload')?.addEventListener('change', function () {
        const nameEl = document.getElementById('foto-name');
        if (this.files.length > 0) {
            nameEl.textContent = this.files[0].name;
            nameEl.classList.remove('hidden');
        } else {
            nameEl.classList.add('hidden');
        }
    });

    function openEditModal(id, nama, harga, detail, fotoUrl) {
        document.getElementById('editForm').action = '/admin/retail/' + id;

        document.getElementById('edit_nama_produk').value = nama;
        document.getElementById('edit_harga').value = harga;
        document.getElementById('edit_detail_spesifik').value = detail;

        const previewContainer = document.getElementById('edit_preview_container');
        const previewImg = document.getElementById('edit_preview_img');

        if (fotoUrl) {
            previewImg.src = fotoUrl;
            previewContainer.classList.remove('hidden');
        } else {
            previewContainer.classList.add('hidden');
        }

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>

</body>
</html>