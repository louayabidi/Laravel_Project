<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_comment_id' => 'nullable|exists:comments,id'
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'parent_comment_id' => $request->parent_comment_id,
            'content' => $request->content,
            'status' => 'active'
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate(['content' => 'required|string|max:1000']);
        $comment->update(['content' => $request->content]);

        return back()->with('success', 'Comment updated successfully!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }
}
