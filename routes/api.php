<?php

use App\Http\Controllers\StationApiController;
use App\Http\Controllers\StationDetectionIngestController;
use App\Http\Controllers\StationTelemetryIngestController;
use Illuminate\Support\Facades\Route;

Route::get('/stations', StationApiController::class);

Route::post('/stations/{station}/telemetry', StationTelemetryIngestController::class);
Route::post('/stations/{station}/detection', StationDetectionIngestController::class);
