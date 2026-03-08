<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Eco System Translator (EST) Dashboard</title>

    @vite('resources/js/app.js')

    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>

</head>
<body
    x-data="dashboardPage({{ \Illuminate\Support\Js::from($stations ?? []) }})"
    @keydown.escape.window="closePanel()"
    class="bg-background-light dark:bg-background-dark text-[#111813] dark:text-white transition-colors duration-200 font-display"
>
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-border-muted dark:border-[#2a3a2e] px-8 py-3 bg-white dark:bg-background-dark sticky top-0 z-[2000]">
    <div class="flex items-center gap-8">
        <div class="flex items-center gap-3">
            <a class="flex items-center justify-center size-10 bg-primary rounded-lg text-background-dark font-black text-lg" href="{{ route('home') }}">EST</a>
            <h2 class="text-[#111813] dark:text-white text-xl font-bold leading-tight tracking-tight">Eco System Translator</h2>
        </div>
        <nav class="hidden md:flex items-center gap-6">
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('home') }}">Home</a>
            <a class="text-[#111813] dark:text-white text-sm font-semibold border-b-2 border-primary pb-1" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('live') }}">Sensors</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('home') }}#species">Species Catalog</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('future') }}">Trends</a>
        </nav>
    </div>
    <div class="flex items-center gap-4">
        <label class="hidden lg:flex items-center bg-background-light dark:bg-[#1a2e21] rounded-lg px-3 py-1.5 min-w-64">
            <span class="material-symbols-outlined text-text-muted mr-2 text-sm">search</span>
            <input class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder-text-muted" placeholder="Search GPS or Sensor ID" type="text"/>
        </label>
        <button class="p-2 rounded-lg bg-background-light dark:bg-[#1a2e21] text-[#111813] dark:text-white" type="button">
            <span class="material-symbols-outlined text-xl">notifications</span>
        </button>
        <div class="size-10 rounded-full bg-cover bg-center border border-primary" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAQ6sYVHlPhXVEi1tbJ1YNhi75fxRxt6mOdV6wmvdBCXViunh4cTLfCuKMGrV_LpJKQFGKJx16mpKFuA2A054XCBX5ia70QpIFtwF89qw4LEbWiQVQ1tqipLuYEM2TvJ4QomCiTYLBv2EdEhKfrP7hmpn-duEXeocvK5Xpr7mJ7AjabESqDig8Ak5H81nlDZ7o6QlOfZientw8gnt3Wzaf5pNl6PRwEfbGjJzS82VSF_VwG42bZcgsvtbWuciYfpraLAxjyiWhTCXs");'></div>
    </div>
