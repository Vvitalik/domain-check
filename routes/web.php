<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DomainController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/dashboard', DashboardController::class)
        ->name('dashboard');

    Route::post('/domains/{domain}/check', [DomainController::class, 'check'])
        ->name('domains.check');

    Route::resource('domains', DomainController::class);

});

require __DIR__ . '/auth.php';
