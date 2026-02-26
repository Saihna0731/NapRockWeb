<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EST | GIS Map</title>

    @vite('resources/js/app.js')

    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjVgcTOOYInsw7RMVgG2LqpS6xO309B9o&callback=Function.prototype" async defer></script>
</head>
<body
    x-data="gisPage()"
    class="bg-background-light dark:bg-background-dark text-[#111813] dark:text-white transition-colors duration-200 font-display"
>

<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-border-muted dark:border-[#2a3a2e] px-8 py-3 bg-white dark:bg-background-dark sticky top-0 z-[2000]">
    <div class="flex items-center gap-8">
        <div class="flex items-center gap-3">
            <a class="flex items-center justify-center size-10 bg-primary rounded-lg text-background-dark font-black text-lg" href="{{ route('home') }}">EST</a>
            <h2 class="text-xl font-bold leading-tight tracking-tight">GIS Map</h2>
        </div>
        <nav class="hidden md:flex items-center gap-6">
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="text-[#111813] dark:text-white text-sm font-semibold border-b-2 border-primary pb-1" href="{{ route('gis') }}">GIS Map</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('historical') }}">Historical</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('species-id') }}">Species ID</a>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <div class="flex items-center gap-2 bg-white dark:bg-[#1a2e21] border border-border-muted dark:border-[#2a3a2e] px-3 py-1.5 rounded-lg">
            <span class="size-2 bg-primary rounded-full animate-pulse"></span>
            <span class="text-xs font-bold" x-text="`${stations.length} station(s)`"></span>
        </div>
        <span class="text-xs text-text-muted font-bold">Updated: <span x-text="lastUpdatedLabel"></span></span>
    </div>
</header>

