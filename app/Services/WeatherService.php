<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    const THRESHOLD_CELSIUS = 25;

    public function getCurrentWeather(): ?array
    {
        // Cache 10 menit -> hemat quota API, tetap terasa real-time
        return Cache::remember('weather_current', now()->addMinutes(10), function () {
            try {
                $response = Http::timeout(5)->get('https://api.openweathermap.org/data/2.5/weather', [
                    'lat'   => config('services.openweathermap.lat'),
                    'lon'   => config('services.openweathermap.lon'),
                    'appid' => config('services.openweathermap.key'),
                    'units' => 'metric',
                ]);

                if ($response->failed()) {
                    throw new \Exception('OpenWeatherMap response failed');
                }

                $data = $response->json();

                return [
                    'suhu'      => $data['main']['temp'],
                    'kondisi'   => $data['weather'][0]['main'] ?? null,
                    'deskripsi' => $data['weather'][0]['description'] ?? null,
                ];
            } catch (\Throwable $e) {
                Log::warning('Gagal mengambil data cuaca: ' . $e->getMessage());
                return null; // null = sinyal tidak ada koneksi / API gagal -> fallback ke menu reguler
            }
        });
    }

    public function getRecommendedTipeSuhu(): ?string
    {
        $weather = $this->getCurrentWeather();
        if (!$weather) {
            return null;
        }
        return $weather['suhu'] >= self::THRESHOLD_CELSIUS ? 'dingin' : 'panas';
    }
}