<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Eco System Translator (EST) Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
</head>
<body
    x-data="dashboardPage({{ \Illuminate\Support\Js::from($stations ?? []) }})"
    @keydown.escape.window="closeModal()"
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
        <div class="mb-8">
            <h3 class="text-xs font-bold text-text-muted uppercase tracking-widest mb-4">Branding</h3>
            <div class="flex flex-col gap-1 p-3 bg-primary/5 border border-primary/20 rounded-xl">
                <p class="text-[#111813] dark:text-white font-bold text-sm">EST Translator</p>
                <p class="text-[10px] text-text-muted">Global Eco-Monitoring</p>
            </div>
        </div>
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
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-text-muted hover:bg-background-light dark:hover:bg-[#1a2e21]" href="{{ route('species-id') }}">
                <span class="material-symbols-outlined">flutter_dash</span>
                <span class="text-sm font-medium">Species ID</span>
            </a>
        </div>
        <div class="mt-auto pt-6">
            <button class="w-full bg-primary text-background-dark font-bold py-3 rounded-lg flex items-center justify-center gap-2 text-sm shadow-sm hover:opacity-90 transition-opacity" type="button">
                <span class="material-symbols-outlined text-sm">download</span>
                Export Report
            </button>
        </div>
    </aside>
    <main class="flex-1 p-8 space-y-8 overflow-x-hidden">
        <div class="flex flex-wrap justify-between items-end gap-6">
            <div class="flex flex-col gap-2">
                <h1 class="text-4xl font-black text-[#111813] dark:text-white leading-tight tracking-tight">Eco System Translator</h1>
                <p class="text-text-muted text-lg font-medium">Visual bird species tracking and identification dashboard</p>
            </div>
            <div class="flex gap-3">
                <div class="flex items-center gap-2 bg-white dark:bg-[#1a2e21] border border-border-muted dark:border-[#2a3a2e] px-4 py-2 rounded-lg">
                    <span class="size-2 bg-primary rounded-full animate-pulse"></span>
                    <span class="text-sm font-bold">Live Monitoring Active</span>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-2 rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-2">
                <span class="text-[10px] font-black uppercase tracking-widest text-text-muted px-2">Area Type</span>
                <button type="button" class="px-3 py-1.5 rounded-lg text-xs font-black"
                        :class="zoneFilter === 'all' ? 'bg-background-light dark:bg-background-dark/40' : 'hover:bg-background-light dark:hover:bg-background-dark/40'"
                        @click="zoneFilter='all'">All</button>
                <button type="button" class="px-3 py-1.5 rounded-lg text-xs font-black"
                        :class="zoneFilter === 'forest' ? 'bg-background-light dark:bg-background-dark/40' : 'hover:bg-background-light dark:hover:bg-background-dark/40'"
                        @click="zoneFilter='forest'">Forest</button>
                <button type="button" class="px-3 py-1.5 rounded-lg text-xs font-black"
                        :class="zoneFilter === 'jungle' ? 'bg-background-light dark:bg-background-dark/40' : 'hover:bg-background-light dark:hover:bg-background-dark/40'"
                        @click="zoneFilter='jungle'">Jungle</button>
                <button type="button" class="px-3 py-1.5 rounded-lg text-xs font-black"
                        :class="zoneFilter === 'dust' ? 'bg-background-light dark:bg-background-dark/40' : 'hover:bg-background-light dark:hover:bg-background-dark/40'"
                        @click="zoneFilter='dust'">Dust</button>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-text-muted font-bold">Live refresh:</span>
                <span class="text-xs font-black" x-text="lastUpdatedLabel"></span>
            </div>
        </div>

        <section class="bg-white dark:bg-[#1a2e21] p-6 rounded-xl border border-border-muted dark:border-[#2a3a2e]">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="text-sm font-black">Firebase Realtime Database Test</h3>
                    <p class="text-xs text-text-muted">Mock ESP32 telemetry бичиж/уншаад холболтоо dashboard дээр шууд шалгана.</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-black"
                      :class="firebaseStatus === 'connected' ? 'bg-primary/20 text-[#111813]' : (firebaseStatus === 'error' ? 'bg-red-500/20 text-red-600' : 'bg-background-light dark:bg-background-dark/40')"
                      x-text="firebaseStatusLabel()"></span>
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-5 gap-3">
                <label class="flex flex-col gap-1 text-xs font-bold text-text-muted">
                    Device ID
                    <input type="text" x-model.trim="mockDeviceId" class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 px-3 py-2 text-sm font-semibold text-[#111813] dark:text-white focus:ring-0" placeholder="esp32-001" />
                </label>
                <label class="flex flex-col gap-1 text-xs font-bold text-text-muted">
                    Sound (dB)
                    <input type="number" x-model.number="mockSoundDb" class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 px-3 py-2 text-sm font-semibold text-[#111813] dark:text-white focus:ring-0" />
                </label>
                <label class="flex flex-col gap-1 text-xs font-bold text-text-muted">
                    Temperature (°C)
                    <input type="number" x-model.number="mockTemperatureC" class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 px-3 py-2 text-sm font-semibold text-[#111813] dark:text-white focus:ring-0" />
                </label>
                <label class="flex flex-col gap-1 text-xs font-bold text-text-muted">
                    Latitude
                    <input type="number" step="any" x-model.number="mockLatitude" class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 px-3 py-2 text-sm font-semibold text-[#111813] dark:text-white focus:ring-0" />
                </label>
                <label class="flex flex-col gap-1 text-xs font-bold text-text-muted">
                    Longitude
                    <input type="number" step="any" x-model.number="mockLongitude" class="rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 px-3 py-2 text-sm font-semibold text-[#111813] dark:text-white focus:ring-0" />
                </label>
            </div>

            <div class="mt-4 flex flex-wrap gap-2">
                <button type="button" class="px-4 py-2 rounded-lg bg-[#111813] text-white text-xs font-black hover:bg-black" @click="testFirebaseConnection()" :disabled="firebaseBusy">
                    Test Connection
                </button>
                <button type="button" class="px-4 py-2 rounded-lg bg-primary text-[#111813] text-xs font-black hover:opacity-90" @click="saveMockEsp32()" :disabled="firebaseBusy">
                    Save Mock ESP32
                </button>
                <button type="button" class="px-4 py-2 rounded-lg border border-border-muted dark:border-[#2a3a2e] text-xs font-black" @click="loadMockEsp32()" :disabled="firebaseBusy">
                    Load Latest
                </button>
            </div>

            <div class="mt-4 rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 p-3">
                <p class="text-[10px] uppercase tracking-widest font-black text-text-muted">Result</p>
                <p class="mt-2 text-xs font-semibold" x-text="firebaseMessage"></p>
                <template x-if="mockLatest">
                    <p class="mt-2 text-[11px] text-text-muted" x-text="`Latest => ${mockLatest.device_id} | ${mockLatest.sound_db} dB | ${mockLatest.temperature_c}°C | ${mockLatest.recorded_at}`"></p>
                </template>
            </div>
        </section>

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xl:col-span-8">
                <div class="bg-white dark:bg-[#1a2e21] p-2 rounded-xl border border-border-muted dark:border-[#2a3a2e] h-160 relative z-0 overflow-hidden group">
                    <div class="w-full h-full rounded-lg relative overflow-hidden">
                        <div x-ref="leafletMap" class="absolute inset-0"></div>
                        <div class="absolute top-3 left-3 rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-white/90 dark:bg-background-dark/80 backdrop-blur px-3 py-2">
                            <p class="text-[10px] font-black uppercase tracking-widest text-text-muted">Leaflet Map</p>
                            <p class="text-xs font-bold" x-text="`${visibleStations().length} station(s) shown`"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-4 space-y-6">
                <div class="bg-white dark:bg-[#1a2e21] p-6 rounded-xl border border-border-muted dark:border-[#2a3a2e]">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <h3 class="text-xs font-bold text-text-muted uppercase tracking-wider">Top Species Detected</h3>
                        <span class="text-[10px] font-black uppercase tracking-widest text-text-muted" x-text="zoneFilter === 'all' ? 'All Areas' : zoneFilter"></span>
                    </div>

                    <div class="space-y-3">
                        <template x-for="area in topSpeciesByArea()" :key="area.key">
                            <button type="button" class="w-full text-left p-4 rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 hover:border-primary transition-colors" @click="openStation(area.station)">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3 min-w-0">
                                        <div class="size-10 rounded-xl overflow-hidden border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-background-dark shrink-0">
                                            <img x-show="area.imageUrl" :src="area.imageUrl" alt="Bird" class="size-full object-cover" />
                                            <div x-show="!area.imageUrl" class="size-full flex items-center justify-center text-text-muted">
                                                <span class="material-symbols-outlined text-base">pets</span>
                                            </div>
                                        </div>
                                        <div class="min-w-0">
                                        <p class="text-[10px] font-black uppercase tracking-widest text-text-muted" x-text="area.label"></p>
                                        <p class="text-sm font-black truncate" x-text="area.speciesName"></p>
                                        <p class="text-[10px] text-text-muted truncate" x-text="area.speciesScientific"></p>
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="text-[10px] font-black uppercase tracking-widest text-text-muted">Confidence</p>
                                        <p class="text-sm font-black" x-text="area.confidence"></p>
                                    </div>
                                </div>
                                <div class="mt-3 flex flex-wrap items-center gap-2">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black"
                                          :class="area.status === 'Healthy' ? 'bg-primary/20 text-[#111813]' : 'bg-red-500/20 text-red-600'"
                                          x-text="area.status"></span>
                                    <span class="text-[10px] font-bold text-text-muted">Type:</span>
                                    <span class="text-[10px] font-black" x-text="area.zone"></span>
                                    <span class="text-[10px] font-bold text-text-muted">Temp:</span>
                                    <span class="text-[10px] font-black" x-text="area.temperature"></span>
                                    <span class="text-[10px] font-bold text-text-muted">Audio:</span>
                                    <span class="text-[10px] font-black" x-text="area.soundDb"></span>
                                </div>
                            </button>
                        </template>

                        <div x-show="topSpeciesByArea().length === 0" class="p-4 rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40">
                            <p class="text-xs font-bold">No stations in this area type.</p>
                            <p class="text-[10px] text-text-muted">Switch filter to view other zones.</p>
                        </div>
                    </div>
                </div>

                <div x-show="selectedStation" x-transition.opacity class="bg-white dark:bg-[#1a2e21] p-6 rounded-xl border border-border-muted dark:border-[#2a3a2e]">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-xs font-bold text-text-muted uppercase tracking-wider">Selected Area Summary</h3>
                            <p class="text-lg font-black mt-1" x-text="selectedStation?.area_label ?? '—'"></p>
                            <p class="text-xs text-text-muted" x-text="selectedStation?.area ?? ''"></p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black"
                              :class="(selectedStation?.ml?.status === 'Healthy') ? 'bg-primary/20 text-[#111813]' : 'bg-red-500/20 text-red-600'"
                              x-text="selectedStation?.ml?.status ?? '—'"></span>
                    </div>

                    <div class="mt-5">
                        <p class="text-[10px] font-black uppercase tracking-widest text-text-muted">Birds in this Area</p>
                        <div class="mt-3 flex flex-wrap gap-3">
                            <template x-for="bird in areaBirds()" :key="bird.key">
                                <div class="flex items-center gap-2 rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark/40 px-3 py-2">
                                    <div class="size-9 rounded-lg overflow-hidden border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-background-dark">
                                        <img x-show="bird.imageUrl" :src="bird.imageUrl" alt="Bird" class="size-full object-cover" />
                                        <div x-show="!bird.imageUrl" class="size-full flex items-center justify-center text-text-muted">
                                            <span class="material-symbols-outlined text-sm">pets</span>
                                        </div>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-black truncate" x-text="bird.commonName"></p>
                                        <p class="text-[10px] text-text-muted truncate" x-text="bird.scientificName"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <div class="rounded-xl border border-border-muted dark:border-[#2a3a2e] p-3">
                            <p class="text-[10px] uppercase tracking-widest font-bold text-text-muted">Most Active Hour</p>
                            <p class="text-sm font-black" x-text="areaMostActiveHourLabel()"></p>
                            <p class="text-[10px] text-text-muted">(demo: derived from latest recorded_at)</p>
                        </div>
                        <div class="rounded-xl border border-border-muted dark:border-[#2a3a2e] p-3">
                            <p class="text-[10px] uppercase tracking-widest font-bold text-text-muted">Change vs Normal</p>
                            <p class="text-sm font-black" x-text="areaDeltaLabel()"></p>
                            <p class="text-[10px] text-text-muted">sound/temp/activity delta</p>
                        </div>
                    </div>

                    <div class="mt-5 rounded-xl border border-border-muted dark:border-[#2a3a2e] p-4">
                        <p class="text-[10px] uppercase tracking-widest font-bold text-text-muted">Detailed Conclusion</p>
                        <ul class="mt-3 space-y-2">
                            <template x-for="(line, idx) in areaConclusions()" :key="idx">
                                <li class="text-xs font-medium flex gap-2">
                                    <span class="material-symbols-outlined text-primary text-sm mt-0.5">check_circle</span>
                                    <span x-text="line"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#1a2e21] p-6 rounded-xl border border-border-muted dark:border-[#2a3a2e] flex flex-col items-center">
                    <h3 class="text-xs font-bold text-text-muted uppercase tracking-wider mb-6 self-start">Eco-Health Index Score</h3>
                    <div class="relative size-40">
                        <div class="rounded-full size-full p-4 bg-[conic-gradient(from_180deg_at_50%_50%,var(--color-primary)_0%,var(--color-primary)_88%,var(--color-border-muted)_88%,var(--color-border-muted)_100%)]">
                            <div class="bg-white dark:bg-[#1a2e21] rounded-full size-full flex flex-col items-center justify-center">
                                <span class="text-4xl font-black">88</span>
                                <span class="text-[10px] font-bold text-primary uppercase">Optimal</span>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 w-full mt-6 gap-4 border-t border-border-muted dark:border-[#2a3a2e] pt-6">
                        <div class="text-center">
                            <p class="text-[10px] text-text-muted uppercase font-bold">Varieties</p>
                            <p class="text-xl font-bold">24</p>
                        </div>
                        <div class="text-center border-l border-border-muted dark:border-[#2a3a2e]">
                            <p class="text-[10px] text-text-muted uppercase font-bold">Signals/hr</p>
                            <p class="text-xl font-bold">1.2k</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#1a2e21] rounded-xl border border-border-muted dark:border-[#2a3a2e] overflow-hidden">
                    <div class="p-4 border-b border-border-muted dark:border-[#2a3a2e] flex items-center justify-between bg-gray-50 dark:bg-white/5">
                        <h3 class="font-bold text-sm">Live Signals</h3>
                        <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full">3 Alert</span>
                    </div>
                    <div class="divide-y divide-border-muted dark:divide-[#2a3a2e]">
                        <div class="p-4 flex gap-3 hover:bg-background-light dark:hover:bg-white/5 cursor-pointer">
                            <span class="material-symbols-outlined text-red-500">warning</span>
                            <div>
                                <p class="text-xs font-bold">Signal Drop - AMZ-042</p>
                                <p class="text-[10px] text-text-muted">2m ago</p>
                            </div>
                        </div>
                        <div class="p-4 flex gap-3 hover:bg-background-light dark:hover:bg-white/5 cursor-pointer">
                            <span class="material-symbols-outlined text-orange-500">sensors</span>
                            <div>
                                <p class="text-xs font-bold">Migration Pattern Shift</p>
                                <p class="text-[10px] text-text-muted">14m ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#1a2e21] p-8 rounded-xl border border-border-muted dark:border-[#2a3a2e]">
            <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold">6-Month Historical Trends</h2>
                    <p class="text-text-muted text-sm font-medium">Tracking ecosystem translation data over the last half year</p>
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
                    <h4 class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2">Translation Insight</h4>
                    <p class="text-sm font-medium">Acoustic translations indicate 12% rise in canopy-level interactions during peak dawn hours.</p>
                </div>
                <div class="p-5 rounded-xl bg-background-light dark:bg-background-dark/30 border border-border-muted dark:border-white/5">
                    <h4 class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2">Stability Report</h4>
                    <p class="text-sm font-medium">Eco-health metrics maintained 88% stability despite heavy seasonal rainfall events.</p>
                </div>
                <div class="p-5 rounded-xl bg-background-light dark:bg-background-dark/30 border border-border-muted dark:border-white/5">
                    <h4 class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2">Migration Hubs</h4>
                    <p class="text-sm font-medium">North Sector 4 identified as primary migratory corridor for 18 specific species.</p>
                </div>
            </div>
        </div>

        <section id="future-predict" class="bg-white dark:bg-[#1a2e21] p-8 rounded-xl border border-border-muted dark:border-[#2a3a2e]">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black">Future Predict</h2>
                    <p class="text-text-muted text-sm font-medium">Dashboard доош гүйлгэхэд харагдах (full page: Trends)</p>
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
                    <p class="text-xs text-text-muted mt-2">ESP32 / INMP441 өгөгдөл (sound_db, dominant_hz, temperature) тогтмол ирэх тусам энэ хэсгийн дүгнэлт илүү нарийвчлалтай болно.</p>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">settings</span>
                        <p class="text-xs font-bold">Tip: `recorded_at`-г илгээвэл хамгийн идэвхтэй цаг бодно.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<!-- Station modal (Alpine.js) -->
<div
    x-show="modalOpen"
    x-transition.opacity
    style="display: none"
    class="fixed inset-0 z-60 flex items-center justify-center p-4"
    aria-modal="true"
    role="dialog"
>
    <div class="absolute inset-0 bg-black/50" @click="closeModal()"></div>

    <div
        x-show="modalOpen"
        x-transition
        class="relative w-full max-w-lg rounded-2xl bg-white dark:bg-background-dark border border-border-muted dark:border-[#2a3a2e] shadow-2xl overflow-hidden"
    >
        <div class="p-5 border-b border-border-muted dark:border-[#2a3a2e] flex items-start justify-between gap-4">
            <div class="min-w-0">
                <p class="text-[10px] uppercase tracking-[0.2em] font-bold text-accent-blue">Station Analytics</p>
                <h3 class="text-xl font-black truncate" x-text="selectedStation ? `${selectedStation.label}: ${selectedStation.id}` : 'Station'"></h3>
                <p class="text-xs text-text-muted" x-text="selectedStation ? selectedStation.area : ''"></p>
            </div>
            <button
                type="button"
                class="p-2 rounded-lg hover:bg-background-light dark:hover:bg-white/5"
                @click="closeModal()"
            >
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="p-5 space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="rounded-xl border border-border-muted dark:border-[#2a3a2e] p-3">
                    <p class="text-[10px] uppercase tracking-widest font-bold text-text-muted">MCU</p>
                    <p class="text-sm font-bold" x-text="selectedStation?.hardware?.mcu ?? '—'"></p>
                </div>
                <div class="rounded-xl border border-border-muted dark:border-[#2a3a2e] p-3">
                    <p class="text-[10px] uppercase tracking-widest font-bold text-text-muted">Microphone</p>
                    <p class="text-sm font-bold" x-text="selectedStation?.hardware?.mic ?? '—'"></p>
                </div>
                <div class="rounded-xl border border-border-muted dark:border-[#2a3a2e] p-3">
                    <p class="text-[10px] uppercase tracking-widest font-bold text-text-muted">Temperature</p>
                    <p class="text-sm font-bold"><span x-text="selectedStation?.telemetry?.temperature_c ?? '—'"></span>°C</p>
                </div>
            </div>

            <div class="rounded-xl border border-border-muted dark:border-[#2a3a2e] p-4">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="size-12 rounded-xl overflow-hidden border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-background-dark shrink-0">
                            <img x-show="selectedStation?.ml?.species?.image_url" :src="selectedStation?.ml?.species?.image_url" alt="Bird" class="size-full object-cover" />
                            <div x-show="!selectedStation?.ml?.species?.image_url" class="size-full flex items-center justify-center text-text-muted">
                                <span class="material-symbols-outlined">pets</span>
                            </div>
                        </div>
                        <div class="min-w-0">
                        <p class="text-[10px] uppercase tracking-widest font-bold text-text-muted">Bird Identification (Edge AI)</p>
                        <p class="text-sm font-black truncate" x-text="selectedStation?.ml?.species?.common_name ?? '—'"></p>
                        <p class="text-[10px] text-text-muted" x-text="selectedStation?.ml?.species?.scientific_name ?? ''"></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] uppercase tracking-widest font-bold text-text-muted">Confidence</p>
                        <p class="text-lg font-black"><span x-text="selectedStation?.ml?.confidence_pct ?? '—'"></span>%</p>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap gap-2 items-center">
                    <span
                        class="px-2.5 py-1 rounded-full text-[10px] font-black"
                        :class="(selectedStation?.ml?.status === 'Healthy') ? 'bg-primary/20 text-[#111813]' : 'bg-red-500/20 text-red-600'"
                        x-text="selectedStation?.ml?.status ?? '—'"
                    ></span>
                    <span class="text-[10px] font-bold text-text-muted">Eco score:</span>
                    <span class="text-[10px] font-black" x-text="selectedStation?.ml?.eco_score ?? '—'"></span>
                    <span class="text-[10px] font-bold text-text-muted">Activity:</span>
                    <span class="text-[10px] font-black"><span x-text="selectedStation?.ml?.activity_det_per_hr ?? '—'"></span> det/hr</span>
                </div>

                <div class="mt-4 rounded-lg border border-border-muted dark:border-[#2a3a2e] bg-white/60 dark:bg-background-dark/40 p-3">
                    <p class="text-[10px] uppercase tracking-widest font-bold text-text-muted">Why this status?</p>
                    <ul class="mt-2 space-y-1">
                        <template x-for="(line, idx) in stationConclusions(selectedStation)" :key="idx">
                            <li class="text-xs text-text-muted"><span class="font-bold text-[#111813] dark:text-white" x-text="'• ' + line"></span></li>
                        </template>
                    </ul>
                </div>
            </div>

            <div class="flex items-center justify-between gap-3 rounded-xl bg-background-light dark:bg-white/5 border border-border-muted dark:border-[#2a3a2e] p-4">
                <div class="text-xs text-text-muted">
                    <p class="font-bold">Location</p>
                    <p class="tabular-nums" x-text="selectedStation ? `${selectedStation.coordinates.lat}, ${selectedStation.coordinates.lng}` : ''"></p>
                </div>
                <a
                    class="px-4 py-2 rounded-lg bg-[#111813] text-white text-xs font-black hover:bg-black transition-colors flex items-center gap-2"
                    href="{{ route('live') }}"
                >
                    <span class="material-symbols-outlined text-sm">hearing</span>
                    Listen
                </a>
            </div>
        </div>
    </div>
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

            firebaseStatus: 'idle',
            firebaseBusy: false,
            firebaseMessage: 'Ready to test Firebase connection.',
            firebaseAutoSyncEnabled: true,
            mockDeviceId: 'esp32-001',
            mockSoundDb: 61,
            mockTemperatureC: 27.4,
            mockLatitude: -3.32,
            mockLongitude: -62.02,
            mockLatest: null,

            init() {
                this.lastUpdatedAt = new Date();
                this.$nextTick(() => this.initLeaflet());
                this.startPolling();
            },

            firebaseStatusLabel() {
                if (this.firebaseStatus === 'connected') return 'Firebase Connected';
                if (this.firebaseStatus === 'error') return 'Firebase Error';
                if (this.firebaseStatus === 'testing') return 'Testing...';
                return 'Not Tested';
            },

            get lastUpdatedLabel() {
                if (!this.lastUpdatedAt) return '—';
                return this.lastUpdatedAt.toLocaleTimeString();
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
                this.modalOpen = true;

                if (this.map && station?.coordinates?.lat != null && station?.coordinates?.lng != null) {
                    this.map.flyTo([station.coordinates.lat, station.coordinates.lng], Math.max(this.map.getZoom(), 9), { duration: 0.6 });
                }
            },

            closeModal() {
                this.modalOpen = false;
                this.selectedStation = null;
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
                        this.stations = await this.mergeWithFirebaseStations(stations);
                        this.lastUpdatedAt = new Date();

                        this.refreshLeafletMarkers(false);

                        if (this.modalOpen && this.selectedStation?.id) {
                            const selectedId = this.stationId(this.selectedStation);
                            const updated = this.stations.find((s) => this.stationId(s) === selectedId);
                            if (updated) this.selectedStation = updated;
                        }
                    }
                } catch (e) {
                    // ignore transient network errors
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

            defaultMockCoordinates(deviceId) {
                const seed = String(deviceId || 'esp32').split('').reduce((acc, ch) => acc + ch.charCodeAt(0), 0);
                return {
                    lat: -3.2 - ((seed % 40) / 100),
                    lng: -62.0 + ((seed % 50) / 100),
                };
            },

            createStationFromMock(deviceId, latest) {
                const fallback = this.defaultMockCoordinates(deviceId);
                const lat = Number(latest?.coordinates?.lat);
                const lng = Number(latest?.coordinates?.lng);

                return {
                    id: deviceId,
                    label: latest?.label || deviceId,
                    area_label: latest?.area_label || `Mock ${deviceId}`,
                    zone: latest?.zone || 'forest',
                    area: latest?.area || 'Mock ESP32 Area',
                    coordinates: {
                        lat: Number.isFinite(lat) ? lat : fallback.lat,
                        lng: Number.isFinite(lng) ? lng : fallback.lng,
                    },
                    hardware: {
                        mcu: 'ESP32',
                        mic: 'INMP441',
                    },
                    telemetry: {
                        temperature_c: Number(latest?.temperature_c ?? latest?.telemetry?.temperature_c ?? 0),
                        sound_db: Number(latest?.sound_db ?? latest?.telemetry?.sound_db ?? 0),
                        dominant_hz: Number(latest?.dominant_hz ?? latest?.telemetry?.dominant_hz ?? 0),
                        recorded_at: latest?.recorded_at || new Date().toISOString(),
                    },
                    baseline: {
                        temperature_c: 27,
                        sound_db: 60,
                        activity_det_per_hr: 65,
                    },
                    ml: {
                        status: 'Healthy',
                        eco_score: 82,
                        confidence_pct: 89,
                        activity_det_per_hr: 72,
                        species: {
                            common_name: 'Mock Bird',
                            scientific_name: 'Aves mockus',
                            image_url: '',
                        },
                        recorded_at: latest?.recorded_at || new Date().toISOString(),
                    },
                    status: 'online',
                };
            },

            async fetchFirebaseMockStations() {
                const handles = this.getFirebaseHandles();
                if (!handles) return [];
                if (!this.firebaseAutoSyncEnabled) return [];

                try {
                    const rootRef = handles.ref(handles.db, 'esp32_mock');
                    const rootSnap = await this.withTimeout(handles.get(rootRef), 'Fetch mock stations', 4000);
                    if (!rootSnap.exists()) return [];

                    const rows = rootSnap.val() || {};
                    return Object.entries(rows).map(([deviceId, value]) => {
                        const latest = value?.latest || value;
                        return this.createStationFromMock(deviceId, latest);
                    });
                } catch (error) {
                    const message = String(error?.message || '');
                    if (message.includes('ERR_NAME_NOT_RESOLVED') || message.includes('timeout')) {
                        this.firebaseAutoSyncEnabled = false;
                    }
                    return [];
                }
            },

            async mergeWithFirebaseStations(apiStations) {
                const firebaseStations = await this.fetchFirebaseMockStations();
                return this.uniqueStations([...(Array.isArray(apiStations) ? apiStations : []), ...firebaseStations]);
            },

            getFirebaseHandles() {
                const db = window.firebaseDatabase;
                const ref = window.firebaseRef;
                const set = window.firebaseSet;
                const get = window.firebaseGet;
                const child = window.firebaseChild;
                const push = window.firebasePush;

                if (!db || !ref || !set || !get || !child || !push) {
                    return null;
                }

                return { db, ref, set, get, child, push };
            },

            async withTimeout(promise, label, timeoutMs = 10000) {
                let timerId;

                const timeoutPromise = new Promise((_, reject) => {
                    timerId = setTimeout(() => {
                        reject(new Error(`${label} timeout (${Math.round(timeoutMs / 1000)}s). Firebase URL / Rules шалгана уу.`));
                    }, timeoutMs);
                });

                try {
                    return await Promise.race([promise, timeoutPromise]);
                } finally {
                    clearTimeout(timerId);
                }
            },

            async testFirebaseConnection() {
                const handles = this.getFirebaseHandles();
                if (!handles) {
                    this.firebaseStatus = 'error';
                    this.firebaseMessage = 'Firebase config дутуу байна. `.env` дээр VITE_FIREBASE_* утгуудыг шалгана уу.';
                    return;
                }

                this.firebaseBusy = true;
                this.firebaseStatus = 'testing';
                this.firebaseAutoSyncEnabled = true;

                try {
                    const pingRef = handles.ref(handles.db, 'healthcheck/dashboard_ping');
                    const payload = {
                        source: 'dashboard',
                        ts: new Date().toISOString(),
                        ok: true,
                    };

                    await this.withTimeout(handles.set(pingRef, payload), 'Test write');
                    const snap = await this.withTimeout(handles.get(pingRef), 'Test read');

                    if (!snap.exists()) {
                        throw new Error('healthcheck өгөгдөл олдсонгүй');
                    }

                    this.firebaseStatus = 'connected';
                    this.firebaseMessage = `Connection OK: ${snap.val().ts}`;
                } catch (error) {
                    this.firebaseStatus = 'error';
                    this.firebaseMessage = `Connection failed: ${error?.message || 'Unknown error'}`;
                } finally {
                    this.firebaseBusy = false;
                }
            },

            buildMockPayload() {
                const deviceId = this.mockDeviceId || 'esp32-001';
                const soundDb = Number(this.mockSoundDb);
                const temperatureC = Number(this.mockTemperatureC);
                const latitude = Number(this.mockLatitude);
                const longitude = Number(this.mockLongitude);
                const dominantHz = Math.round(1800 + Math.random() * 2200);
                const fallbackCoords = this.defaultMockCoordinates(deviceId);

                return {
                    device_id: deviceId,
                    label: deviceId,
                    area_label: `Mock ${deviceId}`,
                    zone: 'forest',
                    area: 'Mock ESP32 Area',
                    sound_db: Number.isFinite(soundDb) ? soundDb : 60,
                    temperature_c: Number.isFinite(temperatureC) ? temperatureC : 27,
                    dominant_hz: dominantHz,
                    coordinates: {
                        lat: Number.isFinite(latitude) ? latitude : fallbackCoords.lat,
                        lng: Number.isFinite(longitude) ? longitude : fallbackCoords.lng,
                    },
                    recorded_at: new Date().toISOString(),
                    source: 'web-dashboard-mock',
                };
            },

            async saveMockEsp32() {
                const handles = this.getFirebaseHandles();
                if (!handles) {
                    this.firebaseStatus = 'error';
                    this.firebaseMessage = 'Firebase config дутуу байна. `.env` дээр VITE_FIREBASE_* утгуудыг шалгана уу.';
                    return;
                }

                this.firebaseBusy = true;
                this.firebaseAutoSyncEnabled = true;
                try {
                    const payload = this.buildMockPayload();
                    const basePath = `esp32_mock/${payload.device_id}`;
                    const latestRef = handles.ref(handles.db, `${basePath}/latest`);
                    const historyRef = handles.ref(handles.db, `${basePath}/history`);

                    await this.withTimeout(handles.set(latestRef, payload), 'Save latest');
                    await this.withTimeout(handles.push(historyRef, payload), 'Save history');

                    this.mockLatest = payload;
                    this.stations = await this.mergeWithFirebaseStations(this.stations);
                    this.refreshLeafletMarkers(true);
                    this.firebaseStatus = 'connected';
                    this.firebaseMessage = `Saved mock data for ${payload.device_id}`;
                } catch (error) {
                    this.firebaseStatus = 'error';
                    this.firebaseMessage = `Save failed: ${error?.message || 'Unknown error'}`;
                } finally {
                    this.firebaseBusy = false;
                }
            },

            async loadMockEsp32() {
                const handles = this.getFirebaseHandles();
                if (!handles) {
                    this.firebaseStatus = 'error';
                    this.firebaseMessage = 'Firebase config дутуу байна. `.env` дээр VITE_FIREBASE_* утгуудыг шалгана уу.';
                    return;
                }

                this.firebaseBusy = true;
                this.firebaseAutoSyncEnabled = true;
                try {
                    const deviceId = this.mockDeviceId || 'esp32-001';
                    const latestRef = handles.ref(handles.db, `esp32_mock/${deviceId}/latest`);
                    const snap = await this.withTimeout(handles.get(latestRef), 'Load latest');

                    if (!snap.exists()) {
                        this.mockLatest = null;
                        this.firebaseStatus = 'connected';
                        this.firebaseMessage = `No data found for ${deviceId}`;
                        return;
                    }

                    this.mockLatest = snap.val();
                    if (this.mockLatest?.coordinates?.lat != null) this.mockLatitude = Number(this.mockLatest.coordinates.lat);
                    if (this.mockLatest?.coordinates?.lng != null) this.mockLongitude = Number(this.mockLatest.coordinates.lng);
                    if (this.mockLatest?.temperature_c != null) this.mockTemperatureC = Number(this.mockLatest.temperature_c);
                    if (this.mockLatest?.sound_db != null) this.mockSoundDb = Number(this.mockLatest.sound_db);

                    this.stations = await this.mergeWithFirebaseStations(this.stations);
                    this.refreshLeafletMarkers(true);
                    this.firebaseStatus = 'connected';
                    this.firebaseMessage = `Loaded latest data for ${deviceId}`;
                } catch (error) {
                    this.firebaseStatus = 'error';
                    this.firebaseMessage = `Load failed: ${error?.message || 'Unknown error'}`;
                } finally {
                    this.firebaseBusy = false;
                }
            },

            initLeaflet() {
                if (!window.L || !this.$refs.leafletMap) return;
                if (this.map) return;

                const L = window.L;
                this.map = L.map(this.$refs.leafletMap, {
                    zoomControl: true,
                    attributionControl: true,
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors',
                }).addTo(this.map);

                this.markerLayer = L.layerGroup().addTo(this.map);

                this.refreshLeafletMarkers(true);
            },

            refreshLeafletMarkers(fit) {
                if (!this.map || !this.markerLayer || !window.L) return;
                const L = window.L;

                this.markerLayer.clearLayers();

                const visible = this.visibleStations();
                const bounds = [];

                visible.forEach((station, idx) => {
                    const lat = station?.coordinates?.lat;
                    const lng = station?.coordinates?.lng;
                    if (lat == null || lng == null) return;

                    const isHealthy = station?.ml?.status === 'Healthy';
                    const bg = isHealthy ? 'var(--color-primary)' : 'rgb(239 68 68)';

                    const icon = L.divIcon({
                        className: '',
                        html: `
                            <div style="width:28px;height:28px;border-radius:9999px;display:flex;align-items:center;justify-content:center;border:2px solid white;background:${bg};box-shadow:0 10px 15px -3px rgba(0,0,0,.25);font-weight:800;color:white;font-size:11px;">
                                ${idx + 1}
                            </div>
                        `,
                        iconSize: [28, 28],
                        iconAnchor: [14, 14],
                    });

                    const marker = L.marker([lat, lng], { icon });
                    marker.on('click', () => this.openStation(station));
                    marker.addTo(this.markerLayer);
                    bounds.push([lat, lng]);
                });

                if (fit && bounds.length) {
                    this.map.fitBounds(bounds, { padding: [24, 24] });
                }

                if (fit && !bounds.length) {
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
                    if (delta <= -8) lines.push(`Шувууны дууны хүч хэвийнээс бага байна (${Math.round(delta)} dB).`);
                    if (delta >= 8) lines.push(`Шувууны дууны хүч хэвийнээс өндөр байна (+${Math.round(delta)} dB).`);
                }

                const temp = Number(station?.telemetry?.temperature_c);
                const tempBase = Number(station?.baseline?.temperature_c);
                if (Number.isFinite(temp) && Number.isFinite(tempBase)) {
                    const delta = temp - tempBase;
                    if (delta >= 2.0) lines.push(`Температур хэвийнээс өндөр байна (+${Math.round(delta * 10) / 10}°C).`);
                    if (delta <= -2.0) lines.push(`Температур хэвийнээс бага байна (${Math.round(delta * 10) / 10}°C).`);
                }

                const eco = Number(station?.ml?.eco_score);
                if (Number.isFinite(eco) && eco < 70) lines.push('Eco-score буурсан (стресс/орчны өөрчлөлт байж болно).');

                const rssi = Number(station?.telemetry?.rssi_dbm);
                if (Number.isFinite(rssi) && rssi < -75) lines.push('Сүлжээ сул (RSSI бага) — өгөгдөл тасалдах магадлалтай.');

                const batt = Number(station?.telemetry?.battery_v);
                if (Number.isFinite(batt) && batt < 3.6) lines.push('Battery бага — мэдрэгчийн тогтвортой байдалд нөлөөлнө.');

                if (!lines.length) lines.push('Одоогийн өгөгдлөөр томоохон асуудал илрээгүй.');
                return lines;
            },

            areaConclusions() {
                const stations = this.areaStations();
                if (!stations.length) return [];

                const warningCount = stations.filter((s) => s?.ml?.status === 'Warning').length;
                const healthyCount = stations.filter((s) => s?.ml?.status === 'Healthy').length;
                const birds = this.areaBirds().map((b) => b.commonName).slice(0, 4);

                const lines = [];
                lines.push(`Энэ бүсэд Healthy: ${healthyCount}, Warning: ${warningCount}.`);
                if (birds.length) lines.push(`Илэрсэн шувууд: ${birds.join(', ')}.`);

                const deltas = this.areaDeltaLabel();
                if (deltas !== '—') lines.push(`Хэвийн хэмжээнээс өөрчлөлт: ${deltas}.`);
                lines.push('Дүгнэлт нь сүүлийн live telemetry/AI detection дээр тулгуурлана.');
                return lines;
            },

            futureHeadline() {
                const stations = this.visibleStations();
                const avgEco = stations.length
                    ? Math.round(stations.reduce((a, s) => a + Number(s?.ml?.eco_score ?? 0), 0) / stations.length)
                    : 0;

                if (!stations.length) {
                    return { title: 'No live stations', detail: 'API-аас станцын өгөгдөл ирээгүй байна.' };
                }

                if (avgEco >= 80) {
                    return { title: 'Тогтвортой 24 цаг', detail: `Дундаж eco-score ~${avgEco}. Идэвхжил хэвийн түвшинд хадгалагдана.` };
                }

                if (avgEco >= 65) {
                    return { title: 'Дунд эрсдэл', detail: `Дундаж eco-score ~${avgEco}. Температур/дууны хэлбэлзэл нэмэгдэх магадлалтай.` };
                }

                return { title: 'Анхаарах шаардлагатай', detail: `Дундаж eco-score ~${avgEco}. Орчны стресс/идэвхжил бууралт ажиглагдаж болзошгүй.` };
            },

            futureDrivers() {
                const stations = this.visibleStations();
                const drivers = [];

                const warnings = stations.filter((s) => s?.ml?.status === 'Warning').length;
                if (warnings) drivers.push(`Warning статус: ${warnings} станц.`);

                const lowSound = stations.filter((s) => {
                    const sound = Number(s?.telemetry?.sound_db);
                    const base = Number(s?.baseline?.sound_db);
                    return Number.isFinite(sound) && Number.isFinite(base) && (sound - base) <= -8;
                }).length;
                if (lowSound) drivers.push(`Хэвийнээс сул дуу: ${lowSound} станц.`);

                const highTemp = stations.filter((s) => {
                    const t = Number(s?.telemetry?.temperature_c);
                    const base = Number(s?.baseline?.temperature_c);
                    return Number.isFinite(t) && Number.isFinite(base) && (t - base) >= 2;
                }).length;
                if (highTemp) drivers.push(`Хэвийнээс өндөр температур: ${highTemp} станц.`);

                if (!drivers.length) drivers.push('Одоогийн өгөгдлөөр хүчтэй эрсдэл илрээгүй.');
                return drivers.slice(0, 4);
            },
        }));
    });
</script>
</html>
