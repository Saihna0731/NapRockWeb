<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class StationFeedService
{
    public function stations(): array
    {
        $baseStations = $this->applyCacheOverrides(config('stations', []));
        $remoteStations = $this->fetchRemoteStations();

        if (empty($remoteStations)) {
            return $baseStations;
        }

        return $this->mergeStations($baseStations, $remoteStations);
    }

    private function applyCacheOverrides(array $stations): array
    {
        return array_map(static function (array $station): array {
            $id = $station['id'] ?? null;

            if (!is_string($id) || $id === '') {
                return $station;
            }

            $override = Cache::get("station:{$id}", []);

            return array_replace_recursive($station, is_array($override) ? $override : []);
        }, $stations);
    }

    private function fetchRemoteStations(): array
    {
        $enabled = (bool) config('services.python_api.enabled', false);
        $baseUrl = rtrim((string) config('services.python_api.base_url', ''), '/');
        $stationsPath = '/' . ltrim((string) config('services.python_api.stations_path', '/stations'), '/');

        if (!$enabled || $baseUrl === '') {
            return [];
        }

        try {
            $response = Http::acceptJson()
                ->timeout(6)
                ->get("{$baseUrl}{$stationsPath}");

            if (!$response->ok()) {
                return [];
            }

            $payload = $response->json();

            return $this->normalizeRemotePayload($payload);
        } catch (\Throwable) {
            return [];
        }
    }

    private function normalizeRemotePayload(mixed $payload): array
    {
        $rows = [];

        if (is_array($payload)) {
            if (array_is_list($payload)) {
                $rows = $payload;
            } elseif (isset($payload['stations']) && is_array($payload['stations'])) {
                $rows = $payload['stations'];
            } elseif (isset($payload['data']) && is_array($payload['data'])) {
                $rows = $payload['data'];
            } elseif (isset($payload['items']) && is_array($payload['items'])) {
                $rows = $payload['items'];
            } else {
                $rows = [$payload];
            }
        }

        $stations = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }

            $station = $this->normalizeStation($row);
            if ($station !== null) {
                $stations[] = $station;
            }
        }

        return $stations;
    }

    private function normalizeStation(array $row): ?array
    {
        $id = $this->pickString($row, ['id', 'station_id', 'device_id', 'label']);
        if ($id === '') {
            return null;
        }

        $commonName = $this->pickString($row, [
            'ml.species.common_name',
            'detection.species.common_name',
            'bird.common_name',
            'species_common_name',
            'species_name',
        ], 'Unknown species');

        $scientificName = $this->pickString($row, [
            'ml.species.scientific_name',
            'detection.species.scientific_name',
            'bird.scientific_name',
            'species_scientific_name',
        ]);

        return [
            'id' => $id,
            'label' => $this->pickString($row, ['label'], $id),
            'area_label' => $this->pickString($row, ['area_label'], "Area {$id}"),
            'zone' => strtolower($this->pickString($row, ['zone'], 'forest')),
            'area' => $this->pickString($row, ['area'], 'Live API Station'),
            'coordinates' => [
                'lat' => $this->pickNumber($row, ['coordinates.lat', 'latitude']),
                'lng' => $this->pickNumber($row, ['coordinates.lng', 'longitude']),
            ],
            'telemetry' => [
                'temperature_c' => $this->pickNumber($row, ['telemetry.temperature_c', 'temperature_c']),
                'humidity_pct' => $this->pickNumber($row, ['telemetry.humidity_pct', 'humidity_pct']),
                'battery_v' => $this->pickNumber($row, ['telemetry.battery_v', 'battery_v']),
                'rssi_dbm' => $this->pickNumber($row, ['telemetry.rssi_dbm', 'rssi_dbm']),
                'sound_db' => $this->pickNumber($row, ['telemetry.sound_db', 'sound_db']),
                'dominant_hz' => $this->pickNumber($row, ['telemetry.dominant_hz', 'dominant_hz']),
                'recorded_at' => $this->pickString($row, ['telemetry.recorded_at', 'recorded_at']),
            ],
            'ml' => [
                'status' => $this->pickString($row, ['ml.status', 'detection.status', 'status'], 'Healthy'),
                'eco_score' => $this->pickNumber($row, ['ml.eco_score', 'detection.eco_score', 'eco_score']),
                'confidence_pct' => $this->pickNumber($row, ['ml.confidence_pct', 'detection.confidence_pct', 'confidence', 'confidence_pct']),
                'activity_det_per_hr' => $this->pickNumber($row, ['ml.activity_det_per_hr', 'detection.activity_det_per_hr', 'activity_det_per_hr']),
                'species' => [
                    'common_name' => $commonName,
                    'scientific_name' => $scientificName,
                    'image_url' => $this->pickString($row, ['ml.species.image_url', 'detection.species.image_url', 'bird.image_url', 'species_image_url']),
                ],
                'recorded_at' => $this->pickString($row, ['ml.recorded_at', 'detection.recorded_at', 'recorded_at']),
            ],
            'status' => strtolower($this->pickString($row, ['status'], 'online')),
        ];
    }

    private function pickString(array $source, array $paths, string $fallback = ''): string
    {
        foreach ($paths as $path) {
            $value = data_get($source, $path);
            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        return $fallback;
    }

    private function pickNumber(array $source, array $paths): ?float
    {
        foreach ($paths as $path) {
            $value = data_get($source, $path);
            if (is_numeric($value)) {
                return (float) $value;
            }
        }

        return null;
    }

    private function mergeStations(array $base, array $remote): array
    {
        $byId = [];

        foreach ($base as $station) {
            if (!is_array($station)) {
                continue;
            }

            $id = $station['id'] ?? null;
            if (!is_string($id) || $id === '') {
                continue;
            }

            $byId[$id] = $station;
        }

        foreach ($remote as $station) {
            if (!is_array($station)) {
                continue;
            }

            $id = $station['id'] ?? null;
            if (!is_string($id) || $id === '') {
                continue;
            }

            $existing = $byId[$id] ?? [];
            $byId[$id] = array_replace_recursive($existing, $station);
        }

        return array_values($byId);
    }
}
