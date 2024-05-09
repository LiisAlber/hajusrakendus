<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $apiKey = Config::get('services.openweathermap.key');
        $baseUrl = Config::get('services.openweathermap.url');
        $units = Config::get('services.openweathermap.units');

        $cityName = $request->input('city', 'Kuressaare'); 
        $apiUrl = "{$baseUrl}?q={$cityName}&appid={$apiKey}&units={$units}";

        $cacheKey = 'weather_data_' . strtolower($cityName);

        if (Cache::has($cacheKey)) {
            $weatherData = Cache::get($cacheKey);
        } else {
            $response = Http::get($apiUrl);

            if ($response->successful()) {
                $weatherData = $response->json();
                Cache::put($cacheKey, $weatherData, now()->addHour());
            } else {
                Log::error('Response: '.$response->body());
                $errorDetails = [
                    'message' => 'Failed to fetch weather data.',
                    'details' => $response->json() ?? 'No additional information available.',
                ];

                return view('weather.error', compact('errorDetails'));
            }
        }

        return view('weather.weather', compact('weatherData'));
    }
}