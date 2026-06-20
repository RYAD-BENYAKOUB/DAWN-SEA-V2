<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dawn & Sea V2 — Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{slug}', [ProgramController::class, 'show'])->name('programs.show');
Route::get('/guides', [GuideController::class, 'index'])->name('guides.index');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard — redirects users to profile, guides to guide dashboard
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->isGuide()) {
        return app(DashboardController::class)->index();
    }
    return redirect()->route('profile.edit');
})->middleware(['auth', 'verified'])->name('dashboard');

// Guide Dashboard Routes (requires auth + guide role)
Route::middleware(['auth', 'verified', 'role:guide'])->prefix('dashboard')->group(function () {
    Route::get('/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
    Route::resource('programs', ProgramController::class)->except(['index', 'show'])->names([
        'create' => 'dashboard.programs.create',
        'store' => 'dashboard.programs.store',
        'edit' => 'dashboard.programs.edit',
        'update' => 'dashboard.programs.update',
        'destroy' => 'dashboard.programs.destroy',
    ]);
});

// Superadmin Dashboard Routes
Route::middleware(['auth', 'verified', 'role:superadmin'])->prefix('dashboard/superadmin')->group(function () {
    Route::get('/', [SuperAdminDashboardController::class, 'index'])->name('dashboard.superadmin');
    Route::get('/users', [UserManagementController::class, 'index'])->name('dashboard.users.index');
    Route::patch('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('dashboard.users.updateRole');
});

require __DIR__.'/auth.php';
