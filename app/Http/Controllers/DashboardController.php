<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('dashboard.index'); 
        } elseif ($user->role === 'user') {
            return view('dashboard.user'); 
        } else {
            abort(403, 'Accès refusé.');
        }
    }
}
