<?php

namespace App\Http\Controllers;

use App\Services\StationFeedService;
use Illuminate\Http\JsonResponse;

class StationApiController extends Controller
{
    public function __invoke(StationFeedService $stationFeed): JsonResponse
    {
        $stations = $stationFeed->stations();

        return response()->json(['stations' => $stations]);
    }
}
