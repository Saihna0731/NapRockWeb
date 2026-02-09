<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class StationApiController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $stations = config('stations', []);

        $stations = array_map(static function (array $station): array {
            $id = $station['id'] ?? null;

            if (!is_string($id) || $id === '') {
                return $station;
            }

            $override = Cache::get("station:{$id}", []);

            return array_replace_recursive($station, is_array($override) ? $override : []);
        }, $stations);

        return response()->json(['stations' => $stations]);
    }
}
