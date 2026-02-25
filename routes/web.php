<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RapportEpargneController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/print', [DashboardController::class, 'print'])->name('dashboard.print');

// Régions
Route::resource('regions', RegionController::class)->except(['show']);

// Provinces
Route::resource('provinces', ProvinceController::class)->except(['show']);

// Rapports d'épargnes
Route::resource('rapports', RapportEpargneController::class)->except(['show']);
