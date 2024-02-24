@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $blog->title }}</h1>
    <p>{{ $blog->description }}</p>
    <a href="{{ route('blog.index') }}" class="btn btn-info mb-4">Back to List</a>

    <div class="comments">
        <h2>Comments</h2>
        @forelse ($blog->comments as $comment)
        <div class="comment mb-3">
            <p>{{ $comment->content }}</p>
            <small>Commented by: {{ $comment->user->name ?? 'Anonymous' }} at {{ $comment->created_at->format('m/d/Y') }}</small>
            <!-- Delete button for comments visible only to admin users -->
            @if(auth()->check() && auth()->user()->isAdmin())
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            @endif

        </div>
        @empty
        <p>No comments yet.</p>
        @endforelse
    </div>

    @if(auth()->check())
    <div class="add-comment mt-4">
        <h3>Add a Comment</h3>
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
            <div class="form-group mb-2">
                <textarea name="content" class="form-control" id="content" rows="3" placeholder="Write your comment here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
    </div>
    @else
    <p><a href="{{ route('login') }}">Log in</a> to post comments.</p>
    @endif
</div>

<script>
    console.log('Blog post loaded:', '{{ $blog->title }}');
</script>
@endsection
