<?php

use App\Http\Controllers\AdminShareController;
use App\Http\Controllers\AdminDataController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tracks');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/tracks', [TrackController::class, 'index'])->name('tracks.index');
    Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

    Route::middleware('role:admin')->group(function (): void {
        Route::post('/admin/shares', [AdminShareController::class, 'update'])->name('admin.shares.update');
        Route::get('/admin/dashboard', [AdminDataController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/admin/sync/daily', [AdminDataController::class, 'runDailySync'])->name('admin.sync.daily');
        Route::post('/admin/sync/monthly', [AdminDataController::class, 'runMonthlySync'])->name('admin.sync.monthly');
        Route::post('/admin/rates', [AdminDataController::class, 'updateRate'])->name('admin.rates.update');
        Route::post('/admin/revenue/{entry}/adjust', [AdminDataController::class, 'manualAdjust'])->name('admin.revenue.adjust');
        Route::get('/admin/export/revenue.csv', [AdminDataController::class, 'exportRevenueCsv'])->name('admin.export.revenue');
        Route::get('/admin/export/incidents.csv', [AdminDataController::class, 'exportIncidentsCsv'])->name('admin.export.incidents');
    });
});
