<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EST | Live Audio Monitoring &amp; Analysis</title>

    @vite('resources/js/app.js')

    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
</head>
<body
    x-data="liveListening()"
    class="bg-background-light dark:bg-background-dark text-[#111813] dark:text-white transition-colors duration-300 font-display"
>
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar: Device Selector -->
    <aside class="w-72 border-r border-border-muted dark:border-[#2a3a2e] flex flex-col bg-white dark:bg-[#152a1c] shrink-0">
        <div class="p-6 border-b border-border-muted dark:border-[#2a3a2e] flex items-center gap-3">
            <div class="flex items-center gap-3">
                <a class="flex items-center justify-center size-10 bg-primary rounded-lg text-background-dark font-black text-lg" href="{{ route('home') }}">EST</a>
                <div>
                    <a class="font-bold text-xl tracking-tight" href="{{ route('dashboard') }}">EST</a>
                    <p class="text-[10px] uppercase tracking-widest text-text-muted opacity-80">Eco System Translator</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 space-y-6">
            <div>
                <h3 class="px-3 text-xs font-bold text-text-muted uppercase tracking-wider mb-3">Remote Audio Sensors</h3>
                <div class="space-y-1">
                    <template x-if="device">
                        <button class="w-full flex items-center justify-between px-3 py-3 rounded-lg bg-primary/10 border border-primary/20 text-[#111813] dark:text-primary" type="button">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-lg">settings_remote</span>
                                <div class="text-left">
                                    <span class="text-sm font-semibold block" x-text="device.device_id || 'ESP32'"></span>
                                    <span class="text-[10px] text-text-muted" x-text="[device.hardware?.mcu, device.hardware?.mic].filter(Boolean).join(' / ')"></span>
                                </div>
                            </div>
                            <span class="size-2 rounded-full animate-pulse" :class="connected ? 'bg-primary' : 'bg-red-500'"></span>
                        </button>
                    </template>
                    <template x-if="!device && !loading">
                        <div class="px-3 py-3 text-xs text-text-muted">No device connected</div>
                    </template>
                </div>
            </div>

            <div>
                <h3 class="px-3 text-xs font-bold text-text-muted uppercase tracking-wider mb-3">Sensor Info</h3>
                <div class="space-y-2 px-3">
                    <template x-if="device">
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs">
                                <span class="text-text-muted">Wi-Fi</span>
                                <span class="font-bold" x-text="device.wifi?.ssid ? (device.wifi.ssid + ' (' + device.wifi.rssi + ' dBm)') : '—'"></span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-text-muted">IP</span>
                                <span class="font-bold" x-text="device.wifi?.ip || '—'"></span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-text-muted">Sensor</span>
                                <span class="font-bold" x-text="device.hardware?.sensor || '—'"></span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-text-muted">Zone</span>
                                <span class="font-bold" x-text="device.station?.zone || '—'"></span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-text-muted">Coordinates</span>
                                <span class="font-bold text-[10px]" x-text="device.station?.coordinates ? (device.station.coordinates.lat + ', ' + device.station.coordinates.lng) : '—'"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="px-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 text-text-muted">
                    <span class="material-symbols-outlined text-lg">dashboard</span>
                    <span class="text-sm font-medium">Back to Dashboard</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden bg-background-light dark:bg-background-dark">
        <!-- Top Nav -->
        <header class="h-16 border-b border-border-muted dark:border-[#2a3a2e] flex items-center justify-between px-8 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md z-10">
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-text-muted">Monitoring</span>
                <span class="material-symbols-outlined text-text-muted text-xs">chevron_right</span>
                <span class="text-sm font-bold" x-text="device ? (device.device_id + ' Live Stream') : 'Connecting...'"></span>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="size-2 rounded-full" :class="connected ? 'bg-primary recording-pulse' : 'bg-red-500'"></span>
                    <span class="text-xs font-bold uppercase tracking-widest" :class="connected ? 'text-primary' : 'text-red-500'" x-text="connected ? 'Live' : (error ? 'Error' : 'Connecting...')"></span>
                </div>
                <div class="h-6 w-px bg-border-muted dark:border-[#2a3a2e]"></div>
                <div class="text-xs text-text-muted font-bold">
                    Updated: <span x-text="lastUpdatedLabel"></span>
                </div>
            </div>
        </header>

        <div class="flex-1 flex overflow-hidden">
            <!-- Center: Waveform & Stats -->
            <div class="flex-1 flex flex-col p-8 gap-6 overflow-y-auto">
                <!-- Title & Summary -->
                <div class="flex flex-wrap justify-between items-end gap-4">
                    <div class="space-y-1">
                        <h2 class="text-4xl font-black leading-tight tracking-tight">Live Audio Monitoring</h2>
                        <p class="text-text-muted font-medium">Real-time acoustic analysis from <span class="font-bold" x-text="device?.device_id || 'ESP32 sensor'"></span></p>
                    </div>
                    <div class="flex gap-6">
                        <div class="flex flex-col items-end">
                            <span class="text-[10px] font-bold uppercase text-text-muted tracking-widest">Eco Status</span>
                            <span class="text-lg font-bold" :class="device?.eco?.status === 'Healthy' ? 'text-primary' : 'text-red-500'" x-text="device?.eco?.status || '—'"></span>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-[10px] font-bold uppercase text-text-muted tracking-widest">Trend</span>
                            <span class="text-lg font-bold" x-text="device?.eco?.trend || '—'"></span>
                        </div>
                    </div>
                </div>

                <!-- Main Spectrogram Display -->
                <div class="relative group">
                    <div class="bg-[#0a0e0b] rounded-2xl overflow-hidden relative" style="height: 340px">
                        <div class="flex h-full">
                            <!-- dB Level Meter (left) -->
                            <div class="w-16 flex flex-col items-center justify-between py-4 px-1 border-r border-white/5 shrink-0 relative">
                                <span class="text-[8px] font-bold text-white/30 uppercase tracking-widest rotate-180" style="writing-mode:vertical-rl">Sound Level</span>
                                <div class="flex-1 flex flex-col items-center justify-center py-2 w-full relative">
                                    <!-- dB scale labels -->
                                    <div class="absolute inset-y-2 left-0 flex flex-col justify-between items-end pr-1 pointer-events-none">
                                        <span class="text-[7px] text-white/25 tabular-nums font-mono">100</span>
                                        <span class="text-[7px] text-white/25 tabular-nums font-mono">80</span>
                                        <span class="text-[7px] text-white/25 tabular-nums font-mono">60</span>
                                        <span class="text-[7px] text-white/25 tabular-nums font-mono">40</span>
                                        <span class="text-[7px] text-white/25 tabular-nums font-mono">20</span>
                                        <span class="text-[7px] text-white/25 tabular-nums font-mono">0</span>
                                    </div>
                                    <!-- Meter bar -->
                                    <div class="w-3 h-full rounded-full bg-white/5 overflow-hidden relative ml-4">
                                        <div class="absolute bottom-0 left-0 right-0 rounded-full transition-all duration-200"
                                             :style="`height: ${Math.min(100, Math.max(2, (device?.microphone?.sound_db ?? 0)))}%`"
                                             :class="(device?.microphone?.sound_db ?? 0) > 70 ? 'db-meter-hot' : (device?.microphone?.sound_db ?? 0) > 45 ? 'db-meter-warm' : 'db-meter-cool'">
                                        </div>
                                        <!-- Peak indicator line -->
                                        <div class="absolute left-0 right-0 h-[2px] bg-red-500/80 transition-all duration-500"
                                             :style="`bottom: ${Math.min(100, Math.abs(device?.microphone?.peak_dbfs ?? 30))}%`"></div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm font-black text-white tabular-nums" x-text="(device?.microphone?.sound_db ?? '—') + ''"></p>
                                    <p class="text-[7px] text-white/30 font-bold">dB</p>
                                </div>
                            </div>

                            <!-- Spectrogram Canvas Area -->
                            <div class="flex-1 relative overflow-hidden">
                                <canvas x-ref="spectrogram" class="absolute inset-0 w-full h-full"></canvas>

                                <!-- Frequency axis labels (right edge) -->
                                <div class="absolute top-4 right-4 flex flex-col justify-between h-[calc(100%-2rem)] pointer-events-none">
                                    <span class="text-[7px] text-white/20 font-mono tabular-nums">8kHz</span>
                                    <span class="text-[7px] text-white/20 font-mono tabular-nums">4kHz</span>
                                    <span class="text-[7px] text-white/20 font-mono tabular-nums">2kHz</span>
                                    <span class="text-[7px] text-white/20 font-mono tabular-nums">1kHz</span>
                                    <span class="text-[7px] text-white/20 font-mono tabular-nums">500Hz</span>
                                    <span class="text-[7px] text-white/20 font-mono tabular-nums">0</span>
                                </div>

                                <!-- Top-left overlay -->
                                <div class="absolute top-4 left-5 flex items-center gap-2 z-10">
                                    <span class="size-2 rounded-full" :class="paused ? 'bg-yellow-400' : (connected ? 'bg-primary animate-pulse' : 'bg-red-500')"></span>
                                    <span class="text-[9px] font-bold uppercase tracking-widest" :class="paused ? 'text-yellow-400/70' : 'text-white/40'" x-text="paused ? 'Paused' : (device?.source || 'awaiting data')"></span>
                                </div>
                                <div class="absolute top-4 right-20 text-[9px] font-bold text-white/25 z-10">
                                    <span x-text="device?.microphone?.duration_sec ? (device.microphone.duration_sec + 's window') : ''"></span>
                                </div>

                                <!-- Waveform bars overlay on top of spectrogram -->
                                <div class="absolute bottom-0 left-0 right-0 flex items-end justify-center gap-[2px] px-4 h-2/5 pointer-events-none z-10">
                                    <template x-for="(bar, i) in waveformBars" :key="i">
                                        <div class="w-[3px] rounded-t-sm transition-all duration-100"
                                             :style="`height: ${bar}%; background: linear-gradient(to top, rgba(57,224,121,0.7), rgba(57,224,121,0.15)); box-shadow: 0 0 4px rgba(57,224,121,${bar/200});`"></div>
                                    </template>
                                </div>

                                <!-- Horizontal scan line -->
                                <div class="absolute left-0 right-0 h-px bg-primary/30 pointer-events-none z-10 scanline-anim"></div>
                            </div>
                        </div>

                        <!-- Bottom Control Bar -->
                        <div class="absolute bottom-0 inset-x-0 flex items-center justify-between px-6 py-3 bg-gradient-to-t from-black/80 to-transparent z-20">
                            <div class="flex items-center gap-4">
                                <!-- Pause / Resume button -->
                                <button type="button"
                                        class="flex items-center justify-center size-9 rounded-full border transition-all"
                                        :class="paused ? 'bg-primary/20 border-primary/40 text-primary hover:bg-primary/30' : 'bg-white/10 border-white/20 text-white hover:bg-white/20'"
                                        @click="togglePause()">
                                    <span class="material-symbols-outlined text-base" x-text="paused ? 'play_arrow' : 'pause'"></span>
                                </button>
                                <span class="text-[10px] font-bold uppercase tracking-wider" :class="paused ? 'text-yellow-400' : 'text-white/50'" x-text="paused ? 'Paused' : 'Streaming'"></span>
                            </div>
                            <div class="flex items-center gap-5">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-white/40 text-sm">graphic_eq</span>
                                    <span class="text-white/70 text-[11px] font-bold tabular-nums" x-text="device?.microphone?.dominant_hz ? (device.microphone.dominant_hz + ' Hz') : '— Hz'"></span>
                                </div>
                                <div class="h-4 w-px bg-white/10"></div>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-white/40 text-sm">volume_up</span>
                                    <span class="text-white/70 text-[11px] font-bold tabular-nums" x-text="device?.microphone?.sound_db ? (device.microphone.sound_db + ' dB') : '— dB'"></span>
                                </div>
                                <div class="h-4 w-px bg-white/10"></div>
                                <span class="text-[10px] font-black tabular-nums" :class="connected ? (paused ? 'text-yellow-400' : 'text-primary') : 'text-red-400'" x-text="connected ? (paused ? 'PAUSED' : 'LIVE') : 'OFFLINE'"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="flex flex-col gap-2 rounded-xl p-5 border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a3022]">
                        <p class="text-text-muted text-[10px] font-bold uppercase tracking-widest">Sound Level</p>
                        <p class="text-2xl font-black"><span x-text="device?.microphone?.sound_db ?? '—'"></span> <span class="text-sm font-normal text-text-muted">dB</span></p>
                    </div>
                    <div class="flex flex-col gap-2 rounded-xl p-5 border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a3022]">
                        <p class="text-text-muted text-[10px] font-bold uppercase tracking-widest">Eco Score</p>
                        <div class="flex items-end justify-between">
                            <p class="text-2xl font-black" x-text="device?.eco?.score ?? '—'"></p>
                            <p class="text-xs font-bold" :class="device?.eco?.status === 'Healthy' ? 'text-primary' : 'text-red-500'" x-text="device?.eco?.status || ''"></p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 rounded-xl p-5 border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a3022]">
                        <p class="text-text-muted text-[10px] font-bold uppercase tracking-widest">Temperature</p>
                        <p class="text-2xl font-black"><span x-text="device?.environment?.temperature_c ?? '—'"></span><span class="text-sm font-normal text-text-muted">°C</span></p>
                    </div>
                    <div class="flex flex-col gap-2 rounded-xl p-5 border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a3022]">
                        <p class="text-text-muted text-[10px] font-bold uppercase tracking-widest">Activity</p>
                        <p class="text-2xl font-black"><span x-text="device?.activity?.detections_per_hr ?? '—'"></span> <span class="text-sm font-normal text-text-muted">det/hr</span></p>
                    </div>
                </div>

                <!-- Environment Detail Row -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="rounded-xl p-4 border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a3022]">
                        <p class="text-text-muted text-[9px] font-bold uppercase tracking-widest">Peak dBFS</p>
                        <p class="text-sm font-black mt-1" x-text="device?.microphone?.peak_dbfs != null ? (Math.round(device.microphone.peak_dbfs * 10) / 10) : '—'"></p>
                    </div>
                    <div class="rounded-xl p-4 border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a3022]">
                        <p class="text-text-muted text-[9px] font-bold uppercase tracking-widest">Dominant Freq</p>
                        <p class="text-sm font-black mt-1"><span x-text="device?.microphone?.dominant_hz ?? '—'"></span> Hz</p>
                    </div>
                    <div class="rounded-xl p-4 border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a3022]">
                        <p class="text-text-muted text-[9px] font-bold uppercase tracking-widest">Pressure</p>
                        <p class="text-sm font-black mt-1"><span x-text="device?.environment?.pressure_hpa ?? '—'"></span> hPa</p>
                    </div>
                    <div class="rounded-xl p-4 border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a3022]">
                        <p class="text-text-muted text-[9px] font-bold uppercase tracking-widest">Confidence</p>
                        <p class="text-sm font-black mt-1"><span x-text="device?.bird?.confidence_pct ?? '—'"></span>%</p>
                    </div>
                </div>
            </div>

            <!-- Right: Live Identification Feed -->
            <div class="w-80 border-l border-border-muted dark:border-[#2a3a2e] flex flex-col bg-white dark:bg-[#152a1c] shrink-0">
                <div class="p-6 border-b border-border-muted dark:border-[#2a3a2e]">
                    <h3 class="font-bold text-sm uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">analytics</span>
                        Live Identification
                    </h3>
                    <p class="text-[10px] text-text-muted mt-1">Top-K predictions from AI model</p>
                </div>
                <div class="flex-1 overflow-y-auto p-4 space-y-3">
                    <template x-for="(pred, idx) in (device?.bird?.topk ?? [])" :key="idx">
                        <div class="p-3 rounded-xl border border-border-muted dark:border-transparent transition-all"
                             :class="idx === 0 ? 'bg-primary/5 border-primary/20' : 'bg-background-light dark:bg-[#1a3022]/40 opacity-80'">
                            <div class="flex gap-3">
                                <div class="size-14 rounded-lg bg-cover bg-center shrink-0 border border-white/10 bg-background-light dark:bg-background-dark"
                                     :style="pred.image_url ? `background-image: url('${pred.image_url}')` : ''">
                                    <template x-if="!pred.image_url">
                                        <div class="size-full flex items-center justify-center text-text-muted">
                                            <span class="material-symbols-outlined">flutter_dash</span>
                                        </div>
                                    </template>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <p class="text-xs font-bold" :class="idx === 0 ? 'text-primary' : 'text-text-muted'" x-text="idx === 0 ? 'TOP MATCH' : ('#' + (idx + 1))"></p>
                                        <span class="text-[10px] font-black text-text-muted tabular-nums" x-text="pred.confidence_pct + '% MATCH'"></span>
                                    </div>
                                    <h4 class="text-sm font-bold truncate mt-0.5" x-text="pred.species || 'Unknown'"></h4>
                                    <p class="text-[10px] text-text-muted italic" x-text="pred.scientific_name || ''"></p>
                                </div>
                            </div>
                            <!-- Confidence bar -->
                            <div class="mt-2 h-1 w-full rounded-full bg-border-muted dark:bg-white/10 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-700"
                                     :class="idx === 0 ? 'bg-primary' : 'bg-text-muted/40'"
                                     :style="`width: ${pred.confidence_pct ?? 0}%`"></div>
                            </div>
                        </div>
                    </template>

                    <template x-if="!device?.bird?.topk?.length && !loading">
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <span class="material-symbols-outlined text-4xl text-text-muted mb-3">flutter_dash</span>
                            <p class="text-sm font-bold">No predictions yet</p>
                            <p class="text-[10px] text-text-muted mt-1">Waiting for sensor data...</p>
                        </div>
                    </template>

                    <template x-if="loading">
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <span class="material-symbols-outlined text-4xl text-text-muted mb-3 animate-spin">progress_activity</span>
                            <p class="text-sm font-bold">Connecting to sensor...</p>
                        </div>
                    </template>
                </div>
                <div class="p-4 border-t border-border-muted dark:border-[#2a3a2e] space-y-2">
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="text-text-muted">Last updated</span>
                        <span class="font-bold" x-text="lastUpdatedLabel"></span>
                    </div>
                    <a href="{{ route('dashboard') }}" class="block w-full text-center py-2 bg-[#f0f4f2] dark:bg-[#1a3022] rounded-lg text-xs font-bold hover:bg-primary hover:text-[#111813] transition-colors">
                        BACK TO DASHBOARD
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('liveListening', () => ({
            device: null,
            connected: false,
            loading: true,
            error: null,
            lastUpdatedAt: null,
            pollTimer: null,
            paused: false,
            waveformBars: Array.from({ length: 60 }, () => 10 + Math.random() * 15),
            waveformTimer: null,
            spectrogramTimer: null,
            spectrogramColumn: 0,
            spectrogramCtx: null,

            apiUrl: 'https://bird-edge-api-910518834273.asia-east1.run.app/api/v1/sensor/latest',
            apiKey: 'birdedge_KfBfwrtXzd7IEeizQLc-iK9EVaJYzp1aJq_AK6p-qdU',

            get lastUpdatedLabel() {
                if (!this.lastUpdatedAt) return '—';
                return this.lastUpdatedAt.toLocaleTimeString();
            },

            init() {
                this.fetchSensor();
                this.pollTimer = setInterval(() => {
                    if (!this.paused) this.fetchSensor();
                }, 3000);
                this.startWaveformAnimation();
                this.$nextTick(() => this.initSpectrogram());

                window.addEventListener('beforeunload', () => {
                    if (this.pollTimer) clearInterval(this.pollTimer);
                    if (this.waveformTimer) clearInterval(this.waveformTimer);
                    if (this.spectrogramTimer) clearInterval(this.spectrogramTimer);
                });
            },

            togglePause() {
                this.paused = !this.paused;
            },

            // ──── Canvas Spectrogram ────
            initSpectrogram() {
                const canvas = this.$refs.spectrogram;
                if (!canvas) return;

                const resize = () => {
                    const rect = canvas.parentElement.getBoundingClientRect();
                    canvas.width = Math.floor(rect.width);
                    canvas.height = Math.floor(rect.height);
                    this.spectrogramColumn = 0;
                };
                resize();
                window.addEventListener('resize', resize);

                this.spectrogramCtx = canvas.getContext('2d');
                this.spectrogramColumn = 0;

                this.spectrogramTimer = setInterval(() => {
                    if (this.paused) return;
                    this.drawSpectrogramColumn();
                }, 80);
            },

            drawSpectrogramColumn() {
                const ctx = this.spectrogramCtx;
                if (!ctx) return;

                const w = ctx.canvas.width;
                const h = ctx.canvas.height;
                const x = this.spectrogramColumn % w;

                // Shift existing content left by 1 column for scrolling effect
                if (this.spectrogramColumn >= w) {
                    const img = ctx.getImageData(1, 0, w - 1, h);
                    ctx.putImageData(img, 0, 0);
                    ctx.clearRect(w - 1, 0, 1, h);
                }

                const drawX = this.spectrogramColumn >= w ? w - 1 : x;

                const soundDb = this.device?.microphone?.sound_db ?? 20;
                const dominantHz = this.device?.microphone?.dominant_hz ?? 500;
                const peakDbfs = Math.abs(this.device?.microphone?.peak_dbfs ?? -30);

                // Generate frequency band intensities
                const bands = 64;
                const dominantBand = Math.floor((dominantHz / 8000) * bands);

                for (let b = 0; b < bands; b++) {
                    const y = h - Math.floor((b / bands) * h) - Math.floor(h / bands);
                    const bandH = Math.max(1, Math.floor(h / bands));

                    // Base intensity from sound level
                    let intensity = (soundDb / 100) * 0.3;

                    // Boost near dominant frequency
                    const distFromDominant = Math.abs(b - dominantBand);
                    if (distFromDominant < 6) {
                        intensity += (1 - distFromDominant / 6) * (soundDb / 80) * 0.7;
                    }

                    // Harmonics
                    const harmonic2 = dominantBand * 2;
                    const harmonic3 = dominantBand * 3;
                    if (Math.abs(b - harmonic2) < 3) intensity += 0.15;
                    if (Math.abs(b - harmonic3) < 2) intensity += 0.08;

                    // Random noise
                    intensity += (Math.random() - 0.3) * 0.08;
                    intensity = Math.max(0, Math.min(1, intensity));

                    // Color: dark green → bright green → yellow → white
                    const r = intensity > 0.7 ? Math.floor((intensity - 0.7) / 0.3 * 200) : 0;
                    const g = Math.floor(intensity * 220 + 10);
                    const bVal = intensity > 0.85 ? Math.floor((intensity - 0.85) / 0.15 * 80) : 0;
                    const a = Math.max(0.02, intensity * 0.95);

                    ctx.fillStyle = `rgba(${r}, ${g}, ${bVal}, ${a})`;
                    ctx.fillRect(drawX, y, 1, bandH);
                }

                // Thin time-cursor line
                if (this.spectrogramColumn < w) {
                    ctx.fillStyle = 'rgba(57,224,121,0.15)';
                    ctx.fillRect(drawX + 1, 0, 1, h);
                }

                this.spectrogramColumn++;
            },

            // ──── Waveform ────
            startWaveformAnimation() {
                this.waveformTimer = setInterval(() => {
                    if (this.paused) return;
                    if (!this.device?.microphone) return;

                    const soundDb = this.device.microphone.sound_db ?? 40;
                    const peakDbfs = Math.abs(this.device.microphone.peak_dbfs ?? -30);
                    const dominantHz = this.device.microphone.dominant_hz ?? 500;

                    const baseHeight = Math.min(85, Math.max(8, soundDb * 1.1));
                    const variance = Math.min(35, peakDbfs * 0.7);

                    this.waveformBars = this.waveformBars.map((_, i) => {
                        const t = Date.now() / 180;
                        const phase1 = Math.sin(t + i * 0.25) * variance * 0.4;
                        const phase2 = Math.sin(t * 1.7 + i * 0.15) * variance * 0.2;
                        const noise = (Math.random() - 0.5) * variance * 0.3;
                        return Math.max(3, Math.min(95, baseHeight + phase1 + phase2 + noise));
                    });
                }, 100);
            },

            // ──── API polling ────
            async fetchSensor() {
                try {
                    const url = `${this.apiUrl}?api_key=${this.apiKey}`;
                    const response = await fetch(url, {
                        headers: { 'Accept': 'application/json' },
                    });

                    if (!response.ok) {
                        this.error = `API returned ${response.status}`;
                        this.connected = false;
                        return;
                    }

                    const data = await response.json();
                    if (data?.ok) {
                        this.device = data;
                        this.connected = true;
                        this.error = null;
                        this.lastUpdatedAt = new Date();
                    } else {
                        this.error = 'API returned ok=false';
                        this.connected = false;
                    }
                } catch (e) {
                    this.error = e.message || 'Network error';
                    this.connected = false;
                } finally {
                    this.loading = false;
                }
            },
        }));
    });
</script>

<style>
    .recording-pulse {
        animation: pulse-recording 1.5s ease-in-out infinite;
    }
    @keyframes pulse-recording {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    /* dB meter gradients */
    .db-meter-cool {
        background: linear-gradient(to top, #064e1e, #39e079);
    }
    .db-meter-warm {
        background: linear-gradient(to top, #064e1e, #39e079 50%, #facc15);
    }
    .db-meter-hot {
        background: linear-gradient(to top, #064e1e, #39e079 40%, #facc15 70%, #ef4444);
    }

    /* Scan line */
    .scanline-anim {
        animation: scanline 4s linear infinite;
    }
    @keyframes scanline {
        0%   { top: 10%; opacity: 0; }
        10%  { opacity: 1; }
        90%  { opacity: 1; }
        100% { top: 90%; opacity: 0; }
    }
</style>
</body>
</html>
