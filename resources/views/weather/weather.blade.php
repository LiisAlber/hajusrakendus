@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="my-5 p-5 bg-white shadow rounded-lg">
        <form method="GET" action="{{ route('weather.get') }}" class="mb-4">
            <input type="text" name="city" placeholder="Enter City Name" class="p-2 border border-gray-300 rounded">
            <button type="submit" class="p-2 bg-blue-500 text-white rounded">Get Weather</button>
        </form>

        @if (isset($weatherData))
        @php
            date_default_timezone_set('Europe/Tallinn');
            $sunrise = \Carbon\Carbon::createFromTimestamp($weatherData['sys']['sunrise'], 'UTC');
            $sunset = \Carbon\Carbon::createFromTimestamp($weatherData['sys']['sunset'], 'UTC');
            $sunrise->setTimezone('Europe/Tallinn');
            $sunset->setTimezone('Europe/Tallinn');
        @endphp

        <div class="my-5 p-5 bg-white shadow rounded-lg">
            <h1 class="text-2xl font-bold text-center text-gray-700 mb-2">Weather in {{ $weatherData['name'] }}</h1>
            @if (isset($weatherData['weather'][0]['icon']))
                <div class="flex justify-center">
                    <img src="https://openweathermap.org/img/wn/{{ $weatherData['weather'][0]['icon'] }}.png" alt="Weather Icon" class="w-20 h-20">

                </div>
            @endif
            <p class="text-gray-600">Temperature: <span class="font-semibold">{{ $weatherData['main']['temp'] }}°C</span></p>
            <p class="text-gray-600">Feels Like: <span class="font-semibold">{{ $weatherData['main']['feels_like'] }}°C</span></p>
            <p class="text-gray-600">Weather: <span class="font-semibold">{{ $weatherData['weather'][0]['main'] }} ({{ $weatherData['weather'][0]['description'] }})</span></p>
            <p class="text-gray-600">Humidity: <span class="font-semibold">{{ $weatherData['main']['humidity'] }}%</span></p>
            <p class="text-gray-600">Wind Speed: <span class="font-semibold">{{ $weatherData['wind']['speed'] }} m/s</span></p>
            <p class="text-gray-600">Visibility: <span class="font-semibold">{{ $weatherData['visibility'] / 1000 }} km</span></p>
            <p class="text-gray-600">Cloudiness: <span class="font-semibold">{{ $weatherData['clouds']['all'] }}%</span></p>
            @if(isset($weatherData['rain']['1h']))
                <p class="text-gray-600">Rain (Last 1 hr): <span class="font-semibold">{{ $weatherData['rain']['1h'] }} mm</span></p>
            @endif
            @if(isset($weatherData['snow']['1h']))
                <p class="text-gray-600">Snow (Last 1 hr): <span class="font-semibold">{{ $weatherData['snow']['1h'] }} mm</span></p>
            @endif
            <p class="text-gray-600">Sunrise: <span class="font-semibold">{{ $sunrise->format('H:i') }}</span></p>
            <p class="text-gray-600">Sunset: <span class="font-semibold">{{ $sunset->format('H:i') }}</span></p>
        </div>
        @else
            <h1 class="text-xl font-bold text-center text-red-500">Please enter a city name.</h1>
        @endif
    </div>
</div>
@endsection
