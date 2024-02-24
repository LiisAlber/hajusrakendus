<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
</head>
<body>
    <h1>Oops! Something went wrong.</h1>
    <p>We encountered an error while fetching weather data. Please try again later.</p>
    @if (isset($errorDetails))
        <p>Error Message: {{ $errorDetails['message'] }}</p>
        <p>Error Details: </p>
        <pre>{{ json_encode($errorDetails['details']) }}</pre>
    @endif
</body>
</html>

