<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu - Panel Admin</title>
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
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-blue-600 hover:bg-gray-50 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Aplikasi</div>
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-blue-600 bg-blue-50 rounded-lg font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Kelola Menu
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white flex items-center justify-between px-8 border-b border-gray-100 shadow-sm z-10">
            <h2 class="text-xl font-bold text-gray-800">Data Master Menu</h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded shadow-sm">Kembali ke Dashboard</a>
        </header>

        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 h-fit">
                <h2 class="text-lg font-bold text-gray-700 mb-4">Tambah Menu Baru</h2>
                
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Produk</label>
                        <input type="text" name="nama_menu" required class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Kategori</label>
                        <select name="kategori" required class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" required class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Foto Menu</label>
                        <input type="file" name="foto" accept="image/*" class="w-full border border-gray-300 rounded shadow-sm focus:border-blue-500 text-sm bg-white p-1">
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks: 2MB</p>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Tipe Suhu (Rule-Based)</label>
                        <select name="tipe_suhu" required class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="netral">Netral (Cocok di Segala Cuaca)</option>
                            <option value="panas">Panas (Disajikan Hangat/Hot)</option>
                            <option value="dingin">Dingin (Disajikan Es/Ice)</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition text-sm">
                        Simpan Menu
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase font-semibold text-xs tracking-wider">
                            <th class="py-3 px-4">Foto</th>
                            <th class="py-3 px-4">Menu & Kategori</th>
                            <th class="py-3 px-4">Harga</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @foreach($menus as $menu)
                            <tr>
                                <td class="py-3 px-4">
                                    @if($menu->foto)
                                        <img src="{{ asset('storage/' . $menu->foto) }}" alt="Foto" class="w-16 h-16 object-cover rounded-md border border-gray-200 shadow-sm">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center text-gray-400 text-xs text-center border border-gray-200 shadow-sm">Tanpa<br>Foto</div>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-gray-900">{{ $menu->nama_menu }}</div>
                                    <div class="text-xs text-gray-500 capitalize">{{ $menu->kategori }} • Suhu: {{ $menu->tipe_suhu }}</div>
                                </td>
                                <td class="py-3 px-4 font-medium text-blue-600">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-center">
                                    <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-semibold bg-red-50 py-1 px-3 rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </main>
</body>
</html>