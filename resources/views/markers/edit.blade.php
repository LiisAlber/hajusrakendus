
<form action="{{ route('markers.update', $marker->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="name" placeholder="Name" value="{{ $marker->name }}">
    <input type="text" name="latitude" placeholder="Latitude" value="{{ $marker->latitude }}">
    <input type="text" name="longitude" placeholder="Longitude" value="{{ $marker->longitude }}">
    <textarea name="description" placeholder="Description">{{ $marker->description }}</textarea>
    <button type="submit">Update Marker</button>
</form>