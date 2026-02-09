<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EST | Historical Trends</title>

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
            <h2 class="text-xl font-bold leading-tight tracking-tight">Historical Trends</h2>
        </div>
        <nav class="hidden md:flex items-center gap-6">
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('gis') }}">GIS Map</a>
            <a class="text-[#111813] dark:text-white text-sm font-semibold border-b-2 border-primary pb-1" href="{{ route('historical') }}">Historical</a>
            <a class="text-text-muted dark:text-gray-400 text-sm font-medium hover:text-primary" href="{{ route('species-id') }}">Species ID</a>
        </nav>
    </div>
</header>

<main class="p-8 space-y-6">
    <div>
        <h1 class="text-3xl font-black tracking-tight">Acoustic & Eco-Health History</h1>
        <p class="text-text-muted text-sm font-medium">Demo view (wired for real data later)</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
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

        <div class="rounded-2xl border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a2e21] p-6 space-y-4">
            <h3 class="text-sm font-black">Station Summary</h3>
            <div class="flex items-center justify-between p-3 rounded-xl bg-background-light dark:bg-background-dark/40">
                <p class="text-xs font-bold">Active Stations</p>
                <p class="text-lg font-black">2</p>
            </div>
            <div class="flex items-center justify-between p-3 rounded-xl bg-background-light dark:bg-background-dark/40">
                <p class="text-xs font-bold">Healthy</p>
                <p class="text-lg font-black text-primary">1</p>
            </div>
            <div class="flex items-center justify-between p-3 rounded-xl bg-background-light dark:bg-background-dark/40">
                <p class="text-xs font-bold">Warning</p>
                <p class="text-lg font-black text-red-500">1</p>
            </div>
        </div>
    </div>
</main>
</body>
</html>
