<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());
        $tanggalCarbon = Carbon::parse($tanggal);

        // ── RINGKASAN KAS (untuk tanggal yang dipilih) ──
        $totalModalAwal  = Kas::where('tipe', 'modal')->whereDate('created_at', $tanggalCarbon)->sum('jumlah');
		$totalUangMasuk  = Kas::where('tipe', 'masuk')->whereDate('created_at', $tanggalCarbon)->sum('jumlah');
		$totalUangKeluar = Kas::where('tipe', 'keluar')->whereDate('created_at', $tanggalCarbon)->sum('jumlah');
		$totalPenjualan  = Transaksi::whereDate('created_at', $tanggalCarbon)->sum('total_pembayaran');
		$saldoKas        = $totalModalAwal + $totalUangMasuk + $totalPenjualan - $totalUangKeluar;
        // ── GRAFIK MINGGUAN 8 minggu terakhir) ──
        $grafikMingguan = collect();
        for ($i = 7; $i >= 0; $i--) {
            $mulaiMinggu = Carbon::now()->subWeeks($i)->startOfWeek();
            $akhirMinggu = Carbon::now()->subWeeks($i)->endOfWeek();
            $totalMinggu = Transaksi::whereBetween('created_at', [$mulaiMinggu, $akhirMinggu])->sum('total_pembayaran');

            $grafikMingguan->push([
                'label' => $mulaiMinggu->format('d/m') . '–' . $akhirMinggu->format('d/m'),
                'total' => (float) $totalMinggu,
            ]);
        }
        $maxMingguan = $grafikMingguan->max('total') ?: 1; // hindari pembagian oleh 0

        // ── DETAIL TRANSAKSI (default: tanggal terpilih) ──
        $detailTransaksi = Transaksi::whereDate('created_at', $tanggalCarbon)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.laporan', compact(
	    'tanggal', 'totalModalAwal', 'totalUangMasuk', 'totalUangKeluar', 'totalPenjualan', 'saldoKas',
	    'grafikMingguan', 'maxMingguan', 'detailTransaksi'
	));
    }
}