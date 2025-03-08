<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MEventController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// チーム関連
Route::get('/teams', [TeamController::class, 'index'])->name('team.index');
Route::get('/teams/create', [TeamController::class, 'create'])->name('team.create');

//　マスタ関連

//　種目マスタ
// Route::get('/m_events', [MEventController::class, 'index'])->name('m_event.index');
// Route::get('/m_events/create', [MEventController::class, 'create'])->name('m_event.create');
// Route::post('/m_events/store', [MEventController::class, 'store'])->name('m_event.store');

Route::middleware('auth')
    ->prefix('m_events')
    ->group(function () {
        Route::get('/', [MEventController::class, 'index'])->name('m_event.index');
        Route::get('/create', [MEventController::class, 'create'])->name('m_event.create');
        Route::post('/store', [MEventController::class, 'store'])->name('m_event.store');
        Route::get('/edit/{id}', [MEventController::class, 'edit'])->name('m_event.edit');
        Route::put('/edit/{id}', [MEventController::class, 'update'])->name('m_event.update');
        Route::delete('/delete/{id}', [MEventController::class, 'destroy'])->name('m_event.destroy');
    });

require __DIR__.'/auth.php';
