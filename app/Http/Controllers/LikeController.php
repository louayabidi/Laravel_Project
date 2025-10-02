<?php


namespace App\Http\Controllers;


use App\Models\Like;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LikeController extends Controller
{
public function __construct()
{
$this->middleware('auth');
}


// Toggle like for a comment or a post
public function toggle(Request $request)
{
$request->validate([
'comment_id' => 'nullable|exists:comments,id',
'post_id' => 'nullable|exists:posts,id'
]);


$userId = Auth::id();


$like = Like::where('user_id', $userId)
->when($request->comment_id, fn($q) => $q->where('comment_id', $request->comment_id))
->when($request->post_id, fn($q) => $q->where('post_id', $request->post_id))
->first();


if ($like) {
$like->delete();
return back();
}


Like::create([
'user_id' => $userId,
'post_id' => $request->post_id,
'comment_id' => $request->comment_id,
]);


return back();
}
}