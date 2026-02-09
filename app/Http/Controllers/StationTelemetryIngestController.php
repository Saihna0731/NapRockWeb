<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StationTelemetryIngestController extends Controller
{
    public function __invoke(Request $request, string $station): JsonResponse
    {
        $payload = $request->validate([
            'temperature_c' => ['nullable', 'numeric'],
            'humidity_pct' => ['nullable', 'numeric'],
            'battery_v' => ['nullable', 'numeric'],
            'rssi_dbm' => ['nullable', 'numeric'],
            // Microphone / audio features from ESP32+INMP441 (or gateway)
            'sound_db' => ['nullable', 'numeric'],
            'dominant_hz' => ['nullable', 'numeric'],
            'rms' => ['nullable', 'numeric'],
            'recorded_at' => ['nullable', 'date'],
        ]);

        $key = "station:{$station}";
        $current = Cache::get($key, []);

        $next = array_replace_recursive($current, [
            'telemetry' => array_filter($payload, static fn ($v) => $v !== null),
        ]);

        Cache::put($key, $next);

        return response()->json([
            'ok' => true,
            'station' => $station,
        ]);
    }
}
