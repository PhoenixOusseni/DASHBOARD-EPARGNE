<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RapportEpargneController;
use App\Http\Controllers\DashboardGlobalController;

// Dashboard
Route::get('/dashboard/mensuel', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/print', [DashboardController::class, 'print'])->name('dashboard.print');

// Dashboard global
Route::get('/', [DashboardGlobalController::class, 'index'])->name('dashboard.global');
Route::get('/dashboard/global/print', [DashboardGlobalController::class, 'print'])->name('dashboard.global.print');

// Régions
Route::resource('regions', RegionController::class)->except(['show']);

// Provinces
Route::resource('provinces', ProvinceController::class)->except(['show']);

// Rapports d'épargnes
Route::resource('rapports', RapportEpargneController::class)->except(['show']);
