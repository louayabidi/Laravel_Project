<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;

// Root redirect
Route::get('/', function () {
    return redirect()->route('sign-in');
})->middleware('guest');

// Authentication routes
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');

Route::get('sign-in', [SessionsController::class, 'create'])
    ->middleware('guest')
    ->name('login'); 

Route::post('sign-in', [SessionsController::class, 'store'])
    ->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');

Route::get('verify', function () {
    return view('sessions.password.verify');
})->middleware('guest')->name('verify');

Route::get('/reset-password/{token}', function ($token) {
    return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Profile & logout
Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');

// Example pages (billing, tables, etc.)
Route::group(['middleware' => 'auth'], function () {
    Route::get('billing', fn() => view('pages.billing'))->name('billing');
    Route::get('tables', fn() => view('pages.tables'))->name('tables');
    Route::get('rtl', fn() => view('pages.rtl'))->name('rtl');
    Route::get('virtual-reality', fn() => view('pages.virtual-reality'))->name('virtual-reality');
    Route::get('notifications', fn() => view('pages.notifications'))->name('notifications');
    Route::get('static-sign-in', fn() => view('pages.static-sign-in'))->name('static-sign-in');
    Route::get('static-sign-up', fn() => view('pages.static-sign-up'))->name('static-sign-up');
    Route::get('user-management', fn() => view('pages.laravel-examples.user-management'))->name('user-management');
    Route::get('user-profile', fn() => view('pages.laravel-examples.user-profile'))->name('user-profile');
});
