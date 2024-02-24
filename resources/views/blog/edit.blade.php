@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Blog Post</h1>
    <form action="{{ route('blog.update', $blog->id) }}" method="POST" id="editForm">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $blog->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="5" required>{{ $blog->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script>
    document.getElementById('editForm').onsubmit = function() {
        return confirm('Are you sure you want to update this post?');
    };
</script>
@endsection
