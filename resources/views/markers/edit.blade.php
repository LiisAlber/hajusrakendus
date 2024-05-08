@extends('layouts.app')

@section('content')
<form action="{{ route('markers.update', $marker->id) }}" method="POST" class="p-4 max-w-lg mx-auto bg-white rounded-lg shadow-md">
    @csrf
    @method('PUT')
    
    <div class="mb-4">
        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
        <input type="text" name="name" id="name" placeholder="Name" value="{{ $marker->name }}" 
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="mb-4">
        <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude</label>
        <input type="text" name="latitude" id="latitude" placeholder="Latitude" value="{{ $marker->latitude }}"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="mb-4">
        <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude</label>
        <input type="text" name="longitude" id="longitude" placeholder="Longitude" value="{{ $marker->longitude }}"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="mb-6">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
        <textarea name="description" id="description" placeholder="Description"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $marker->description }}</textarea>
    </div>

    <div class="flex items-center justify-between">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Update Marker
        </button>
    </div>
</form>
@endsection