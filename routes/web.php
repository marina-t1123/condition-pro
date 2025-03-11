<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MEventController;
use App\Http\Controllers\MEventPositionController;
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

//=============================================================
// マスタ関連
//=============================================================

// 種目マスタ
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

// ポジション・階級マスタ
Route::middleware('auth')
    ->prefix('m_event_positions')
    ->group(function () {
        Route::get('/', [MEventPositionController::class, 'index'])->name('m_event_position.index');
        Route::get('/create', [MEventPositionController::class, 'create'])->name('m_event_position.create');
        Route::post('/store', [MEventPositionController::class, 'store'])->name('m_event_position.store');
        Route::get('/edit/{id}', [MEventPositionController::class, 'edit'])->name('m_event_position.edit');
        Route::put('/edit/{id}', [MEventPositionController::class, 'update'])->name('m_event_position.update');
        Route::delete('/delete/{id}', [MEventPositionController::class, 'destroy'])->name('m_event_position.destroy');
});

require __DIR__.'/auth.php';
