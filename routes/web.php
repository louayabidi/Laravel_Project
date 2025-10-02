<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MealFoodController;
use App\Http\Controllers\HabitudeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SanteMesureController;


// Root redirect
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');


// Authentication routes
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');

Route::get('sign-in', [SessionsController::class, 'create'])
    ->middleware('guest')
    //->name('sign-in');
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
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Profile & logout
Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');

// Example pages (billing, tables, etc.)
Route::group(['middleware' => 'auth'], function () {
    Route::get('billing', fn () => view('pages.billing'))->name('billing');
    Route::get('tables', fn () => view('pages.tables'))->name('tables');
    Route::get('rtl', fn () => view('pages.rtl'))->name('rtl');
    Route::get('virtual-reality', fn () => view('pages.virtual-reality'))->name('virtual-reality');
    Route::get('notifications', fn () => view('pages.notifications'))->name('notifications');
    Route::get('static-sign-in', fn () => view('pages.static-sign-in'))->name('static-sign-in');
    Route::get('static-sign-up', fn () => view('pages.static-sign-up'))->name('static-sign-up');
    Route::get('user-management', fn () => view('pages.laravel-examples.user-management'))->name('user-management');
    Route::get('user-profile', fn () => view('pages.laravel-examples.user-profile'))->name('user-profile');

    // Route back/admin en premier
    Route::get('habitudes/back', [HabitudeController::class, 'backIndex'])
        ->name('habitudes.backIndex');

    // Routes front pour les utilisateurs (CRUD)
    Route::resource('habitudes', HabitudeController::class)
        ->except(['index']);

    // Route index utilisateur
    Route::get('habitudes', [HabitudeController::class, 'index'])
        ->name('habitudes.index');




    // Route back/admin en premier
    Route::get('sante-mesures/back', [SanteMesureController::class, 'backIndex'])
        ->name('sante-mesures.backIndex');
    Route::get('sante-mesures/back/{sante_mesure}', [SanteMesureController::class, 'backShow'])
        ->name('sante-mesures.backShow');

    // Routes front pour les utilisateurs (CRUD)
    Route::resource('sante-mesures', SanteMesureController::class)
        ->except(['index']);

    // Route index utilisateur
    Route::get('sante-mesures', [SanteMesureController::class, 'index'])
        ->name('sante-mesures.index');

    Route::get('sante-mesures/export/pdf', [SanteMesureController::class, 'exportPDF'])->name('sante-mesures.export.pdf');

    // gestion alimentaire 
    Route::resource('foods', FoodController::class);
    Route::resource('meals', MealController::class);
    Route::resource('analytics', AnalyticController::class);
    Route::resource('meal-foods', MealFoodController::class);


    // forum 
    Route::resource('posts', PostController::class);

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/admin/posts/{post}', [PostController::class, 'show'])->name('admin.show');

    Route::get('/admin/posts', [PostController::class, 'adminIndex'])->name('admin.index');

    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('/admin/posts/{post}/edit', [PostController::class, 'edit'])->name('admin.edit');

    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/hide', [PostController::class, 'hide'])->name('posts.hide');
    Route::post('/posts/{post}/unhide', [PostController::class, 'unhide'])->name('posts.unhide');
    Route::get('/admin/hidden-posts', [PostController::class, 'hiddenPosts'])->name('posts.hidden');
});
