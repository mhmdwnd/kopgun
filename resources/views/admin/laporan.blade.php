<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan — Kopgun Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bar-mingguan { transition: height 0.4s cubic-bezier(0.4,0,0.2,1); }
        .trx-row { cursor: pointer; transition: background 0.15s; }
        .trx-row:hover { background: #f9fafb; }
        .modal-panel { transition: transform 0.2s cubic-bezier(0.4,0,0.2,1), opacity 0.2s; }
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

        <header class="h-14 bg-white border-b border-gray-100 flex items-center justify-between px-6 flex-shrink-0">
            <div>
                <h1 class="text-[15px] font-semibold text-gray-900">Laporan Penjualan</h1>
                <p class="text-[12px] text-gray-400">Ringkasan kas, tren mingguan, dan detail transaksi</p>
            </div>

            <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex items-center gap-2">
                <label class="text-[12px] text-gray-500">Tanggal:</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()"
                    class="text-[12px] px-3 py-1.5 rounded-lg border border-gray-200 focus:outline-none focus:border-[#2C4870] transition">
            </form>
        </header>

        <div class="flex-1 overflow-y-auto p-5 space-y-4">

            {{-- ===== RINGKASAN KAS GABUNGAN ===== --}}
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <p class="text-[11px] text-gray-400 mb-1">Modal Awal</p>
                <p class="text-[16px] font-bold text-[#2C4870]">Rp {{ number_format($totalModalAwal, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <p class="text-[11px] text-gray-400 mb-1">Kas Masuk (Tambahan)</p>
                <p class="text-[16px] font-bold text-emerald-600">Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <p class="text-[11px] text-gray-400 mb-1">Kas Keluar</p>
                <p class="text-[16px] font-bold text-red-600">Rp {{ number_format($totalUangKeluar, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <p class="text-[11px] text-gray-400 mb-1">Hasil Penjualan</p>
                <p class="text-[16px] font-bold text-gray-900">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
            </div>
            <div class="bg-[#2C4870] rounded-xl p-4">
                <p class="text-[11px] text-[#C3D4E8] mb-1">Saldo Kas (Total)</p>
                <p class="text-[16px] font-bold text-white">Rp {{ number_format($saldoKas, 0, ',', '.') }}</p>
            </div>
        </div>

            {{-- ===== GRAFIK MINGGUAN ===== --}}
            <div class="bg-white border border-gray-100 rounded-xl p-5">
                <h2 class="text-[13px] font-semibold text-gray-800 mb-4">Tren Penjualan 8 Minggu Terakhir</h2>
                <div class="flex items-end gap-3 h-48 overflow-x-auto pb-1">
                    @foreach($grafikMingguan as $minggu)
                        @php $tinggiPersen = $maxMingguan > 0 ? max(4, ($minggu['total'] / $maxMingguan) * 100) : 4; @endphp
                        <div class="flex-1 flex flex-col items-center justify-end h-full group">
                            <span class="text-[10px] font-semibold text-gray-600 mb-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                Rp {{ number_format($minggu['total'], 0, ',', '.') }}
                            </span>
                            <div class="bar-mingguan w-full bg-gradient-to-t from-[#1A1A2E] to-[#2C4870] rounded-t-md hover:opacity-80"
                                 style="height: {{ $tinggiPersen }}%"></div>
                            <span class="text-[9px] text-gray-400 mt-1.5 whitespace-nowrap">{{ $minggu['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ===== DETAIL TRANSAKSI (sesuai tanggal filter) ===== --}}
            <div class="bg-white border border-gray-100 rounded-xl">
                <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                    <h2 class="text-[13px] font-semibold text-gray-800">
                        Detail Transaksi — {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}
                    </h2>
                    <span class="text-[11px] text-gray-400 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">
                        {{ $detailTransaksi->count() }} transaksi
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Waktu</th>
                                <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Meja</th>
                                <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Pelanggan</th>
                                <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Metode</th>
                                <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-5 py-3">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($detailTransaksi as $trx)
                                <tr class="trx-row" onclick="lihatDetailTransaksi('{{ $trx->id }}')">
                                    <td class="px-5 py-3 text-[12px] text-gray-600">{{ $trx->created_at->format('H:i') }}</td>
                                    <td class="px-5 py-3 text-[12px] text-gray-800 font-medium">Meja {{ $trx->nomor_meja }}</td>
                                    <td class="px-5 py-3 text-[12px] text-gray-600">{{ $trx->nama_pelanggan }}</td>
                                    <td class="px-5 py-3">
                                        <span class="text-[10px] font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ strtoupper($trx->metode_pembayaran) }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-[12px] font-semibold text-gray-900 text-right">Rp {{ number_format($trx->total_pembayaran, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-12 text-center text-[13px] text-gray-400">Tidak ada transaksi pada tanggal ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ======================== MODAL: DETAIL TRANSAKSI ======================== --}}
<div id="modal-detail-trx" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="tutupDetailTransaksi()"></div>
    <div class="relative z-10 flex justify-center px-4 py-10 min-h-full">
        <div class="modal-panel bg-white rounded-xl border border-gray-100 shadow-2xl w-full max-w-md h-fit">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100">
                <h2 class="text-[13px] font-semibold text-gray-800">Detail Transaksi</h2>
                <button onclick="tutupDetailTransaksi()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-5 py-4">
                <div class="bg-gray-50 border border-gray-100 rounded-lg p-3 space-y-1 mb-3">
                    <div class="flex justify-between text-[12px]"><span class="text-gray-400">Meja</span><span id="dt-meja" class="font-medium text-gray-800"></span></div>
                    <div class="flex justify-between text-[12px]"><span class="text-gray-400">Pelanggan</span><span id="dt-nama" class="font-medium text-gray-800"></span></div>
                    <div class="flex justify-between text-[12px]"><span class="text-gray-400">Waktu</span><span id="dt-waktu" class="font-medium text-gray-800"></span></div>
                    <div class="flex justify-between text-[12px]"><span class="text-gray-400">Metode</span><span id="dt-metode" class="font-medium text-gray-800"></span></div>
                </div>
                <div id="dt-items" class="space-y-1 max-h-52 overflow-y-auto mb-3"></div>
                <div class="flex justify-between text-[14px] font-bold text-gray-900 pt-2 border-t border-dashed border-gray-100">
                    <span>Total</span><span id="dt-total"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const dataTransaksi = @json($detailTransaksi);

    function lihatDetailTransaksi(id) {
        const trx = dataTransaksi.find(t => String(t.id) === String(id));
        if (!trx) return;

        document.getElementById('dt-meja').textContent   = 'Meja ' + trx.nomor_meja;
        document.getElementById('dt-nama').textContent   = trx.nama_pelanggan;
        document.getElementById('dt-waktu').textContent  = new Date(trx.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        document.getElementById('dt-metode').textContent = trx.metode_pembayaran.toUpperCase();
        document.getElementById('dt-total').textContent  = 'Rp ' + parseInt(trx.total_pembayaran).toLocaleString('id-ID');

        const itemsEl = document.getElementById('dt-items');
        itemsEl.innerHTML = '';
        (trx.items || []).forEach(item => {
            const extra = [item.suhu_pilihan, item.catatan].filter(Boolean).join(', ');
            itemsEl.insertAdjacentHTML('beforeend', `
                <div class="flex justify-between text-[12px] text-gray-600 py-1 border-b border-gray-50">
                    <span>${item.kuantitas}× ${item.nama}${extra ? ` <span class="text-gray-400 italic">(${extra})</span>` : ''}</span>
                    <span class="font-medium flex-shrink-0 ml-2">Rp ${(item.harga * item.kuantitas).toLocaleString('id-ID')}</span>
                </div>`);
        });

        document.getElementById('modal-detail-trx').classList.remove('hidden');
    }

    function tutupDetailTransaksi() {
        document.getElementById('modal-detail-trx').classList.add('hidden');
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') tutupDetailTransaksi();
    });
</script>

</body>
</html>