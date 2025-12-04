<?php

use App\Http\Controllers\AdminWebController;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\ProfileWebController;
use App\Http\Controllers\SuperAdminWebController;
use App\Http\Controllers\UnitWebController;
use App\Http\Controllers\TrackingController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ========================================
// ROOT REDIRECT
// ========================================
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->role && $user->role->name === 'Super Admin') {
            return redirect()->route('users.index');
        } elseif ($user->role && $user->role->name === 'Admin') {
            return redirect()->route('shippings.index');
        }
    }

    return redirect()->route('login');
});

// ========================================
// AUTH ROUTES
// ========================================
Route::get('/login', function () {
    return view('Auth.login');
})->name('login');

Route::post('/login', [AuthWebController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

// ========================================
// AUTHENTICATED ROUTES
// ========================================
Route::middleware(['auth'])->group(function () {

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', function () {
            return view('General.profile');
        })->name('index');
        Route::put('/update', [ProfileWebController::class, 'update'])->name('update');
    });

    // Shipping Routes
    Route::prefix('shippings')->name('shippings.')->group(function () {
        Route::get('/', [AdminWebController::class, 'shippingsIndex'])->name('index');
        Route::get('/export', [AdminWebController::class, 'exportShippings'])->name('export');
        Route::get('/search', [AdminWebController::class, 'searchDocument'])->name('search');
        Route::get('/add', [AdminWebController::class, 'shippingsAdd'])->name('add');
        Route::post('/', [AdminWebController::class, 'shippingsAddTravelDocument'])->name('store');
        Route::get('/{id}', [AdminWebController::class, 'shippingsDetail'])->name('detail');
        Route::get('/{id}/edit', [AdminWebController::class, 'shippingsEdit'])->name('edit');
        Route::put('/{id}', [AdminWebController::class, 'shippingsUpdate'])->name('update');
        Route::delete('/{id}', [AdminWebController::class, 'shippingsDelete'])->name('destroy');
        Route::get('/{id}/print', [AdminWebController::class, 'printShippings'])->name('print');
    });

    // Tracking Routes
    Route::prefix('tracking')->name('tracking.')->group(function () {
        Route::get('/', [TrackingController::class, 'index'])->name('index');
        Route::get('/search', [TrackingController::class, 'search'])->name('search');
        Route::get('/{track_id}', [TrackingController::class, 'show'])->name('show');
    });

    // Unit Routes
    Route::prefix('units')->name('units.')->group(function () {
        Route::get('/', [UnitWebController::class, 'index'])->name('index');
        Route::get('/add', [UnitWebController::class, 'create'])->name('add');
        Route::post('/', [UnitWebController::class, 'store'])->name('store');
        Route::get('/{unit}/edit', [UnitWebController::class, 'edit'])->name('edit');
        Route::put('/{unit}', [UnitWebController::class, 'update'])->name('update');
        Route::delete('/{unit}', [UnitWebController::class, 'destroy'])->name('destroy');
    });
});

// ========================================
// SUPER ADMIN ROUTES
// ========================================
Route::middleware(['auth', RoleMiddleware::class.':super admin'])->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [SuperAdminWebController::class, 'index'])->name('index');
        Route::get('/search', [SuperAdminWebController::class, 'searchUser'])->name('search');
        Route::get('/add', [SuperAdminWebController::class, 'add'])->name('add');
        Route::post('/', [SuperAdminWebController::class, 'register'])->name('store');
        Route::get('/{id}/edit', [SuperAdminWebController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SuperAdminWebController::class, 'update'])->name('update');
        Route::delete('/{id}', [SuperAdminWebController::class, 'delete'])->name('destroy');
    });
});
