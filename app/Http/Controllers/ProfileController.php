<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function create()
{
    $user = auth()->user();
    $badges = $user->badges; // eager-load if needed: $user->load('badges');


    return view('pages.profile', compact('user','badges'));
}


    public function update()
    {

        $user = request()->user();
        $attributes = request()->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'name' => 'required',
            'phone' => 'required|max:10',
            'about' => 'required:max:150',
            'location' => 'required'
        ]);

        auth()->user()->update($attributes);
        return back()->withStatus('Profile successfully updated.');

    }
        public function getUserBadges()
    {
        $user = auth()->user();
        $badges = $user->badges; // eager-load if needed: $user->load('badges');

        return view('pages.profile', compact('badges'));
    }
    public function show(User $user){
        //get the user by id
        $user = User::findOrFail($user->id);
        $badges = $user->badges;

        return view('pages.indexProfile', compact('user','badges'));
    }

}
