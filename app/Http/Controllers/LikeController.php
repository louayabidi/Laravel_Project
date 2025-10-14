<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggleCommentLike(Comment $comment)
    {
        $like = Like::where('user_id', auth()->id())
            ->where('comment_id', $comment->id)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'comment_id' => $comment->id,
            ]);
        }

        return back();
    }
}
