<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    const THRESHOLD_CELSIUS = 25;
    const CITY = 'Bandung';

    public function getCurrentWeather(): array
    {
        // Cache 10 menit -> hemat quota API, tetap terasa real-time
        return Cache::remember('weather_current', now()->addMinutes(10), function () {
            $weatherData = [
                'suhu' => null,
                'kondisi' => 'Tidak Diketahui',
                'is_offline' => false,
                'rekomendasi_suhu' => 'netral',
            ];

            try {
                $response = Http::timeout(5)->get('https://api.openweathermap.org/data/2.5/weather', [
                    'q'     => self::CITY,
                    'units' => 'metric',
                    'appid' => env('OPENWEATHER_API_KEY'),
                ]);

                if ($response->failed()) {
                    throw new \Exception('OpenWeatherMap response failed');
                }

                $data = $response->json();
                $suhuAsli = $data['main']['temp'];

                $weatherData['suhu']     = round($suhuAsli);
                $weatherData['kondisi']  = $data['weather'][0]['description'] ?? 'Tidak Diketahui';
                $weatherData['rekomendasi_suhu'] = $suhuAsli < self::THRESHOLD_CELSIUS ? 'panas' : 'dingin';

            } catch (\Throwable $e) {
                Log::warning('Gagal mengambil data cuaca: ' . $e->getMessage());
                $weatherData['is_offline'] = true;
                $weatherData['kondisi'] = 'Mode Offline (Tanpa Internet)';
                $weatherData['rekomendasi_suhu'] = 'netral';
            }

            return $weatherData;
        });
    }
}