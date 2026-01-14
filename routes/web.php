<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlatformController;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {

    // Dashboard / Games
    Route::get('/dashboard', [GameController::class, 'index'])->name('dashboard');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');
    Route::get('/games/trash', [GameController::class, 'trash'])->name('games.trash');
    Route::post('/games/{id}/restore', [GameController::class, 'restore'])->name('games.restore');
    Route::delete('/games/{id}/force-delete', [GameController::class, 'forceDelete'])->name('games.force-delete');
    Route::get('/games/export/pdf', [GameController::class, 'exportPdf'])->name('games.export-pdf');

    // Platforms management
    Route::get('/platforms', [PlatformController::class, 'index'])->name('platforms.index');
    Route::post('/platforms', [PlatformController::class, 'store'])->name('platforms.store');
    Route::put('/platforms/{platform}', [PlatformController::class, 'update'])->name('platforms.update');
    Route::delete('/platforms/{platform}', [PlatformController::class, 'destroy'])->name('platforms.destroy');
    Route::get('/platforms/trash', [PlatformController::class, 'trash'])->name('platforms.trash');
    Route::post('/platforms/{id}/restore', [PlatformController::class, 'restore'])->name('platforms.restore');
    Route::delete('/platforms/{id}/force-delete', [PlatformController::class, 'forceDelete'])->name('platforms.force-delete');
    Route::get('/platforms/export/pdf', [PlatformController::class, 'exportPdf'])->name('platforms.export-pdf');

    // Redirect /settings to the profile page
    Route::redirect('settings', 'settings/profile');

    // Volt routes for settings
    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    // Two-factor authentication route (only if enabled in Fortify)
    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],  // Empty array means no additional middleware when it's disabled
            ),
        )
        ->name('two-factor.show');
});

// Include Laravel Fortify authentication routes
require __DIR__.'/auth.php';
