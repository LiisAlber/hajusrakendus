<!DOCTYPE html>
<html>
<head>
    <title>Weather Information</title>
</head>
<body>
    @if (isset($weatherData))
    @php
        date_default_timezone_set('Europe/Tallinn');

        $sunrise = \Carbon\Carbon::createFromTimestamp($weatherData['sys']['sunrise'], 'UTC');
        $sunset = \Carbon\Carbon::createFromTimestamp($weatherData['sys']['sunset'], 'UTC');

        $sunrise->setTimezone('Europe/Tallinn');
        $sunset->setTimezone('Europe/Tallinn');
    @endphp


        <h1>Weather in {{ $weatherData['name'] }}</h1>
        @if (isset($weatherData['weather'][0]['icon']))
            <img src="http://openweathermap.org/img/wn/{{ $weatherData['weather'][0]['icon'] }}.png" alt="Weather Icon">
        @endif
        <p>Temperature: {{ $weatherData['main']['temp'] }}°C</p>
        <p>Feels Like: {{ $weatherData['main']['feels_like'] }}°C</p>
        <p>Weather: {{ $weatherData['weather'][0]['main'] }} ({{ $weatherData['weather'][0]['description'] }})</p>
        <p>Humidity: {{ $weatherData['main']['humidity'] }}%</p>
        <p>Wind Speed: {{ $weatherData['wind']['speed'] }} meter/sec</p>
        <p>Visibility: {{ $weatherData['visibility'] / 1000 }} km</p>
        <p>Cloudiness: {{ $weatherData['clouds']['all'] }}%</p>
        @if(isset($weatherData['rain']['1h']))
            <p>Rain (Last 1 hr): {{ $weatherData['rain']['1h'] }} mm</p>
        @endif
        @if(isset($weatherData['snow']['1h']))
            <p>Snow (Last 1 hr): {{ $weatherData['snow']['1h'] }} mm</p>
        @endif
        <p>Sunrise: {{ date('H:i', $weatherData['sys']['sunrise']) }}</p>
        <p>Sunset: {{ date('H:i', $weatherData['sys']['sunset']) }}</p>
    @else
        <h1>Oops! Something went wrong.</h1>
    @endif
</body>
</html>



