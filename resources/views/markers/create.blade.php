@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <form action="{{ route('markers.store') }}" method="POST" class="p-4 bg-white rounded-lg shadow-md">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input type="text" name="name" id="name" placeholder="Name" class="form-control">
        </div>
        <div class="mb-4">
            <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude</label>
            <input type="text" name="latitude" id="latitude" placeholder="Latitude" class="form-control">
        </div>
        <div class="mb-4">
            <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude</label>
            <input type="text" name="longitude" id="longitude" placeholder="Longitude" class="form-control">
        </div>
        <div class="mb-6">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" id="description" placeholder="Description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Marker</button>
    </form>
</div>
@endsection