<main class="p-6 space-y-4">

    {{-- Title + zone tabs --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight">Station Coverage Map</h1>
            <p class="text-text-muted text-sm font-medium">Live station markers — click a device to inspect</p>
        </div>
        <div class="flex items-center gap-1 bg-white dark:bg-[#1a2e21] rounded-xl border border-border-muted dark:border-[#2a3a2e] p-1.5 overflow-x-auto">
            <button type="button"
                class="px-4 py-1.5 rounded-lg text-xs font-black transition-colors whitespace-nowrap"
                :class="zoneFilter === 'all' ? 'bg-[#111813] text-white dark:bg-primary dark:text-background-dark shadow' : 'text-text-muted hover:bg-background-light dark:hover:bg-background-dark/40'"
                @click="setZone('all')">All Zones</button>
            <button type="button"
                class="px-4 py-1.5 rounded-lg text-xs font-black transition-colors whitespace-nowrap"
                :class="zoneFilter === 'forest' ? 'bg-[#111813] text-white dark:bg-primary dark:text-background-dark shadow' : 'text-text-muted hover:bg-background-light dark:hover:bg-background-dark/40'"
                @click="setZone('forest')">
                <span class="inline-flex items-center gap-1.5"><span class="size-2 rounded-full bg-primary inline-block"></span>Zone 1 · Forest</span>
            </button>
            <button type="button"
                class="px-4 py-1.5 rounded-lg text-xs font-black transition-colors whitespace-nowrap"
                :class="zoneFilter === 'jungle' ? 'bg-[#111813] text-white dark:bg-primary dark:text-background-dark shadow' : 'text-text-muted hover:bg-background-light dark:hover:bg-background-dark/40'"
                @click="setZone('jungle')">
                <span class="inline-flex items-center gap-1.5"><span class="size-2 rounded-full bg-accent-blue inline-block"></span>Zone 2 · Jungle</span>
            </button>
            <button type="button"
                class="px-4 py-1.5 rounded-lg text-xs font-black transition-colors whitespace-nowrap"
                :class="zoneFilter === 'dust' ? 'bg-[#111813] text-white dark:bg-primary dark:text-background-dark shadow' : 'text-text-muted hover:bg-background-light dark:hover:bg-background-dark/40'"
                @click="setZone('dust')">
                <span class="inline-flex items-center gap-1.5"><span class="size-2 rounded-full bg-orange-400 inline-block"></span>Zone 3 · Dust</span>
            </button>
            <button type="button"
                class="px-4 py-1.5 rounded-lg text-xs font-black transition-colors whitespace-nowrap"
                :class="zoneFilter === 'wetland' ? 'bg-[#111813] text-white dark:bg-primary dark:text-background-dark shadow' : 'text-text-muted hover:bg-background-light dark:hover:bg-background-dark/40'"
                @click="setZone('wetland')">
                <span class="inline-flex items-center gap-1.5"><span class="size-2 rounded-full bg-cyan-400 inline-block"></span>Zone 4 · Wetland</span>
            </button>
        </div>
    </div>

    {{-- Map + Side panel --}}
    <div class="grid grid-cols-12 gap-5">

        {{-- Map --}}
        <div class="col-span-12 xl:col-span-8">
            <div class="bg-white dark:bg-[#1a2e21] rounded-2xl border border-border-muted dark:border-[#2a3a2e] overflow-hidden relative" style="height:600px">
                <div x-ref="gisMap" class="absolute inset-0 z-0"></div>

                {{-- Map overlay: station count --}}
                <div class="absolute top-3 left-3 z-10 rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-white/90 dark:bg-background-dark/80 backdrop-blur px-3 py-2">
                    <p class="text-[10px] font-black uppercase tracking-widest text-text-muted">Google Maps</p>
                    <p class="text-xs font-bold" x-text="`${visibleStations().length} station(s) shown`"></p>
                </div>

                {{-- Selected device badge --}}
                <div
                    x-show="selectedStation"
                    class="absolute bottom-3 left-3 z-10 flex items-center gap-2 rounded-xl border border-primary bg-white/95 dark:bg-background-dark/95 backdrop-blur px-3 py-2"
                    style="display:none"
                >
                    <span class="size-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-xs font-black" x-text="selectedStation ? (selectedStation.label + ': ' + selectedStation.id) : ''"></span>
                    <button type="button" class="ml-1 text-text-muted hover:text-[#111813] dark:hover:text-white" @click="selectedStation = null">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Side detail panel --}}
        <div class="col-span-12 xl:col-span-4">
            <div class="bg-white dark:bg-[#1a2e21] rounded-2xl border border-border-muted dark:border-[#2a3a2e] overflow-hidden flex flex-col" style="height:600px">

                {{-- Panel header --}}
                <div class="px-5 py-4 border-b border-border-muted dark:border-[#2a3a2e] shrink-0 bg-primary/5">
                    <h3 class="text-sm font-black" x-text="selectedStation ? 'Device Details' : 'All Stations'"></h3>
                    <p class="text-[10px] text-text-muted mt-0.5"
                       x-text="selectedStation ? (selectedStation.area ?? selectedStation.id) : `${visibleStations().length} visible`"></p>
                </div>

                {{-- No selection: station list --}}
                <div x-show="!selectedStation" class="flex-1 overflow-y-auto divide-y divide-border-muted dark:divide-[#2a3a2e]">
                    <template x-for="(st, idx) in visibleStations()" :key="stationId(st)">
                        <button type="button"
                            class="w-full text-left px-4 py-3 flex items-center gap-3 hover:bg-background-light dark:hover:bg-white/5 transition-colors"
                            @click="selectStation(st)"
                        >
                            <span class="size-6 rounded-full shrink-0 flex items-center justify-center text-[10px] font-black text-white"
                                  :style="`background:${st?.ml?.status === 'Healthy' ? 'var(--color-primary)' : 'rgb(239,68,68)'}`"
                                  x-text="idx + 1"></span>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-black truncate" x-text="(st.label ?? st.id) + ': ' + st.id"></p>
                                <p class="text-[10px] text-text-muted truncate italic" x-text="st?.ml?.species?.common_name ?? 'Unknown'"></p>
                                <p class="text-[10px] text-text-muted truncate" x-text="st.zone ?? ''"></p>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="block px-1.5 py-0.5 rounded-full text-[9px] font-black"
                                      :class="st?.ml?.status === 'Healthy' ? 'bg-primary/20 text-[#111813]' : 'bg-red-500/20 text-red-600'"
                                      x-text="st?.ml?.status ?? '—'"></span>
                                <span class="text-[10px] font-black tabular-nums" x-text="(st?.ml?.confidence_pct ?? 0) + '%'"></span>
                            </div>
                        </button>
                    </template>
                    <div x-show="visibleStations().length === 0" class="flex flex-col items-center justify-center h-full p-8 text-center">
                        <span class="material-symbols-outlined text-4xl text-text-muted mb-3">sensors_off</span>
                        <p class="text-sm font-bold">No stations</p>
                        <p class="text-[10px] text-text-muted mt-1">Change zone filter or check API</p>
                    </div>
                </div>

                {{-- Selected station detail --}}
                <div x-show="selectedStation" class="flex-1 overflow-y-auto" style="display:none">
                    <button type="button" class="w-full flex items-center gap-2 px-4 py-3 border-b border-border-muted dark:border-[#2a3a2e] text-text-muted hover:text-[#111813] dark:hover:text-white hover:bg-background-light dark:hover:bg-white/5" @click="selectedStation = null">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        <span class="text-xs font-bold">Back to list</span>
                    </button>

                    <div class="p-4 space-y-4">
                        {{-- Header info --}}
                        <div>
                            <p class="text-[10px] uppercase tracking-widest font-bold text-accent-blue">Station Analytics</p>
                            <p class="text-base font-black mt-0.5" x-text="selectedStation ? (selectedStation.label + ': ' + selectedStation.id) : ''"></p>
                            <p class="text-xs text-text-muted" x-text="selectedStation?.area ?? ''"></p>
                        </div>

                        {{-- Bird + confidence --}}
                        <div class="rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/30 p-3">
                            <div class="flex items-start gap-3">
                                <div class="size-14 rounded-xl overflow-hidden border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-background-dark shrink-0">
                                    <img x-show="selectedStation?.ml?.species?.image_url" :src="selectedStation?.ml?.species?.image_url" alt="" class="size-full object-cover"/>
                                    <div x-show="!selectedStation?.ml?.species?.image_url" class="size-full flex items-center justify-center text-text-muted">
                                        <span class="material-symbols-outlined">flutter_dash</span>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[9px] uppercase tracking-widest font-bold text-text-muted">Bird ID (Edge AI)</p>
                                    <p class="text-sm font-black leading-tight mt-0.5" x-text="selectedStation?.ml?.species?.common_name ?? '—'"></p>
                                    <p class="text-[10px] text-text-muted italic" x-text="selectedStation?.ml?.species?.scientific_name ?? ''"></p>
                                    <div class="flex items-center gap-2 mt-1.5">
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black"
                                              :class="(selectedStation?.ml?.status === 'Healthy') ? 'bg-primary/20 text-[#111813]' : 'bg-red-500/20 text-red-600'"
                                              x-text="selectedStation?.ml?.status ?? '—'"></span>
                                        <span class="text-[10px] font-black"><span x-text="selectedStation?.ml?.confidence_pct ?? '—'"></span>% conf.</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Confidence bar --}}
                            <div class="mt-3 space-y-1">
                                <div class="flex justify-between text-[9px] font-bold text-text-muted">
                                    <span>Confidence</span>
                                    <span x-text="(selectedStation?.ml?.confidence_pct ?? 0) + '%'"></span>
                                </div>
                                <div class="h-1.5 w-full rounded-full bg-border-muted dark:bg-white/10">
                                    <div class="h-full rounded-full bg-primary transition-all duration-500"
                                         :style="`width:${selectedStation?.ml?.confidence_pct ?? 0}%`"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Hardware + telemetry --}}
                        <div class="grid grid-cols-2 gap-2">
                            <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-2.5">
                                <p class="text-[9px] uppercase font-bold text-text-muted">MCU</p>
                                <p class="text-xs font-bold mt-0.5" x-text="selectedStation?.hardware?.mcu ?? '—'"></p>
                            </div>
                            <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-2.5">
                                <p class="text-[9px] uppercase font-bold text-text-muted">Mic</p>
                                <p class="text-xs font-bold mt-0.5" x-text="selectedStation?.hardware?.mic ?? '—'"></p>
                            </div>
                            <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-2.5">
                                <p class="text-[9px] uppercase font-bold text-text-muted">Temperature</p>
                                <p class="text-xs font-bold mt-0.5"><span x-text="selectedStation?.telemetry?.temperature_c ?? '—'"></span>°C</p>
                            </div>
                            <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-2.5">
                                <p class="text-[9px] uppercase font-bold text-text-muted">Sound</p>
                                <p class="text-xs font-bold mt-0.5"><span x-text="selectedStation?.telemetry?.sound_db ?? '—'"></span> dB</p>
                            </div>
                            <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-2.5">
                                <p class="text-[9px] uppercase font-bold text-text-muted">Eco Score</p>
                                <p class="text-xs font-bold mt-0.5" x-text="selectedStation?.ml?.eco_score ?? '—'"></p>
                            </div>
                            <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-2.5">
                                <p class="text-[9px] uppercase font-bold text-text-muted">Activity</p>
                                <p class="text-xs font-bold mt-0.5"><span x-text="selectedStation?.ml?.activity_det_per_hr ?? '—'"></span>/hr</p>
                            </div>
                        </div>

                        {{-- Coordinates --}}
                        <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 px-3 py-2.5">
                            <p class="text-[9px] uppercase font-bold text-text-muted">Location</p>
                            <p class="text-xs font-bold tabular-nums mt-0.5"
                               x-text="selectedStation ? (selectedStation.coordinates.lat + ', ' + selectedStation.coordinates.lng) : '—'"></p>
                        </div>

                        {{-- Analysis --}}
                        <div class="rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/30 p-3">
                            <p class="text-[9px] uppercase tracking-widest font-bold text-text-muted mb-2">Analysis</p>
                            <ul class="space-y-1.5">
                                <template x-for="(line, idx) in stationConclusions(selectedStation)" :key="idx">
                                    <li class="text-xs font-medium text-[#111813] dark:text-white" x-text="'• ' + line"></li>
                                </template>
                            </ul>
                        </div>

                        <a href="{{ route('live') }}"
                           class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-[#111813] dark:bg-white text-white dark:text-[#111813] text-sm font-black hover:opacity-80 transition-opacity">
                            <span class="material-symbols-outlined text-sm">hearing</span>
                            Listen Live
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Bottom legend --}}
    <div class="flex flex-wrap items-center gap-6 bg-white dark:bg-[#1a2e21] rounded-xl border border-border-muted dark:border-[#2a3a2e] px-5 py-3">
        <span class="text-xs font-bold text-text-muted uppercase tracking-widest">Legend</span>
        <div class="flex items-center gap-2">
            <span class="size-4 rounded-full bg-primary border-2 border-white shadow"></span>
            <span class="text-xs font-bold">Healthy station</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="size-4 rounded-full bg-red-500 border-2 border-white shadow"></span>
            <span class="text-xs font-bold">Warning station</span>
        </div>
        <div class="flex items-center gap-2 ml-auto text-[10px] text-text-muted">
            Map: © <a href="https://www.google.com/maps" class="hover:underline ml-1">Google Maps</a>
        </div>
    </div>

