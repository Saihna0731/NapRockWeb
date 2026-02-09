<?php

return [
    [
        'id' => 'AMZ-042',
        'label' => 'Device #1',
        'area_label' => 'Area 1',
        'zone' => 'forest',
        'area' => 'Amazon Basin Node #01',
        'coordinates' => [
            'lat' => -3.4653,
            'lng' => -62.2159,
        ],
        'map' => [
            // Percent positions for the dashboard background image.
            'top' => 40,
            'left' => 35,
        ],
        'hardware' => [
            'mcu' => 'ESP32',
            'mic' => 'INMP441',
        ],
        'telemetry' => [
            'temperature_c' => 28.4,
            'humidity_pct' => 76,
            'battery_v' => 3.91,
            'rssi_dbm' => -61,
            'sound_db' => 56.2,
            'dominant_hz' => 1850,
            'rms' => 0.21,
        ],
        'baseline' => [
            'temperature_c' => 27.0,
            'sound_db' => 62.0,
            'activity_det_per_hr' => 70,
        ],
        'ml' => [
            'status' => 'Healthy',
            'eco_score' => 88,
            'confidence_pct' => 94,
            'species' => [
                'common_name' => 'Scarlet Macaw',
                'scientific_name' => 'Ara macao',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAT3XXHEOaOXgx2Cuwkhlpm-elLSkF842I4KdYw68Uaoab5J2BEMKxdgs3ToK0q2ekgZR1GUbK0tWDA0-SnsOnuGDUYHAsoYokw-xqW7PJpu-udzI8BPmLPUaP0csh_w7PBYzive4ERV9PSd8oIapuxcZAm87WJwOXLUAjSw_v1bBsLe5nuk938bzRsBwJheTLILyDlb8SkRGe2EeLzBi6l8Xa0aM5dxIQ4LMaJlwwyAumd7iiWle-kfcususry_f_jgKVXm6uSz68',
            ],
            'activity_det_per_hr' => 82,
        ],
        'status' => 'online',
    ],
    [
        'id' => 'AMZ-017',
        'label' => 'Device #2',
        'area_label' => 'Area 2',
        'zone' => 'jungle',
        'area' => 'North Sector 4',
        'coordinates' => [
            'lat' => -3.1271,
            'lng' => -61.8423,
        ],
        'map' => [
            'top' => 30,
            'left' => 60,
        ],
        'hardware' => [
            'mcu' => 'ESP32',
            'mic' => 'INMP441',
        ],
        'telemetry' => [
            'temperature_c' => 30.1,
            'humidity_pct' => 71,
            'battery_v' => 3.74,
            'rssi_dbm' => -68,
            'sound_db' => 44.7,
            'dominant_hz' => 980,
            'rms' => 0.15,
        ],
        'baseline' => [
            'temperature_c' => 28.0,
            'sound_db' => 60.0,
            'activity_det_per_hr' => 65,
        ],
        'ml' => [
            'status' => 'Warning',
            'eco_score' => 62,
            'confidence_pct' => 87,
            'species' => [
                'common_name' => 'Keel-billed Toucan',
                'scientific_name' => 'Ramphastos sulfuratus',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAYuje81hopaw7IMeg57X5hVP4dJ7-O_ik67gJsEzsMkfw2SjDwa3DZEVoR3qtsNIKTRhp0QvwOwCOU7Jvivoe-4kQ4-NAFq8bDWkHkJX7pdv9PPBjjUx7k-pWcH2liLLpxVHrQbh6M-XRIaUWk9JeZBTRXhhu7l6E15XB9JcIE7z0bZ5IDjzVwgTJfUKZ0lEHQp0IL-XL8vx0W7D7idH0gPOo_sdg3ovwrmn9M-H8HCnQmVCXE1Mx1qcBAsTQ4Pancgp1FaYpbKpU',
            ],
            'activity_det_per_hr' => 54,
        ],
        'status' => 'online',
    ],
];
