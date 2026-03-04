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
        $apiKey = trim((string) config('services.python_api.api_key', ''));

        if (!$enabled || $baseUrl === '') {
            return [];
        }

        try {
            $request = Http::acceptJson()
                ->timeout(6);

            $query = [];
            if ($apiKey !== '') {
                $query['api_key'] = $apiKey;
            }

            $response = $request->get("{$baseUrl}{$stationsPath}", $query);

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

        // ── Species / Bird detection ──
        $commonName = $this->pickString($row, [
            'bird.species',
            'bird.common_name',
            'ml.species.common_name',
            'detection.species.common_name',
            'species_common_name',
            'species_name',
        ], 'Unknown species');

        $scientificName = $this->pickString($row, [
            'bird.scientific_name',
            'ml.species.scientific_name',
            'detection.species.scientific_name',
            'species_scientific_name',
        ]);

        $imageUrl = $this->normalizeImageUrl($this->pickString($row, [
            'bird.image_url',
            'ml.species.image_url',
            'detection.species.image_url',
            'species_image_url',
            'image_path',
        ]));

        // ── Top-K predictions ──
        $topk = data_get($row, 'bird.topk');
        $topkNormalized = [];
        if (is_array($topk)) {
            foreach (array_slice($topk, 0, 5) as $entry) {
                if (!is_array($entry)) {
                    continue;
                }
                $topkNormalized[] = [
                    'species' => $this->pickString($entry, ['species', 'common_name'], ''),
                    'scientific_name' => $this->pickString($entry, ['scientific_name'], ''),
                    'confidence_pct' => $this->pickNumber($entry, ['confidence_pct']),
                    'image_url' => $this->normalizeImageUrl($this->pickString($entry, ['image_url'], '')),
                ];
            }
        }

        // ── Eco trend ──
        $ecoTrend = $this->pickString($row, ['eco.trend', 'ml.eco_trend'], 'stable');

        return [
            'id' => $id,
            'label' => $this->pickString($row, ['label', 'station.label'], $id),
            'area_label' => $this->pickString($row, ['station.area_label', 'area_label'], "Station {$id}"),
            'zone' => strtolower($this->pickString($row, ['station.zone', 'zone'], 'forest')),
            'area' => $this->pickString($row, ['station.area', 'area'], 'Live Station'),
            'coordinates' => [
                'lat' => $this->pickNumber($row, ['station.coordinates.lat', 'coordinates.lat', 'latitude']),
                'lng' => $this->pickNumber($row, ['station.coordinates.lng', 'coordinates.lng', 'longitude']),
            ],
            'hardware' => [
                'mcu' => $this->pickString($row, ['hardware.mcu'], 'ESP32'),
                'mic' => $this->pickString($row, ['hardware.mic'], 'INMP441'),
                'sensor' => $this->pickString($row, ['hardware.sensor'], ''),
            ],
            'telemetry' => [
                'temperature_c' => $this->pickNumber($row, ['environment.temperature_c', 'telemetry.temperature_c', 'temperature_c']),
                'humidity_pct' => $this->pickNumber($row, ['environment.humidity_pct', 'telemetry.humidity_pct', 'humidity_pct']),
                'pressure_hpa' => $this->pickNumber($row, ['environment.pressure_hpa']),
                'battery_v' => $this->pickNumber($row, ['telemetry.battery_v', 'battery_v']),
                'rssi_dbm' => $this->pickNumber($row, ['wifi.rssi', 'telemetry.rssi_dbm', 'rssi_dbm']),
                'sound_db' => $this->pickNumber($row, ['microphone.sound_db', 'microphone.loudness_dbfs', 'telemetry.sound_db', 'sound_db']),
                'dominant_hz' => $this->pickNumber($row, ['microphone.dominant_hz', 'telemetry.dominant_hz', 'dominant_hz']),
                'peak_dbfs' => $this->pickNumber($row, ['microphone.peak_dbfs']),
                'duration_sec' => $this->pickNumber($row, ['microphone.duration_sec']),
                'recorded_at' => $this->pickString($row, ['ts', 'telemetry.recorded_at', 'recorded_at']),
            ],
            'wifi' => [
                'ssid' => $this->pickString($row, ['wifi.ssid']),
                'rssi' => $this->pickNumber($row, ['wifi.rssi']),
                'ip' => $this->pickString($row, ['wifi.ip']),
            ],
            'ml' => [
                'status' => $this->pickString($row, ['eco.status', 'ml.status', 'detection.status'], 'Healthy'),
                'eco_score' => $this->pickNumber($row, ['eco.score', 'ml.eco_score', 'detection.eco_score', 'eco_score']),
                'eco_trend' => $ecoTrend,
                'confidence_pct' => $this->pickNumber($row, ['bird.confidence_pct', 'ml.confidence_pct', 'detection.confidence_pct', 'confidence_pct']),
                'activity_det_per_hr' => $this->pickNumber($row, ['activity.detections_per_hr', 'ml.activity_det_per_hr', 'activity_det_per_hr']),
                'species' => [
                    'common_name' => $commonName,
                    'scientific_name' => $scientificName,
                    'image_url' => $imageUrl,
                ],
                'topk' => $topkNormalized,
                'recorded_at' => $this->pickString($row, ['ts', 'ml.recorded_at', 'detection.recorded_at', 'recorded_at']),
            ],
            'source' => $this->pickString($row, ['source'], 'api'),
            'status' => 'online',
        ];
    }

    private function normalizeImageUrl(string $value): string
    {
        if ($value === '') {
            return '';
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        if (!str_starts_with($value, '/')) {
            return $value;
        }

        $baseUrl = rtrim((string) config('services.python_api.base_url', ''), '/');

        if ($baseUrl === '') {
            return $value;
        }

        return $baseUrl . $value;
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
