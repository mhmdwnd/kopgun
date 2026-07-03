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

        $weatherData = [
            'suhu' => null,
            'kondisi' => 'Tidak Diketahui',
            'is_offline' => false,
            'rekomendasi_suhu' => 'netral'
        ];

        try {
            $apiKey = env('OPENWEATHER_API_KEY');
            $city = 'Bandung';

            $response = Http::timeout(3)->get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'units' => 'metric',
                'appid' => $apiKey
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $suhuAsli = $data['main']['temp'];

                $weatherData['suhu'] = round($suhuAsli);
                $weatherData['kondisi'] = $data['weather'][0]['description'];
                $weatherData['rekomendasi_suhu'] = $suhuAsli < 25 ? 'panas' : 'dingin';
            } else {
                throw new \Exception("Gagal mendapatkan respons sukses dari API.");
            }
        } catch (\Exception $e) {
            $weatherData['is_offline'] = true;
            $weatherData['kondisi'] = 'Mode Offline (Tanpa Internet)';
            $weatherData['rekomendasi_suhu'] = 'netral';
        }

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
 
    // Fungsi untuk mengambil riwayat transaksi hari ini
    public function riwayatTransaksi()
    {
        $riwayat = Transaksi::whereDate('created_at', \Carbon\Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($riwayat);
    }

}