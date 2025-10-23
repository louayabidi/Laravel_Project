<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use App\Models\Post;
use App\Models\Report;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of posts
     * - Admins see all posts with status
     * - Regular users see only active posts
     */
    public function index(Request $request)
    {
        // Base query for app posts
        if (Auth::check() && Auth::user()->isAdmin()) {
            $query = Post::with('user')->latest();
        } else {
            $query = Post::where('status', 'active')
                ->with('user')
                ->latest();
        }

        // Search functionality
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by tags
        if ($request->has('tags') && !empty($request->input('tags'))) {
            $tag = request('tags');
            $query->where('tags', 'like', "%{$tag}%");
        }

        $posts = $query->paginate(10);

        // Get all unique tags for the filter dropdown
        if (Auth::check() && Auth::user()->isAdmin()) {
            $allTags = Post::whereNotNull('tags')
                ->where('tags', '!=', '')
                ->get()
                ->flatMap(function ($post) {
                    return array_map('trim', explode(',', $post->tags));
                })
                ->unique()
                ->sort()
                ->values();
        } else {
            $allTags = Post::where('status', 'active')
                ->whereNotNull('tags')
                ->where('tags', '!=', '')
                ->get()
                ->flatMap(function ($post) {
                    return array_map('trim', explode(',', $post->tags));
                })
                ->unique()
                ->sort()
                ->values();
        }

        // Reddit posts
        $redditPosts = [];
        $subreddit = env('REDDIT_SUBREDDIT', 'healthcare');
        $limit = env('REDDIT_POST_LIMIT', 6);

        try {
            $response = Http::withHeaders([
                'User-Agent' => env('REDDIT_USER_AGENT'),
            ])->get("https://www.reddit.com/r/{$subreddit}/hot.json?limit={$limit}");

            if ($response->ok()) {
                $redditPosts = $response->json()['data']['children'];
            }
        } catch (\Exception $e) {
            // Handle errors silently
            $redditPosts = [];
        }

        // Get user's reports
        $myReports = collect();
        $myReportsCount = 0;

        if (Auth::check()) {
            $myReports = Report::with(['post.user'])
                ->where('reporter_id', Auth::id())
                ->latest()
                ->get();
            $myReportsCount = $myReports->count();
        }

        return view('posts.index', compact(
            'posts',
            'redditPosts',
            'myReports',
            'myReportsCount',
            'allTags'
        ));
    }
    /**
     * Show the form for creating a new post
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created post
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|regex:/^[a-zA-Z0-9\s\.,!?\-]+$/',
            'media_url' => 'nullable|url',
            'tags' => 'nullable|string|max:500'
        ], [
            'title.required' => 'The post title is required.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'content.required' => 'Please provide some content for your post.',
            'content.regex' => 'Content can only contain letters, numbers, spaces, and basic punctuation (. , ! ? -).',
            'media_url.url' => 'Please enter a valid URL for the media.',
            'tags.max' => 'Tags cannot exceed 500 characters.'
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'media_url' => $request->media_url,
            'status' => 'active',
            'tags' => $request->tags
        ]);

        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified post
     */
    public function show($id)
    {
        $post = Post::with(['user', 'comments', 'likes'])->findOrFail($id);

        // Check if post is active or user is admin/owner
        if (
            $post->status !== 'active' &&
            !(Auth::check() && (Auth::user()->isAdmin() || Auth::id() === $post->user_id))
        ) {
            abort(404);
        }

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Only post owner or admin can edit
        if (Auth::id() !== $post->user_id && !(Auth::check() && Auth::user()->isAdmin())) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified post
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Only post owner or admin can update
        if (Auth::id() !== $post->user_id && !(Auth::check() && Auth::user()->isAdmin())) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'media_url' => 'nullable|url',
            'tags' => 'nullable|string|max:500' // Change to string validation
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'media_url' => $request->media_url,
            'tags' => $request->tags // Store as string directly
        ]);

        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Only post owner or admin can delete
        if (Auth::id() !== $post->user_id && !(Auth::check() && Auth::user()->isAdmin())) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    /**
     * Admin function to hide a post
     */
    public function hide($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        $post = Post::findOrFail($id);
        $post->update(['status' => 'hidden']);

        return redirect()->back()->with('success', 'Post hidden successfully!');
    }

    /**
     * Admin function to unhide a post
     */
    public function unhide($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        $post = Post::findOrFail($id);
        $post->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Post unhidden successfully!');
    }

    /**
     * Admin function to view hidden posts
     */
    public function hiddenPosts()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        $posts = Post::where('status', 'hidden')
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('posts.hidden', compact('posts'));
    }
    public function adminIndex(Request $request)
    {
        // Get the status filter from the request
        $status = $request->query('status', 'all');

        // Start building the query - ADD REPORTS RELATIONSHIPS
        $query = Post::with([
            'user',
            'reports.reporter',
            'reports.assignedModerator',
            'comments', // if you want comment counts
            'likes'     // if you want like counts
        ]);

        // Apply filter if not 'all'
        if ($status === 'active') {
            $query->where('status', 'active');
        } elseif ($status === 'hidden') {
            $query->where('status', 'hidden');
        }
        // If status is 'all', no additional where clause is needed

        $posts = $query->latest()->paginate(12);

        return view('admin.index', compact('posts'));
    }

    /**
     * Display the specified post for admin
     */
    public function adminShow($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        $post = Post::with([
            'user', 'comments.user', 'comments.likes.user',
            'comments.reports', 'likes.user', 'reports.reporter'
        ])
            ->findOrFail($id);

        return view('admin.show', compact('post'));
    }

    public function getPostReports($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            // Make sure to load the relationships correctly
            $post = Post::with([
                'reports.reporter',
                'reports.assignedModerator'
            ])->findOrFail($id);

            $reports = $post->reports->map(function ($report) {
                return [
                    'id' => $report->id,
                    'reason' => $report->reason,
                    'description' => $report->description,
                    'status' => $report->status,
                    'created_at' => $report->created_at,
                    'reporter_name' => $report->reporter ? $report->reporter->name : null,
                    'assigned_moderator_name' => $report->assignedModerator ? $report->assignedModerator->name : null,
                ];
            });

            return response()->json([
                'reports' => $reports,
                'post_title' => $post->title
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Post not found or server error'
            ], 404);
        }
    }
}
