<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Event — Kopgun Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Aplikasi</p>
            <a href="{{ route('admin.menu.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                Kelola Menu
            </a>

            <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Konten Publik</p>
            <a href="{{ route('admin.event.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-semibold bg-[#2C4870]/30 text-[#9DBADD] border border-[#2C4870]/50">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Kelola Event
            </a>
            <a href="{{ route('admin.area.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4M3 13v6l9 4 9-4v-6"/></svg>
                Kelola Area
            </a>

            <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Retail</p>
            <a href="{{ route('admin.retail.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Etalase Biji Kopi
            </a>

            <p class="px-2 pt-4 pb-1.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Laporan</p>
            <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
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
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full mt-1 flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] text-slate-400 hover:bg-white/5 hover:text-slate-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ======================== MAIN ======================== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        <header class="h-14 bg-white border-b border-gray-100 flex items-center justify-between px-6 flex-shrink-0">
            <div>
                <h1 class="text-[15px] font-semibold text-gray-900">Kelola Event</h1>
                <p class="text-[12px] text-gray-400">Kelola foto & informasi event Kopgun</p>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-5">
            <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-4 items-start">

                {{-- ===== FORM TAMBAH ===== --}}
                <div class="bg-white rounded-xl border border-gray-100">
                    <div class="flex items-center gap-2.5 px-5 py-3.5 border-b border-gray-100">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <h2 class="text-[13px] font-semibold text-gray-800">Tambah Event Baru</h2>
                    </div>
                    <div class="p-5">
                        @if(session('success'))
                            <div class="flex items-center gap-2 bg-green-50 border border-green-100 text-green-700 text-[12px] font-medium px-3.5 py-2.5 rounded-lg mb-4">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Foto Event <span class="text-red-400">*</span></label>
                                <label for="foto-upload" class="flex flex-col items-center justify-center gap-1.5 border border-dashed border-gray-200 rounded-lg p-5 bg-gray-50 hover:bg-gray-100 hover:border-gray-300 cursor-pointer transition-colors group">
                                    <svg class="w-7 h-7 text-gray-300 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p id="foto-name-text" class="text-[12px] text-gray-500">Pilih file gambar</p>
                                </label>
                                <input id="foto-upload" type="file" name="foto" accept="image/*" required class="hidden">
                                @error('foto') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-5">
                                <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Deskripsi Event <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                <textarea name="deskripsi" rows="4" placeholder="Ceritakan tentang event ini..." class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-800 placeholder-gray-300 focus:outline-none focus:border-[#2C4870] focus:ring-2 focus:ring-[#E7EEF6] transition resize-none">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#1a1a2e] hover:bg-[#2a2a42] text-white text-[13px] font-medium py-2.5 rounded-lg transition-colors">
                                Simpan Event
                            </button>
                        </form>
                    </div>
                </div>

                {{-- ===== TABEL EVENT ===== --}}
                <div class="bg-white rounded-xl border border-gray-100">
                    <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                        <h2 class="text-[13px] font-semibold text-gray-800">Daftar Event</h2>
                        <span class="text-[11px] text-gray-400 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">{{ $events->count() }} item</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3 w-24">Foto</th>
                                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Deskripsi</th>
                                    <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($events as $event)
                                    <tr class="menu-row hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3.5">
                                            <img src="{{ asset('storage/' . $event->foto) }}" class="w-16 h-16 object-cover rounded-lg border border-gray-100">
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <p class="text-[12px] text-gray-600 line-clamp-3">{{ $event->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                                        </td>
                                        <td class="px-5 py-3.5 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button type="button"
                                                    data-id="{{ $event->id }}"
                                                    data-deskripsi="{{ $event->deskripsi }}"
                                                    data-foto="{{ asset('storage/' . $event->foto) }}"
                                                    onclick="openEditModal(this)"
                                                    class="inline-flex items-center gap-1.5 text-[12px] text-gray-500 border border-gray-200 hover:bg-gray-50 px-3 py-1.5 rounded-lg transition-colors">
                                                    Ubah
                                                </button>
                                                <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus event ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1.5 text-[12px] text-red-500 border border-red-100 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-5 py-16 text-center text-[12px] text-gray-400">Belum ada event yang ditambahkan.</td>
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

{{-- ======================== MODAL EDIT EVENT ======================== --}}
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="relative z-10 flex justify-center px-4 py-10 min-h-full">
        <div class="bg-white rounded-xl border border-gray-100 shadow-2xl w-full max-w-md h-fit">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 bg-gray-50/50 rounded-t-xl">
                <h2 class="text-[13px] font-semibold text-gray-800">Ubah Data Event</h2>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="px-5 py-4 space-y-4">
                    <div>
                        <label class="block text-[12px] font-medium text-gray-600 mb-1.5">
                            Foto Event <span class="text-gray-400 font-normal">(kosongkan jika tidak diganti)</span>
                        </label>
                        <div class="mb-2">
                            <img id="edit_preview_img" src="" alt="Preview" class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                        </div>
                        <input type="file" name="foto" accept="image/*"
                            class="w-full text-[12px] text-gray-500 border border-gray-200 rounded-lg p-2 focus:outline-none focus:border-[#2C4870] transition">
                    </div>
                    <div>
                        <label class="block text-[12px] font-medium text-gray-600 mb-1.5">Deskripsi Event</label>
                        <textarea id="edit_deskripsi" name="deskripsi" rows="4"
                            class="w-full text-[13px] px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-[#2C4870] focus:ring-2 focus:ring-[#E7EEF6] transition resize-none"></textarea>
                    </div>
                </div>
                <div class="flex gap-2.5 px-5 pb-5 pt-2 border-t border-gray-100">
                    <button type="button" onclick="closeEditModal()" class="flex-1 border border-gray-200 text-gray-500 text-[13px] py-2.5 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                    <button type="submit" class="flex-1 bg-[#1a1a2e] hover:bg-[#2a2a42] text-white text-[13px] py-2.5 rounded-lg transition-colors">Simpan perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('foto-upload')?.addEventListener('change', function () {
        const label = document.getElementById('foto-name-text');
        if (this.files.length > 0) label.textContent = this.files[0].name;
    });

    function openEditModal(btn) {
        document.getElementById('editForm').action = '/admin/event/' + btn.dataset.id;
        document.getElementById('edit_deskripsi').value = btn.dataset.deskripsi || '';
        document.getElementById('edit_preview_img').src = btn.dataset.foto;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeEditModal();
    });
</script>

</body>
</html>