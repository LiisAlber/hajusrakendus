@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Tool</h1>
    <form action="{{ route('tools.update', $tool->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $tool->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required>{{ $tool->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="brand">Brand:</label>
            <input type="text" class="form-control" id="brand" name="brand" value="{{ $tool->brand }}" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $tool->price }}" required>
        </div>
        <div class="form-group">
            <label for="image">Image URL:</label>
            <input type="text" class="form-control" id="image" name="image" value="{{ $tool->image }}" placeholder="https://example.com/image.jpg">
        </div>
        <button type="submit" class="btn btn-primary">Update Tool</button>
    </form>
</div>
@endsection
