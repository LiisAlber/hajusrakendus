<!DOCTYPE html>
<html>
<head>
    <title>Map Markers</title>

    <style>
        #map {
            height: 400px; 
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Map Markers</h1>

    <!-- Div to display the Google Map -->
    <div id="map"></div>

    <h2>Markers List</h2>
    <ul>
        @foreach($markers as $marker)
            <li>
                {{ $marker->name }} - {{ $marker->description }}
                <!-- Edit Link -->
                <a href="{{ route('edit', $marker->id) }}">Edit</a>
                <!-- Delete Link -->
                <form action="{{ route('destroy', $marker->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    <!-- Link to Add New Marker -->
    <a href="{{ route('markers.create') }}">Add New Marker</a>

</div>


<!-- Google Maps API -->
<script async defer 
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
</script>

<script>
    function initMap() {
        // Create an empty LatLngBounds object to encompass all markers
        const bounds = new google.maps.LatLngBounds();

        const mapOptions = {
            zoom: 8,
            center: bounds.getCenter() // Center the map based on marker bounds
        };

        const map = new google.maps.Map(document.getElementById('map'), mapOptions);

        @foreach($markers as $marker)
            const marker = new google.maps.Marker({
                position: { lat: {{ $marker->latitude }}, lng: {{ $marker->longitude }} },
                map: map,
                title: "{{ $marker->name }}"
            });

            // Extend the bounds to include this marker's position
            bounds.extend(marker.getPosition());
        @endforeach

        // Set the map to fit within the bounds of all markers
        map.fitBounds(bounds);

        google.maps.event.addListener(map, 'click', function(event) {
            // Handle map click event
        });
    }
</script>


</body>
</html>
