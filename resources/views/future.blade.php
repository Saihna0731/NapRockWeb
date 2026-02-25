<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EST: Future Ecosystem Projections</title>

    @vite('resources/js/app.js')

    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;family=Noto+Sans:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
</head>
<body class="bg-background-light dark:bg-background-dark font-display min-h-screen text-[#111813] dark:text-white transition-colors duration-300">
<!-- Navigation -->
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-border-muted dark:border-white/10 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md px-10 py-3 sticky top-0 z-50">
    <div class="flex items-center gap-8">
        <div class="flex items-center gap-3">
            <div class="size-8 bg-primary rounded flex items-center justify-center text-background-dark">
                <span class="material-symbols-outlined font-bold">query_stats</span>
            </div>
            <h2 class="text-[#111813] dark:text-white text-xl font-bold leading-tight tracking-[-0.015em]">EST</h2>
        </div>
        <nav class="hidden md:flex items-center gap-6">
            <a class="text-text-muted dark:text-gray-400 hover:text-primary transition-colors text-sm font-medium" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="text-primary text-sm font-bold border-b-2 border-primary" href="{{ route('future') }}">Future Outlook</a>
            <a class="text-text-muted dark:text-gray-400 hover:text-primary transition-colors text-sm font-medium" href="#">Acoustic Library</a>
            <a class="text-text-muted dark:text-gray-400 hover:text-primary transition-colors text-sm font-medium" href="#">Reports</a>
        </nav>
    </div>
    <div class="flex items-center gap-4">
        <div class="relative hidden sm:block">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted text-sm">search</span>
            <input class="w-64 bg-[#f0f4f2] dark:bg-white/5 border-none rounded-lg pl-10 text-sm focus:ring-2 focus:ring-primary/50" placeholder="Search insights..." type="text"/>
        </div>
        <button class="p-2 rounded-lg bg-[#f0f4f2] dark:bg-white/5 text-text-muted hover:text-primary transition-colors" type="button">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        <div class="size-10 rounded-full border-2 border-primary overflow-hidden">
            <img class="w-full h-full object-cover" alt="User avatar for environmental analyst" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAXqdDCNtB_RgBmILC-p7xAoSa0d8nUPZ5SU50fEpKL8YLO7lXyHquK3Mtu8dtJA8pXe4RNDVqfIqZ8sH35IfO5SSH9MEHV6UXMwnh1VwVWTD4dYJHFXL8uP-zKMsC_mLweJiCtTlydurSVcWEM4K3Cq5FT1xv1yJkDE7CT_mPT6Lt_yjCIPiwnvDEHA_JWzsFLiNgxKI0iFb0tnrsL_nGNidcjoSALxdCUkdFZ0RlOiH_Vm79Aa0JZ184cqBQdmHmzJqem-JF5d_E"/>
        </div>
    </div>
