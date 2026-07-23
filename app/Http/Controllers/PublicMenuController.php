<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Retail;
use App\Services\WeatherService;

class PublicMenuController extends Controller
{
    public function index()
    {
        $weatherData = app(WeatherService::class)->getCurrentWeather();

        // Hanya tampilkan menu yang benar-benar tersedia — pelanggan tidak perlu
        // melihat menu berstatus habis/musiman (beda dengan kasir yang perlu tahu untuk info ke pelanggan langsung)
       $menus = Menu::where('status', '!=', 'musiman')
	    ->orderByRaw("FIELD(kategori, 'minuman', 'makanan')")
	    ->orderBy('sub_kategori', 'asc')
	    ->get();

        $menusBySubKategori = $menus->groupBy('sub_kategori');

        $menuRekomendasi = collect();
        if (!$weatherData['is_offline']) {
            $menuRekomendasi = $menus->filter(function ($menu) use ($weatherData) {
                return $menu->status === 'tersedia'
                    && ($menu->tipe_suhu === $weatherData['rekomendasi_suhu'] || $menu->tipe_suhu === 'netral');
            })->sortBy(function ($menu) {
                return $menu->kategori === 'minuman' ? 0 : 1; // minuman (0) selalu di depan makanan (1)
            })->values();
        }


        $retails = Retail::all();

        return view('public.menu', compact('menus', 'menusBySubKategori', 'weatherData', 'menuRekomendasi', 'retails'));
    }
}