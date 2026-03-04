<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/dashboard', DashboardController::class)->name('dashboard');
Route::view('/gis', 'gis')->name('gis');
Route::get('/historical', function () {
    $stations = app(\App\Services\StationFeedService::class)->stations();
    return view('historical', ['stations' => $stations]);
})->name('historical');
Route::view('/species-id', 'species-id')->name('species-id');
Route::view('/future', 'future')->name('future');
Route::view('/live', 'live')->name('live');
