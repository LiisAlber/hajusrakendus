@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Tool</h1>
        <form action="{{ route('tools.update', $tool) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $tool->title }}" required>
            </div>
            <div class="form-group">
                <label for="brand">Brand:</label>
                <input type="text" class="form-control" id="brand" name="brand" value="{{ $tool->brand }}" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $tool->price }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Tool</button>
        </form>
    </div>
@endsection