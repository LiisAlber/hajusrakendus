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
<script>
    // Prepare marker data
    const markersData = @json($markers);

    function initMap() {
        // Define map options
        const mapOptions = {
            zoom: 8,
            center: new google.maps.LatLng(0, 0) // Default center if no markers
        };
        
        // Initialize map
        const map = new google.maps.Map(document.getElementById('map'), mapOptions);
        const bounds = new google.maps.LatLngBounds();

        // Place markers
        markersData.forEach((data) => {
            const mapMarker = new google.maps.Marker({
                position: new google.maps.LatLng(data.latitude, data.longitude),
                map: map,
                title: data.name
            });

            // Extend the bounds to include this marker's position
            bounds.extend(mapMarker.getPosition());
        });

        // Only fit the bounds if there are markers
        if (markersData.length > 0) {
            map.fitBounds(bounds);
        } else {
            map.setCenter(mapOptions.center);
        }

        // Add map click event listener
        google.maps.event.addListener(map, 'click', function(event) {
            // Show prompt to enter marker details
            const markerName = prompt("Enter marker name:", "");
            if (markerName) {
                const markerDescription = prompt("Enter marker description:", "");
                // Create marker on the map
                const clickMarker = new google.maps.Marker({
                    position: event.latLng,
                    map: map,
                    title: markerName
                });

                // Prepare data to send to backend
                const markerData = {
                    name: markerName,
                    latitude: event.latLng.lat(),
                    longitude: event.latLng.lng(),
                    description: markerDescription,
                    _token: '{{ csrf_token() }}' // CSRF token for security
                };

                // Send data to backend via POST request
                fetch('{{ route('markers.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure you have a valid CSRF token
                    },
                    body: JSON.stringify(markerData)
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Marker saved:', data);
                    // Optionally update the UI to reflect the new marker
                })
                .catch(error => {
                    console.error('Error saving marker:', error);
                });
            }
        });
    }
</script>
<script async defer 
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
</script>

</body>
</html>
