<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/dashboard', DashboardController::class)->name('dashboard');
Route::view('/gis', 'gis')->name('gis');
Route::view('/historical', 'historical')->name('historical');
Route::view('/species-id', 'species-id')->name('species-id');
Route::view('/future', 'future')->name('future');
Route::view('/live', 'live')->name('live');