</header>
<main class="max-w-[1200px] mx-auto px-6 py-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="px-2 py-0.5 bg-primary/20 text-primary text-[10px] font-bold uppercase rounded tracking-wider">AI Predictive Model v4.2</span>
            </div>
            <h1 class="text-4xl font-black leading-tight tracking-tight dark:text-white">Future Ecosystem Projections</h1>
            <p class="text-text-muted dark:text-gray-400 text-base max-w-2xl">Forecasting biological health indicators using deep learning acoustic analysis of avian migratory patterns and vocal complexity.</p>
        </div>
        <div class="flex gap-3">
            <button class="flex items-center gap-2 bg-[#f0f4f2] dark:bg-white/5 hover:bg-primary/10 px-4 py-2.5 rounded-lg font-bold text-sm transition-all border border-transparent hover:border-primary/30" type="button">
                <span class="material-symbols-outlined text-sm">ios_share</span>
                Export CSV
            </button>
            <button class="flex items-center gap-2 bg-primary text-background-dark px-4 py-2.5 rounded-lg font-bold text-sm hover:opacity-90 transition-all shadow-lg shadow-primary/20" type="button">
                <span class="material-symbols-outlined text-sm">description</span>
                Generate AI Summary
            </button>
        </div>
    </div>

    <!-- Dashboard Grid -->
    <div class="grid grid-cols-12 gap-6">
        <!-- Main Forecast Section -->
        <div class="col-span-12 lg:col-span-8 space-y-6">
            <!-- Chart Controls -->
            <div class="bg-white dark:bg-background-dark border border-border-muted dark:border-white/10 rounded-xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-border-muted dark:border-white/10 flex items-center justify-between bg-white dark:bg-background-dark">
                    <h3 class="font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">show_chart</span>
                        12-Month Predictive Trend
                    </h3>
                    <div class="flex h-9 bg-[#f0f4f2] dark:bg-white/5 p-1 rounded-lg">
                        <label class="flex cursor-pointer items-center px-3 rounded-md has-[:checked]:bg-white dark:has-[:checked]:bg-white/10 has-[:checked]:shadow-sm text-xs font-bold text-text-muted has-[:checked]:text-primary transition-all">
                            <span>Future Projections</span>
                            <input checked class="hidden" name="view-type" type="radio"/>
                        </label>
                        <label class="flex cursor-pointer items-center px-3 rounded-md has-[:checked]:bg-white dark:has-[:checked]:bg-white/10 has-[:checked]:shadow-sm text-xs font-bold text-text-muted has-[:checked]:text-primary transition-all">
                            <span>Historical Comp</span>
                            <input class="hidden" name="view-type" type="radio"/>
                        </label>
                    </div>
                </div>
                <div class="p-8">
                    <div class="flex gap-8 mb-8">
                        <div class="flex flex-col">
                            <span class="text-text-muted dark:text-gray-400 text-xs font-medium uppercase">Model Confidence</span>
                            <span class="text-2xl font-black text-primary">84.2%</span>
                        </div>
                        <div class="flex flex-col border-l border-border-muted dark:border-white/10 pl-8">
                            <span class="text-text-muted dark:text-gray-400 text-xs font-medium uppercase">Predicted Change</span>
                            <span class="text-2xl font-black">+12.4% <span class="text-xs font-normal text-text-muted">vs last year</span></span>
                        </div>
                    </div>

                    <!-- SVG Chart Placeholder -->
                    <div class="relative h-64 w-full">
                        <svg class="w-full h-full overflow-visible" viewBox="0 0 800 200">
                            <!-- Grid Lines -->
                            <line class="text-border-muted/30 dark:text-white/5" stroke="currentColor" x1="0" x2="800" y1="0" y2="0"></line>
                            <line class="text-border-muted/30 dark:text-white/5" stroke="currentColor" x1="0" x2="800" y1="50" y2="50"></line>
                            <line class="text-border-muted/30 dark:text-white/5" stroke="currentColor" x1="0" x2="800" y1="100" y2="100"></line>
                            <line class="text-border-muted/30 dark:text-white/5" stroke="currentColor" x1="0" x2="800" y1="150" y2="150"></line>
                            <line class="text-border-muted/30 dark:text-white/5" stroke="currentColor" x1="0" x2="800" y1="200" y2="200"></line>
                            <!-- Confidence Interval Shading -->
                            <path d="M400 120 L500 100 L600 130 L700 80 L800 90 L800 130 L700 120 L600 170 L500 140 L400 160 Z" fill="#13ec5b" fill-opacity="0.05"></path>
                            <!-- Data Line: Historical (Solid) -->
                            <path d="M0 150 C50 140, 100 170, 150 140 S250 110, 300 130 S350 100, 400 120" fill="none" stroke="#61896f" stroke-linecap="round" stroke-width="3"></path>
                            <!-- Data Line: Future (Dotted) -->
                            <path class="dotted-line" d="M400 120 C450 110, 500 90, 550 110 S650 60, 700 80 S750 70, 800 85" fill="none" stroke="#13ec5b" stroke-linecap="round" stroke-width="3"></path>
                            <!-- Current Indicator -->
                            <circle cx="400" cy="120" fill="#13ec5b" r="6" stroke="white" stroke-width="2"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-end justify-between px-2 pb-[-20px]">
                            <span class="text-[10px] font-bold text-text-muted uppercase">Oct</span>
                            <span class="text-[10px] font-bold text-text-muted uppercase">Nov</span>
                            <span class="text-[10px] font-bold text-text-muted uppercase">Dec</span>
                            <span class="text-[10px] font-bold text-primary uppercase">Jan '24 (Today)</span>
                            <span class="text-[10px] font-bold text-text-muted uppercase">Feb</span>
                            <span class="text-[10px] font-bold text-text-muted uppercase">Mar</span>
                            <span class="text-[10px] font-bold text-text-muted uppercase">Apr</span>
                        </div>
                    </div>

                    <div class="mt-12 flex items-center gap-6 text-[11px] font-bold uppercase tracking-widest text-text-muted dark:text-gray-500">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-1 bg-text-muted rounded"></div>
                            <span>Observed History</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-1 bg-primary rounded dotted-line border-t-2 border-primary"></div>
                            <span>AI Projection</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Impact Analysis Header -->
            <div class="pt-4">
                <h2 class="text-2xl font-bold dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">hub</span>
                    Impact Analysis
                </h2>
                <p class="text-text-muted dark:text-gray-400 text-sm">ML-derived correlations between bio-acoustic shifts and future environmental outcomes.</p>
            </div>

            <!-- Impact Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-background-dark border border-border-muted dark:border-white/10 p-5 rounded-xl shadow-sm hover:border-primary/50 transition-colors">
                    <div class="size-10 rounded bg-[#f0f4f2] dark:bg-white/5 flex items-center justify-center text-primary mb-4">
                        <span class="material-symbols-outlined">volume_up</span>
                    </div>
                    <h4 class="font-bold text-sm mb-1 uppercase tracking-tight">Song Intensity</h4>
                    <p class="text-xs text-text-muted dark:text-gray-400 leading-relaxed mb-3">Predicted drop in decibel variance indicates higher competition for nesting.</p>
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-[10px] font-black px-2 py-0.5 bg-orange-100 text-orange-600 rounded">Alert: Low stability</span>
                        <span class="text-sm font-bold">-4.2%</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-background-dark border border-border-muted dark:border-white/10 p-5 rounded-xl shadow-sm hover:border-primary/50 transition-colors">
                    <div class="size-10 rounded bg-[#f0f4f2] dark:bg-white/5 flex items-center justify-center text-primary mb-4">
                        <span class="material-symbols-outlined">waves</span>
                    </div>
                    <h4 class="font-bold text-sm mb-1 uppercase tracking-tight">Frequency Shift</h4>
                    <p class="text-xs text-text-muted dark:text-gray-400 leading-relaxed mb-3">Acoustic frequency narrowing predicts food scarcity in Quarter 3.</p>
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-[10px] font-black px-2 py-0.5 bg-red-100 text-red-600 rounded">Risk: High</span>
                        <span class="text-sm font-bold">+18.1%</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-background-dark border border-border-muted dark:border-white/10 p-5 rounded-xl shadow-sm hover:border-primary/50 transition-colors">
                    <div class="size-10 rounded bg-[#f0f4f2] dark:bg-white/5 flex items-center justify-center text-primary mb-4">
                        <span class="material-symbols-outlined">analytics</span>
                    </div>
                    <h4 class="font-bold text-sm mb-1 uppercase tracking-tight">Vocal Complexity</h4>
                    <p class="text-xs text-text-muted dark:text-gray-400 leading-relaxed mb-3">Sustained pattern variety suggests high biodiversity resilience.</p>
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-[10px] font-black px-2 py-0.5 bg-green-100 text-green-600 rounded">Healthy</span>
                        <span class="text-sm font-bold">+0.8%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Sidebar / Metrics -->
        <div class="col-span-12 lg:col-span-4 space-y-6">
            <!-- Stability Gauge Card -->
            <div class="bg-white dark:bg-background-dark border border-border-muted dark:border-white/10 rounded-xl p-6 shadow-sm">
                <h3 class="font-bold text-sm mb-8 uppercase tracking-widest text-text-muted dark:text-gray-400">Next Qtr Stability Index</h3>
                <div class="relative flex flex-col items-center">
                    <!-- Gauge SVG -->
                    <svg class="w-48 h-24" viewBox="0 0 100 50">
                        <path d="M10,50 A40,40 0 0,1 90,50" fill="none" stroke="#f0f4f2" stroke-linecap="round" stroke-width="12"></path>
                        <path d="M10,50 A40,40 0 0,1 78,22" fill="none" stroke="#13ec5b" stroke-linecap="round" stroke-width="12"></path>
                    </svg>
                    <div class="absolute bottom-0 text-center">
                        <span class="text-5xl font-black text-background-dark dark:text-white leading-none">72%</span>
                        <p class="text-xs font-bold text-primary uppercase mt-1">Sturdy</p>
                    </div>
                </div>
                <div class="mt-10 space-y-4">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-text-muted dark:text-gray-400">Reliability Weight</span>
                        <span class="font-bold">High (0.92)</span>
                    </div>
                    <div class="w-full bg-[#f0f4f2] dark:bg-white/5 h-1.5 rounded-full">
                        <div class="bg-primary h-full w-[92%] rounded-full"></div>
                    </div>
                    <p class="text-[11px] text-text-muted dark:text-gray-400 leading-relaxed">Based on 2.4M acoustic events recorded across the regional translator network.</p>
                </div>
            </div>

            <!-- Insights Feed -->
            <div class="bg-background-dark text-white rounded-xl p-6 shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">psychology</span>
                </div>
                <h3 class="font-bold text-primary mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">auto_awesome</span>
                    Predictive Insights
                </h3>
                <ul class="space-y-4 relative z-10">
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-primary text-sm mt-1">priority_high</span>
                        <p class="text-xs leading-relaxed text-gray-300"><span class="font-bold text-white">Migration Drift:</span> Model predicts a 4-day delay in Arctic Tern arrival due to current acoustic stillness in northern sectors.</p>
                    </li>
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-primary text-sm mt-1">check_circle</span>
                        <p class="text-xs leading-relaxed text-gray-300"><span class="font-bold text-white">Nesting Boom:</span> High-frequency density in southern forests suggests a 15% increase in seasonal brood success.</p>
                    </li>
                    <li class="flex gap-3">
                        <span class="material-symbols-outlined text-primary text-sm mt-1">info</span>
                        <p class="text-xs leading-relaxed text-gray-300"><span class="font-bold text-white">Resource Sync:</span> Peak acoustic activity aligns with predicted insect bloom within a 3-day window.</p>
                    </li>
                </ul>
                <button class="w-full mt-6 py-2 border border-white/20 rounded-lg text-xs font-bold hover:bg-white hover:text-background-dark transition-colors" type="button">
                    View Detailed Forecast
                </button>
            </div>

            <!-- Confident Score card -->
            <div class="bg-white dark:bg-background-dark border border-border-muted dark:border-white/10 rounded-xl p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary">verified</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-text-muted uppercase">Model Integrity</p>
                        <p class="text-sm font-black dark:text-white">Scientific Grade</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Info -->
    <footer class="mt-12 pt-8 border-t border-border-muted dark:border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-text-muted dark:text-gray-500 text-[11px] font-medium uppercase tracking-widest">
        <div class="flex items-center gap-4">
            <span>EST Prediction Engine v4.2.0-stable</span>
            <span>•</span>
            <span>Last updated: 14 Jan 2024, 09:12 GMT</span>
        </div>
        <div class="flex items-center gap-4">
            <a class="hover:text-primary transition-colors" href="#">Data Privacy</a>
            <a class="hover:text-primary transition-colors" href="#">Methodology</a>
            <a class="hover:text-primary transition-colors" href="#">Support</a>
        </div>
    </footer>
</main>
</body>
</html>
