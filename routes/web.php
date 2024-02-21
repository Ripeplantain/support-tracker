<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityUpdateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Activities
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities/{id}', [ActivityController::class, 'show'])->name('activities.show');
    Route::delete('/activities/{id}', [ActivityController::class, 'destroy'])->name('activities.destroy');
    Route::get('/activities/{id}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::patch('/activities/{id}', [ActivityController::class, 'update'])->name('activities.update');
    
    // Activity Updates
    Route::get('/activities/{id}/updates/create', [ActivityUpdateController::class, 'create'])->name('activity_updates.create');
    Route::post('/activities/{id}/updates', [ActivityUpdateController::class, 'store'])->name('activity_updates.store');
    Route::get('/activities/{id}/updates/{update}/edit', [ActivityUpdateController::class, 'edit'])->name('activity_updates.edit');
    Route::patch('/activities/{id}/updates/{update}', [ActivityUpdateController::class, 'update'])->name('activity_updates.update');
    Route::delete('/activities/{id}/updates/{update}', [ActivityUpdateController::class, 'destroy'])->name('activity_updates.destroy');
});

require __DIR__.'/auth.php';
