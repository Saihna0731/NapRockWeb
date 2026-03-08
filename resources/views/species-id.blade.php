<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EST | Species ID</title>

    @vite('resources/js/app.js')

    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#111813] dark:text-white transition-colors duration-200 font-display">
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-border-muted dark:border-[#2a3a2e] px-8 py-3 bg-white dark:bg-background-dark sticky top-0 z-50">
    <div class="flex items-center gap-8">
        <div class="flex items-center gap-3">
            <a class="flex items-center justify-center size-10 bg-primary rounded-lg text-background-dark font-black text-lg" href="{{ route('home') }}">EST</a>
            <h2 class="text-xl font-bold leading-tight tracking-tight">Species ID</h2>
        </div>
        <nav class="hidden md:flex items-center gap-6">
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('gis') }}">GIS Map</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('historical') }}">Historical</a>
            <a class="text-[#111813] dark:text-white text-sm font-semibold border-b-2 border-primary pb-1" href="{{ route('species-id') }}">Species ID</a>
        </nav>
    </div>
</header>

<main class="p-6 md:p-8 space-y-6" x-data="speciesCatalog()" x-init="init()">

    {{-- ══ Page header + stats ══ --}}
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black tracking-tight">Bird Species Catalog</h1>
            <p class="text-text-muted text-sm font-medium">
                Realtime species detected by ESP32 sensors — auto-saved
            </p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Search --}}
            <label class="flex items-center gap-2 rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] px-4 py-2">
                <span class="material-symbols-outlined text-text-muted text-sm">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-sm w-48 md:w-64 placeholder-text-muted" placeholder="Search species..." x-model="query" />
            </label>
            {{-- Clear catalog --}}
            <button @click="if(confirm('Clear all saved species?')) clearCatalog()"
                    class="flex items-center gap-1.5 px-3 py-2 rounded-xl border border-red-200 dark:border-red-900/40 text-red-500 text-xs font-bold hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                <span class="material-symbols-outlined text-sm">delete</span>
                Clear
            </button>
        </div>
    </div>

    {{-- ══ Live detection banner ══ --}}
    <div class="rounded-2xl border-2 border-primary/30 bg-gradient-to-r from-primary/5 to-transparent p-5">
        <div class="flex items-center gap-3 mb-4">
            <span class="relative flex size-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                <span class="relative inline-flex rounded-full size-2.5 bg-primary"></span>
            </span>
            <h2 class="text-sm font-black uppercase tracking-widest text-primary">Live Detection</h2>
            <span class="text-[10px] text-text-muted ml-auto" x-text="deviceId ? ('Sensor: ' + deviceId) : 'Connecting...'"></span>
        </div>

        <template x-if="liveTopk.length > 0">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                <template x-for="(pred, idx) in liveTopk" :key="pred.species + '-' + idx">
                    <div class="flex items-center gap-3 bg-white dark:bg-[#1a2e21] rounded-xl border border-border-muted dark:border-[#2a3a2e] p-3 transition-all"
                         :class="idx === 0 ? 'ring-2 ring-primary/40' : ''">
                        <div class="size-12 rounded-lg overflow-hidden border border-border-muted dark:border-[#2a3a2e] bg-background-light dark:bg-background-dark shrink-0">
                            <img x-show="pred.image_url" :src="pred.image_url" alt="" class="size-full object-cover"/>
                            <div x-show="!pred.image_url" class="size-full flex items-center justify-center text-text-muted">
                                <span class="material-symbols-outlined text-lg">flutter_dash</span>
                            </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-black truncate" x-text="pred.species || 'Unknown'"></p>
                            <p class="text-[10px] text-text-muted italic truncate" x-text="pred.scientific_name || ''"></p>
                            <div class="mt-1 flex items-center gap-2">
                                <div class="flex-1 h-1.5 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500"
                                         :class="pred.confidence_pct > 70 ? 'bg-primary' : pred.confidence_pct > 40 ? 'bg-yellow-500' : 'bg-red-400'"
                                         :style="'width:' + Math.round(pred.confidence_pct ?? 0) + '%'"></div>
                                </div>
                                <span class="text-[10px] font-black tabular-nums" x-text="Math.round(pred.confidence_pct ?? 0) + '%'"></span>
                            </div>
                        </div>
                        <template x-if="idx === 0">
                            <span class="shrink-0 px-1.5 py-0.5 rounded text-[8px] font-black bg-primary/20 text-primary uppercase">Top</span>
                        </template>
                    </div>
                </template>
            </div>
        </template>
        <template x-if="liveTopk.length === 0">
            <div class="flex items-center gap-3 text-text-muted">
                <span class="material-symbols-outlined animate-spin text-lg">progress_activity</span>
                <span class="text-sm">Waiting for species detection...</span>
            </div>
        </template>
    </div>

    {{-- ══ Stats row ══ --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-4">
            <p class="text-[10px] font-black uppercase tracking-widest text-text-muted">Total Species</p>
            <p class="text-2xl font-black mt-1" x-text="Object.keys(catalog).length"></p>
        </div>
        <div class="rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-4">
            <p class="text-[10px] font-black uppercase tracking-widest text-text-muted">Total Detections</p>
            <p class="text-2xl font-black mt-1" x-text="totalDetections"></p>
        </div>
        <div class="rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-4">
            <p class="text-[10px] font-black uppercase tracking-widest text-text-muted">Top Species</p>
            <p class="text-sm font-black mt-1 truncate" x-text="topSavedSpecies || '—'"></p>
        </div>
        <div class="rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-4">
            <p class="text-[10px] font-black uppercase tracking-widest text-text-muted">Avg Confidence</p>
            <p class="text-2xl font-black mt-1" x-text="avgConfidence + '%'"></p>
        </div>
    </div>

    {{-- ══ Saved Species Catalog Grid ══ --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-black">Saved Species
                <span class="text-sm font-medium text-text-muted ml-2" x-text="'(' + filteredCatalog().length + ')'"></span>
            </h2>
            <div class="flex items-center gap-2">
                <button @click="sortBy = 'recent'" class="px-3 py-1 rounded-lg text-xs font-bold transition-colors"
                        :class="sortBy === 'recent' ? 'bg-primary/20 text-primary' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-white/5'">
                    Recent
                </button>
                <button @click="sortBy = 'count'" class="px-3 py-1 rounded-lg text-xs font-bold transition-colors"
                        :class="sortBy === 'count' ? 'bg-primary/20 text-primary' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-white/5'">
                    Most Detected
                </button>
                <button @click="sortBy = 'confidence'" class="px-3 py-1 rounded-lg text-xs font-bold transition-colors"
                        :class="sortBy === 'confidence' ? 'bg-primary/20 text-primary' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-white/5'">
                    Confidence
                </button>
                <button @click="sortBy = 'alpha'" class="px-3 py-1 rounded-lg text-xs font-bold transition-colors"
                        :class="sortBy === 'alpha' ? 'bg-primary/20 text-primary' : 'text-text-muted hover:bg-gray-100 dark:hover:bg-white/5'">
                    A–Z
                </button>
            </div>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <template x-for="item in filteredCatalog()" :key="item.species">
                <div class="group rounded-2xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] overflow-hidden hover:shadow-lg hover:border-primary/30 transition-all duration-300">
                    {{-- Image --}}
                    <div class="relative aspect-[4/3] bg-background-light dark:bg-background-dark overflow-hidden">
                        <img x-show="item.imageUrl" :src="item.imageUrl" alt=""
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                        <div x-show="!item.imageUrl" class="w-full h-full flex items-center justify-center text-text-muted">
                            <span class="material-symbols-outlined text-5xl">flutter_dash</span>
                        </div>
                        {{-- Confidence badge --}}
                        <div class="absolute top-3 right-3 px-2 py-1 rounded-lg text-[10px] font-black backdrop-blur-md"
                             :class="item.bestConfidence > 70 ? 'bg-primary/80 text-white' : item.bestConfidence > 40 ? 'bg-yellow-500/80 text-white' : 'bg-red-400/80 text-white'">
                            <span x-text="item.bestConfidence + '%'"></span>
                        </div>
                        {{-- Detection count badge --}}
                        <div class="absolute top-3 left-3 px-2 py-1 rounded-lg text-[10px] font-black bg-black/50 text-white backdrop-blur-md flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">visibility</span>
                            <span x-text="item.count + 'x'"></span>
                        </div>
                    </div>
                    {{-- Info --}}
                    <div class="p-4">
                        <h3 class="text-sm font-black truncate" x-text="item.species"></h3>
                        <p class="text-[10px] text-text-muted italic truncate mt-0.5" x-text="item.scientificName || ''"></p>
                        <div class="mt-3 flex items-center justify-between">
                            <div class="flex items-center gap-1.5 text-[10px] text-text-muted">
                                <span class="material-symbols-outlined text-xs">schedule</span>
                                <span x-text="formatTime(item.firstSeen)"></span>
                            </div>
                            <div class="flex items-center gap-1.5 text-[10px] text-text-muted">
                                <span class="material-symbols-outlined text-xs">update</span>
                                <span x-text="formatTime(item.lastSeen)"></span>
                            </div>
                        </div>
                        {{-- Confidence bar --}}
                        <div class="mt-3 flex items-center gap-2">
                            <div class="flex-1 h-1.5 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500"
                                     :class="item.bestConfidence > 70 ? 'bg-primary' : item.bestConfidence > 40 ? 'bg-yellow-500' : 'bg-red-400'"
                                     :style="'width:' + item.bestConfidence + '%'"></div>
                            </div>
                            <span class="text-[10px] font-black tabular-nums shrink-0" x-text="'Best: ' + item.bestConfidence + '%'"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Empty state --}}
        <div x-show="filteredCatalog().length === 0" class="flex flex-col items-center justify-center py-16 text-center">
            <span class="material-symbols-outlined text-5xl text-text-muted mb-3">library_books</span>
            <p class="text-sm font-bold" x-text="query ? 'No species match your search' : 'No species saved yet'"></p>
            <p class="text-xs text-text-muted mt-1">Species will appear here as they are detected by sensors</p>
        </div>
    </div>
</main>

<script>
function speciesCatalog() {
    const STORAGE_KEY = 'est_species_catalog';
    const API_URL = 'https://bird-edge-api-879683801404.asia-east1.run.app/api/v1/sensor/latest';
    const API_KEY = 'birdedge_KfBfwrtXzd7IEeizQLc-iK9EVaJYzp1aJq_AK6p-qdU';

    return {
        query: '',
        sortBy: 'recent',
        catalog: {},           // { speciesName: { species, scientificName, imageUrl, bestConfidence, count, firstSeen, lastSeen } }
        liveTopk: [],
        deviceId: null,
        pollTimer: null,

        init() {
            this.loadCatalog();
            this.fetchApi();
            this.pollTimer = setInterval(() => this.fetchApi(), 3000);

            window.addEventListener('beforeunload', () => {
                if (this.pollTimer) clearInterval(this.pollTimer);
            });
        },

        // ── API polling ──
        async fetchApi() {
            try {
                const url = `${API_URL}?api_key=${API_KEY}`;
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) return;
                const data = await res.json();
                if (!data?.ok) return;

                this.deviceId = data.device_id || null;
                const topk = data.bird?.topk;

                if (Array.isArray(topk) && topk.length) {
                    this.liveTopk = topk;
                    this.saveDetections(topk);
                }
            } catch (e) {
                // ignore network errors
            }
        },

        // ── Save species to catalog ──
        saveDetections(topk) {
            const now = new Date().toISOString();
            let changed = false;

            for (const pred of topk) {
                const name = (pred.species || '').trim();
                if (!name) continue;

                const existing = this.catalog[name];
                if (existing) {
                    // Update existing entry
                    existing.count += 1;
                    existing.lastSeen = now;
                    if ((pred.confidence_pct ?? 0) > existing.bestConfidence) {
                        existing.bestConfidence = Math.round(pred.confidence_pct);
                    }
                    // Update image if we get one and didn't have one before
                    if (pred.image_url && !existing.imageUrl) {
                        existing.imageUrl = pred.image_url;
                    }
                    // Update scientific name if we get one
                    if (pred.scientific_name && !existing.scientificName) {
                        existing.scientificName = pred.scientific_name;
                    }
                } else {
                    // New species!
                    this.catalog[name] = {
                        species: name,
                        scientificName: pred.scientific_name || '',
                        imageUrl: pred.image_url || '',
                        bestConfidence: Math.round(pred.confidence_pct ?? 0),
                        count: 1,
                        firstSeen: now,
                        lastSeen: now,
                    };
                }
                changed = true;
            }

            if (changed) this.persistCatalog();
        },

        // ── LocalStorage ──
        loadCatalog() {
            try {
                const raw = localStorage.getItem(STORAGE_KEY);
                if (raw) {
                    this.catalog = JSON.parse(raw);
                }
            } catch (e) {
                this.catalog = {};
            }
        },

        persistCatalog() {
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(this.catalog));
            } catch (e) {
                // storage full — ignore
            }
        },

        clearCatalog() {
            this.catalog = {};
            localStorage.removeItem(STORAGE_KEY);
        },

        // ── Computed helpers ──
        get totalDetections() {
            return Object.values(this.catalog).reduce((sum, s) => sum + s.count, 0);
        },

        get topSavedSpecies() {
            const entries = Object.values(this.catalog);
            if (!entries.length) return null;
            return entries.reduce((a, b) => a.count > b.count ? a : b).species;
        },

        get avgConfidence() {
            const entries = Object.values(this.catalog);
            if (!entries.length) return 0;
            const sum = entries.reduce((s, e) => s + e.bestConfidence, 0);
            return Math.round(sum / entries.length);
        },

        filteredCatalog() {
            let items = Object.values(this.catalog);

            // Search filter
            if (this.query.trim()) {
                const q = this.query.trim().toLowerCase();
                items = items.filter(i =>
                    i.species.toLowerCase().includes(q) ||
                    (i.scientificName || '').toLowerCase().includes(q)
                );
            }

            // Sort
            switch (this.sortBy) {
                case 'recent':
                    items.sort((a, b) => new Date(b.lastSeen) - new Date(a.lastSeen));
                    break;
                case 'count':
                    items.sort((a, b) => b.count - a.count);
                    break;
                case 'confidence':
                    items.sort((a, b) => b.bestConfidence - a.bestConfidence);
                    break;
                case 'alpha':
                    items.sort((a, b) => a.species.localeCompare(b.species));
                    break;
            }

            return items;
        },

        formatTime(iso) {
            if (!iso) return '—';
            const d = new Date(iso);
            if (isNaN(d.getTime())) return '—';
            const now = new Date();
            const diff = now - d;

            // Today: show time
            if (d.toDateString() === now.toDateString()) {
                return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
            // Yesterday
            const yesterday = new Date(now);
            yesterday.setDate(yesterday.getDate() - 1);
            if (d.toDateString() === yesterday.toDateString()) {
                return 'Yesterday';
            }
            // Within 7 days
            if (diff < 7 * 24 * 60 * 60 * 1000) {
                return d.toLocaleDateString([], { weekday: 'short' });
            }
            // Older
            return d.toLocaleDateString([], { month: 'short', day: 'numeric' });
        },
    };
}
</script>
</body>
</html>
