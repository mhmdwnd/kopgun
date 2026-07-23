<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Retail;
use App\Models\Transaksi;
use App\Models\Kas;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $weatherData = app(\App\Services\WeatherService::class)->getCurrentWeather();

        $hariIni = Carbon::today();

        // ── RINGKASAN HARI INI ──
        $totalPenjualanHariIni  = Transaksi::whereDate('created_at', $hariIni)->sum('total_pembayaran');
        $jumlahTransaksiHariIni = Transaksi::whereDate('created_at', $hariIni)->count();

        $modalAwal = Kas::where('tipe', 'modal')->whereDate('created_at', $hariIni)->sum('jumlah');
        $kasMasuk  = Kas::where('tipe', 'masuk')->whereDate('created_at', $hariIni)->sum('jumlah');
        $kasKeluar = Kas::where('tipe', 'keluar')->whereDate('created_at', $hariIni)->sum('jumlah');
        $saldoKasHariIni = $modalAwal + $kasMasuk + $totalPenjualanHariIni - $kasKeluar;

        // ── GRAFIK PENJUALAN 7 HARI TERAKHIR (harian) ──
        $grafikHarian = collect();
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $total = Transaksi::whereDate('created_at', $tanggal)->sum('total_pembayaran');
            $grafikHarian->push([
                'label' => $tanggal->format('d/m'),
                'total' => (float) $total,
                'is_hari_ini' => $tanggal->isToday(),
            ]);
        }
        $maxHarian = $grafikHarian->max('total') ?: 1;

        // ── MENU PALING LARIS (30 hari terakhir, agregasi dari item transaksi) ──
        $transaksi30Hari = Transaksi::where('created_at', '>=', Carbon::now()->subDays(30))->get();
        $agregasi = [];
        foreach ($transaksi30Hari as $trx) {
            foreach ($trx->items ?? [] as $item) {
                if (!empty($item['retail_id'])) continue;

                $nama = $item['nama'] ?? 'Tidak diketahui';
                $qty  = (int) ($item['kuantitas'] ?? 0);
                $agregasi[$nama] = ($agregasi[$nama] ?? 0) + $qty;
            }
        }
        arsort($agregasi);
        $menuTerlaris = collect($agregasi)->take(5)->map(function ($qty, $nama) {
            return ['nama' => $nama, 'qty' => $qty];
        })->values();
        $maxTerlaris = $menuTerlaris->max('qty') ?: 1;

        // ── MENU PERLU RESTOCK (status habis) ──
        $menuHabis = Menu::where('status', 'habis')->get();

        return view('admin.dashboard', compact(
            'totalPenjualanHariIni', 'jumlahTransaksiHariIni', 'saldoKasHariIni',
            'grafikHarian', 'maxHarian',
            'menuTerlaris', 'maxTerlaris',
            'menuHabis', 'weatherData'
        ));
    }
}