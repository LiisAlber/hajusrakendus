<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with('blog')->latest()->paginate(10);

        return view('comments.index', compact('comments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'content' => 'required|string',
        ]);

        Comment::create([
            'blog_id' => $request->blog_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        // Loading comments for a specific blog post
        $comments = $blog->comments()->with('user')->get();

        return view('blog.show', compact('blog', 'comments'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if (! auth()->user()->isAdmin()) {
            return back()->with('error', 'You do not have permission to do this.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
