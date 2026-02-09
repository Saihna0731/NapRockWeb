<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>EST | Live Audio Monitoring &amp; Analysis</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#111813] dark:text-white transition-colors duration-300 font-display">
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar: Device Selector -->
    <aside class="w-72 border-r border-border-muted dark:border-[#2a3a2e] flex flex-col bg-white dark:bg-[#152a1c] shrink-0">
        <div class="p-6 border-b border-border-muted dark:border-[#2a3a2e] flex items-center gap-3">
            <div class="text-primary">
                <svg class="size-8" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.1288 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z" fill="currentColor"></path>
                    <path clip-rule="evenodd" d="M10.4485 13.8519C10.4749 13.9271 10.6203 14.246 11.379 14.7361C12.298 15.3298 13.7492 15.9145 15.6717 16.3735C18.0007 16.9296 20.8712 17.2655 24 17.2655C27.1288 17.2655 29.9993 16.9296 32.3283 16.3735C34.2508 15.9145 35.702 15.3298 36.621 14.7361C37.3796 14.246 37.5251 13.9271 37.5515 13.8519C37.5287 13.7876 37.4333 13.5973 37.0635 13.2931C36.5266 12.8516 35.6288 12.3647 34.343 11.9175C31.79 11.0295 28.1333 10.4437 24 10.4437C19.8667 10.4437 16.2099 11.0295 13.657 11.9175C12.3712 12.3647 11.4734 12.8516 10.9365 13.2931C10.5667 13.5973 10.4713 13.7876 10.4485 13.8519ZM37.5563 18.7877C36.3176 19.3925 34.8502 19.8839 33.2571 20.2642C30.5836 20.9025 27.3973 21.2655 24 21.2655C20.6027 21.2655 17.4164 20.9025 14.7429 20.2642C13.1498 19.8839 11.6824 19.3925 10.4436 18.7877V34.1275C10.4515 34.1545 10.5427 34.4867 11.379 35.027C12.298 35.6207 13.7492 36.2054 15.6717 36.6644C18.0007 37.2205 20.8712 37.5564 24 37.5564C27.1288 37.5564 29.9993 37.2205 32.3283 36.6644C34.2508 36.2054 35.702 35.6207 36.621 35.027C37.4573 34.4867 37.5485 34.1546 37.5563 34.1275V18.7877ZM41.5563 13.8546V34.1455C41.5563 36.1078 40.158 37.5042 38.7915 38.3869C37.3498 39.3182 35.4192 40.0389 33.2571 40.5551C30.5836 41.1934 27.3973 41.5564 24 41.5564C20.6027 41.5564 17.4164 41.1934 14.7429 40.5551C12.5808 40.0389 10.6502 39.3182 9.20848 38.3869C7.84205 37.5042 6.44365 36.1078 6.44365 34.1455L6.44365 13.8546C6.44365 12.2684 7.37223 11.0454 8.39581 10.2036C9.43325 9.3505 10.8137 8.67141 12.343 8.13948C15.4203 7.06909 19.5418 6.44366 24 6.44366C28.4582 6.44366 32.5797 7.06909 35.657 8.13948C37.1863 8.67141 38.5667 9.3505 39.6042 10.2036C40.6278 11.0454 41.5563 12.2684 41.5563 13.8546Z" fill="currentColor" fill-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <a class="font-bold text-xl tracking-tight" href="{{ route('dashboard') }}">EST</a>
                <p class="text-[10px] uppercase tracking-widest text-text-muted opacity-80">Eco System Translator</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 space-y-6">
            <div>
                <h3 class="px-3 text-xs font-bold text-text-muted uppercase tracking-wider mb-3">Remote Audio Sensors</h3>
                <div class="space-y-1">
                    <button class="w-full flex items-center justify-between px-3 py-3 rounded-lg bg-primary/10 border border-primary/20 text-[#111813] dark:text-primary" type="button">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-lg">settings_remote</span>
                            <span class="text-sm font-semibold">Device #1</span>
                        </div>
                        <span class="size-2 bg-primary rounded-full animate-pulse"></span>
                    </button>
                    <button class="w-full flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 text-text-muted" type="button">
                        <span class="material-symbols-outlined text-lg">settings_remote</span>
                        <span class="text-sm font-medium">Device #2 (Idle)</span>
                    </button>
                    <button class="w-full flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 text-text-muted opacity-50" type="button">
                        <span class="material-symbols-outlined text-lg">wifi_off</span>
                        <span class="text-sm font-medium">Device #3 (Offline)</span>
                    </button>
                </div>
            </div>

            <div>
                <h3 class="px-3 text-xs font-bold text-text-muted uppercase tracking-wider mb-3">Global Overviews</h3>
                <div class="space-y-1">
                    <button class="w-full flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 text-[#111813] dark:text-white" type="button">
                        <span class="material-symbols-outlined text-lg">public</span>
                        <span class="text-sm font-medium">Network Map</span>
                    </button>
                    <button class="w-full flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 text-[#111813] dark:text-white" type="button">
                        <span class="material-symbols-outlined text-lg">history</span>
                        <span class="text-sm font-medium">Archive</span>
                    </button>
                    <button class="w-full flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 text-[#111813] dark:text-white" type="button">
                        <span class="material-symbols-outlined text-lg">settings</span>
                        <span class="text-sm font-medium">System Settings</span>
                    </button>
                </div>
            </div>
        </nav>

        <div class="p-4 border-t border-border-muted dark:border-[#2a3a2e]">
            <div class="flex items-center gap-3 p-2 bg-[#f0f4f2] dark:bg-[#1a3022] rounded-xl">
                <div class="size-10 rounded-full bg-cover bg-center" data-alt="User profile avatar" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDmzkxrlQPAFFXTax9ZPJxpiXOu10VjEGzIjVbER44tQze32MetbIss_Iqhz75NEv1O-SSVWsJQAYuY_B3UkEyKsIr003XTtZSNtsmFpz8u7TMfXiAeptrtItFDnNUeJcsiVbVJGhccPjbCeac3Cl_lekkqPTkZ61ZAM27beJFQXP57EUoWAbi4CiAirFLj-7t5wUpn9ZajwFErmGkVWNGUqpkCdW8NRsAm7roQrqOvI-3Ie675THzCnEcp3rlwqZjhTcvTrAp3WFo");'></div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold truncate">Dr. Aris Thorne</p>
                    <p class="text-[10px] text-text-muted">Field Lead</p>
                </div>
                <span class="material-symbols-outlined text-text-muted cursor-pointer">logout</span>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden bg-background-light dark:bg-background-dark">
        <!-- Top Nav -->
        <header class="h-16 border-b border-border-muted dark:border-[#2a3a2e] flex items-center justify-between px-8 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md z-10">
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-text-muted">Monitoring</span>
                <span class="material-symbols-outlined text-text-muted text-xs">chevron_right</span>
                <span class="text-sm font-bold">Device #1 Live Stream</span>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="size-2 rounded-full bg-red-500 recording-pulse"></span>
                    <span class="text-xs font-bold uppercase tracking-widest text-red-500">Live Recording</span>
                </div>
                <div class="h-6 w-px bg-border-muted dark:border-[#2a3a2e]"></div>
                <button class="bg-primary text-[#111813] px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2" type="button">
                    <span class="material-symbols-outlined text-lg">sensors</span>
                    Live Listening
                </button>
            </div>
        </header>

        <div class="flex-1 flex overflow-hidden">
            <!-- Center: Waveform & Visualizer -->
            <div class="flex-1 flex flex-col p-8 gap-6 overflow-y-auto">
                <!-- Title & Summary -->
                <div class="flex flex-wrap justify-between items-end gap-4">
                    <div class="space-y-1">
                        <h2 class="text-4xl font-black leading-tight tracking-tight">Live Audio Monitoring</h2>
                        <p class="text-text-muted font-medium">Real-time acoustic analysis for Amazon Basin Node #01</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex flex-col items-end">
                            <span class="text-[10px] font-bold uppercase text-text-muted tracking-widest">Active Time</span>
                            <span class="text-lg font-bold tabular-nums">04:22:18</span>
                        </div>
                    </div>
                </div>

                <!-- Main Waveform Display -->
                <div class="relative group">
                    <div class="bg-black rounded-2xl aspect-[21/9] flex items-end justify-center gap-1 p-8 overflow-hidden relative">
                        <!-- Simplified Waveform Visualizer -->
                        <div class="waveform-bar w-1.5 bg-primary/20 rounded-full" style="animation-delay: 0.1s; height: 30%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/40 rounded-full" style="animation-delay: 0.2s; height: 50%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/60 rounded-full" style="animation-delay: 0.3s; height: 80%"></div>
                        <div class="waveform-bar w-1.5 bg-primary rounded-full" style="animation-delay: 0.4s; height: 60%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/80 rounded-full" style="animation-delay: 0.5s; height: 90%"></div>
                        <div class="waveform-bar w-1.5 bg-primary rounded-full" style="animation-delay: 0.1s; height: 40%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/50 rounded-full" style="animation-delay: 0.3s; height: 70%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/30 rounded-full" style="animation-delay: 0.6s; height: 25%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/60 rounded-full" style="animation-delay: 0.2s; height: 45%"></div>
                        <div class="waveform-bar w-1.5 bg-primary rounded-full" style="animation-delay: 0.4s; height: 75%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/70 rounded-full" style="animation-delay: 0.1s; height: 55%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/20 rounded-full" style="animation-delay: 0.5s; height: 85%"></div>
                        <div class="waveform-bar w-1.5 bg-primary rounded-full" style="animation-delay: 0.3s; height: 65%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/40 rounded-full" style="animation-delay: 0.6s; height: 35%"></div>
                        <!-- Repeats to fill space -->
                        <div class="waveform-bar w-1.5 bg-primary/60 rounded-full" style="animation-delay: 0.1s; height: 80%"></div>
                        <div class="waveform-bar w-1.5 bg-primary rounded-full" style="animation-delay: 0.4s; height: 60%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/80 rounded-full" style="animation-delay: 0.5s; height: 90%"></div>
                        <div class="waveform-bar w-1.5 bg-primary rounded-full" style="animation-delay: 0.1s; height: 40%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/50 rounded-full" style="animation-delay: 0.3s; height: 70%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/30 rounded-full" style="animation-delay: 0.6s; height: 25%"></div>
                        <div class="waveform-bar w-1.5 bg-primary/60 rounded-full" style="animation-delay: 0.2s; height: 45%"></div>
                        <div class="waveform-bar w-1.5 bg-primary rounded-full" style="animation-delay: 0.4s; height: 75%"></div>

                        <!-- Spectrogram Overlay Grid -->
                        <div class="absolute inset-0 grid grid-cols-12 grid-rows-6 pointer-events-none opacity-20">
                            <div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div>
                            <div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div>
                            <div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div><div class="border-r border-b border-primary/30"></div>
                        </div>

                        <!-- Playback Control Bar -->
                        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-4 bg-white/10 backdrop-blur-xl px-6 py-3 rounded-full border border-white/20">
                            <button class="text-white hover:text-primary transition-colors" type="button">
                                <span class="material-symbols-outlined fill-1">pause</span>
                            </button>
                            <div class="h-6 w-px bg-white/20"></div>
                            <div class="flex items-center gap-2 group/volume">
                                <span class="material-symbols-outlined text-white text-sm">volume_up</span>
                                <div class="w-24 h-1 bg-white/20 rounded-full overflow-hidden">
                                    <div class="bg-primary h-full w-[70%]"></div>
                                </div>
                            </div>
                            <div class="h-6 w-px bg-white/20"></div>
                            <span class="text-white font-bold text-xs tabular-nums">LIVE</span>
                        </div>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex flex-col gap-2 rounded-xl p-6 border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a3022]">
                        <p class="text-text-muted text-sm font-medium uppercase tracking-widest">Ambient Level</p>
                        <div class="flex items-end justify-between">
                            <p class="text-3xl font-black">42 <span class="text-base font-normal">dB</span></p>
                            <p class="text-primary text-sm font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">trending_up</span> 2.1%
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 rounded-xl p-6 border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a3022]">
                        <p class="text-text-muted text-sm font-medium uppercase tracking-widest">ML Confidence</p>
                        <div class="flex items-end justify-between">
                            <p class="text-3xl font-black">98.4<span class="text-base font-normal">%</span></p>
                            <p class="text-primary text-sm font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">check_circle</span> Stable
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 rounded-xl p-6 border border-border-muted dark:border-[#2a3a2e] bg-white dark:bg-[#1a3022]">
                        <p class="text-text-muted text-sm font-medium uppercase tracking-widest">Spectral Density</p>
                        <div class="flex items-end justify-between">
                            <p class="text-3xl font-black">0.86 <span class="text-base font-normal">Hz/s</span></p>
                            <p class="text-yellow-500 text-sm font-bold flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">warning</span> Moderate
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Identification Feed -->
            <div class="w-80 border-l border-border-muted dark:border-[#2a3a2e] flex flex-col bg-white dark:bg-[#152a1c] shrink-0">
                <div class="p-6 border-b border-border-muted dark:border-[#2a3a2e]">
                    <h3 class="font-bold text-sm uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">analytics</span>
                        Live Identification
                    </h3>
                </div>
                <div class="flex-1 overflow-y-auto p-4 space-y-4">
                    <!-- ID Card -->
                    <div class="p-3 bg-background-light dark:bg-[#1a3022] rounded-xl border border-border-muted dark:border-transparent hover:border-primary/50 transition-all cursor-pointer">
                        <div class="flex gap-3">
                            <div class="size-16 rounded-lg bg-cover bg-center shrink-0 border border-white/10" data-alt="Photo of a Northern Cardinal" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAZpKNj4Xj0WLxJ_1OYS-egzfNJuAc9RlE74OTi02QT6aUiF5ix454MiifabigWTe2BchVbTq9dsTNAhngeJrBmDxvOArGLxryI4bgIBoRahysQBIHJLUv4HbUu9I7ykThTTV74khMrfwVH6Rl3y3v9CPN9KURezR9f82XKKid0pzMR78RHJvXJ6XhHRpaF0TqLW8Kll3xpeO3p-HE85GUuytRBDCzCihegdEdMVNx-7gNBcB76moitwt8SpBdLyrOB2UIHJBPhwcg");'></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <p class="text-xs font-bold text-primary">JUST NOW</p>
                                    <span class="text-[10px] font-bold text-text-muted">94% MATCH</span>
                                </div>
                                <h4 class="text-sm font-bold truncate">Northern Cardinal</h4>
                                <p class="text-[10px] text-text-muted">Cardinalis cardinalis</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-white dark:bg-[#1a3022]/40 rounded-xl border border-border-muted dark:border-transparent opacity-80">
                        <div class="flex gap-3">
                            <div class="size-16 rounded-lg bg-cover bg-center shrink-0" data-alt="Photo of a Blue Jay" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA6GOlk1qhD0cmLt_6Perat9OU37whdFbwG6ks0KPBPs1fIwfgDOfp3oqbxmef5PAnPPGc_N06-9t0I9Ln0EZm-q1j9XklSJZa5DEZ2yhUnppoO9kFwCbqXZ7Y6Z4U1RESM_namBXU_DydMkYFm-xVpv1IzjJB2GG2sc_ky_4L5YIQfD4XO39j85HzZTdhaAk1lC_ySOTAjUOPe4ZYKH8iSJbyM0YeAhXVY2lcRjqCZZosWHC_zwykTqrhsTF31UlZdfJzR6vYGqp4");'></div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <p class="text-xs font-bold text-text-muted">2m ago</p>
                                    <span class="text-[10px] font-bold text-text-muted">87% MATCH</span>
                                </div>
                                <h4 class="text-sm font-bold truncate">Blue Jay</h4>
                                <p class="text-[10px] text-text-muted">Cyanocitta cristata</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t border-border-muted dark:border-[#2a3a2e]">
                    <button class="w-full py-2 bg-[#f0f4f2] dark:bg-[#1a3022] rounded-lg text-xs font-bold hover:bg-primary hover:text-[#111813] transition-colors" type="button">
                        VIEW FULL LOG
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
