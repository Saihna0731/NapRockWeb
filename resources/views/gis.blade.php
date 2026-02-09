<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EST | GIS Map</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            <h2 class="text-xl font-bold leading-tight tracking-tight">GIS Map</h2>
        </div>
        <nav class="hidden md:flex items-center gap-6">
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="text-[#111813] dark:text-white text-sm font-semibold border-b-2 border-primary pb-1" href="{{ route('gis') }}">GIS Map</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('historical') }}">Historical</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('species-id') }}">Species ID</a>
        </nav>
    </div>
</header>

<main class="p-8 space-y-6">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black tracking-tight">Station Coverage Map</h1>
            <p class="text-text-muted text-sm font-medium">Demo view (plug in real map tiles later)</p>
        </div>
        <div class="flex items-center gap-2 rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-2">
            <span class="text-[10px] font-black uppercase tracking-widest text-text-muted px-2">Zone</span>
            <button class="px-3 py-1.5 rounded-lg text-xs font-black bg-background-light dark:bg-background-dark/40">Forest</button>
            <button class="px-3 py-1.5 rounded-lg text-xs font-black hover:bg-background-light dark:hover:bg-background-dark/40">Jungle</button>
            <button class="px-3 py-1.5 rounded-lg text-xs font-black hover:bg-background-light dark:hover:bg-background-dark/40">Dust</button>
        </div>
    </div>

    <div class="rounded-2xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] overflow-hidden">
        <div class="h-[520px] bg-gradient-to-br from-background-light to-white dark:from-background-dark dark:to-[#1a2e21] relative">
            <div class="absolute inset-0 grid grid-cols-12 grid-rows-6 opacity-25 pointer-events-none">
                @for ($i = 0; $i < 72; $i++)
                    <div class="border-r border-b border-border-muted dark:border-[#2a3a2e]"></div>
                @endfor
            </div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center space-y-2">
                    <span class="material-symbols-outlined text-primary text-4xl">public</span>
                    <p class="text-sm font-bold">GIS Map Placeholder</p>
                    <p class="text-xs text-text-muted">Integrate Leaflet/Mapbox later (no Bootstrap)</p>
                </div>
            </div>
        </div>
        <div class="p-4 border-t border-border-muted dark:border-[#2a3a2e] flex items-center justify-between">
            <p class="text-xs text-text-muted font-medium">Tip: use station coordinates from the API for markers.</p>
            <a class="text-xs font-black text-primary hover:opacity-80" href="{{ route('dashboard') }}">Back to Dashboard</a>
        </div>
    </div>
</main>
</body>
</html>
