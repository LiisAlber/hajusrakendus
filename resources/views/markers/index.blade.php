@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row h-screen">
    <div id="map" class="flex-1"></div>
    <div class="p-4 overflow-auto bg-white md:w-1/3 lg:w-1/4 h-full">
        <h1 class="text-xl font-bold mb-4">Map Markers</h1>
        <div class="space-y-4">
            @php $limitedMarkers = array_slice($markers->toArray(), -10); @endphp
            @foreach($limitedMarkers as $marker)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 ease-in-out">
                    <div class="flex-grow">
                        <div class="font-semibold text-lg">{{ $marker['name'] }}</div>
                        <div class="text-sm text-gray-600">{{ $marker['description'] }}</div>
                    </div>
                    <div class="flex-shrink-0 flex space-x-2">
                        <a href="{{ route('markers.edit', $marker['id']) }}" class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">Edit</a>
                        <form action="{{ route('markers.destroy', $marker['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this marker?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="{{ route('markers.create') }}" class="mt-4 text-center block bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">Add New Marker</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const markersData = @json($markers);
    function initMap() {
        const mapOptions = {
            zoom: 8,
            center: new google.maps.LatLng(0, 0)  // Default center if no markers
        };
        const map = new google.maps.Map(document.getElementById('map'), mapOptions);
        const bounds = new google.maps.LatLngBounds();

        markersData.forEach((data) => {
            const mapMarker = new google.maps.Marker({
                position: new google.maps.LatLng(data.latitude, data.longitude),
                map: map,
                title: data.name
            });

            bounds.extend(mapMarker.getPosition());
        });

        if (markersData.length > 0) {
            map.fitBounds(bounds);
        } else {
            map.setCenter(mapOptions.center);
        }

        google.maps.event.addListener(map, 'click', function(event) {
            const markerName = prompt("Enter marker name:", "");
            if (markerName) {
                const markerDescription = prompt("Enter marker description:", "");
                const clickMarker = new google.maps.Marker({
                    position: event.latLng,
                    map: map,
                    title: markerName
                });

                const markerData = {
                    name: markerName,
                    latitude: event.latLng.lat(),
                    longitude: event.latLng.lng(),
                    description: markerDescription,
                    _token: '{{ csrf_token() }}'
                };

                fetch('{{ route('markers.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(markerData)
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Marker saved:', data);
                })
                .catch(error => {
                    console.error('Error saving marker:', error);
                });
            }
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
@endsection
