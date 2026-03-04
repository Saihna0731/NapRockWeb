<?php

/*
|--------------------------------------------------------------------------
| Stations (empty — all station data comes from Python API at runtime)
|--------------------------------------------------------------------------
|
| Previously held hardcoded mock devices (AMZ-042, AMZ-017).
| Now cleared; real ESP32 data is fetched via StationFeedService
| from the Cloud Run Python API endpoint configured in .env:
|   PYTHON_API_URL / PYTHON_STATIONS_PATH / PYTHON_API_KEY
|
*/

return [];
