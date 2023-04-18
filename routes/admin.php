<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;


Route::name('admin.')->group(function() {
    $enableViews = config('fortify.views', true);

    // Authentication...
    if ($enableViews) {
        Route::view('/login', 'admin.auth.login')
            ->middleware(['guest:admin'])
            ->name('login');
    }
    
    $limiter = config('fortify.limiters.login');
    
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:admin',
            $limiter ? 'throttle:'.$limiter : null,
        ]));
    
    Route::middleware(['auth:admin', 'verified'])->group(function() {
    
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        Route::get('/dashboard', DashboardController::class)
            ->name('dashboard');
    
    });
});