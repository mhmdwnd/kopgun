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
        // 1. LOGIKA PENGAMBILAN DATA MENU (MINUMAN DULU, LALU MAKANAN)       
        $menus = Menu::where('status', '!=', 'musiman')
            ->orderByRaw("FIELD(kategori, 'minuman', 'makanan')")
            ->orderBy('sub_kategori', 'asc') // Mengurutkan sub-kategori secara alfabetis
            ->get();

        // Mengelompokkan menu berdasarkan sub_kategori untuk mempermudah pembuatan Tab di Kasir
        $menusBySubKategori = $menus->groupBy('sub_kategori');


        // ====================================================================
        // 2. LOGIKA CONTEXT-AWARE (CUACA REAL-TIME) DENGAN FALLBACK OFFLINE
        // ====================================================================
        $weatherData = [
            'suhu' => null,
            'kondisi' => 'Tidak Diketahui',
            'is_offline' => false,
            'rekomendasi_suhu' => 'netral' // Default rule jika sistem tidak tahu kondisi cuaca
        ];

        try {
            // Mengambil API Key dari berkas konfigurasi .env
            $apiKey = env('OPENWEATHER_API_KEY');
            $city = 'Bandung';
            
            // Mengirim request HTTP GET ke OpenWeatherMap dengan timeout maksimal 3 detik
            $response = Http::timeout(3)->get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'units' => 'metric',
                'appid' => $apiKey
            ]);

            // Jika API merespons dengan sukses (status kode 200)
            if ($response->successful()) {
                $data = $response->json();
                $suhuAsli = $data['main']['temp'];
                
                $weatherData['suhu'] = round($suhuAsli); // Membulatkan angka suhu agar rapi di UI
                $weatherData['kondisi'] = $data['weather'][0]['description'];
                
                // LOGIKA ATURAN (RULE-BASED ENGINE)
                // Jika suhu di bawah 25 derajat celcius, rekomendasikan menu bertipe panas
                if ($suhuAsli < 25) {
                    $weatherData['rekomendasi_suhu'] = 'panas';
                } else {
                    $weatherData['rekomendasi_suhu'] = 'dingin';
                }
            } else {
                // Memaksa masuk ke blok catch jika status API tidak sukses (misal: limit habis / token salah)
                throw new \Exception("Gagal mendapatkan respons sukses dari API.");
            }

        } catch (\Exception $e) {
            // JIKA INTERNET TERPUTUS ATAU SESSINYA TIMEOUT
            // Sistem langsung mengamankan operasional kasir dengan mengaktifkan mode offline
            $weatherData['is_offline'] = true;
            $weatherData['kondisi'] = 'Mode Offline (Tanpa Internet)';
            
            // Aturan cadangan (Fallback Rule): tawarkan menu netral (aman di semua cuaca)
            $weatherData['rekomendasi_suhu'] = 'netral'; 
        }   
        return view('pos.index', compact('menus', 'menusBySubKategori', 'weatherData'));
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
        // Ini mencegah error "Malformed UTF-8 characters" saat json_encode(),
        // yang paling sering muncul dari field catatan/suhu_pilihan hasil input mobile.
        $items = collect($request->items)->map(function ($item) {
            return [
                'menu_id'      => $item['menu_id'] ?? null,
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