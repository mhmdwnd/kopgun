<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Http;

class PosController extends Controller
{
    public function index()
    {
        $menus = Menu::where('status', '!=', 'musiman')
            ->orderByRaw("FIELD(kategori, 'minuman', 'makanan')")
            ->orderBy('sub_kategori', 'asc')
            ->get();

        $menusBySubKategori = $menus->groupBy('sub_kategori');

        $weatherData = app(\App\Services\WeatherService::class)->getCurrentWeather();

        // Menu rekomendasi: sesuai arah cuaca saat ini, ATAU netral (cocok segala cuaca).
        // Hanya ditampilkan saat cuaca berhasil terdeteksi (online) — kalau offline, section ini disembunyikan di blade.
        $menuRekomendasi = collect();
        if (!$weatherData['is_offline']) {
            $menuRekomendasi = $menus->filter(function ($menu) use ($weatherData) {
                return $menu->status === 'tersedia'
                    && ($menu->tipe_suhu === $weatherData['rekomendasi_suhu'] || $menu->tipe_suhu === 'netral');
            });
        }

        // Produk retail (biji kopi) untuk section paling bawah
        $retails = \App\Models\Retail::all();

        return view('pos.index', compact('menus', 'menusBySubKategori', 'weatherData', 'menuRekomendasi', 'retails'));
    }

    public function simpanTransaksi(Request $request)
    {
        try {
            $request->validate([
                'nomor_meja' => 'required',
                'total_pembayaran' => 'required|numeric',
                'metode_pembayaran' => 'required|string',
                'items' => 'required|array'
            ]);

            // Bersihkan setiap item sebelum disimpan sebagai JSON.
            $items = collect($request->items)->map(function ($item) {
                return [
                    'menu_id'      => $item['menu_id'] ?? null,
                    'retail_id'    => $item['retail_id'] ?? null,
                    'nama'         => isset($item['nama']) ? mb_convert_encoding($item['nama'], 'UTF-8', 'UTF-8') : null,
                    'harga'        => $item['harga'] ?? 0,
                    'kuantitas'    => $item['kuantitas'] ?? 1,
                    'suhu_pilihan' => isset($item['suhu_pilihan']) ? mb_convert_encoding($item['suhu_pilihan'], 'UTF-8', 'UTF-8') : null,
                    'catatan'      => isset($item['catatan']) ? mb_convert_encoding($item['catatan'], 'UTF-8', 'UTF-8') : null,
                ];
            })->toArray();

            $transaksi = \App\Models\Transaksi::create([
                'nama_pelanggan'    => $request->nama_pelanggan ?? 'Anonim',
                'nomor_meja'        => $request->nomor_meja,
                'total_pembayaran'  => $request->total_pembayaran,
                'metode_pembayaran' => $request->metode_pembayaran,
                'items'             => $items,
            ]);

            return response()->json([
                'success'       => true,
                'message'       => 'Transaksi berhasil disimpan',
                'id_transaksi'  => $transaksi->id
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangkap validasi terpisah supaya pesannya jelas (bukan tertutup Exception umum)
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal simpan transaksi POS: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
 
    public function simpanKas(Request $request)
    {
        try {
            $request->validate([
                'tipe'       => 'required|in:modal,masuk,keluar',
                'jumlah'     => 'required|numeric|min:1',
                'keterangan' => 'required|string|max:255',
            ]);

            $kas = \App\Models\Kas::create([
                'tipe'       => $request->tipe,
                'jumlah'     => $request->jumlah,
                'keterangan' => $request->keterangan,
                'user_id'    => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kas berhasil dicatat',
                'id_kas'  => $kas->id,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal simpan kas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Gabungkan transaksi penjualan + kas masuk/keluar, urut berdasarkan waktu terbaru
    public function riwayatTransaksi()
    {
        $transaksi = Transaksi::whereDate('created_at', \Carbon\Carbon::today())
            ->get()
            ->map(function ($trx) {
                return [
                    'tipe_riwayat'      => 'penjualan',
                    'id'                => $trx->id,
                    'nomor_meja'        => $trx->nomor_meja,
                    'nama_pelanggan'    => $trx->nama_pelanggan,
                    'total_pembayaran'  => $trx->total_pembayaran,
                    'metode_pembayaran' => $trx->metode_pembayaran,
                    'items'             => $trx->items,
                    'created_at'        => $trx->created_at->format('H:i'),
                    'created_at_sort'   => $trx->created_at,
                ];
            });

        $kas = \App\Models\Kas::whereDate('created_at', \Carbon\Carbon::today())
            ->get()
            ->map(function ($k) {
                return [
                    'tipe_riwayat' => 'kas',
                    'id'           => $k->id,
                    'tipe_kas'     => $k->tipe,
                    'jumlah'       => $k->jumlah,
                    'keterangan'   => $k->keterangan,
                    'created_at'   => $k->created_at->format('H:i'),
                    'created_at_sort' => $k->created_at,
                ];
            });

        $riwayat = $transaksi->concat($kas)
            ->sortByDesc('created_at_sort')
            ->values();

        return response()->json($riwayat);
    }

}