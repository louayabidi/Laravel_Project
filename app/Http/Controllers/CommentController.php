<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Services\HuggingFaceToxicityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    protected $toxicityService;

    public function __construct(HuggingFaceToxicityService $toxicityService)
    {
        $this->toxicityService = $toxicityService;
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_comment_id' => 'nullable|exists:comments,id'
        ]);

        // Detect toxicity before creating comment
        $toxicityResult = $this->toxicityService->detectToxicity($request->content);

        if ($toxicityResult && $toxicityResult['is_toxic']) {
            return back()->withErrors([
                'content' => 'Your comment appears to be toxic. Please revise your message.',
                'toxicity_score' => $toxicityResult['max_score']
            ])->withInput();
        }

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'parent_comment_id' => $request->parent_comment_id,
            'content' => $request->content,
            'status' => 'active',
            'toxicity_score' => $toxicityResult ? json_encode($toxicityResult) : null,
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate(['content' => 'required|string|max:1000']);

        // Detect toxicity before updating comment
        $toxicityResult = $this->toxicityService->detectToxicity($request->content);

        if ($toxicityResult && $toxicityResult['is_toxic']) {
            return back()->withErrors([
                'content' => 'Your comment appears to be toxic. Please revise your message.',
                'toxicity_score' => $toxicityResult['max_score']
            ])->withInput();
        }

        $comment->update([
            'content' => $request->content,
            'toxicity_score' => $toxicityResult ? json_encode($toxicityResult) : null,
        ]);

        return back()->with('success', 'Comment updated successfully!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }
}