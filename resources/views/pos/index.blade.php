<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kasir (POS) — Kopgun</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .scroll-hide::-webkit-scrollbar { display: none; }
        .scroll-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .menu-card { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
        .menu-card:hover { transform: translateY(-2px); }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800 overflow-hidden h-screen flex flex-col">

    {{-- ======================== HEADER BAR ======================== --}}
    <header class="h-14 bg-white border-b border-gray-100 flex items-center justify-between px-6 flex-shrink-0 z-20 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="w-8 h-8 rounded-lg bg-[#1a1a2e] flex items-center justify-center text-white hover:bg-[#2a2a42] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-[15px] font-bold text-gray-900 tracking-tight">Kopgun POS</h1>
                <p class="text-[11px] text-gray-400">Terminal Kasir Utama</p>
            </div>
            <button type="button" onclick="bukaRiwayat()" class="ml-4 flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-[12px] font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Riwayat Transaksi
            </button>
        </div>

        <div class="flex items-center gap-3 bg-gray-50 border border-gray-100 px-3 py-1.5 rounded-xl">
            <div class="flex items-center justify-center w-7 h-7 bg-white rounded-lg border border-gray-200/60 text-[14px]">
                @if($weatherData['rekomendasi_suhu'] === 'panas') ⛅ @else ❄️ @endif
            </div>
            <div class="text-left">
                <p class="text-[11px] font-semibold text-gray-800 leading-tight">Bandung, {{ $weatherData['suhu'] ?? '--' }}°C</p>
                <p class="text-[10px] text-gray-400 capitalize">{{ $weatherData['kondisi'] }}</p>
            </div>
            @if($weatherData['is_offline'])
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse" title="Sistem offline"></span>
            @else
                <span class="w-2 h-2 rounded-full bg-green-500" title="API Aktif"></span>
            @endif
        </div>
        <div class="flex items-center gap-3">
    <!-- ... tombol back & riwayat yang sudah ada ... -->

            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                @csrf
                <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-[12px] font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </header>

    {{-- ======================== MAIN WORKSPACE ======================== --}}
    <div class="flex-1 flex overflow-hidden relative">

        {{-- AREA KATALOG (KIRI - 70%) --}}
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50/50 p-4">
            
            <div class="flex items-center gap-2 overflow-x-auto pb-3 scroll-hide flex-shrink-0">
                <button type="button" onclick="filterSubKategori('semua')" id="btn-tab-semua" class="tab-pill px-4 py-2 text-[12px] font-semibold rounded-xl border border-[#1a1a2e] bg-[#1a1a2e] text-white whitespace-nowrap shadow-sm transition-all">Semua Menu</button>
                @foreach($menusBySubKategori as $subKat => $items)
                    <button type="button" onclick="filterSubKategori('{{ $subKat }}')" id="btn-tab-{{ $subKat }}" class="tab-pill px-4 py-2 text-[12px] font-semibold rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 whitespace-nowrap transition-all">{{ ucwords(str_replace('_', ' ', $subKat)) }}</button>
                @endforeach
            </div>

            <div class="flex-1 overflow-y-auto pr-1">
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3">
                    @forelse($menus as $menu)
                        {{-- PEMBARUAN: Memanggil fungsi bukaModalOpsi dan mengirim tipe_suhu --}}
                        <div class="menu-card bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col cursor-pointer group select-none"
                             data-subkategori="{{ $menu->sub_kategori }}"
                             onclick="bukaModalOpsi('{{ $menu->id }}', '{{ addslashes($menu->nama_menu) }}', {{ $menu->harga }}, '{{ $menu->foto ? asset('storage/' . $menu->foto) : '' }}', '{{ $menu->tipe_suhu }}')">
                            
                            <div class="relative aspect-video w-full bg-gray-50 overflow-hidden flex-shrink-0 border-b border-gray-50">
                                @if($menu->foto)
                                    <img src="{{ asset('storage/' . $menu->foto) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300">🍽️</div>
                                @endif
                            </div>

                            <div class="p-3 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-[13px] font-bold text-gray-800 leading-tight">{{ $menu->nama_menu }}</h3>
                                </div>
                                <div class="flex items-center justify-between mt-3 pt-2 border-t border-gray-50 flex-shrink-0">
                                    <span class="text-[13px] font-extrabold text-gray-950">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center text-gray-400 text-[13px]">Belum ada menu.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- AREA KERANJANG (KANAN - 30%) --}}
        <div class="w-[340px] flex-shrink-0 bg-white border-l border-gray-100 flex flex-col h-full shadow-lg relative z-10">
            
            <div class="p-4 border-b border-gray-100 bg-gray-50/50 grid grid-cols-2 gap-2 flex-shrink-0">
                <div>
                    <label class="block text-[11px] font-medium text-gray-500 mb-1">Pelanggan (Opsional)</label>
                    <input type="text" id="nama_pelanggan" placeholder="cth. Anonim" class="w-full text-[12px] px-2.5 py-1.5 rounded-lg border border-gray-200 bg-white focus:outline-none focus:border-[#1a1a2e]">
                </div>
                <div>
                    <label class="block text-[11px] font-medium text-gray-500 mb-1">No. Meja <span class="text-red-500">*</span></label>
                    <input type="text" id="nomor_meja" placeholder="cth. 04" class="w-full text-[12px] px-2.5 py-1.5 rounded-lg border border-gray-200 bg-white focus:outline-none focus:border-[#1a1a2e]">
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-3 scroll-hide" id="container-keranjang">
                <div id="keranjang-kosong" class="h-full flex flex-col items-center justify-center text-center text-gray-400 py-12">
                    <p class="text-[12px]">Belum ada pesanan terpilih.</p>
                </div>
            </div>

            <div class="p-4 border-t border-gray-100 bg-white shadow-[0_-4px_20px_rgba(0,0,0,0.02)] flex-shrink-0">
                <div class="space-y-1.5 text-[13px] mb-4">
                    <div class="flex justify-between font-extrabold text-gray-950 text-[15px] pt-1.5 border-t border-dashed border-gray-100">
                        <span>Total Pembayaran</span>
                        <span id="txt-total">Rp 0</span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="bukaModalPembayaran()" class="flex-1 bg-[#1a1a2e] hover:bg-[#2a2a42] text-white font-semibold text-[13px] py-3 rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                        Simpan & Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= MODAL OPSI MENU (BARU) ================= --}}
    <div id="modal-opsi-menu" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="tutupModalOpsi()"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 z-10 overflow-hidden p-5">
            <h2 id="opsi-nama-menu" class="text-[15px] font-bold text-gray-800 mb-1">Nama Menu</h2>
            <p id="opsi-harga-menu" class="text-[13px] font-semibold text-gray-500 mb-4 border-b border-gray-100 pb-4">Rp 0</p>
            
            {{-- Form Opsi Khusus --}}
            <form id="form-opsi" onsubmit="event.preventDefault(); simpanKeKeranjang();">
                <input type="hidden" id="opsi-id-menu">
                <input type="hidden" id="opsi-foto-menu">
                <input type="hidden" id="opsi-harga-asli">

                {{-- Opsi Suhu (Hanya muncul jika menu bertipe netral) --}}
                <div id="area-suhu" class="mb-4 hidden">
                    <label class="block text-[12px] font-semibold text-gray-800 mb-2">Pilih Suhu Penyajian <span class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <label class="flex-1 flex items-center justify-center gap-1.5 p-2.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-orange-50 transition-colors">
                            <input type="radio" name="pilihan_suhu" value="Panas" required class="text-orange-500 focus:ring-orange-500">
                            <span class="text-[12px] font-bold text-gray-700">☕ Panas</span>
                        </label>
                        <label class="flex-1 flex items-center justify-center gap-1.5 p-2.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-sky-50 transition-colors">
                            <input type="radio" name="pilihan_suhu" value="Dingin" required class="text-sky-500 focus:ring-sky-500">
                            <span class="text-[12px] font-bold text-gray-700">🧊 Dingin</span>
                        </label>
                    </div>
                </div>

                {{-- Input Catatan Khusus --}}
                <div class="mb-5">
                    <label class="block text-[12px] font-semibold text-gray-800 mb-2">Catatan Pesanan (Opsional)</label>
                    <textarea id="opsi-catatan" rows="2" placeholder="Cth: Kurangi manis, Jangan pakai es..." class="w-full text-[12px] p-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:border-[#1a1a2e] transition-colors resize-none"></textarea>
                </div>

                <div class="flex gap-2.5 mt-2">
                    <button type="button" onclick="tutupModalOpsi()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold text-[13px] py-2.5 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="flex-1 bg-[#1a1a2e] hover:bg-[#2a2a42] text-white font-semibold text-[13px] py-2.5 rounded-xl shadow transition-colors">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= MODAL KONFIRMASI PEMBAYARAN ================= --}}
    <div id="modal-pembayaran" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="tutupModalPembayaran()"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 z-10 overflow-hidden transform transition-all p-5">
            <h2 class="text-[15px] font-bold text-gray-800 mb-1 text-center">Konfirmasi Pembayaran</h2>
            <div class="bg-gray-50 rounded-xl p-4 mb-5 mt-4 text-center border border-gray-100">
                <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-widest mb-1">Total Tagihan</p>
                <p class="text-3xl font-extrabold text-gray-900" id="konfirmasi-total">Rp 0</p>
            </div>
            <div class="grid grid-cols-2 gap-3 mb-2">
                <button type="button" onclick="eksekusiPembayaran('tunai')" class="flex flex-col items-center justify-center gap-2 p-4 rounded-xl border-2 border-gray-200 hover:border-emerald-500 hover:bg-emerald-50 text-gray-700 transition-all">
                    <span class="text-[13px] font-bold">Uang Tunai</span>
                </button>
                <button type="button" onclick="eksekusiPembayaran('qris')" class="flex flex-col items-center justify-center gap-2 p-4 rounded-xl border-2 border-gray-200 hover:border-blue-500 hover:bg-blue-50 text-gray-700 transition-all">
                    <span class="text-[13px] font-bold">QRIS</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ================= MODAL RIWAYAT TRANSAKSI ================= --}}
    <div id="modal-riwayat" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="tutupRiwayat()"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4 z-10 overflow-hidden flex flex-col max-h-[80vh]">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-gray-50/50 flex-shrink-0">
                <h2 class="text-[14px] font-bold text-gray-800 flex items-center gap-2">Riwayat Transaksi Hari Ini</h2>
                <button type="button" onclick="tutupRiwayat()" class="text-gray-400 hover:text-gray-600">X</button>
            </div>
            <div class="flex-1 overflow-y-auto p-5 bg-gray-50" id="container-riwayat"></div>
        </div>
    </div>

    {{-- ======================== JAVASCRIPT ENGINE ======================== --}}
    <script>
        let keranjang = [];

        function filterSubKategori(subKategori) {
            document.querySelectorAll('.tab-pill').forEach(btn => {
                btn.classList.remove('bg-[#1a1a2e]', 'text-white', 'border-[#1a1a2e]');
                btn.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
            });
            const activeBtn = document.getElementById('btn-tab-' + subKategori);
            if (activeBtn) activeBtn.classList.add('bg-[#1a1a2e]', 'text-white', 'border-[#1a1a2e]');
            document.querySelectorAll('.menu-card').forEach(card => {
                card.style.display = (subKategori === 'semua' || card.getAttribute('data-subkategori') === subKategori) ? 'flex' : 'none';
            });
        }

        // --- FUNGSI BARU: MODAL OPSI MENU ---
        function bukaModalOpsi(id, nama, harga, fotoUrl, tipeSuhu) {
            document.getElementById('opsi-id-menu').value = id;
            document.getElementById('opsi-nama-menu').textContent = nama;
            document.getElementById('opsi-harga-menu').textContent = 'Rp ' + harga.toLocaleString('id-ID');
            document.getElementById('opsi-harga-asli').value = harga;
            document.getElementById('opsi-foto-menu').value = fotoUrl;
            document.getElementById('opsi-catatan').value = '';

            const areaSuhu = document.getElementById('area-suhu');
            const radioPanas = document.querySelector('input[value="Panas"]');
            const radioDingin = document.querySelector('input[value="Dingin"]');
            
            // Uncheck radiok button
            radioPanas.checked = false;
            radioDingin.checked = false;

            // Jika menu netral, buka pilihan. Jika tidak, sembunyikan.
            if (tipeSuhu === 'netral') {
                areaSuhu.classList.remove('hidden');
                radioPanas.required = true;
            } else {
                areaSuhu.classList.add('hidden');
                radioPanas.required = false; // hapus required agar form bisa disubmit
            }

            document.getElementById('modal-opsi-menu').classList.remove('hidden');
        }

        function tutupModalOpsi() {
            document.getElementById('modal-opsi-menu').classList.add('hidden');
        }

        // --- FUNGSI BARU: SIMPAN KE KERANJANG BERDASARKAN ID UNIK (CART_ID) ---
        function simpanKeKeranjang() {
            const id = document.getElementById('opsi-id-menu').value;
            const nama = document.getElementById('opsi-nama-menu').textContent;
            const harga = parseInt(document.getElementById('opsi-harga-asli').value);
            const fotoUrl = document.getElementById('opsi-foto-menu').value;
            const catatan = document.getElementById('opsi-catatan').value.trim();
            
            let suhuTerpilih = null;
            if (!document.getElementById('area-suhu').classList.contains('hidden')) {
                suhuTerpilih = document.querySelector('input[name="pilihan_suhu"]:checked').value;
            }

            // Gunakan Date.now() sebagai id unik keranjang, agar Teh (Panas) & Teh (Dingin) tidak menyatu
            const cart_id = Date.now().toString();

            keranjang.push({ 
                cart_id, id, nama, harga, fotoUrl, kuantitas: 1, suhu_pilihan: suhuTerpilih, catatan 
            });

            tutupModalOpsi();
            renderKeranjang();
        }

        function ubahKuantitas(cartId, perubahan) {
            const indeks = keranjang.findIndex(item => item.cart_id === cartId);
            if (indeks === -1) return;
            keranjang[indeks].kuantitas += perubahan;
            if (keranjang[indeks].kuantitas <= 0) keranjang.splice(indeks, 1);
            renderKeranjang();
        }

        function getHitungTotal() { return keranjang.reduce((sum, item) => sum + (item.harga * item.kuantitas), 0); }

        function renderKeranjang() {
            const container = document.getElementById('container-keranjang');
            const stateKosong = document.getElementById('keranjang-kosong');
            container.innerHTML = '';

            if (keranjang.length === 0) {
                container.appendChild(stateKosong);
                document.getElementById('txt-total').textContent = 'Rp 0';
                return;
            }

            keranjang.forEach(item => {
                // Tampilkan info tambahan jika ada
                let teksTambahan = '';
                if (item.suhu_pilihan) teksTambahan += `<span class="text-[9px] font-bold text-gray-500 border border-gray-200 px-1 rounded">${item.suhu_pilihan}</span> `;
                if (item.catatan) teksTambahan += `<span class="text-[10px] text-gray-400 italic">"${item.catatan}"</span>`;

                const rowHtml = `
                    <div class="flex items-start gap-3 bg-gray-50/70 border border-gray-100 p-2.5 rounded-xl">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-[12px] font-bold text-gray-800 leading-tight">${item.nama}</h4>
                            <p class="text-[11px] font-semibold text-gray-500 mt-0.5 mb-1.5">Rp ${item.harga.toLocaleString('id-ID')}</p>
                            <div class="flex items-center gap-1 flex-wrap">${teksTambahan}</div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0 mt-1">
                            <button type="button" onclick="ubahKuantitas('${item.cart_id}', -1)" class="w-6 h-6 rounded bg-white border border-gray-200 font-bold">-</button>
                            <span class="text-[12px] font-extrabold w-4 text-center">${item.kuantitas}</span>
                            <button type="button" onclick="ubahKuantitas('${item.cart_id}', 1)" class="w-6 h-6 rounded bg-white border border-gray-200 font-bold">+</button>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', rowHtml);
            });
            document.getElementById('txt-total').textContent = 'Rp ' + getHitungTotal().toLocaleString('id-ID');
        }

        // --- CHECKOUT & AJAX REQUEST ---
        function bukaModalPembayaran() {
            const meja = document.getElementById('nomor_meja').value.trim();
            if (keranjang.length === 0) return alert('Keranjang kosong!');
            if (!meja) return alert('Isi Nomor Meja terlebih dahulu!');
            
            document.getElementById('konfirmasi-total').textContent = 'Rp ' + getHitungTotal().toLocaleString('id-ID');
            document.getElementById('modal-pembayaran').classList.remove('hidden');
        }

        function tutupModalPembayaran() { document.getElementById('modal-pembayaran').classList.add('hidden'); }

        async function eksekusiPembayaran(metode) {
            const nama = document.getElementById('nama_pelanggan').value.trim() || 'Anonim';
            const meja = document.getElementById('nomor_meja').value.trim();
            const total = getHitungTotal();

            try {
                const response = await fetch("{{ route('pos.simpan') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                    body: JSON.stringify({ nama_pelanggan: nama, nomor_meja: meja, total_pembayaran: total, metode_pembayaran: metode, items: keranjang })
                });

                const result = await response.json(); // Mengambil data error/success dari controller

                if (response.ok && result.success) {
                    tutupModalPembayaran();
                    keranjang = [];
                    document.getElementById('nama_pelanggan').value = '';
                    document.getElementById('nomor_meja').value = '';
                    renderKeranjang();
                } else {
                    // JIKA GAGAL, BROWSER AKAN MEMBERITAHUKAN ALASAN TEPATNYA (Misal: Tabel tidak ada)
                    alert('Gagal menyimpan: ' + (result.message || 'Kesalahan server'));
                }
            } catch (error) {
                alert('Terjadi kesalahan jaringan.');
            }
        }

        // --- RIWAYAT ---
        async function bukaRiwayat() {
            document.getElementById('modal-riwayat').classList.remove('hidden');
            const container = document.getElementById('container-riwayat');
            container.innerHTML = '<p class="text-center text-gray-400 py-10">Memuat...</p>';

            try {
                const response = await fetch("{{ route('pos.riwayat') }}");
                const data = await response.json();
                
                if (data.length === 0) {
                    container.innerHTML = '<p class="text-center text-gray-400 py-10">Belum ada transaksi.</p>';
                    return;
                }

                container.innerHTML = '<div class="space-y-3"></div>';
                const wrapper = container.querySelector('.space-y-3');

                data.forEach(trx => {
                    let detailItems = '';
                    trx.items.forEach(item => {
                        let note = item.catatan ? ` <span class="italic text-[9px]">(${item.catatan})</span>` : '';
                        let temp = item.suhu_pilihan ? ` <span class="font-bold text-[9px]">[${item.suhu_pilihan}]</span>` : '';
                        detailItems += `<div class="flex justify-between text-[11px] text-gray-500 mt-1"><span>${item.kuantitas}x ${item.nama}${temp}${note}</span><span>Rp ${(item.harga * item.kuantitas).toLocaleString('id-ID')}</span></div>`;
                    });

                    const htmlCard = `
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start border-b border-gray-50 pb-2 mb-2">
                                <div><h4 class="text-[13px] font-bold text-gray-800">Meja ${trx.nomor_meja} (${trx.nama_pelanggan})</h4></div>
                                <div class="text-right flex flex-col items-end gap-1">
                                    <span class="text-[14px] font-extrabold">Rp ${trx.total_pembayaran.toLocaleString('id-ID')}</span>
                                    <span class="bg-gray-100 px-2 py-0.5 rounded text-[10px] font-bold uppercase">${trx.metode_pembayaran}</span>
                                </div>
                            </div>
                            <div class="pt-1">${detailItems}</div>
                        </div>
                    `;
                    wrapper.insertAdjacentHTML('beforeend', htmlCard);
                });
            } catch (e) {
                container.innerHTML = '<p class="text-center text-red-400 py-10">Gagal mengambil riwayat.</p>';
            }
        }
        function tutupRiwayat() { document.getElementById('modal-riwayat').classList.add('hidden'); }
    </script>
</body>
</html>