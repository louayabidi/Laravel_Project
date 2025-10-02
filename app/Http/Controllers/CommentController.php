<?php


namespace App\Http\Controllers;


use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
public function __construct()
{
$this->middleware('auth');
}


public function store(Request $request, Post $post)
{
$request->validate([
'content' => 'required|string',
'parent_comment_id' => 'nullable|exists:comments,id'
]);


Comment::create([
'post_id' => $post->id,
'user_id' => Auth::id(),
'parent_comment_id' => $request->parent_comment_id,
'content' => $request->content,
'status' => 'active'
]);


return back()->with('success','Comment added');
}
}