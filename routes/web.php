<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\BrainController;
use App\Http\Controllers\BrainRecordController;
use App\Http\Controllers\UserRecordController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// use Illuminate\Foundation\Application;
// use App\Http\Controllers\PlayController;
// use App\Http\Controllers\WatchController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () {
    return Inertia::render('Home', [
        'messages' => trans('messages'),
    ]);
})->name('home');
Route::get('/privacy-policy', function () {
    return Inertia::render('PrivacyPolicy', [
        'messages' => trans('messages'),
    ]);
})->name('privacy-policy');

Route::get('/switch-language/{locale}', [LanguageController::class, 'switch']);

Route::get('/play', function () {
    return Inertia::render('Play', [
        'messages' => trans('messages'),
    ]);
})->name('play');

// Route::get('/watch', [WatchController::class, 'index'])->name('watch');
Route::get('/challenge', [ChallengeController::class, 'index'])->name('challenge');

Route::resource('brain-records', BrainRecordController::class);
Route::get('/simulation', [BrainRecordController::class, 'create'])->name('simulation');

Route::resource('brains', BrainController::class);
Route::get('/brains/{brain}/detail', [BrainController::class, 'showDetail'])->name('brains.detail');

Route::resource('user-records', UserRecordController::class);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
