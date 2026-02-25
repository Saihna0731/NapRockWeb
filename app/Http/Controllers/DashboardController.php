<?php

namespace App\Http\Controllers;

use App\Services\StationFeedService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request, StationFeedService $stationFeed)
    {
        $stations = $stationFeed->stations();

        return view('dashboard', [
            'stations' => $stations,
        ]);
    }
}
