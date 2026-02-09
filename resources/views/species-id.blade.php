<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EST | Species ID</title>

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

<main class="p-8 space-y-6" x-data="{ query: '' }">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black tracking-tight">Bird Species Catalog</h1>
            <p class="text-text-muted text-sm font-medium">Demo catalog (connect to your ML output later)</p>
        </div>
        <label class="flex items-center gap-2 rounded-xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] px-4 py-2">
            <span class="material-symbols-outlined text-text-muted text-sm">search</span>
            <input class="bg-transparent border-none focus:ring-0 text-sm w-64 placeholder-text-muted" placeholder="Search species" x-model="query" />
        </label>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-2xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-5">
            <p class="text-xs font-black text-primary">TOP MATCH</p>
            <h3 class="text-lg font-black mt-1">Scarlet Macaw</h3>
            <p class="text-xs text-text-muted">Ara macao</p>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-widest text-text-muted">Confidence</span>
                <span class="text-sm font-black">96%</span>
            </div>
        </div>

        <div class="rounded-2xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-5">
            <p class="text-xs font-black text-accent-blue">RECENT</p>
            <h3 class="text-lg font-black mt-1">Keel-billed Toucan</h3>
            <p class="text-xs text-text-muted">Ramphastos sulfuratus</p>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-widest text-text-muted">Confidence</span>
                <span class="text-sm font-black">87%</span>
            </div>
        </div>

        <div class="rounded-2xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-5">
            <p class="text-xs font-black text-text-muted">DEMO</p>
            <h3 class="text-lg font-black mt-1">Northern Cardinal</h3>
            <p class="text-xs text-text-muted">Cardinalis cardinalis</p>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-[10px] font-black uppercase tracking-widest text-text-muted">Confidence</span>
                <span class="text-sm font-black">94%</span>
            </div>
        </div>
    </div>
</main>
</body>
</html>
