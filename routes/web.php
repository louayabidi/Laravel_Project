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
use App\Http\Controllers\FoodGoalController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\NutritionController;
use App\Http\Controllers\BadgeCategoryController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;



// Root redirect
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

use App\Http\Controllers\SanteMesureController;
use App\Http\Controllers\ObjectifController;

/*
|--------------------------------------------------------------------------
| Routes publiques / guest
|--------------------------------------------------------------------------
*/

// Redirection root vers login
Route::get('/', fn() => redirect()->route('login'))->middleware('guest');

// Authentication routes
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');

Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');

Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');

Route::get('verify', fn() => view('sessions.password.verify'))->middleware('guest')->name('verify');

Route::get('/reset-password/{token}', fn($token) => view('sessions.password.reset', ['token' => $token]))
    ->middleware('guest')->name('password.reset');

/*
|--------------------------------------------------------------------------
| Routes protégées / auth
|--------------------------------------------------------------------------
*/
// Back-office admin : Objectifs + Habitudes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('objectifs-habitudes', [ObjectifController::class, 'backIndex'])->name('admin.objectifs.habitudes');
});

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile & logout
    Route::get('profile', [ProfileController::class, 'create'])->name('profile');


    Route::post('user-profile', [ProfileController::class, 'update']);
    Route::post('sign-out', [SessionsController::class, 'destroy'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Pages exemples
    |--------------------------------------------------------------------------
    */
    Route::view('tables', 'pages.tables')->name('tables');
    Route::view('user-management', 'pages.laravel-examples.user-management')->name('user-management');
    Route::view('user-profile', 'pages.laravel-examples.user-profile')->name('user-profile');
    //Route::view('profile', 'pages.profile')->name('profile');

   // gestion alimentaire

    /*
    |--------------------------------------------------------------------------
    | Objectifs & Habitudes
    |--------------------------------------------------------------------------
    */

    // Objectifs
    Route::resource('objectifs', ObjectifController::class);
    Route::get('/objectifs/{id}', [ObjectifController::class, 'show'])->name('objectifs.show');
    Route::delete('/objectifs/{id}', [ObjectifController::class, 'destroy'])->name('objectifs.destroy');

    // Habitudes générales
    Route::get('/habitudes', [HabitudeController::class, 'index'])->name('habitudes.index');

    // Habitudes CRUD classiques
    Route::put('/habitudes/{habitude}', [HabitudeController::class, 'update'])->name('habitudes.update');
    Route::delete('/habitudes/{habitude}', [HabitudeController::class, 'destroy'])->name('habitudes.destroy');
    Route::get('/habitudes/{habitude}', [HabitudeController::class, 'show'])->name('habitudes.show');

    // Habitudes "back/admin"
    Route::get('habitudes/back', [HabitudeController::class, 'backIndex'])->name('habitudes.backIndex');
    // Habitudes liées à un objectif
    Route::prefix('objectifs/{objectif}/habitudes')->group(function () {
        Route::get('/', [HabitudeController::class, 'indexByObjectif'])->name('objectifs.habitudes.index');
        Route::get('create', [HabitudeController::class, 'create'])->name('objectifs.habitudes.create');
        Route::post('/', [HabitudeController::class, 'store'])->name('objectifs.habitudes.store');
        Route::get('{habitude}/edit', [HabitudeController::class, 'edit'])->name('objectifs.habitudes.edit');
    });

    /*
    |--------------------------------------------------------------------------
    | Santé Mesures
    |--------------------------------------------------------------------------
    */
    Route::get('sante-mesures/back', [SanteMesureController::class, 'backIndex'])->name('sante-mesures.backIndex');
    Route::get('sante-mesures/back/{sante_mesure}', [SanteMesureController::class, 'backShow'])->name('sante-mesures.backShow');

    Route::resource('sante-mesures', SanteMesureController::class)->except(['index']);
    Route::get('sante-mesures', [SanteMesureController::class, 'index'])->name('sante-mesures.index');
    Route::get('sante-mesures/export/pdf', [SanteMesureController::class, 'exportPDF'])->name('sante-mesures.export.pdf');

    /*
    |--------------------------------------------------------------------------
    | Gestion alimentaire
    |--------------------------------------------------------------------------
    */
Route::resource('foods', FoodController::class);
Route::resource('meals', MealController::class);
Route::resource('analytics', AnalyticController::class);
Route::resource('meal-foods', MealFoodController::class);
Route::resource('goals', FoodGoalController::class);
Route::delete('goals/{goal}', [FoodGoalController::class, 'destroy'])->name('goals.destroy');
Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
Route::get('/food-suggestions', [App\Http\Controllers\MealFoodController::class, 'suggestions'])->name('food.suggestions');

Route::post('goals/{goal}/set-active', [FoodGoalController::class, 'setActive'])->name('goals.set-active');
Route::get('admin/activity-logs', [FoodGoalController::class, 'activityLogs'])
    ->name('activity_logs');

Route::resource('categories', BadgeCategoryController::class);
Route::resource('badges', BadgeController::class);


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
