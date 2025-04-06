<?php

use App\Http\Controllers\AthleteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MEventController;
use App\Http\Controllers\MEventPositionController;
use App\Http\Controllers\MBodyPartController;
use App\Http\Controllers\MInjuryNameController;
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
Route::middleware('auth')
    ->prefix('teams')
    ->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('team.index');
        Route::get('/create', [TeamController::class, 'create'])->name('team.create');
        Route::post('/store', [TeamController::class, 'store'])->name('team.store');
        Route::get('/show/{id}', [TeamController::class, 'show'])->name('team.show');
        Route::get('/edit/{id}', [TeamController::class, 'edit'])->name('team.edit');
        Route::put('/edit/{id}', [TeamController::class, 'update'])->name('team.update');
        Route::delete('/delete/{id}', [TeamController::class, 'destroy'])->name('team.destroy');
    });

// 選手関連
Route::middleware('auth')
    ->prefix('athletes')
    ->group(function () {
        Route::get('/', [AthleteController::class, 'index'])->name('athlete.index');
        Route::get('/team/{team_id}', [AthleteController::class, 'showRespectiveTeam'])->name('athlete.show_respective_team');
        Route::get('/create', [AthleteController::class, 'create'])->name('athlete.create');
        Route::post('/store', [AthleteController::class, 'store'])->name('athlete.store');
        Route::get('/show/{athlete_id}/{position_id}', [AthleteController::class, 'show'])->name('athlete.show');
        Route::get('/edit/{athlete_id}/{position_id}', [AthleteController::class, 'edit'])->name('athlete.edit');
        Route::put('/edit/{athlete_id}', [AthleteController::class, 'update'])->name('athlete.update');
        Route::delete('/delete/{athlete_id}', [AthleteController::class, 'destroy'])->name('athlete.destroy');
    });


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

// 部位マスタ
Route::middleware('auth')
    ->prefix('m_body_parts')
    ->group(function() {
        Route::get('/', [MBodyPartController::class, 'index'])->name('m_body_part.index');
    });

// 傷病名マスタ
Route::middleware('auth')
    ->prefix('m_injury_names')
    ->group(function() {
        Route::get('/', [MInjuryNameController::class, 'index'])->name('m_injury_name.index');
        Route::get('/create', [MInjuryNameController::class, 'create'])->name('m_injury_name.create');
        Route::post('/store', [MInjuryNameController::class, 'store'])->name('m_injury_name.store');
        Route::get('/edit/{id}', [MInjuryNameController::class, 'edit'])->name('m_injury_name.edit');
        Route::put('/edit/{id}', [MInjuryNameController::class, 'update'])->name('m_injury_name.update');
    }
);

require __DIR__.'/auth.php';
