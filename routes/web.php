<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/api/geomap', [DashboardController::class, 'geomapData'])->name('dashboard.geomap');
Route::get('/api/datatable', [DashboardController::class, 'datatableData'])->name('dashboard.datatable');
Route::post('/api/store', [DashboardController::class, 'store'])->name('dashboard.store');
Route::post('/api/update', [DashboardController::class, 'update'])->name('dashboard.update');
Route::post('/api/delete', [DashboardController::class, 'delete'])->name('dashboard.delete');
Route::post('/api/chat', [DashboardController::class, 'chat'])->name('dashboard.chat');
