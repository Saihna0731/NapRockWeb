<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EST | Historical Trends</title>

    @vite('resources/js/app.js')

    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</head>
<body
    x-data="historicalPage({{ \Illuminate\Support\Js::from($stations ?? []) }})"
    class="bg-background-light dark:bg-background-dark text-[#111813] dark:text-white transition-colors duration-200 font-display"
>
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-border-muted dark:border-[#2a3a2e] px-8 py-3 bg-white dark:bg-background-dark sticky top-0 z-50">
    <div class="flex items-center gap-8">
        <div class="flex items-center gap-3">
            <a class="flex items-center justify-center size-10 bg-primary rounded-lg text-background-dark font-black text-lg" href="{{ route('home') }}">EST</a>
            <h2 class="text-xl font-bold leading-tight tracking-tight">Eco System Translator</h2>
        </div>
        <nav class="hidden md:flex items-center gap-6">
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('gis') }}">GIS Map</a>
            <a class="text-[#111813] dark:text-white text-sm font-semibold border-b-2 border-primary pb-1" href="{{ route('historical') }}">Historical</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('species-id') }}">Species ID</a>
        </nav>
    </div>
</header>

<div class="flex">
    {{-- ══ Sidebar — station list driven by API data ══ --}}
    <aside class="w-64 border-r border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-background-dark min-h-[calc(100vh-64px)] hidden xl:flex flex-col p-6 sticky top-16">
        <p class="text-[10px] uppercase tracking-widest font-black text-text-muted mb-4">Stations</p>
        <div class="flex flex-col gap-1">
            <template x-for="st in stations" :key="stationId(st)">
                <a href="#"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors"
                   :class="selectedId === stationId(st) ? 'bg-primary/10 text-[#111813] dark:text-primary font-bold' : 'text-text-muted hover:bg-background-light dark:hover:bg-[#1a2e21]'"
                   @click.prevent="selectStation(st)"
                >
                    <span class="material-symbols-outlined text-base" x-text="st?.ml?.status === 'Healthy' ? 'check_circle' : 'warning'"></span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium truncate" x-text="st.label || st.id"></p>
                        <p class="text-[10px] text-text-muted truncate" x-text="st?.ml?.species?.common_name || 'Unknown'"></p>
                    </div>
                    <span class="text-[10px] font-black px-1.5 py-0.5 rounded-full"
                          :class="st?.ml?.status === 'Healthy' ? 'bg-primary/20 text-primary' : 'bg-red-500/20 text-red-600'"
                          x-text="st?.ml?.status || '—'"></span>
                </a>
            </template>
            <div x-show="stations.length === 0" class="text-xs text-text-muted py-4 text-center">No stations available</div>
        </div>
    </aside>

    <main class="flex-1 p-8 space-y-6 overflow-x-hidden">
        <div>
            <h1 class="text-3xl font-black tracking-tight">Acoustic & Eco-Health History</h1>
            <p class="text-text-muted text-sm font-medium">Long-term trends — chart data will be wired to time-series DB</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Chart placeholder --}}
            <div class="lg:col-span-2 rounded-2xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-black">Eco Score (Last 7 Days)</h3>
                    <div class="flex items-center gap-2 bg-background-light dark:bg-background-dark/40 p-1 rounded-lg">
                        <button class="px-3 py-1.5 text-xs font-black rounded-md bg-white dark:bg-primary dark:text-background-dark">7D</button>
                        <button class="px-3 py-1.5 text-xs font-black rounded-md hover:bg-white/70 dark:hover:bg-white/10">30D</button>
                        <button class="px-3 py-1.5 text-xs font-black rounded-md hover:bg-white/70 dark:hover:bg-white/10">6M</button>
                    </div>
                </div>

                <div class="mt-6 h-64 relative">
                    <div class="absolute inset-0 grid grid-cols-12 grid-rows-6 opacity-20 pointer-events-none">
                        @for ($i = 0; $i < 72; $i++)
                            <div class="border-r border-b border-border-muted dark:border-[#2a3a2e]"></div>
                        @endfor
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <p class="text-xs text-text-muted font-medium">Chart placeholder (bind to DB time-series later)</p>
                    </div>
                </div>
            </div>

            {{-- Station Summary — data-driven --}}
            <div class="rounded-2xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-6 space-y-4">
                <h3 class="text-sm font-black">Station Summary</h3>
                <div class="flex items-center justify-between p-3 rounded-xl bg-background-light dark:bg-background-dark/40">
                    <p class="text-xs font-bold">Active Stations</p>
                    <p class="text-lg font-black" x-text="stations.length"></p>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-background-light dark:bg-background-dark/40">
                    <p class="text-xs font-bold">Healthy</p>
                    <p class="text-lg font-black text-primary" x-text="stations.filter(s => s?.ml?.status === 'Healthy').length"></p>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-background-light dark:bg-background-dark/40">
                    <p class="text-xs font-bold">Warning</p>
                    <p class="text-lg font-black text-red-500" x-text="stations.filter(s => s?.ml?.status === 'Warning' || (s?.ml?.status && s.ml.status !== 'Healthy')).length"></p>
                </div>
            </div>
        </div>

        {{-- Selected Station Detail --}}
        <div x-show="selectedId" x-transition class="rounded-2xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-6 space-y-4" style="display:none">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black" x-text="selected?.label || selected?.id || 'Station'"></h3>
                    <p class="text-[10px] text-text-muted" x-text="(selected?.area_label || '') + (selected?.zone ? ' · Zone: ' + selected.zone : '')"></p>
                </div>
                <button type="button" @click="selectedId = null" class="text-text-muted hover:text-[#111813] dark:hover:text-white p-1">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="rounded-xl bg-background-light dark:bg-background-dark/40 p-3">
                    <p class="text-[9px] uppercase font-bold text-text-muted">Species</p>
                    <p class="text-xs font-black mt-1" x-text="selected?.ml?.species?.common_name || '—'"></p>
                </div>
                <div class="rounded-xl bg-background-light dark:bg-background-dark/40 p-3">
                    <p class="text-[9px] uppercase font-bold text-text-muted">Confidence</p>
                    <p class="text-xs font-black mt-1" x-text="(selected?.ml?.confidence_pct ?? '—') + '%'"></p>
                </div>
                <div class="rounded-xl bg-background-light dark:bg-background-dark/40 p-3">
                    <p class="text-[9px] uppercase font-bold text-text-muted">Eco Score</p>
                    <p class="text-xs font-black mt-1" x-text="selected?.ml?.eco_score ?? '—'"></p>
                </div>
                <div class="rounded-xl bg-background-light dark:bg-background-dark/40 p-3">
                    <p class="text-[9px] uppercase font-bold text-text-muted">Activity</p>
                    <p class="text-xs font-black mt-1" x-text="(selected?.ml?.activity_det_per_hr ?? '—') + ' det/hr'"></p>
                </div>
                <div class="rounded-xl bg-background-light dark:bg-background-dark/40 p-3">
                    <p class="text-[9px] uppercase font-bold text-text-muted">Temperature</p>
                    <p class="text-xs font-black mt-1" x-text="(selected?.telemetry?.temperature_c ?? '—') + '°C'"></p>
                </div>
                <div class="rounded-xl bg-background-light dark:bg-background-dark/40 p-3">
                    <p class="text-[9px] uppercase font-bold text-text-muted">Sound</p>
                    <p class="text-xs font-black mt-1" x-text="(selected?.telemetry?.sound_db ?? '—') + ' dB'"></p>
                </div>
                <div class="rounded-xl bg-background-light dark:bg-background-dark/40 p-3">
                    <p class="text-[9px] uppercase font-bold text-text-muted">Hardware</p>
                    <p class="text-xs font-black mt-1" x-text="[selected?.hardware?.mcu, selected?.hardware?.mic, selected?.hardware?.sensor].filter(Boolean).join(' / ') || '—'"></p>
                </div>
                <div class="rounded-xl bg-background-light dark:bg-background-dark/40 p-3">
                    <p class="text-[9px] uppercase font-bold text-text-muted">Status</p>
                    <p class="text-xs font-black mt-1"
                       :class="selected?.ml?.status === 'Healthy' ? 'text-primary' : 'text-red-500'"
                       x-text="selected?.ml?.status ?? '—'"></p>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('historicalPage', (initialStations) => ({
            stations: Array.isArray(initialStations) ? initialStations : [],
            selectedId: null,

            get selected() {
                if (!this.selectedId) return null;
                return this.stations.find(s => this.stationId(s) === this.selectedId) || null;
            },

            stationId(station) {
                if (!station || typeof station !== 'object') return '';
                const id = station.id ?? station.device_id ?? station.label;
                return typeof id === 'string' ? id.trim() : '';
            },

            selectStation(st) {
                const id = this.stationId(st);
                this.selectedId = this.selectedId === id ? null : id;
            },

            init() {
                // Auto-select first station if available
                if (this.stations.length) {
                    this.selectedId = this.stationId(this.stations[0]);
                }
            },
        }));
    });
</script>
</body>
</html>