</header>
<div class="flex">
    <aside class="w-64 border-r border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-background-dark min-h-[calc(100vh-64px)] hidden xl:flex flex-col p-6 sticky top-16">
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary/10 text-[#111813] dark:text-primary font-bold">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-sm">Overview</span>
            </div>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-text-muted hover:bg-background-light dark:hover:bg-[#1a2e21]" href="{{ route('gis') }}">
                <span class="material-symbols-outlined">map</span>
                <span class="text-sm font-medium">GIS Map</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-text-muted hover:bg-background-light dark:hover:bg-[#1a2e21]" href="{{ route('historical') }}">
                <span class="material-symbols-outlined">monitoring</span>
                <span class="text-sm font-medium">Historical Trends</span>
            </a>
        </div>
    </aside>
    <main class="flex-1 p-8 space-y-8 overflow-x-hidden">
        {{-- ══ Zone Tab Bar ══ --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-1 bg-white dark:bg-[#1a2e21] rounded-xl border border-border-muted dark:border-[#2a3a2e] p-1.5 overflow-x-auto">
                <button type="button"
                    class="px-4 py-2 rounded-lg text-xs font-black transition-colors whitespace-nowrap"
                    :class="zoneFilter === 'all' ? 'bg-[#111813] text-white dark:bg-primary dark:text-background-dark shadow' : 'text-text-muted hover:bg-background-light dark:hover:bg-background-dark/40'"
                    @click="setZone('all')">
                    All Zones
                </button>
                <button type="button"
                    class="px-4 py-2 rounded-lg text-xs font-black transition-colors whitespace-nowrap"
                    :class="zoneFilter === 'forest' ? 'bg-[#111813] text-white dark:bg-primary dark:text-background-dark shadow' : 'text-text-muted hover:bg-background-light dark:hover:bg-background-dark/40'"
                    @click="setZone('forest')">
                    <span class="inline-flex items-center gap-1.5"><span class="size-2 rounded-full bg-primary inline-block"></span>Zone 1 · Forest</span>
                </button>
                <button type="button"
                    class="px-4 py-2 rounded-lg text-xs font-black transition-colors whitespace-nowrap"
                    :class="zoneFilter === 'jungle' ? 'bg-[#111813] text-white dark:bg-primary dark:text-background-dark shadow' : 'text-text-muted hover:bg-background-light dark:hover:bg-background-dark/40'"
                    @click="setZone('jungle')">
                    <span class="inline-flex items-center gap-1.5"><span class="size-2 rounded-full bg-accent-blue inline-block"></span>Zone 2 · Jungle</span>
                </button>
                <button type="button"
                    class="px-4 py-2 rounded-lg text-xs font-black transition-colors whitespace-nowrap"
                    :class="zoneFilter === 'dust' ? 'bg-[#111813] text-white dark:bg-primary dark:text-background-dark shadow' : 'text-text-muted hover:bg-background-light dark:hover:bg-background-dark/40'"
                    @click="setZone('dust')">
                    <span class="inline-flex items-center gap-1.5"><span class="size-2 rounded-full bg-orange-400 inline-block"></span>Zone 3 · Dust</span>
                </button>
                <button type="button"
                    class="px-4 py-2 rounded-lg text-xs font-black transition-colors whitespace-nowrap"
                    :class="zoneFilter === 'wetland' ? 'bg-[#111813] text-white dark:bg-primary dark:text-background-dark shadow' : 'text-text-muted hover:bg-background-light dark:hover:bg-background-dark/40'"
                    @click="setZone('wetland')">
                    <span class="inline-flex items-center gap-1.5"><span class="size-2 rounded-full bg-cyan-400 inline-block"></span>Zone 4 · Wetland</span>
                </button>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-text-muted font-bold">Live refresh:</span>
                <span class="text-xs font-black" x-text="lastUpdatedLabel"></span>
            </div>
        </div>

        {{-- ══ Map + Species List ══ --}}
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xl:col-span-7">
                <div class="bg-white dark:bg-[#1a2e21] p-2 rounded-xl border border-border-muted dark:border-[#2a3a2e] relative z-0 overflow-hidden" style="height:520px">
                    <div class="w-full h-full rounded-lg relative overflow-hidden">
                        <div x-ref="leafletMap" class="absolute inset-0 z-0"></div>
                        <div class="absolute top-98 left-3 z-10 rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-white/90 dark:bg-background-dark/80 backdrop-blur px-3 py-2">
                            <p class="text-[10px] font-black uppercase tracking-widest text-text-muted">MAP</p>
                            <p class="text-xs font-bold" x-text="`${visibleStations().length} station(s)`"></p>
                        </div>
                        {{-- Zone badge --}}
                        <div x-show="zoneFilter !== 'all'" class="absolute top-3 right-3 z-10 flex items-center gap-1.5 rounded-lg bg-[#111813]/80 text-white px-3 py-1.5 backdrop-blur">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            <span class="text-[10px] font-black uppercase" x-text="zoneFilter"></span>
                        </div>
                        {{-- Selected device badge --}}
                        <div x-show="selectedStation" class="absolute bottom-3 left-3 z-10 flex items-center gap-2 rounded-xl border border-primary bg-white/95 dark:bg-background-dark/95 backdrop-blur px-3 py-2">
                            <span class="size-2 rounded-full bg-primary animate-pulse"></span>
                            <span class="text-xs font-black" x-text="selectedStation ? (selectedStation.label + ': ' + selectedStation.id) : ''"></span>
                            <button type="button" class="ml-1 text-text-muted hover:text-[#111813] dark:hover:text-white" @click="closePanel()">
                                <span class="material-symbols-outlined text-sm">close</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══ Species / Nearby Birds panel ══ --}}
            <div class="col-span-12 xl:col-span-5">
                <div class="bg-white dark:bg-[#1a2e21] rounded-xl border border-border-muted dark:border-[#2a3a2e] flex flex-col overflow-hidden" style="height:520px">
                    {{-- Panel header --}}
                    <div class="px-5 py-4 border-b border-border-muted dark:border-[#2a3a2e] flex items-center justify-between shrink-0">
                        <div>
                            <h3 class="text-sm font-black" x-text="selectedStation ? 'Nearby Birds' : 'Live Species Detection'"></h3>
                            <p class="text-[10px] text-text-muted mt-0.5"
                               x-text="selectedStation ? ('Near · ' + (selectedStation.label ?? selectedStation.id)) : (directDevice?.device_id ? ('Realtime · ' + directDevice.device_id) : 'All visible stations')"></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <template x-if="directDevice && !selectedStation">
                                <span class="flex items-center gap-1.5 text-[10px] font-bold text-primary">
                                    <span class="relative flex size-1.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span><span class="relative inline-flex rounded-full size-1.5 bg-primary"></span></span>
                                    LIVE
                                </span>
                            </template>
                            <a href="{{ route('live') }}"
                               class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-[#111813] dark:bg-primary text-white dark:text-background-dark text-xs font-black hover:opacity-80 transition-opacity">
                                <span class="relative flex size-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary dark:bg-background-dark opacity-75"></span>
                                    <span class="relative inline-flex rounded-full size-2 bg-primary dark:bg-background-dark"></span>
                                </span>
                                Live
                            </a>
                        </div>
                    </div>
                    {{-- Scrollable accordion list --}}
                    <div class="flex-1 overflow-y-auto divide-y divide-border-muted dark:divide-[#2a3a2e]">
                        <template x-for="(item, idx) in speciesListItems()" :key="item.key">
                            <div x-data="{ open: false }">
                                {{-- Row header --}}
                                <button type="button"
                                    class="w-full text-left px-4 py-3 flex items-center gap-3 hover:bg-background-light dark:hover:bg-white/5 transition-colors"
                                    :class="[
                                        selectedStation && item.station && stationId(item.station) === stationId(selectedStation) ? 'bg-primary/5' : '',
                                        open ? 'border-l-2 border-l-primary' : 'border-l-2 border-l-transparent'
                                    ]"
                                    @click="open = !open; item.station && openStation(item.station)"
                                >
                                    <span class="text-xs font-black text-text-muted w-5 shrink-0 text-center" x-text="idx + 1"></span>
                                    <div class="size-10 rounded-lg overflow-hidden border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-background-dark shrink-0">
                                        <img x-show="item.imageUrl" :src="item.imageUrl" alt="" class="size-full object-cover"/>
                                        <div x-show="!item.imageUrl" class="size-full flex items-center justify-center text-text-muted">
                                            <span class="material-symbols-outlined text-base">flutter_dash</span>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-black truncate" x-text="item.commonName"></p>
                                        <p class="text-[10px] text-text-muted italic truncate" x-text="item.scientificName"></p>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <div class="text-right">
                                            <span class="block px-2 py-0.5 rounded-full text-[10px] font-black mb-1"
                                                  :class="item.status === 'Healthy' ? 'bg-primary/20 text-[#111813]' : 'bg-red-500/20 text-red-600'"
                                                  x-text="item.status"></span>
                                            <span class="text-[10px] font-black tabular-nums" x-text="item.confidence + '%'"></span>
                                        </div>
                                        <span class="material-symbols-outlined text-sm text-text-muted transition-transform duration-200"
                                              :class="open ? 'rotate-180' : ''">expand_more</span>
                                    </div>
                                </button>

                                {{-- Expandable detail --}}
                                <div
                                    x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    style="display:none"
                                    class="px-4 pb-4 bg-background-light dark:bg-background-dark/30"
                                >
                                    {{-- Coords --}}
                                    <div class="pt-3 pb-1">
                                        <p class="text-[10px] text-text-muted">Station: <span class="font-bold" x-text="item.stationLabel"></span> &nbsp;·&nbsp; Coords: <span class="font-bold tabular-nums" x-text="item.station ? (item.station.coordinates?.lat + ', ' + item.station.coordinates?.lng) : '—'"></span></p>
                                    </div>

                                    {{-- Telemetry chips --}}
                                    <div class="mt-3 grid grid-cols-3 gap-2">
                                        <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-background-dark/50 p-2 text-center">
                                            <p class="text-[9px] uppercase font-bold text-text-muted">Temp</p>
                                            <p class="text-xs font-black mt-0.5"><span x-text="item.station?.telemetry?.temperature_c ?? '—'"></span>°C</p>
                                        </div>
                                        <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-background-dark/50 p-2 text-center">
                                            <p class="text-[9px] uppercase font-bold text-text-muted">Sound</p>
                                            <p class="text-xs font-black mt-0.5"><span x-text="item.station?.telemetry?.sound_db != null ? (Math.round(item.station.telemetry.sound_db * 10) / 10) : '—'"></span> dB</p>
                                        </div>
                                        <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-background-dark/50 p-2 text-center">
                                            <p class="text-[9px] uppercase font-bold text-text-muted">Eco</p>
                                            <p class="text-xs font-black mt-0.5" x-text="item.station?.ml?.eco_score ?? '—'"></p>
                                        </div>
                                    </div>

                                    {{-- Top-K predictions --}}
                                    <template x-if="item.station?.ml?.topk?.length > 0">
                                        <div class="mt-3">
                                            <p class="text-[9px] uppercase tracking-widest font-bold text-text-muted mb-2">Top Predictions</p>
                                            <div class="space-y-1">
                                                <template x-for="(pred, pi) in (item.station?.ml?.topk ?? [])" :key="pi">
                                                    <div class="flex items-center gap-2 text-[11px]">
                                                        <img x-show="pred.image_url" :src="pred.image_url" class="size-5 rounded object-cover" />
                                                        <span class="font-bold truncate flex-1" x-text="pred.species"></span>
                                                        <span class="font-black tabular-nums text-text-muted" x-text="(pred.confidence_pct ?? 0) + '%'"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- Activity + confidence bar --}}
                                    <div class="mt-3 space-y-2">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[10px] font-bold text-text-muted">AI Confidence</span>
                                            <span class="text-[10px] font-black" x-text="item.confidence + '%'"></span>
                                        </div>
                                        <div class="h-1.5 w-full rounded-full bg-border-muted dark:bg-white/10 overflow-hidden">
                                            <div class="h-full rounded-full bg-primary transition-all duration-500"
                                                 :style="`width:${item.confidence}%`"></div>
                                        </div>
                                        <div class="flex items-center justify-between mt-1">
                                            <span class="text-[10px] font-bold text-text-muted">Activity</span>
                                            <span class="text-[10px] font-black" x-text="(item.station?.ml?.activity_det_per_hr ?? '—') + ' det/hr'"></span>
                                        </div>
                                    </div>

                                    {{-- Why this status --}}
                                    <div class="mt-3 rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-white/60 dark:bg-background-dark/40 p-3">
                                        <p class="text-[9px] uppercase tracking-widest font-bold text-text-muted mb-2">Analysis</p>
                                        <ul class="space-y-1">
                                            <template x-for="(line, li) in stationConclusions(item.station)" :key="li">
                                                <li class="text-[11px] font-medium text-[#111813] dark:text-white" x-text="'• ' + line"></li>
                                            </template>
                                        </ul>
                                    </div>

                                    {{-- Listen button --}}
                                    <a href="{{ route('live') }}"
                                       class="mt-3 flex items-center justify-center gap-2 w-full px-3 py-2 rounded-lg bg-[#111813] dark:bg-white text-white dark:text-[#111813] text-xs font-black hover:opacity-80 transition-opacity">
                                        <span class="material-symbols-outlined text-sm">hearing</span>
                                        Listen Live
                                    </a>
                                </div>
                            </div>
                        </template>
                        <div x-show="speciesListItems().length === 0" class="flex flex-col items-center justify-center h-full p-8 text-center">
                            <span class="material-symbols-outlined text-4xl text-text-muted mb-3">flutter_dash</span>
                            <p class="text-sm font-bold">No species data</p>
                            <p class="text-[10px] text-text-muted mt-1">Select a zone or device on the map</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ Wave chart + Eco Donut (when ESP selected) ══ --}}
        <div
            x-show="selectedStation"
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            style="display:none"
            class="grid grid-cols-12 gap-6"
        >
            {{-- Wave chart (col 8) --}}
            <div class="col-span-12 xl:col-span-8 bg-white dark:bg-[#1a2e21] rounded-xl border border-border-muted dark:border-[#2a3a2e] p-6">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest font-bold text-text-muted">Audio Wave · Since Select</p>
                        <p class="text-sm font-black mt-0.5" x-text="selectedStation ? (selectedStation.label + ': ' + selectedStation.id) : '—'"></p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-[9px] text-text-muted font-bold uppercase">Sound</p>
                            <p class="text-sm font-black"><span x-text="selectedStation?.telemetry?.sound_db ?? '—'"></span> dB</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] text-text-muted font-bold uppercase">Freq</p>
                            <p class="text-sm font-black" x-text="selectedStation?.telemetry?.dominant_hz ? (selectedStation.telemetry.dominant_hz + ' Hz') : '—'"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] text-text-muted font-bold uppercase">Updated</p>
                            <p class="text-sm font-black" x-text="formatIsoTime(selectedStation?.telemetry?.recorded_at)"></p>
                        </div>
                    </div>
                </div>
                {{-- SVG waveform --}}
                <div class="relative h-28 w-full overflow-hidden">
                    <svg class="w-full h-full" viewBox="0 0 800 100" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="waveGrad" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0%" stop-color="var(--color-primary)" stop-opacity="0.2"/>
                                <stop offset="50%" stop-color="var(--color-primary)" stop-opacity="1"/>
                                <stop offset="100%" stop-color="var(--color-primary)" stop-opacity="0.2"/>
                            </linearGradient>
                        </defs>
                        <line x1="0" y1="50" x2="800" y2="50" stroke="currentColor" stroke-opacity="0.1" stroke-width="1"/>
                        <line x1="0" y1="20" x2="800" y2="20" stroke="currentColor" stroke-opacity="0.06" stroke-width="1" stroke-dasharray="4,6"/>
                        <line x1="0" y1="80" x2="800" y2="80" stroke="currentColor" stroke-opacity="0.06" stroke-width="1" stroke-dasharray="4,6"/>
                        <path fill="none" stroke="url(#waveGrad)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M0,50 C15,50 18,18 35,18 C52,18 55,82 75,82 C95,82 98,32 115,32 C132,32 135,68 155,68 C175,68 178,22 195,22 C212,22 215,78 235,78 C255,78 258,38 275,38 C292,38 295,62 315,62 C335,62 338,26 355,26 C372,26 375,74 395,74 C415,74 418,42 435,42 C452,42 455,58 475,58 C495,58 498,24 515,24 C532,24 535,76 555,76 C575,76 578,40 595,40 C612,40 615,60 635,60 C655,60 658,30 675,30 C692,30 695,70 715,70 C735,70 738,48 755,48 C770,48 778,50 800,50"
                        />
                        <circle cx="800" cy="50" r="4" fill="var(--color-primary)"/>
                    </svg>
                </div>
                <div class="mt-2 flex justify-between text-[9px] font-bold text-text-muted px-1">
                    <span>−30s</span>
                    <span>−20s</span>
                    <span>−10s</span>
                    <span>Now</span>
                </div>
                {{-- Hardware info row --}}
                <div class="mt-4 grid grid-cols-4 gap-2 border-t border-border-muted dark:border-[#2a3a2e] pt-4">
                    <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-2.5">
                        <p class="text-[9px] uppercase tracking-widest font-bold text-text-muted">MCU</p>
                        <p class="text-xs font-bold mt-0.5" x-text="selectedStation?.hardware?.mcu ?? '—'"></p>
                    </div>
                    <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-2.5">
                        <p class="text-[9px] uppercase tracking-widest font-bold text-text-muted">Mic</p>
                        <p class="text-xs font-bold mt-0.5" x-text="selectedStation?.hardware?.mic ?? '—'"></p>
                    </div>
                    <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-2.5">
                        <p class="text-[9px] uppercase tracking-widest font-bold text-text-muted">Sensor</p>
                        <p class="text-xs font-bold mt-0.5" x-text="selectedStation?.hardware?.sensor || '—'"></p>
                    </div>
                    <div class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-2.5">
                        <p class="text-[9px] uppercase tracking-widest font-bold text-text-muted">Temp</p>
                        <p class="text-xs font-bold mt-0.5"><span x-text="selectedStation?.telemetry?.temperature_c ?? '—'"></span>°C</p>
                    </div>
                </div>
            </div>
            {{-- Eco-Health Donut (col 4) --}}
            <div class="col-span-12 xl:col-span-4 bg-white dark:bg-[#1a2e21] rounded-xl border border-border-muted dark:border-[#2a3a2e] p-6 flex flex-col items-center justify-center">
                <p class="text-[10px] font-black text-text-muted uppercase tracking-widest mb-5 self-start">Eco-Health Score</p>
                <div class="relative size-36">
                    <div class="rounded-full size-full p-3.5"
                         :style="`background: conic-gradient(from 180deg at 50% 50%, var(--color-primary) 0%, var(--color-primary) ${((selectedStation?.ml?.eco_score ?? 0) / 100 * 100).toFixed(1)}%, var(--color-border-muted) ${((selectedStation?.ml?.eco_score ?? 0) / 100 * 100).toFixed(1)}%, var(--color-border-muted) 100%)`"
                    >
                        <div class="bg-white dark:bg-[#1a2e21] rounded-full size-full flex flex-col items-center justify-center">
                            <span class="text-3xl font-black" x-text="selectedStation?.ml?.eco_score ?? '—'"></span>
                            <span class="text-[9px] font-black text-primary uppercase">Score</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-3 w-full mt-5 gap-3 border-t border-border-muted dark:border-[#2a3a2e] pt-5">
                    <div class="text-center">
                        <p class="text-[9px] text-text-muted uppercase font-bold">Activity</p>
                        <p class="text-base font-black"><span x-text="selectedStation?.ml?.activity_det_per_hr ?? '—'"></span>/hr</p>
                    </div>
                    <div class="text-center border-l border-border-muted dark:border-[#2a3a2e]">
                        <p class="text-[9px] text-text-muted uppercase font-bold">Status</p>
                        <p class="text-xs font-black mt-1"
                           :class="(selectedStation?.ml?.status === 'Healthy') ? 'text-primary' : 'text-red-500'"
                           x-text="selectedStation?.ml?.status ?? '—'"></p>
                    </div>
                    <div class="text-center border-l border-border-muted dark:border-[#2a3a2e]">
                        <p class="text-[9px] text-text-muted uppercase font-bold">Trend</p>
                        <p class="text-xs font-black mt-1" x-text="selectedStation?.ml?.eco_trend ?? '—'"></p>
                    </div>
                </div>
                {{-- Pressure & Wi-Fi --}}
                <div class="grid grid-cols-2 w-full mt-3 gap-3 border-t border-border-muted dark:border-[#2a3a2e] pt-3">
                    <div class="text-center">
                        <p class="text-[9px] text-text-muted uppercase font-bold">Pressure</p>
                        <p class="text-xs font-black mt-0.5"><span x-text="selectedStation?.telemetry?.pressure_hpa ?? '—'"></span> hPa</p>
                    </div>
                    <div class="text-center border-l border-border-muted dark:border-[#2a3a2e]">
                        <p class="text-[9px] text-text-muted uppercase font-bold">Wi-Fi</p>
                        <p class="text-xs font-black mt-0.5" x-text="selectedStation?.wifi?.ssid ? (selectedStation.wifi.ssid + ' (' + selectedStation.wifi.rssi + ' dBm)') : '—'"></p>
                    </div>
                </div>
            </div>
        </div>

        <div
            x-show="selectedStation"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-3"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-3"
            style="display:none"
            class="bg-white dark:bg-[#1a2e21] p-8 rounded-xl border border-border-muted dark:border-[#2a3a2e]"
        >
            <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h2 class="text-2xl font-bold">Area Trends</h2>
                        <span class="px-2.5 py-0.5 rounded-full bg-primary/10 text-[10px] font-black uppercase tracking-wider" x-text="selectedStation?.area_label ?? selectedStation?.label ?? ''"></span>
                    </div>
                    <p class="text-text-muted text-sm font-medium">
                        <span x-text="selectedStation ? `${selectedStation.area ?? 'Selected station'} — ` : ''"></span>Detected activity &amp; eco score over last 6 months
                    </p>
                </div>
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="size-3 bg-primary rounded-full"></span>
                            <span class="text-xs font-bold text-[#111813] dark:text-white">Detected Activity</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="size-3 bg-accent-blue rounded-full"></span>
                            <span class="text-xs font-bold text-[#111813] dark:text-white">Eco Score</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 p-1 bg-[#f0f4f2] dark:bg-background-dark rounded-lg">
                        <button class="px-4 py-1.5 text-xs font-bold rounded-md hover:bg-white transition-colors" type="button">1 Month</button>
                        <button class="px-4 py-1.5 text-xs font-bold bg-white dark:bg-primary dark:text-background-dark rounded-md shadow-sm" type="button">6 Months</button>
                        <button class="px-4 py-1.5 text-xs font-bold rounded-md hover:bg-white transition-colors" type="button">1 Year</button>
                    </div>
                </div>
            </div>

            <div class="relative h-80 w-full mt-10">
                <div class="absolute inset-0 grid grid-cols-12 grid-rows-6 pointer-events-none opacity-20">
                    @for ($i = 0; $i < 72; $i++)
                        <div class="border-r border-b border-border-muted dark:border-[#2a3a2e]"></div>
                    @endfor
                </div>
                <div class="absolute left-0 top-0 h-full flex flex-col justify-between text-[10px] font-bold text-text-muted -translate-x-full pr-4 pb-8">
                    <span>100%</span>
                    <span>75%</span>
                    <span>50%</span>
                    <span>25%</span>
                    <span>0%</span>
                </div>
                <svg class="w-full h-full overflow-visible" preserveAspectRatio="none" viewBox="0 0 1200 300">
                    <path class="fill-none stroke-3 stroke-linecap-round stroke-linejoin-round stroke-primary" d="M 100,200 L 300,160 L 500,80 L 700,220 L 900,140 L 1100,100"></path>
                    <path class="fill-none stroke-3 stroke-linecap-round stroke-linejoin-round stroke-accent-blue" d="M 100,140 L 300,180 L 500,120 L 700,100 L 900,130 L 1100,60"></path>
                    <circle class="fill-primary stroke-white dark:stroke-[#1a2e21] stroke-2" cx="100" cy="200" r="5"></circle>
                    <circle class="fill-primary stroke-white dark:stroke-[#1a2e21] stroke-2" cx="300" cy="160" r="5"></circle>
                    <circle class="fill-primary stroke-white dark:stroke-[#1a2e21] stroke-2" cx="500" cy="80" r="5"></circle>
                    <circle class="fill-primary stroke-white dark:stroke-[#1a2e21] stroke-2" cx="700" cy="220" r="5"></circle>
                    <circle class="fill-primary stroke-white dark:stroke-[#1a2e21] stroke-2" cx="900" cy="140" r="5"></circle>
                    <circle class="fill-primary stroke-white dark:stroke-[#1a2e21] stroke-2" cx="1100" cy="100" r="5"></circle>
                    <circle class="fill-accent-blue stroke-white dark:stroke-[#1a2e21] stroke-2" cx="100" cy="140" r="5"></circle>
                    <circle class="fill-accent-blue stroke-white dark:stroke-[#1a2e21] stroke-2" cx="300" cy="180" r="5"></circle>
                    <circle class="fill-accent-blue stroke-white dark:stroke-[#1a2e21] stroke-2" cx="500" cy="120" r="5"></circle>
                    <circle class="fill-accent-blue stroke-white dark:stroke-[#1a2e21] stroke-2" cx="700" cy="100" r="5"></circle>
                    <circle class="fill-accent-blue stroke-white dark:stroke-[#1a2e21] stroke-2" cx="900" cy="130" r="5"></circle>
                    <circle class="fill-accent-blue stroke-white dark:stroke-[#1a2e21] stroke-2" cx="1100" cy="60" r="5"></circle>
                    <g transform="translate(450, 45)">
                        <rect fill="#111813" height="24" rx="4" width="100" x="0" y="0"></rect>
                        <text fill="white" font-size="10" font-weight="bold" text-anchor="middle" x="50" y="16">ANNUAL PEAK</text>
                        <path d="M 50,24 L 50,32" stroke="#111813" stroke-width="2"></path>
                    </g>
                </svg>
                <div class="absolute inset-x-0 bottom-0 flex justify-between px-[8.33%] translate-y-full pt-4">
                    <span class="text-[10px] font-bold text-text-muted">JAN</span>
                    <span class="text-[10px] font-bold text-text-muted">FEB</span>
                    <span class="text-[10px] font-bold text-[#111813] dark:text-white underline decoration-primary decoration-2 underline-offset-4">MAR</span>
                    <span class="text-[10px] font-bold text-text-muted">APR</span>
                    <span class="text-[10px] font-bold text-text-muted">MAY</span>
                    <span class="text-[10px] font-bold text-text-muted">JUN</span>
                </div>
            </div>

            <div class="mt-16 pt-8 border-t border-border-muted dark:border-[#2a3a2e] grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-5 rounded-xl bg-background-light dark:bg-background-dark/30 border border-border-muted dark:border-white/5">
                    <h4 class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2">Station Insight</h4>
                    <p class="text-sm font-medium">
                        <span x-text="selectedStation?.ml?.species?.common_name ?? 'Species'"></span> detected with
                        <span x-text="(selectedStation?.ml?.confidence_pct ?? '—') + '%'"></span> confidence.
                        Acoustic analysis indicates stable canopy-level interactions near this sensor.
                    </p>
                </div>
                <div class="p-5 rounded-xl bg-background-light dark:bg-background-dark/30 border border-border-muted dark:border-white/5">
                    <h4 class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2">Environment</h4>
                    <p class="text-sm font-medium">
                        Temperature: <span x-text="(selectedStation?.telemetry?.temperature_c ?? '—') + '°C'"></span>,
                        Sound: <span x-text="(selectedStation?.telemetry?.sound_db ?? '—') + ' dB'"></span>.
                        <span x-text="selectedStation?.zone ? 'Zone type: ' + selectedStation.zone + '.' : ''"></span>
                    </p>
                </div>
                <div class="p-5 rounded-xl bg-background-light dark:bg-background-dark/30 border border-border-muted dark:border-white/5">
                    <h4 class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2">Activity</h4>
                    <p class="text-sm font-medium">
                        <span x-text="(selectedStation?.ml?.activity_det_per_hr ?? '—') + ' detections/hr'"></span> recorded.
                        Eco score: <span x-text="selectedStation?.ml?.eco_score ?? '—'"></span>.
                        Status: <span x-text="selectedStation?.ml?.status ?? '—'"></span>.
                    </p>
                </div>
            </div>
        </div>

        <section id="future-predict" class="bg-white dark:bg-[#1a2e21] p-8 rounded-xl border border-border-muted dark:border-[#2a3a2e]">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black">Future Predict</h2>
                    <p class="text-text-muted text-sm font-medium">Predictive insights based on live sensor data (full page: Trends)</p>
                </div>
                <a class="px-4 py-2 rounded-lg bg-primary text-background-dark text-xs font-black hover:opacity-90" href="{{ route('future') }}">Open Full Future Page</a>
            </div>

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="rounded-2xl border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-5">
                    <p class="text-[10px] uppercase tracking-widest font-black text-text-muted">Next 24h</p>
                    <p class="text-lg font-black mt-1" x-text="futureHeadline().title"></p>
                    <p class="text-xs text-text-muted mt-2" x-text="futureHeadline().detail"></p>
                </div>
                <div class="rounded-2xl border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-5">
                    <p class="text-[10px] uppercase tracking-widest font-black text-text-muted">Key Drivers</p>
                    <ul class="mt-3 space-y-2">
                        <template x-for="(d, idx) in futureDrivers()" :key="idx">
                            <li class="text-xs font-medium flex gap-2">
                                <span class="material-symbols-outlined text-accent-blue text-sm mt-0.5">insights</span>
                                <span x-text="d"></span>
                            </li>
                        </template>
                    </ul>
                </div>
                <div class="rounded-2xl border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-5">
                    <p class="text-[10px] uppercase tracking-widest font-black text-text-muted">Action</p>
                    <p class="text-xs text-text-muted mt-2">As more ESP32/INMP441 data streams in (sound_db, dominant_hz, temperature), these predictions become increasingly accurate.</p>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">settings</span>
                        <p class="text-xs font-bold">Tip: Include `recorded_at` timestamps to compute peak activity hours.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

</body>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dashboardPage', (initialStations) => ({
            stations: Array.isArray(initialStations) ? initialStations : [],
            selectedStation: null,
            modalOpen: false,
            zoneFilter: 'all',
            lastUpdatedAt: null,
            pollEveryMs: 3000,
            pollTimer: null,

            map: null,
            markerLayer: null,

            // Direct Python API for realtime species
            directApiUrl: 'https://bird-edge-api-879683801404.asia-east1.run.app/api/v1/sensor/latest',
            directApiKey: 'birdedge_KfBfwrtXzd7IEeizQLc-iK9EVaJYzp1aJq_AK6p-qdU',
            directDevice: null,
            directPollTimer: null,

            realtimeListenerDeviceId: null,
            realtimeListenerStartedAt: null,
            realtimeSubscriptions: [],
            realtimePathSamples: {},
            realtimePathUsed: null,
            realtimeLastSuccessIso: null,
            realtimeReconnectCount: 0,
            realtimeErrorCount: 0,
            realtimeTelemetryHeartbeatAt: 0,
            latestRealtimeByDevice: {},
            realtimeSamplesByDevice: {},

            init() {
                this.lastUpdatedAt = new Date();
                this.$nextTick(() => this.initLeafletMap());
                this.startPolling();
                this.startDirectApiPolling();
                this.$watch('selectedStation', () => this.syncRealtimeAudioListener());

                window.addEventListener('beforeunload', () => {
                    this.clearRealtimeAudioSubscriptions();
                    if (this.directPollTimer) clearInterval(this.directPollTimer);
                });
            },

            get lastUpdatedLabel() {
                if (!this.lastUpdatedAt) return '—';
                return this.lastUpdatedAt.toLocaleTimeString();
            },

            formatIsoTime(iso) {
                if (!iso) return '—';
                const d = new Date(iso);
                if (Number.isNaN(d.getTime())) return '—';
                return d.toLocaleTimeString();
            },

            toFiniteNumber(value) {
                const n = Number(value);
                return Number.isFinite(n) ? n : null;
            },

            clamp(value, min, max) {
                if (!Number.isFinite(value)) return value;
                return Math.min(max, Math.max(min, value));
            },

            priorityRealtimePaths(deviceId) {
                return [
                    `esp32_mock/${deviceId}/realtime_audio/latest`,
                    `devices/${deviceId}/realtime_audio/latest`,
                    `devices/${deviceId}/latest`,
                ];
            },

            logFirebaseListenerTelemetry(event, extra = {}) {
                const payload = {
                    event,
                    device_id: this.realtimeListenerDeviceId,
                    path: this.realtimePathUsed,
                    last_success_at: this.realtimeLastSuccessIso,
                    listener_started_at: this.realtimeListenerStartedAt,
                    reconnect_count: this.realtimeReconnectCount,
                    error_count: this.realtimeErrorCount,
                    source: 'dashboard-web',
                    ...extra,
                };

                fetch('/api/firebase/listener-telemetry', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                }).catch(() => {
                    // best-effort only
                });
            },

            clearRealtimeAudioSubscriptions() {
                const handles = this.getFirebaseHandles();
                for (const sub of this.realtimeSubscriptions) {
                    try {
                        if (handles?.off) {
                            handles.off(sub.ref, 'value', sub.onData);
                        }
                    } catch (e) {
                        // ignore cleanup errors
                    }
                }
                this.realtimeSubscriptions = [];
                this.realtimePathSamples = {};
                this.realtimePathUsed = null;
            },

            syncRealtimeAudioListener() {
                const handles = this.getFirebaseHandles();
                const deviceId = this.stationId(this.selectedStation);

                if (!deviceId || !handles?.onValue) {
                    this.clearRealtimeAudioSubscriptions();
                    this.realtimeListenerDeviceId = null;
                    return;
                }

                if (this.realtimeListenerDeviceId === deviceId && this.realtimeSubscriptions.length) {
                    return;
                }

                if (this.realtimeListenerDeviceId && this.realtimeListenerDeviceId !== deviceId) {
                    this.realtimeReconnectCount += 1;
                    this.logFirebaseListenerTelemetry('listener_reconnect', {
                        message: `Device switched to ${deviceId}`,
                    });
                }

                this.clearRealtimeAudioSubscriptions();
                this.realtimeListenerDeviceId = deviceId;
                this.realtimeListenerStartedAt = new Date().toISOString();

                for (const path of this.priorityRealtimePaths(deviceId)) {
                    const audioRef = handles.ref(handles.db, path);
                    const onData = (snapshot) => {
                        if (!snapshot.exists()) {
                            this.realtimePathSamples[path] = null;
                            this.applyBestRealtimeSample(deviceId);
                            return;
                        }

                        const parsed = this.parseRealtimeAudioSample(snapshot.val(), deviceId);
                        this.realtimePathSamples[path] = parsed;
                        this.applyBestRealtimeSample(deviceId);
                    };

                    const onError = (error) => {
                        this.realtimeErrorCount += 1;
                        this.realtimeReconnectCount += 1;
                        this.logFirebaseListenerTelemetry('listener_error', {
                            path,
                            message: String(error?.message || 'Unknown firebase listener error'),
                        });

                        this.logFirebaseListenerTelemetry('listener_reconnect', {
                            path,
                            message: 'Resubscribing after listener error',
                        });

                        setTimeout(() => {
                            if (this.realtimeListenerDeviceId === deviceId) {
                                this.syncRealtimeAudioListener();
                            }
                        }, 1000);
                    };

                    handles.onValue(audioRef, onData, onError);
                    this.realtimeSubscriptions.push({ ref: audioRef, onData });
                }

                this.logFirebaseListenerTelemetry('listener_started', {
                    device_id: deviceId,
                    path: this.priorityRealtimePaths(deviceId)[0],
                });
            },

            parseRealtimeAudioSample(raw, deviceId) {
                if (!raw || typeof raw !== 'object') return null;

                const telemetry = raw?.telemetry || {};
                const ml = raw?.ml || {};

                let peakDbfs = this.toFiniteNumber(raw?.peak_dbfs ?? telemetry?.peak_dbfs);
                let loudnessDbfs = this.toFiniteNumber(raw?.loudness_dbfs ?? telemetry?.loudness_dbfs ?? raw?.sound_db ?? telemetry?.sound_db);
                let dominantHz = this.toFiniteNumber(raw?.dominant_hz ?? telemetry?.dominant_hz);

                if (peakDbfs != null) peakDbfs = this.clamp(peakDbfs, -120, 0);
                if (loudnessDbfs != null) loudnessDbfs = this.clamp(loudnessDbfs, -120, 0);
                if (dominantHz != null && dominantHz <= 0) dominantHz = null;

                let confidence = this.toFiniteNumber(raw?.confidence ?? raw?.confidence_pct ?? ml?.confidence_pct);
                if (confidence != null) {
                    if (confidence > 1 && confidence <= 100) confidence = confidence / 100;
                    confidence = this.clamp(confidence, 0, 1);
                }

                const species = typeof raw?.species === 'string'
                    ? raw.species.trim()
                    : (ml?.species?.common_name || null);

                const tsRaw = raw?.ts ?? raw?.timestamp ?? raw?.recorded_at ?? telemetry?.recorded_at;
                const parsedDate = tsRaw ? new Date(tsRaw) : new Date();
                const ts = Number.isNaN(parsedDate.getTime()) ? new Date().toISOString() : parsedDate.toISOString();

                const durationSec = this.toFiniteNumber(raw?.duration_sec);
                const hasSignal = peakDbfs != null || loudnessDbfs != null || dominantHz != null || species || confidence != null;
                if (!hasSignal) return null;

                return {
                    device_id: String(raw?.device_id || deviceId || '').trim() || deviceId,
                    ts,
                    source: raw?.source || 'firebase-realtime',
                    species: species || null,
                    confidence,
                    loudness_dbfs: loudnessDbfs,
                    peak_dbfs: peakDbfs,
                    dominant_hz: dominantHz,
                    duration_sec: durationSec,
                };
            },

            applyBestRealtimeSample(deviceId) {
                const orderedPaths = this.priorityRealtimePaths(deviceId);
                for (const path of orderedPaths) {
                    const sample = this.realtimePathSamples[path];
                    if (!sample) continue;
                    this.applyRealtimeSampleToDevice(deviceId, sample, path);
                    return;
                }
            },

            mergeRealtimeIntoStation(station, sample) {
                if (!sample || !station) return station;

                const merged = {
                    ...station,
                    telemetry: {
                        ...(station.telemetry || {}),
                    },
                    ml: {
                        ...(station.ml || {}),
                        species: {
                            ...(station?.ml?.species || {}),
                        },
                    },
                };

                const preferredLoudness = sample.peak_dbfs ?? sample.loudness_dbfs;
                if (preferredLoudness != null) {
                    merged.telemetry.sound_db = Math.round(preferredLoudness * 10) / 10;
                }
                if (sample.dominant_hz != null) {
                    merged.telemetry.dominant_hz = Math.round(sample.dominant_hz);
                }
                merged.telemetry.recorded_at = sample.ts;

                if (sample.species) {
                    merged.ml.species.common_name = sample.species;
                }
                if (sample.confidence != null) {
                    merged.ml.confidence_pct = Math.round(sample.confidence * 100);
                }

                merged.realtime_audio = {
                    ...(station.realtime_audio || {}),
                    ...sample,
                };

                return merged;
            },

            pushRealtimeSample(deviceId, sample) {
                const now = Date.now();
                const parsedMs = Date.parse(sample.ts);
                const tsMs = Number.isFinite(parsedMs) ? parsedMs : now;
                const nextSample = {
                    ...sample,
                    _ts_ms: tsMs,
                };

                const current = Array.isArray(this.realtimeSamplesByDevice[deviceId])
                    ? this.realtimeSamplesByDevice[deviceId]
                    : [];
                const next = [...current, nextSample]
                    .filter((row) => Number.isFinite(row._ts_ms) && now - row._ts_ms <= 120000)
                    .slice(-900);

                this.realtimeSamplesByDevice = {
                    ...this.realtimeSamplesByDevice,
                    [deviceId]: next,
                };
            },

            applyRealtimeSampleToDevice(deviceId, sample, path) {
                this.latestRealtimeByDevice = {
                    ...this.latestRealtimeByDevice,
                    [deviceId]: sample,
                };

                this.pushRealtimeSample(deviceId, sample);
                this.realtimeLastSuccessIso = sample.ts;
                this.lastUpdatedAt = new Date();

                this.stations = this.stations.map((station) => {
                    if (this.stationId(station) !== deviceId) return station;
                    return this.mergeRealtimeIntoStation(station, sample);
                });

                if (this.selectedStation && this.stationId(this.selectedStation) === deviceId) {
                    const refreshed = this.stations.find((station) => this.stationId(station) === deviceId);
                    if (refreshed) this.selectedStation = refreshed;
                }

                if (this.realtimePathUsed !== path) {
                    this.realtimePathUsed = path;
                    this.logFirebaseListenerTelemetry('path_selected', {
                        path,
                        last_success_at: sample.ts,
                    });
                }

                const now = Date.now();
                if (now - this.realtimeTelemetryHeartbeatAt > 30000) {
                    this.realtimeTelemetryHeartbeatAt = now;
                    this.logFirebaseListenerTelemetry('listener_heartbeat', {
                        path,
                        last_success_at: sample.ts,
                    });
                }
            },

            applyRealtimeEnrichment() {
                this.stations = this.stations.map((station) => {
                    const id = this.stationId(station);
                    if (!id) return station;
                    const sample = this.latestRealtimeByDevice[id];
                    if (!sample) return station;
                    return this.mergeRealtimeIntoStation(station, sample);
                });

                const selectedId = this.stationId(this.selectedStation);
                if (selectedId) {
                    const refreshed = this.stations.find((station) => this.stationId(station) === selectedId);
                    if (refreshed) this.selectedStation = refreshed;
                }
            },

            normalizedAudioFeatures(deviceId = this.stationId(this.selectedStation), windowSec = 120) {
                if (!deviceId) return { available: false };

                const all = Array.isArray(this.realtimeSamplesByDevice[deviceId])
                    ? this.realtimeSamplesByDevice[deviceId]
                    : [];
                if (!all.length) return { available: false };

                const now = Date.now();
                const windowMs = Math.max(60, windowSec) * 1000;
                const samples = all.filter((row) => Number.isFinite(row?._ts_ms) && now - row._ts_ms <= windowMs);
                if (!samples.length) return { available: false };

                const pickLoudness = (row) => this.toFiniteNumber(row?.peak_dbfs ?? row?.loudness_dbfs);
                const loudnessValues = samples.map(pickLoudness).filter((n) => Number.isFinite(n));
                const dominantValues = samples.map((row) => this.toFiniteNumber(row?.dominant_hz)).filter((n) => Number.isFinite(n));

                const firstTs = samples[0]._ts_ms;
                const lastTs = samples[samples.length - 1]._ts_ms;
                const spanSec = Math.max(1, (lastTs - firstTs) / 1000);
                const eventRatePerMin = (samples.length / spanSec) * 60;

                const avg = (list) => (list.length ? list.reduce((acc, n) => acc + n, 0) / list.length : null);
                const avgLoudnessDbfs = avg(loudnessValues);

                const trendPerMin = (list) => {
                    if (list.length < 2) return 0;
                    return ((list[list.length - 1] - list[0]) / spanSec) * 60;
                };

                const peakTrendDbPerMin = trendPerMin(loudnessValues);
                const dominantTrendHzPerMin = trendPerMin(dominantValues);

                const normalize = (value, min, max) => {
                    if (!Number.isFinite(value)) return null;
                    return this.clamp((value - min) / (max - min), 0, 1);
                };

                return {
                    available: true,
                    avg_loudness_dbfs: avgLoudnessDbfs,
                    peak_trend_db_per_min: peakTrendDbPerMin,
                    dominant_trend_hz_per_min: dominantTrendHzPerMin,
                    event_rate_per_min: eventRatePerMin,
                    norm: {
                        avg_loudness: normalize(avgLoudnessDbfs, -120, 0),
                        peak_trend: normalize(peakTrendDbPerMin, -20, 20),
                        dominant_trend: normalize(dominantTrendHzPerMin, -1500, 1500),
                        event_rate: normalize(eventRatePerMin, 0, 120),
                    },
                };
            },

            passesZone(station) {
                if (this.zoneFilter === 'all') return true;
                return (station?.zone || '').toLowerCase() === this.zoneFilter;
            },

            setZone(zone) {
                this.zoneFilter = zone;
                this.refreshLeafletMarkers(true);
            },

            visibleStations() {
                return this.uniqueStations(this.stations).filter((station) => this.passesZone(station));
            },

            openStation(station) {
                this.selectedStation = station;
                // panel is inline — no overlay needed
                // fly map to station if possible
                if (this.map && station?.coordinates?.lat != null && station?.coordinates?.lng != null) {
                    this.map.panTo({ lat: station.coordinates.lat, lng: station.coordinates.lng });
                    if (this.map.getZoom() < 9) this.map.setZoom(9);
                }
                // smooth scroll so panel is visible on small screens
                this.$nextTick(() => {
                    const el = this.$el.querySelector('[x-show="selectedStation"]');
                    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                });
            },

            closePanel() {
                this.selectedStation = null;
                this.syncRealtimeAudioListener();
            },

            /** @deprecated kept for backward compat with any old references */
            closeModal() {
                this.closePanel();
            },

            topSpeciesByArea() {
                const grouped = new Map();
                for (const station of this.visibleStations()) {
                    const areaLabel = station?.area_label || station?.label || station?.id || 'Area';
                    const key = String(areaLabel);

                    const confidence = Number(station?.ml?.confidence_pct ?? 0);
                    const existing = grouped.get(key);
                    if (!existing || confidence > existing.confidenceValue) {
                        grouped.set(key, {
                            key,
                            label: areaLabel,
                            station,
                            confidenceValue: confidence,
                            confidence: `${Math.round(confidence)}%`,
                            status: station?.ml?.status || '—',
                            zone: station?.zone || '—',
                            speciesName: station?.ml?.species?.common_name || 'Unknown species',
                            speciesScientific: station?.ml?.species?.scientific_name || '',
                            imageUrl: station?.ml?.species?.image_url || '',
                            temperature: station?.telemetry?.temperature_c != null
                                ? `${station.telemetry.temperature_c}°C`
                                : '—',
                            soundDb: station?.telemetry?.sound_db != null
                                ? `${station.telemetry.sound_db} dB`
                                : '—',
                        });
                    }
                }

                return Array.from(grouped.values()).sort((a, b) => a.label.localeCompare(b.label));
            },

            speciesListItems() {
                if (this.selectedStation) {
                    // Show ALL detected species from the selected station's topk list
                    const topk = this.selectedStation?.ml?.topk;
                    if (Array.isArray(topk) && topk.length) {
                        return topk.map((pred, idx) => ({
                            key: `${this.stationId(this.selectedStation)}-topk-${idx}`,
                            station: this.selectedStation,
                            commonName: pred.species || 'Unknown species',
                            scientificName: pred.scientific_name || '',
                            imageUrl: pred.image_url || '',
                            status: this.selectedStation?.ml?.status || '—',
                            confidence: Math.round(pred.confidence_pct ?? 0),
                            stationLabel: this.selectedStation?.label || this.selectedStation?.id || '',
                        }));
                    }
                    // Fallback: single top species if topk not available
                    return [{
                        key: this.stationId(this.selectedStation) || String(Math.random()),
                        station: this.selectedStation,
                        commonName: this.selectedStation?.ml?.species?.common_name || 'Unknown species',
                        scientificName: this.selectedStation?.ml?.species?.scientific_name || '',
                        imageUrl: this.selectedStation?.ml?.species?.image_url || '',
                        status: this.selectedStation?.ml?.status || '—',
                        confidence: Math.round(this.selectedStation?.ml?.confidence_pct ?? 0),
                        stationLabel: this.selectedStation?.label || this.selectedStation?.id || '',
                    }];
                }

                // Realtime: show direct API topk predictions (like Live Listening)
                if (this.directDevice?.bird?.topk?.length) {
                    return this.directDevice.bird.topk.map((pred, idx) => ({
                        key: `direct-topk-${idx}-${pred.species}`,
                        station: null,
                        commonName: pred.species || 'Unknown species',
                        scientificName: pred.scientific_name || '',
                        imageUrl: pred.image_url || '',
                        status: this.directDevice?.eco?.status || '—',
                        confidence: Math.round(pred.confidence_pct ?? 0),
                        stationLabel: this.directDevice?.device_id || 'Live Sensor',
                    }));
                }

                // Fallback: top species per area from all visible stations
                return this.topSpeciesByArea().map((area) => ({
                    key: area.key,
                    station: area.station,
                    commonName: area.speciesName,
                    scientificName: area.speciesScientific,
                    imageUrl: area.imageUrl,
                    status: area.status,
                    confidence: Math.round(area.confidenceValue ?? 0),
                    stationLabel: area.label,
                }));
            },

            startPolling() {
                if (this.pollTimer) return;
                this.fetchStations();
                this.pollTimer = setInterval(() => this.fetchStations(), this.pollEveryMs);
            },

            stopPolling() {
                if (!this.pollTimer) return;
                clearInterval(this.pollTimer);
                this.pollTimer = null;
            },

            async fetchStations() {
                try {
                    const response = await fetch('/api/stations', {
                        headers: {
                            'Accept': 'application/json',
                        },
                    });

                    if (!response.ok) return;

                    const payload = await response.json();
                    const stations = payload?.stations;
                    if (Array.isArray(stations)) {
                        this.stations = this.uniqueStations(stations);
                        this.applyRealtimeEnrichment();
                        this.lastUpdatedAt = new Date();

                        this.refreshLeafletMarkers(false);

                        if (this.selectedStation?.id) {
                            const selectedId = this.stationId(this.selectedStation);
                            const updated = this.stations.find((s) => this.stationId(s) === selectedId);
                            if (updated) this.selectedStation = updated;
                        }

                        this.syncRealtimeAudioListener();
                    }
                } catch (e) {
                    // ignore transient network errors
                }
            },

            // ──── Direct Python API polling (realtime species) ────
            startDirectApiPolling() {
                this.fetchDirectApi();
                this.directPollTimer = setInterval(() => this.fetchDirectApi(), 3000);
            },

            async fetchDirectApi() {
                try {
                    const url = `${this.directApiUrl}?api_key=${this.directApiKey}`;
                    const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) return;
                    const data = await res.json();
                    if (data?.ok) {
                        this.directDevice = data;
                    }
                } catch (e) {
                    // ignore
                }
            },

            stationId(station) {
                if (!station || typeof station !== 'object') return '';
                const id = station.id ?? station.device_id ?? station.label;
                return typeof id === 'string' ? id.trim() : '';
            },

            uniqueStations(stations) {
                const byId = new Map();

                for (const station of Array.isArray(stations) ? stations : []) {
                    const id = this.stationId(station);
                    if (!id) continue;

                    const previous = byId.get(id);
                    if (!previous) {
                        byId.set(id, station);
                        continue;
                    }

                    byId.set(id, {
                        ...previous,
                        ...station,
                        telemetry: {
                            ...(previous.telemetry || {}),
                            ...(station.telemetry || {}),
                        },
                        baseline: {
                            ...(previous.baseline || {}),
                            ...(station.baseline || {}),
                        },
                        ml: {
                            ...(previous.ml || {}),
                            ...(station.ml || {}),
                            species: {
                                ...(previous?.ml?.species || {}),
                                ...(station?.ml?.species || {}),
                            },
                        },
                        coordinates: {
                            ...(previous.coordinates || {}),
                            ...(station.coordinates || {}),
                        },
                    });
                }

                return Array.from(byId.values());
            },

            getFirebaseHandles() {
                const db = window.firebaseDatabase;
                const ref = window.firebaseRef;
                const set = window.firebaseSet;
                const get = window.firebaseGet;
                const child = window.firebaseChild;
                const push = window.firebasePush;
                const onValue = window.firebaseOnValue;
                const off = window.firebaseOff;

                if (!db || !ref || !set || !get || !child || !push || !onValue || !off) {
                    return null;
                }

                return { db, ref, set, get, child, push, onValue, off };
            },

            async withTimeout(promise, label, timeoutMs = 10000) {
                let timerId;

                const timeoutPromise = new Promise((_, reject) => {
                    timerId = setTimeout(() => {
                        reject(new Error(`${label} timeout (${Math.round(timeoutMs / 1000)}s). Check Firebase URL / Rules.`));
                    }, timeoutMs);
                });

                try {
                    return await Promise.race([promise, timeoutPromise]);
                } finally {
                    clearTimeout(timerId);
                }
            },

            initLeafletMap() {
                if (!window.L || !this.$refs.leafletMap) return;
                if (this.map) return;

                this.map = L.map(this.$refs.leafletMap, {
                    center: [47.9, 106.9],
                    zoom: 4,
                    zoomControl: true,
                    attributionControl: false,
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(this.map);

                L.control.attribution({ position: 'bottomright', prefix: false })
                    .addAttribution('&copy; <a href="https://openstreetmap.org">OSM</a>')
                    .addTo(this.map);

                this.markerLayer = L.layerGroup().addTo(this.map);
                this.refreshLeafletMarkers(true);
            },

            refreshLeafletMarkers(fit) {
                if (!this.map || !window.L) return;

                this.markerLayer.clearLayers();

                const visible = this.visibleStations();
                const coords = [];

                visible.forEach((station, idx) => {
                    const lat = station?.coordinates?.lat;
                    const lng = station?.coordinates?.lng;
                    if (lat == null || lng == null) return;

                    const isHealthy = station?.ml?.status === 'Healthy';
                    const bg = isHealthy ? '#39e079' : '#ef4444';

                    const icon = L.divIcon({
                        className: '',
                        iconSize: [32, 32],
                        iconAnchor: [16, 16],
                        html: `<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"><circle cx="16" cy="16" r="14" fill="${bg}" stroke="white" stroke-width="2.5"/><text x="16" y="21" text-anchor="middle" font-size="12" font-weight="800" fill="white" font-family="sans-serif">${idx + 1}</text></svg>`,
                    });

                    const marker = L.marker([lat, lng], { icon, title: `${station.label ?? station.id}: ${station.id}` });

                    marker.bindPopup(
                        `<div style="font-family:inherit;font-size:12px;font-weight:700;line-height:1.5;padding:2px 0;">`
                        + `<div>${station.label ?? station.id}: ${station.id}</div>`
                        + `<div style="font-weight:400;font-style:italic">${station?.ml?.species?.common_name ?? 'Unknown'}</div>`
                        + `<div style="font-weight:400">${station?.ml?.confidence_pct ?? 0}% · ${station?.ml?.status ?? '—'}</div>`
                        + `</div>`,
                        { closeButton: false, className: 'est-popup' }
                    );

                    marker.on('click', () => this.openStation(station));
                    this.markerLayer.addLayer(marker);
                    coords.push([lat, lng]);
                });

                if (fit && coords.length) {
                    this.map.fitBounds(coords, { padding: [24, 24], maxZoom: 12 });
                } else if (fit) {
                    this.map.setView([0, 0], 2);
                }
            },

            areaStations() {
                if (!this.selectedStation?.area_label) return [];
                const sameArea = this.stations.filter((s) => s?.area_label === this.selectedStation.area_label);
                return this.uniqueStations(sameArea);
            },

            areaBirds() {
                const birds = new Map();
                for (const st of this.areaStations()) {
                    const sp = st?.ml?.species;
                    const key = sp?.common_name || st?.id;
                    if (!key) continue;
                    if (!birds.has(key)) {
                        birds.set(key, {
                            key,
                            commonName: sp?.common_name || 'Unknown species',
                            scientificName: sp?.scientific_name || '',
                            imageUrl: sp?.image_url || '',
                        });
                    }
                }
                return Array.from(birds.values());
            },

            areaMostActiveHourLabel() {
                const stations = this.areaStations();
                let best = null;
                for (const st of stations) {
                    const score = Number(st?.ml?.activity_det_per_hr ?? 0);
                    if (!best || score > best.score) {
                        best = { st, score };
                    }
                }

                const recordedAt = best?.st?.ml?.recorded_at || best?.st?.telemetry?.recorded_at;
                if (!recordedAt) return '—';

                const d = new Date(recordedAt);
                if (Number.isNaN(d.getTime())) return '—';

                const hh = String(d.getHours()).padStart(2, '0');
                return `${hh}:00`;
            },

            areaDeltaLabel() {
                const stations = this.areaStations();
                if (!stations.length) return '—';

                const avg = (arr) => arr.reduce((a, b) => a + b, 0) / arr.length;

                const temp = stations.map((s) => Number(s?.telemetry?.temperature_c)).filter((n) => Number.isFinite(n));
                const tempBase = stations.map((s) => Number(s?.baseline?.temperature_c)).filter((n) => Number.isFinite(n));
                const sound = stations.map((s) => Number(s?.telemetry?.sound_db)).filter((n) => Number.isFinite(n));
                const soundBase = stations.map((s) => Number(s?.baseline?.sound_db)).filter((n) => Number.isFinite(n));
                const act = stations.map((s) => Number(s?.ml?.activity_det_per_hr)).filter((n) => Number.isFinite(n));
                const actBase = stations.map((s) => Number(s?.baseline?.activity_det_per_hr)).filter((n) => Number.isFinite(n));

                const parts = [];
                if (temp.length && tempBase.length) parts.push(`Temp ${Math.round((avg(temp) - avg(tempBase)) * 10) / 10}°C`);
                if (sound.length && soundBase.length) parts.push(`Sound ${Math.round((avg(sound) - avg(soundBase)) * 10) / 10} dB`);
                if (act.length && actBase.length) parts.push(`Activity ${Math.round(avg(act) - avg(actBase))} det/hr`);

                return parts.length ? parts.join(' • ') : '—';
            },

            stationConclusions(station) {
                if (!station) return [];
                const lines = [];

                const sound = Number(station?.telemetry?.sound_db);
                const soundBase = Number(station?.baseline?.sound_db);
                if (Number.isFinite(sound) && Number.isFinite(soundBase)) {
                    const delta = sound - soundBase;
                    if (delta <= -8) lines.push(`Sound level below baseline (${Math.round(delta)} dB).`);
                    if (delta >= 8) lines.push(`Sound level above baseline (+${Math.round(delta)} dB).`);
                }

                const temp = Number(station?.telemetry?.temperature_c);
                const tempBase = Number(station?.baseline?.temperature_c);
                if (Number.isFinite(temp) && Number.isFinite(tempBase)) {
                    const delta = temp - tempBase;
                    if (delta >= 2.0) lines.push(`Temperature above baseline (+${Math.round(delta * 10) / 10}°C).`);
                    if (delta <= -2.0) lines.push(`Temperature below baseline (${Math.round(delta * 10) / 10}°C).`);
                }

                const eco = Number(station?.ml?.eco_score);
                if (Number.isFinite(eco) && eco < 70) lines.push('Eco-score declined — possible stress or environmental shifts.');

                const rssi = Number(station?.telemetry?.rssi_dbm);
                if (Number.isFinite(rssi) && rssi < -75) lines.push('Weak signal (low RSSI) — data may be intermittent.');

                const batt = Number(station?.telemetry?.battery_v);
                if (Number.isFinite(batt) && batt < 3.6) lines.push('Low battery — sensor stability may be affected.');

                if (!lines.length) lines.push('No significant issues detected based on current data.');
                return lines;
            },

            areaConclusions() {
                const stations = this.areaStations();
                if (!stations.length) return [];

                const warningCount = stations.filter((s) => s?.ml?.status === 'Warning').length;
                const healthyCount = stations.filter((s) => s?.ml?.status === 'Healthy').length;
                const birds = this.areaBirds().map((b) => b.commonName).slice(0, 4);

                const lines = [];
                lines.push(`This zone: Healthy: ${healthyCount}, Warning: ${warningCount}.`);
                if (birds.length) lines.push(`Detected species: ${birds.join(', ')}.`);

                const deltas = this.areaDeltaLabel();
                if (deltas !== '—') lines.push(`Deviation from baseline: ${deltas}.`);
                lines.push('Analysis is based on the latest live telemetry & AI detection data.');
                return lines;
            },

            futureHeadline() {
                const audio = this.normalizedAudioFeatures();
                if (audio.available) {
                    if ((audio.norm?.event_rate ?? 0) > 0.55 && (audio.norm?.avg_loudness ?? 0) > 0.45) {
                        return {
                            title: 'Rising Activity',
                            detail: `Audio stream stable (avg ${Math.round(audio.avg_loudness_dbfs ?? 0)} dBFS, rate ${Math.round(audio.event_rate_per_min ?? 0)}/min).`,
                        };
                    }

                    if ((audio.norm?.event_rate ?? 0) < 0.2 && (audio.norm?.avg_loudness ?? 1) < 0.35) {
                        return {
                            title: 'Quiet Period',
                            detail: `Realtime audio quiet (avg ${Math.round(audio.avg_loudness_dbfs ?? 0)} dBFS) — continuing observation.`,
                        };
                    }
                }

                const stations = this.visibleStations();
                const avgEco = stations.length
                    ? Math.round(stations.reduce((a, s) => a + Number(s?.ml?.eco_score ?? 0), 0) / stations.length)
                    : 0;

                if (!stations.length) {
                    return { title: 'No Live Stations', detail: 'No station data received from API.' };
                }

                if (avgEco >= 80) {
                    return { title: 'Stable 24h Outlook', detail: `Avg eco-score ~${avgEco}. Activity expected to remain at normal levels.` };
                }

                if (avgEco >= 65) {
                    return { title: 'Moderate Risk', detail: `Avg eco-score ~${avgEco}. Temperature/sound fluctuations may increase.` };
                }

                return { title: 'Attention Required', detail: `Avg eco-score ~${avgEco}. Environmental stress or declining activity may be observed.` };
            },

            futureDrivers() {
                const stations = this.visibleStations();
                const drivers = [];
                const audio = this.normalizedAudioFeatures();

                if (audio.available) {
                    drivers.push(`Audio event rate: ${Math.round(audio.event_rate_per_min ?? 0)} /min.`);
                    if (Number.isFinite(audio.peak_trend_db_per_min)) {
                        drivers.push(`Peak trend: ${audio.peak_trend_db_per_min >= 0 ? '+' : ''}${Math.round(audio.peak_trend_db_per_min)} dBFS/min.`);
                    }
                    if (Number.isFinite(audio.dominant_trend_hz_per_min)) {
                        drivers.push(`Dominant freq trend: ${audio.dominant_trend_hz_per_min >= 0 ? '+' : ''}${Math.round(audio.dominant_trend_hz_per_min)} Hz/min.`);
                    }
                }

                const warnings = stations.filter((s) => s?.ml?.status === 'Warning').length;
                if (warnings) drivers.push(`Warning status: ${warnings} station(s).`);

                const lowSound = stations.filter((s) => {
                    const sound = Number(s?.telemetry?.sound_db);
                    const base = Number(s?.baseline?.sound_db);
                    return Number.isFinite(sound) && Number.isFinite(base) && (sound - base) <= -8;
                }).length;
                if (lowSound) drivers.push(`Sound below baseline: ${lowSound} station(s).`);

                const highTemp = stations.filter((s) => {
                    const t = Number(s?.telemetry?.temperature_c);
                    const base = Number(s?.baseline?.temperature_c);
                    return Number.isFinite(t) && Number.isFinite(base) && (t - base) >= 2;
                }).length;
                if (highTemp) drivers.push(`Temperature above baseline: ${highTemp} station(s).`);

                if (!drivers.length) drivers.push('No significant risk detected based on current data.');
                return drivers.slice(0, 4);
            },
        }));
    });
</script>
</html>
