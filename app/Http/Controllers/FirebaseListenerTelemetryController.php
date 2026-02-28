<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FirebaseListenerTelemetryController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'event' => ['required', 'string', 'max:64'],
            'device_id' => ['nullable', 'string', 'max:128'],
            'path' => ['nullable', 'string', 'max:255'],
            'last_success_at' => ['nullable', 'string', 'max:64'],
            'listener_started_at' => ['nullable', 'string', 'max:64'],
            'reconnect_count' => ['nullable', 'integer', 'min:0'],
            'error_count' => ['nullable', 'integer', 'min:0'],
            'source' => ['nullable', 'string', 'max:64'],
            'message' => ['nullable', 'string', 'max:500'],
        ]);

        Log::info('firebase.listener.telemetry', $payload);

        return response()->json(['ok' => true]);
    }
}
