<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Eco System Translator | EST Branding</title>

    @vite('resources/js/app.js')

    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-[#111813] dark:text-[#f0f4f2] transition-colors duration-300">
<header class="sticky top-0 z-50 bg-white/90 dark:bg-background-dark/90 backdrop-blur-md border-b border-[#dbe6df] dark:border-[#2a3d31]">
    <div class="max-w-[1280px] mx-auto flex items-center justify-between px-6 py-3">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 group cursor-pointer">
                <div class="size-10 bg-primary rounded-lg flex items-center justify-center shadow-sm">
                    <span class="text-[#111813] font-black text-lg tracking-tighter">EST</span>
                </div>
                <div class="flex flex-col leading-none">
                    <h1 class="text-lg font-bold tracking-tight">Eco System Translator</h1>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-accent-earth font-bold">Bioacoustic Edge AI</span>
                </div>
            </div>
        </div>
        <nav class="hidden md:flex items-center gap-10">
            <div class="flex items-center gap-8">
                <a class="text-sm font-semibold text-[#111813]/70 hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
                <a class="text-sm font-semibold text-[#111813]/70 hover:text-primary transition-colors" href="#why-birds">About</a>
                <a class="text-sm font-semibold text-[#111813]/70 hover:text-primary transition-colors" href="#insights">Technology</a>
            </div>
            <div class="h-6 w-px bg-[#dbe6df] dark:bg-[#2a3d31]"></div>
            <a class="flex items-center gap-2 bg-primary text-[#111813] px-6 py-2.5 rounded-full text-sm font-bold hover:shadow-lg hover:shadow-primary/20 transition-all" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined text-sm">dashboard</span>
                Dashboard
            </a>
        </nav>
        <button class="md:hidden text-[#111813]" type="button">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </div>
</header>
<main>
    <section class="max-w-[1200px] mx-auto px-6 py-12 md:py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-4">
                    <span class="bg-primary/20 text-emerald-800 dark:text-primary px-3 py-1 rounded-full text-xs font-bold w-fit uppercase tracking-widest">Powered by Edge AI</span>
                    <h1 class="text-5xl md:text-6xl font-black leading-tight tracking-[-0.033em]">
                        Translating the <span class="text-primary">Language</span> of the Wild
                    </h1>
                    <p class="text-lg opacity-80 leading-relaxed max-w-[500px]">
                        Advanced bioacoustic monitoring using ESP32-based Edge AI to track ecosystem health and food density through real-time avian communication analysis.
                    </p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a class="bg-primary text-[#111813] px-8 py-4 rounded-xl font-bold text-lg hover:shadow-lg hover:shadow-primary/20 transition-all" href="{{ route('dashboard') }}">
                        Explore Dashboard
                    </a>
                    <button class="bg-white dark:bg-[#1a2e20] border border-[#dbe6df] dark:border-[#2a3d31] px-8 py-4 rounded-xl font-bold text-lg hover:bg-[#f0f4f2] transition-all" type="button">
                        View Hardware Spec
                    </button>
                </div>
            </div>
            <div class="relative group">
                <div class="absolute -inset-4 bg-primary/20 rounded-full blur-3xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
                <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-[4/3] bg-[#dbe6df] dark:bg-[#2a3d31]">
                    <img alt="Beautiful forest bird singing on a branch" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBgzUsWuPc4LDO2eqSWiztXfW02A7LBHGJH7GLHX8nj8rKr2BoNqP4CZgWNAeoffL0ZWsdxu0CX_R-txgqPiOD6F41Kr4vMBIbM_4jdxyn4vhPiOKHa11ibvj0ATfFKsP80Zt_9-JBfl94fA7M2C1wxfY6HBRxRafB-AA-6Zpd2T6OeZ3pzTSno3VUfEFPvaOvtSNFiOfqGXNmXTaWGbSpvSjqP1XmGWcRb0CunOOHOcm2J6wM7r3tCXMjkBh7coLvkZr7h0DeleHU"/>
                    <div class="absolute bottom-6 right-6 bg-white/90 dark:bg-[#111813]/90 backdrop-blur p-4 rounded-xl shadow-lg border border-white/20">
                        <div class="flex items-center gap-3">
                            <div class="size-10 bg-black rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">memory</span>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-500">Device Status</p>
                                <p class="text-sm font-bold">ESP32 Monitoring Active</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== WHY BIRDS? — Scientific Foundation ===== --}}
    <section class="relative overflow-hidden bg-white dark:bg-[#0c1a11] py-20" id="why-birds">
        {{-- decorative blobs --}}
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            {{-- heading --}}
            <div class="flex flex-col items-center text-center mb-14 gap-4">
                <span class="bg-primary/20 text-emerald-800 dark:text-primary px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest">Scientific Foundation</span>
                <h2 class="text-4xl md:text-5xl font-black tracking-tight">Why <span class="text-primary">Birds</span>?</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-[680px] leading-relaxed">
                    Birds are highly sensitive to environmental changes and are widely recognized as reliable indicators of ecosystem health.
                    Changes in bird presence, diversity, and acoustic activity reflect shifts in habitat quality and ecosystem balance.
                </p>
            </div>

            {{-- 4 feature cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-[900px] mx-auto">
                {{-- card 1 --}}
                <div class="group flex items-start gap-4 bg-[#f0faf3] dark:bg-[#152a1b] p-6 rounded-2xl border border-primary/15 hover:shadow-lg hover:shadow-primary/10 transition-all">
                    <div class="shrink-0 size-11 rounded-full bg-primary flex items-center justify-center shadow-md">
                        <span class="material-symbols-outlined text-white text-xl">bolt</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-base mb-1">Rapid Habitat Response</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Birds respond rapidly to habitat disturbance, making them effective early-warning sentinels for ecological change.</p>
                    </div>
                </div>

                {{-- card 2 --}}
                <div class="group flex items-start gap-4 bg-[#f0faf3] dark:bg-[#152a1b] p-6 rounded-2xl border border-primary/15 hover:shadow-lg hover:shadow-primary/10 transition-all">
                    <div class="shrink-0 size-11 rounded-full bg-primary flex items-center justify-center shadow-md">
                        <span class="material-symbols-outlined text-white text-xl">diversity_3</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-base mb-1">Biodiversity Mirror</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Bird diversity reflects ecosystem stability and overall biodiversity levels across habitats.</p>
                    </div>
                </div>

                {{-- card 3 --}}
                <div class="group flex items-start gap-4 bg-[#f0faf3] dark:bg-[#152a1b] p-6 rounded-2xl border border-primary/15 hover:shadow-lg hover:shadow-primary/10 transition-all">
                    <div class="shrink-0 size-11 rounded-full bg-primary flex items-center justify-center shadow-md">
                        <span class="material-symbols-outlined text-white text-xl">trending_up</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-base mb-1">Global Indicator</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Bird population trends are used globally as key biodiversity indicators by conservation bodies.</p>
                    </div>
                </div>

                {{-- card 4 --}}
                <div class="group flex items-start gap-4 bg-[#f0faf3] dark:bg-[#152a1b] p-6 rounded-2xl border border-primary/15 hover:shadow-lg hover:shadow-primary/10 transition-all">
                    <div class="shrink-0 size-11 rounded-full bg-primary flex items-center justify-center shadow-md">
                        <span class="material-symbols-outlined text-white text-xl">graphic_eq</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-base mb-1">Acoustic Assessment</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Acoustic monitoring of birds enables early, non-invasive ecosystem health assessment at scale.</p>
                    </div>
                </div>
            </div>

            {{-- sources --}}
            <p class="text-center text-xs text-gray-400 dark:text-gray-500 mt-10">
                Sources: BirdLife International &middot; International Union for Conservation of Nature (IUCN)
            </p>
        </div>
    </section>

    <section class="bg-white dark:bg-[#0c1a11] py-20" id="how-it-works">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="flex flex-col items-center text-center mb-16 gap-4">
                <h2 class="text-3xl md:text-4xl font-bold">The Bioacoustic Pipeline</h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-[600px]">Our hardware translates raw acoustic waves into meaningful environmental data without cloud dependency.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
                <div class="flex flex-col items-center text-center gap-6 relative z-10">
                    <div class="size-16 rounded-2xl bg-primary/10 flex items-center justify-center border-2 border-primary/30">
                        <span class="material-symbols-outlined text-3xl text-primary">mic_external_on</span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-xl font-bold">Sound Capture</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">INMP441 high-precision I2S microphone captures 24-bit audio streams with 61dB SNR.</p>
                    </div>
                </div>
                <div class="flex flex-col items-center text-center gap-6 relative z-10">
                    <div class="size-16 rounded-2xl bg-primary/10 flex items-center justify-center border-2 border-primary/30">
                        <span class="material-symbols-outlined text-3xl text-primary">psychology</span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-xl font-bold">Edge AI Processing</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">On-device ML analysis using TensorFlow Lite for Microcontrollers to detect intensity and pitch shifts.</p>
                    </div>
                </div>
                <div class="flex flex-col items-center text-center gap-6 relative z-10">
                    <div class="size-16 rounded-2xl bg-primary/10 flex items-center justify-center border-2 border-primary/30">
                        <span class="material-symbols-outlined text-3xl text-primary">analytics</span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-xl font-bold">Ecosystem Insights</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Real-time correlation of sound metrics to insect population density and food availability.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20" id="insights">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="bg-primary/5 dark:bg-primary/5 rounded-[2rem] p-8 md:p-16 border border-primary/10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="flex flex-col gap-6">
                        <h2 class="text-4xl font-black">Deciphering Nature's Metrics</h2>
                        <p class="text-lg opacity-80 leading-relaxed">
                            Our translator doesn't just record sound—it interprets ecological health markers through two primary audio dimensions.
                        </p>
                        <div class="space-y-6 mt-4">
                            <div class="flex gap-5 p-5 bg-white dark:bg-[#1a2e20] rounded-2xl shadow-sm border border-[#dbe6df] dark:border-[#2a3d31]">
                                <span class="material-symbols-outlined text-primary text-3xl">equalizer</span>
                                <div>
                                    <h4 class="font-bold text-lg">Song Intensity (dB)</h4>
                                    <p class="text-sm opacity-70">Decibel levels correlate directly with population density and competitive mating success.</p>
                                </div>
                            </div>
                            <div class="flex gap-5 p-5 bg-white dark:bg-[#1a2e20] rounded-2xl shadow-sm border border-[#dbe6df] dark:border-[#2a3d31]">
                                <span class="material-symbols-outlined text-primary text-3xl">waves</span>
                                <div>
                                    <h4 class="font-bold text-lg">Frequency Stability</h4>
                                    <p class="text-sm opacity-70">Consistency in pitch signals lower stress levels and high resource (insect/seed) abundance.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-[#111813] p-8 rounded-3xl shadow-xl border border-[#dbe6df] dark:border-[#2a3d31]">
                        <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">monitoring</span>
                            Real-time Spectrum Analysis
                        </h3>
                        <div class="aspect-square bg-[#f8faf9] dark:bg-[#0c1a11] rounded-xl flex items-end gap-1 p-4 border border-[#dbe6df] dark:border-[#2a3d31]">
                            <div class="w-full bg-primary h-[30%] rounded-t-sm opacity-40"></div>
                            <div class="w-full bg-primary h-[60%] rounded-t-sm opacity-60"></div>
                            <div class="w-full bg-primary h-[45%] rounded-t-sm opacity-50"></div>
                            <div class="w-full bg-primary h-[85%] rounded-t-sm opacity-100"></div>
                            <div class="w-full bg-primary h-[70%] rounded-t-sm opacity-80"></div>
                            <div class="w-full bg-primary h-[95%] rounded-t-sm opacity-100"></div>
                            <div class="w-full bg-primary h-[40%] rounded-t-sm opacity-50"></div>
                            <div class="w-full bg-primary h-[20%] rounded-t-sm opacity-30"></div>
                            <div class="w-full bg-primary h-[55%] rounded-t-sm opacity-70"></div>
                            <div class="w-full bg-primary h-[75%] rounded-t-sm opacity-90"></div>
                        </div>
                        <div class="mt-6 flex justify-between text-xs font-bold text-gray-500 uppercase tracking-tighter">
                            <span>100Hz</span>
                            <span>Ecosystem Baseline (Stable)</span>
                            <span>20kHz</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-background-light dark:bg-background-dark" id="species">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div class="flex flex-col gap-2">
                    <h2 class="text-3xl font-bold">Monitored Species</h2>
                    <p class="text-gray-600 dark:text-gray-400">Current bioacoustic profiles loaded into Edge AI.</p>
                </div>
                <a href="{{ route('species-id') }}" class="text-primary font-bold flex items-center gap-2 hover:underline">
                    View All Map Data <span class="material-symbols-outlined">arrow_right_alt</span>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group bg-white dark:bg-[#1a2e20] rounded-2xl overflow-hidden border border-[#dbe6df] dark:border-[#2a3d31] hover:shadow-xl transition-all">
                    <div class="h-48 overflow-hidden relative">
                        <img alt="European Robin" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBOJbxUSxuMKJIgS7bjbs4GXYG0nSKN_g5xl_VSBZeeH7oqiEolbTbxkyJOZGni7PrLFvK6UBPTIT6dF6PfsucsF94aBedoBv_E2mUlyS1z3v3cJfMSiXpbpFtrnT4dulqluKg-o5xX9P_uxmFw_2r07GnrgGfCFGv_X7J5no-pgf1xnXIJElDyTdw6YUutfRM_x0VDNTGBbZNAnLDPqnC_AV0RbFWgE-w7RNUwmhx8fbImFLYgq_GS5pO2WxinsyKLTgK6rmoS9g4"/>
                        <div class="absolute top-4 right-4 bg-white/90 dark:bg-black/80 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest">Active</div>
                    </div>
                    <div class="p-6 flex flex-col gap-4">
                        <div>
                            <h3 class="text-xl font-bold">European Robin</h3>
                            <p class="text-sm text-gray-500 italic">Erithacus rubecula</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded">2.5 - 4.5 kHz</span>
                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 text-[10px] font-bold rounded flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">location_on</span> Woodlands
                            </span>
                        </div>
                        <div class="pt-4 border-t border-[#dbe6df] dark:border-[#2a3d31] flex justify-between items-center">
                            <span class="text-xs font-medium">Population Status</span>
                            <span class="text-xs font-bold text-emerald-500">Thriving</span>
                        </div>
                    </div>
                </div>

                <div class="group bg-white dark:bg-[#1a2e20] rounded-2xl overflow-hidden border border-[#dbe6df] dark:border-[#2a3d31] hover:shadow-xl transition-all">
                    <div class="h-48 overflow-hidden relative">
                        <img alt="Great Tit" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCI1Dylj1TtOoaeivdgCye95iwfiG_oyT55vsHmIkvj7mzE4XgGNrH6JvgDhfwBKgfUGUYMESZRhuajNnH--nPujhHGq5i6Rd9KiBWJaretMUkplMB_-kILqO3NzD42FbqU_NC2H22lpvFxbzoFqXZs65SQDZ5qXTHcsn2TD7o1LqFq8Mud0uWXGd5Jqajm6uAuxpteCqFUA-A05GQAwrTqZvrH4ygChUWz-F7XB0D5N7B1YI1QKDGB2JHyPld3cZswEaJBdHd-PUw"/>
                        <div class="absolute top-4 right-4 bg-white/90 dark:bg-black/80 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest">Active</div>
                    </div>
                    <div class="p-6 flex flex-col gap-4">
                        <div>
                            <h3 class="text-xl font-bold">Great Tit</h3>
                            <p class="text-sm text-gray-500 italic">Parus major</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded">3.0 - 8.0 kHz</span>
                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 text-[10px] font-bold rounded flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">location_on</span> Urban Parks
                            </span>
                        </div>
                        <div class="pt-4 border-t border-[#dbe6df] dark:border-[#2a3d31] flex justify-between items-center">
                            <span class="text-xs font-medium">Population Status</span>
                            <span class="text-xs font-bold text-yellow-500">Stable</span>
                        </div>
                    </div>
                </div>

                <div class="group bg-white dark:bg-[#1a2e20] rounded-2xl overflow-hidden border border-[#dbe6df] dark:border-[#2a3d31] hover:shadow-xl transition-all">
                    <div class="h-48 overflow-hidden relative">
                        <img alt="Blackbird" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDvT_ZGXz8lPaYTnx-9CwroQNpNhjVvvT0Q9yGFbMUI1mePWwD3AGjp6DTVvb6dgfheNp-FSZ3CW5-vBUmpZ7vttUTNOWCdCrTGUg7mgvDtPtrwHrEqATxeIEa6ycRCFbjp0je0DWv1yylWjk_9itzBjo-u_cApwf7_q9Cv3G-t5HMckhIEQw-bqECl-P4eYcTYmNd6Tte7oJcfwrnlbpq4vVftxpote4iOSIZ4-UkU20NcOysDpkGMix_piRgSW9HoSvIo2kACjyo"/>
                        <div class="absolute top-4 right-4 bg-white/90 dark:bg-black/80 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest">Active</div>
                    </div>
                    <div class="p-6 flex flex-col gap-4">
                        <div>
                            <h3 class="text-xl font-bold">Common Blackbird</h3>
                            <p class="text-sm text-gray-500 italic">Turdus merula</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded">1.5 - 3.5 kHz</span>
                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 text-[10px] font-bold rounded flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">location_on</span> Forest Edge
                            </span>
                        </div>
                        <div class="pt-4 border-t border-[#dbe6df] dark:border-[#2a3d31] flex justify-between items-center">
                            <span class="text-xs font-medium">Population Status</span>
                            <span class="text-xs font-bold text-emerald-500">Increasing</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<footer class="bg-white dark:bg-[#0c1a11] border-t border-[#dbe6df] dark:border-[#2a3d31] pt-16 pb-8">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <div class="flex flex-col gap-6 col-span-1 md:col-span-1">
                <div class="flex items-center gap-3">
                    <div class="size-8 bg-primary rounded flex items-center justify-center font-black">EST</div>
                    <h2 class="text-lg font-bold">Eco System Translator</h2>
                </div>
                <p class="text-sm opacity-60 leading-relaxed">
                    An open-source conservation project bridging high-end bioacoustics with accessible IoT hardware for global environmental monitoring.
                </p>
            </div>
            <div>
                <h4 class="font-bold mb-6">Hardware</h4>
                <ul class="space-y-4 text-sm opacity-70">
                    <li>ESP32-S3 Microcontroller</li>
                    <li>INMP441 I2S Microphone</li>
                    <li>LiPo Battery Management</li>
                    <li>IP67 Weatherproofing</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6">Software</h4>
                <ul class="space-y-4 text-sm opacity-70">
                    <li>TensorFlow Lite Micro</li>
                    <li>I2S DMA Audio Driver</li>
                    <li>MQTT Data Ingestion</li>
                    <li>Species ID Models</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6">Get Involved</h4>
                <ul class="space-y-4 text-sm opacity-70">
                    <li>GitHub Repository</li>
                    <li>Open Dataset Access</li>
                    <li>Documentation</li>
                    <li>Contact Team</li>
                </ul>
            </div>
        </div>
        <div class="pt-8 border-t border-[#dbe6df] dark:border-[#2a3d31] flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs opacity-50">© 2024 Eco System Translator Project. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <span class="material-symbols-outlined text-xl opacity-60 hover:opacity-100 cursor-pointer">language</span>
                <span class="material-symbols-outlined text-xl opacity-60 hover:opacity-100 cursor-pointer">terminal</span>
                <span class="material-symbols-outlined text-xl opacity-60 hover:opacity-100 cursor-pointer">share</span>
            </div>
        </div>
    </div>
</footer>

</body>

</html>
