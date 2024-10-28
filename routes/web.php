<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WatchController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\BrainController;
use App\Http\Controllers\UserRecordController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Home');
})->name('home');

Route::get('/play', function () {
    return Inertia::render('Play');
})->name('play');

// Route::get('/watch', [WatchController::class, 'index'])->name('watch');
Route::get('/challenge', [ChallengeController::class, 'index'])->name('challenge');

Route::resource('records', RecordController::class);
Route::get('/brains/{brain}/records', [BrainController::class, 'showRecords'])->name('brains.records');
Route::resource('brains', BrainController::class);
Route::resource('user-records', UserRecordController::class);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
