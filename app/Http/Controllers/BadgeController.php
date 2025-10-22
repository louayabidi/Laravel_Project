<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Models\Badge;
use Illuminate\Http\Request;
use App\Models\BadgeCategorie;
use Illuminate\Support\Facades\Auth;
class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $user = Auth::user();

    // Fetch all badges with categories
    $badges = Badge::with('category')->get();

    // Fetch all users with badges
    $allUsers = User::with(['badges' => function($query) {
    $query->wherePivot('acquired', true);
}])->get();

    // Filter users with at least one badge
    $usersWithBadges = $allUsers->filter(fn($u) => $u->badges->count() > 0);

    // Prepare leaderboard
    $leaderboard = $usersWithBadges->map(function($u) {
        $u->badge_count = $u->badges->count();

        // Shuffle badges and take max 3
        $u->random_badges = $u->badges->shuffle()->take(3);

        // Compute how many extra badges
        $u->extra_badges = max(0, $u->badge_count - 3);

        return $u;
    })->sortByDesc('badge_count');
    $leaderboard = $leaderboard->take(10);
    $leaderboard = $leaderboard->values();

    return view('gamification.badge.index', compact('badges', 'user', 'allUsers', 'leaderboard'))
        ->with('activePage', 'badges');
}



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
{
    $categories = BadgeCategorie::all();
    $selectedCategoryId = $request->query('badge_categorie_id'); // ✅ reads query parameter

    return view('gamification.badge.create', [
        'activePage' => 'badges',
        'categories' => $categories,
        'selectedCategoryId' => $selectedCategoryId
    ]);
}


        public function store(Request $request)
    {
        // Log incoming request for debugging
        \Log::info('Badge store request:', $request->all());
        \Log::info('Has Image?', ['hasFile' => $request->hasFile('image')]);

        // Validate inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'badge_categorie_id' => 'required|exists:badge_categories,id',
            'criteria' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description', 'badge_categorie_id', 'criteria']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('badges', 'public');
            $data['image'] = $path;
        }

        // Make sure model has fillable
        Badge::create($data);

        return redirect()->route('categories.show', $request->badge_categorie_id)
                        ->with('success', 'Badge created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Badge $badge)
    {
        // show badge
        return view('gamification.badge.show', compact('badge'))
            ->with('activePage', 'badges');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Badge $badge)
    {
        return view('gamification.badge.edit', compact('badge'))
            ->with('activePage', 'badges');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Badge $badge)
    {
        // Validate inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'criteria' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description', 'criteria']);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('badges', 'public');
            $data['image'] = $path;
        }

        $badge->update($data);

        return redirect()->route('categories.show', $badge->badge_categorie_id)->with('success', 'Badge updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Badge $badge)
    {
        // Delete badge
        $badge->delete();
        return redirect()->route('categories.show', $badge->badge_categorie_id)->with('success', 'Badge deleted successfully!');
    }
}
