<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StationDetectionIngestController extends Controller
{
    public function __invoke(Request $request, string $station): JsonResponse
    {
        $payload = $request->validate([
            'status' => ['nullable', 'string', 'in:Healthy,Warning'],
            'eco_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'confidence_pct' => ['nullable', 'integer', 'min:0', 'max:100'],
            'activity_det_per_hr' => ['nullable', 'integer', 'min:0'],
            'species.common_name' => ['nullable', 'string'],
            'species.scientific_name' => ['nullable', 'string'],
            'species.image_url' => ['nullable', 'url'],
            'recorded_at' => ['nullable', 'date'],
        ]);

        $key = "station:{$station}";
        $current = Cache::get($key, []);

        $next = array_replace_recursive($current, [
            'ml' => array_filter($payload, static fn ($v) => $v !== null),
        ]);

        Cache::put($key, $next);

        return response()->json([
            'ok' => true,
            'station' => $station,
        ]);
    }
}
