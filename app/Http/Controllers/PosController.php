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

            \App\Models\Transaksi::create([
                'nama_pelanggan' => $request->nama_pelanggan ?? 'Anonim',
                'nomor_meja' => $request->nomor_meja,
                'total_pembayaran' => $request->total_pembayaran,
                'metode_pembayaran' => $request->metode_pembayaran,
                'items' => $request->items
            ]);

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan']);
        } catch (\Exception $e) {
            // Ini akan mengirimkan pesan eror aslinya ke layar peramban Anda!
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
 
    // Fungsi untuk mengambil riwayat transaksi hari ini
    public function riwayatTransaksi()
    {
        // Ambil transaksi hari ini, urutkan dari yang paling baru
        $riwayat = Transaksi::whereDate('created_at', \Carbon\Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($riwayat);
    }

}