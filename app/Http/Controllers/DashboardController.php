<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
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

        return view('dashboard', [
            'stations' => $stations,
        ]);
    }
}