</main>

</body>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('gisPage', () => ({
            stations: [],
            selectedStation: null,
            zoneFilter: 'all',
            lastUpdatedAt: null,
            pollTimer: null,
            pollEveryMs: 5000,

            map: null,
            markerLayer: null,

            get lastUpdatedLabel() {
                if (!this.lastUpdatedAt) return '—';
                return this.lastUpdatedAt.toLocaleTimeString();
            },

            init() {
                this.lastUpdatedAt = new Date();
                this.$nextTick(() => this.initMap());
                this.startPolling();
            },

            passesZone(station) {
                if (this.zoneFilter === 'all') return true;
                return (station?.zone || '').toLowerCase() === this.zoneFilter;
            },

            visibleStations() {
                return this.uniqueStations(this.stations).filter(s => this.passesZone(s));
            },

            setZone(zone) {
                this.zoneFilter = zone;
                this.refreshMarkers(true);
            },

            selectStation(station) {
                this.selectedStation = station;
                if (this.map && station?.coordinates?.lat != null && station?.coordinates?.lng != null) {
                    this.map.panTo({ lat: station.coordinates.lat, lng: station.coordinates.lng });
                    if (this.map.getZoom() < 10) this.map.setZoom(10);
                }
            },

            uniqueStations(stns) {
                const byId = new Map();
                for (const s of (Array.isArray(stns) ? stns : [])) {
                    const id = s?.id ?? s?.device_id ?? s?.label;
                    if (!id) continue;
                    const prev = byId.get(id);
                    if (!prev) { byId.set(id, s); continue; }
                    byId.set(id, {
                        ...prev, ...s,
                        telemetry: { ...(prev.telemetry||{}), ...(s.telemetry||{}) },
                        ml: { ...(prev.ml||{}), ...(s.ml||{}), species: { ...(prev?.ml?.species||{}), ...(s?.ml?.species||{}) } },
                        coordinates: { ...(prev.coordinates||{}), ...(s.coordinates||{}) },
                    });
                }
                return Array.from(byId.values());
            },

            stationId(st) {
                if (!st || typeof st !== 'object') return '';
                const id = st.id ?? st.device_id ?? st.label;
                return typeof id === 'string' ? id.trim() : '';
            },

            startPolling() {
                if (this.pollTimer) return;
                this.fetchStations();
                this.pollTimer = setInterval(() => this.fetchStations(), this.pollEveryMs);
            },

            async fetchStations() {
                try {
                    const res = await fetch('/api/stations', { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) return;
                    const payload = await res.json();
                    if (Array.isArray(payload?.stations)) {
                        this.stations = payload.stations;
                        this.lastUpdatedAt = new Date();
                        this.refreshMarkers(false);

                        // keep selected station in sync
                        if (this.selectedStation?.id) {
                            const updated = this.stations.find(s => this.stationId(s) === this.stationId(this.selectedStation));
                            if (updated) this.selectedStation = updated;
                        }
                    }
                } catch (e) { /* ignore */ }
            },

            initMap() {
                if (!window.google?.maps || !this.$refs.gisMap) return;
                if (this.map) return;

                this.map = new google.maps.Map(this.$refs.gisMap, {
                    zoom: 4,
                    center: { lat: 0, lng: 0 },
                    mapTypeId: 'terrain',
                    mapTypeControl: true,
                    streetViewControl: false,
                    fullscreenControl: true,
                    zoomControl: true,
                    styles: [
                        { featureType: 'poi', stylers: [{ visibility: 'off' }] },
                        { featureType: 'transit', stylers: [{ visibility: 'off' }] },
                    ],
                });
                this.markerLayer = [];
                this._infoWindow = new google.maps.InfoWindow();
                this.refreshMarkers(true);
            },

            refreshMarkers(fit) {
                if (!this.map) return;
                this.markerLayer.forEach(m => m.setMap(null));
                this.markerLayer = [];

                const visible = this.visibleStations();
                const bounds = new google.maps.LatLngBounds();
                let hasPoints = false;

                visible.forEach((station, idx) => {
                    const lat = station?.coordinates?.lat;
                    const lng = station?.coordinates?.lng;
                    if (lat == null || lng == null) return;

                    const isHealthy = station?.ml?.status === 'Healthy';
                    const bg = isHealthy ? '#39e079' : '#ef4444';
                    const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"><circle cx="15" cy="15" r="14" fill="${bg}" stroke="white" stroke-width="2.5"/><text x="15" y="20" text-anchor="middle" fill="white" font-size="11" font-weight="800">${idx + 1}</text></svg>`;
                    const iconUrl = 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);

                    const marker = new google.maps.Marker({
                        position: { lat, lng },
                        map: this.map,
                        icon: { url: iconUrl, scaledSize: new google.maps.Size(30, 30), anchor: new google.maps.Point(15, 15) },
                        title: station.label ?? station.id,
                    });

                    marker.addListener('click', () => {
                        this._infoWindow.setContent(
                            `<div style="font-family:inherit;font-size:11px;font-weight:700;line-height:1.4;">
                                <div>${station.label ?? station.id}: ${station.id}</div>
                                <div style="font-weight:400;font-style:italic">${station?.ml?.species?.common_name ?? 'Unknown'}</div>
                                <div style="font-weight:400">${station?.ml?.confidence_pct ?? 0}% · ${station?.ml?.status ?? '—'}</div>
                            </div>`
                        );
                        this._infoWindow.open(this.map, marker);
                        this.selectStation(station);
                    });

                    this.markerLayer.push(marker);
                    bounds.extend({ lat, lng });
                    hasPoints = true;
                });

                if (fit && hasPoints) {
                    this.map.fitBounds(bounds, { top: 32, right: 32, bottom: 32, left: 32 });
                }
                if (fit && !hasPoints) {
                    this.map.setCenter({ lat: 0, lng: 0 });
                    this.map.setZoom(2);
                }
            },

            stationConclusions(station) {
                if (!station) return [];
                const lines = [];
                const sound = Number(station?.telemetry?.sound_db);
                const soundBase = Number(station?.baseline?.sound_db);
                if (Number.isFinite(sound) && Number.isFinite(soundBase)) {
                    const d = sound - soundBase;
                    if (d <= -8) lines.push(`Шувууны дуу хэвийнээс бага (${Math.round(d)} dB).`);
                    if (d >= 8) lines.push(`Шувууны дуу хэвийнээс өндөр (+${Math.round(d)} dB).`);
                }
                const temp = Number(station?.telemetry?.temperature_c);
                const tempBase = Number(station?.baseline?.temperature_c);
                if (Number.isFinite(temp) && Number.isFinite(tempBase)) {
                    const d = temp - tempBase;
                    if (d >= 2) lines.push(`Температур хэвийнээс өндөр (+${Math.round(d*10)/10}°C).`);
                    if (d <= -2) lines.push(`Температур хэвийнээс бага (${Math.round(d*10)/10}°C).`);
                }
                const eco = Number(station?.ml?.eco_score);
                if (Number.isFinite(eco) && eco < 70) lines.push('Eco-score буурсан — стресс/орчны өөрчлөлт байж болно.');
                if (!lines.length) lines.push('Одоогийн өгөгдлөөр томоохон асуудал илрээгүй.');
                return lines;
            },
        }));
    });
</script>


</html>
