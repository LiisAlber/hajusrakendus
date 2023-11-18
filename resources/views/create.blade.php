
<form action="{{ route('markers.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Name">
    <input type="text" name="latitude" placeholder="Latitude">
    <input type="text" name="longitude" placeholder="Longitude">
    <textarea name="description" placeholder="Description"></textarea>
    <button type="submit">Add Marker</button>
</form>
