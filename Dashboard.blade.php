<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Eco System Translator (EST) Dashboard</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec5b",
                        "accent-blue": "#3b82f6",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216",
                    },
                    fontFamily: {
                        "display": ["Space Grotesk"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
<style type="text/tailwindcss">
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Space Grotesk', sans-serif;
        }
        .gauge-gradient {
            background: conic-gradient(from 180deg at 50% 50%, #13ec5b 0%, #13ec5b 88%, #dbe6df 88% 100%);
        }
        .chart-grid {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, #e5e7eb 1px, transparent 1px), linear-gradient(to bottom, #e5e7eb 1px, transparent 1px);
        }
        .dark .chart-grid {
            background-image: linear-gradient(to right, #2a3a2e 1px, transparent 1px), linear-gradient(to bottom, #2a3a2e 1px, transparent 1px);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #dbe6df;
            border-radius: 10px;
        }.chart-line {
            fill: none;
            stroke-width: 3;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        .chart-dot {
            stroke: white;
            stroke-width: 2;
        }
        .dark .chart-dot {
            stroke: #1a2e21;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#111813] dark:text-white transition-colors duration-200">
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-[#dbe6df] dark:border-[#2a3a2e] px-8 py-3 bg-white dark:bg-background-dark sticky top-0 z-50">
<div class="flex items-center gap-8">
<div class="flex items-center gap-3">
<div class="flex items-center justify-center size-10 bg-primary rounded-lg text-background-dark font-black text-lg">
                EST
            </div>
<h2 class="text-[#111813] dark:text-white text-xl font-bold leading-tight tracking-tight">Eco System Translator</h2>
</div>
<nav class="hidden md:flex items-center gap-6">
<a class="text-[#111813] dark:text-white text-sm font-semibold border-b-2 border-primary pb-1" href="#">Dashboard</a>
<a class="text-[#61896f] dark:text-gray-400 text-sm font-medium hover:text-primary" href="#">Sensors</a>
<a class="text-[#61896f] dark:text-gray-400 text-sm font-medium hover:text-primary" href="#">Species Catalog</a>
<a class="text-[#61896f] dark:text-gray-400 text-sm font-medium hover:text-primary" href="#">Trends</a>
</nav>
</div>
<div class="flex items-center gap-4">
<label class="hidden lg:flex items-center bg-[#f0f4f2] dark:bg-[#1a2e21] rounded-lg px-3 py-1.5 min-w-64">
<span class="material-symbols-outlined text-[#61896f] mr-2 text-sm">search</span>
<input class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder-[#61896f]" placeholder="Search GPS or Sensor ID" type="text"/>
</label>
<button class="p-2 rounded-lg bg-[#f0f4f2] dark:bg-[#1a2e21] text-[#111813] dark:text-white">
<span class="material-symbols-outlined text-xl">notifications</span>
</button>
<div class="size-10 rounded-full bg-cover bg-center border border-primary" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAQ6sYVHlPhXVEi1tbJ1YNhi75fxRxt6mOdV6wmvdBCXViunh4cTLfCuKMGrV_LpJKQFGKJx16mpKFuA2A054XCBX5ia70QpIFtwF89qw4LEbWiQVQ1tqipLuYEM2TvJ4QomCiTYLBv2EdEhKfrP7hmpn-duEXeocvK5Xpr7mJ7AjabESqDig8Ak5H81nlDZ7o6QlOfZientw8gnt3Wzaf5pNl6PRwEfbGjJzS82VSF_VwG42bZcgsvtbWuciYfpraLAxjyiWhTCXs");'></div>
</div>
</header>
<div class="flex">
<aside class="w-64 border-r border-[#dbe6df] dark:border-[#2a3a2e] bg-white dark:bg-background-dark min-h-[calc(100vh-64px)] hidden xl:flex flex-col p-6 sticky top-[64px]">
<div class="mb-8">
<h3 class="text-xs font-bold text-[#61896f] uppercase tracking-widest mb-4">Branding</h3>
<div class="flex flex-col gap-1 p-3 bg-primary/5 border border-primary/20 rounded-xl">
<p class="text-[#111813] dark:text-white font-bold text-sm">EST Translator</p>
<p class="text-[10px] text-[#61896f]">Global Eco-Monitoring</p>
</div>
</div>
<div class="flex flex-col gap-2">
<div class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary/10 text-[#111813] dark:text-primary font-bold">
<span class="material-symbols-outlined">dashboard</span>
<span class="text-sm">Overview</span>
</div>
<div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#61896f] hover:bg-[#f0f4f2] dark:hover:bg-[#1a2e21] cursor-pointer">
<span class="material-symbols-outlined">map</span>
<span class="text-sm font-medium">GIS Map</span>
</div>
<div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#61896f] hover:bg-[#f0f4f2] dark:hover:bg-[#1a2e21] cursor-pointer">
<span class="material-symbols-outlined">monitoring</span>
<span class="text-sm font-medium">Historical Trends</span>
</div>
<div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#61896f] hover:bg-[#f0f4f2] dark:hover:bg-[#1a2e21] cursor-pointer">
<span class="material-symbols-outlined">flutter_dash</span>
<span class="text-sm font-medium">Species ID</span>
</div>
</div>
<div class="mt-auto pt-6">
<button class="w-full bg-primary text-background-dark font-bold py-3 rounded-lg flex items-center justify-center gap-2 text-sm shadow-sm hover:opacity-90 transition-opacity">
<span class="material-symbols-outlined text-sm">download</span>
                Export Report
            </button>
</div>
</aside>
<main class="flex-1 p-8 space-y-8 overflow-x-hidden">
<div class="flex flex-wrap justify-between items-end gap-6">
<div class="flex flex-col gap-2">
<h1 class="text-4xl font-black text-[#111813] dark:text-white leading-tight tracking-tight">Eco System Translator</h1>
<p class="text-[#61896f] text-lg font-medium">Visual bird species tracking and identification dashboard</p>
</div>
<div class="flex gap-3">
<div class="flex items-center gap-2 bg-white dark:bg-[#1a2e21] border border-[#dbe6df] dark:border-[#2a3a2e] px-4 py-2 rounded-lg">
<span class="size-2 bg-primary rounded-full animate-pulse"></span>
<span class="text-sm font-bold">Live Monitoring Active</span>
</div>
</div>
</div>
<div class="grid grid-cols-12 gap-6">
<div class="col-span-12 xl:col-span-8">
<div class="bg-white dark:bg-[#1a2e21] p-2 rounded-xl border border-[#dbe6df] dark:border-[#2a3a2e] h-[640px] relative overflow-hidden group">
<div class="w-full h-full rounded-lg bg-cover bg-center relative" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA5-wNQlQDb7ymFv_VOOgnM1qGLu7NGJGt68Nb5F4CTXwcliV5AVphtXRP6QtIKYsif2Q7Lkh0kYd9oOyuyx8QoDzHaYwbDkIG0ezlGyOmBZ2vnCFTkLS7fE9SsdOtsMsm8ZFPgDYWl1Ndls5gXwxcoerhP4W82S0rPhOYuPj1lZlK6395NjJT-ljGj8nt0OJpZ3lHGbTx5G1NnK1V5EEUCPMVhPWpQRVRNVjWjpdHBXceqeTrzNiJH4R9_rWU1U6xTslmaEvtL0ko");'>
<div class="absolute inset-0 bg-black/10"></div>
<div class="absolute top-[40%] left-[35%] cursor-pointer group/pin">
<div class="relative">
<div class="absolute -inset-8 bg-primary/20 rounded-full animate-pulse"></div>
<div class="size-8 bg-primary rounded-full border-2 border-white shadow-lg flex items-center justify-center relative z-10 transition-transform hover:scale-125">
<span class="text-[10px] font-bold text-white">01</span>
</div>
</div>
</div>
<div class="absolute top-[30%] left-[60%] cursor-pointer group/pin">
<div class="relative">
<div class="absolute -inset-10 bg-accent-blue/20 rounded-full animate-ping"></div>
<div class="size-8 bg-accent-blue rounded-full border-2 border-white shadow-xl flex items-center justify-center relative z-20 scale-110">
<span class="material-symbols-outlined text-white text-sm">sensors</span>
</div>
</div>
</div>
<div class="absolute top-4 right-4 bottom-4 w-[340px] bg-white/95 dark:bg-[#102216]/95 backdrop-blur-md rounded-xl border border-[#dbe6df] dark:border-[#2a3a2e] shadow-2xl p-6 flex flex-col z-30 transition-all duration-300">
<div class="flex justify-between items-start mb-6">
<div>
<h4 class="text-[10px] font-bold text-accent-blue uppercase tracking-[0.2em] mb-1">Station Analytics</h4>
<h3 class="text-xl font-bold">Device #1: AMZ-042</h3>
</div>
<button class="text-[#61896f] hover:text-[#111813]"><span class="material-symbols-outlined">close</span></button>
</div>
<div class="flex-1 flex flex-col min-h-0">
<h4 class="text-sm font-bold mb-4 flex items-center justify-between">
<span>Detected Birds Gallery</span>
<span class="text-[10px] text-[#61896f] font-normal">REAL-TIME</span>
</h4>
<div class="space-y-4 overflow-y-auto custom-scrollbar pr-2 flex-1">
<div class="flex items-center gap-4 p-3 rounded-xl bg-white border border-[#dbe6df] dark:border-[#2a3a2e] hover:border-primary transition-all cursor-pointer">
<img alt="Scarlet Macaw" class="size-14 rounded-full object-cover border-2 border-primary/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5yPQVwp5hwawtcU80_OucQiAfQPKDsLwG2cA8eRU7pfleEbEN8MoQoZMIQAmthopWwpi3-ZHQdRbvY8XgkPH9UdOuX7fY7paYgKB3MqviaCwyn_EnsEeCG62H6bxYuaMmMiJoZMjTPPxft-TXeMjs1MOWSyotNYuFxmjYPZSDyGIVI0X3r3mh2-t64dgTvzp6iMUjbmC1dvaD9dwW9NO3X__bsfNr3eCaVWd2nhAuKkxbv81LGNPSxz5xg3p-sfvO5tyQM-v2pgo"/>
<div class="flex-1">
<div class="flex justify-between items-center mb-1">
<span class="text-xs font-bold">Scarlet Macaw</span>
<span class="text-[10px] font-black text-primary">82 Det/hr</span>
</div>
<div class="w-full bg-gray-100 dark:bg-white/10 h-1.5 rounded-full overflow-hidden">
<div class="bg-primary h-full w-[82%]"></div>
</div>
</div>
</div>
<div class="flex items-center gap-4 p-3 rounded-xl bg-white border border-[#dbe6df] dark:border-[#2a3a2e] hover:border-accent-blue transition-all cursor-pointer">
<img alt="Keel-billed Toucan" class="size-14 rounded-full object-cover border-2 border-accent-blue/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCNC4XkgimtVwQ_uzFqa5SyjPrxo_HncHJ-Sn2qO75YgfO_8Oa9K0hJdJVZVx2kS207Y4YOSBZsevUe8kaQ6oZAZcMuDQKdf9Va6QFagscg35hvJHXGqNGydqX87H_8UgrdFpNIXhDxtnoxH7N0xMVvNPrSfCAvosndLOc0JqtjPdpxr9wGkZ1Yk-uDkzQ6RBIOCten-vCMnudaC5s7odJjgmkbeVNIp3L6iC9gwiFjua6vysEDagSJM7dwL14TGQvs6RdFmPYTTlk"/>
<div class="flex-1">
<div class="flex justify-between items-center mb-1">
<span class="text-xs font-bold">Keel-billed Toucan</span>
<span class="text-[10px] font-black text-accent-blue">54 Det/hr</span>
</div>
<div class="w-full bg-gray-100 dark:bg-white/10 h-1.5 rounded-full overflow-hidden">
<div class="bg-accent-blue h-full w-[54%]"></div>
</div>
</div>
</div>
<div class="flex items-center gap-4 p-3 rounded-xl bg-white border border-[#dbe6df] dark:border-[#2a3a2e] hover:border-green-600 transition-all cursor-pointer">
<img alt="Harpy Eagle" class="size-14 rounded-full object-cover border-2 border-green-600/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCdiUFTaFOq5etxq6xDngjMGitBUxG_IlYIRvt8Z_eWSV4OpfuJrAgR_RWEIDwTP_Zpk7OnKL30WlxZOJc-pROeBUo7_AmmgUiIaXKKPRQ9Jq2uFj2EraQYByQWnHKHs0TEllD4i-MJ79fN81smRHEF2kOfziNWClQ6d8jho_c6Pfhtenuo5C0CsuuDsvDI1r6-7ztE69-Nt1SQkVMkzMQZZf9asP2Ha_vA4Jy4XlvFZ8g2EIYMtUbhRG6fEmQ0lpipLa7deZhPdOc"/>
<div class="flex-1">
<div class="flex justify-between items-center mb-1">
<span class="text-xs font-bold">Harpy Eagle</span>
<span class="text-[10px] font-black text-green-600">21 Det/hr</span>
</div>
<div class="w-full bg-gray-100 dark:bg-white/10 h-1.5 rounded-full overflow-hidden">
<div class="bg-green-600 h-full w-[21%]"></div>
</div>
</div>
</div>
<div class="flex items-center gap-4 p-3 rounded-xl bg-white border border-[#dbe6df] dark:border-[#2a3a2e] hover:border-gray-400 transition-all cursor-pointer">
<img alt="Blue Jay" class="size-14 rounded-full object-cover border-2 border-gray-400/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDInZGQDyXPuUGFA2JT6iluVLF5ZaVsXAxRYamLDD8yyQQGPPrchL9apNnhKq1qYe3al4cEi7xZ5yk7lFiF7M0PwhHopgYhfKgorOhvzH_CoJNrRu_YmjyNHUiw6350DJTaoegsqoYhfel5_WweBDH1-bAIMI_I7PB8Oft6U0z-k5nB6rvfYhoKTdNawYTavgcYCqWknPS5y-8d8PCSYHopfxcLDgnhiwYkJuLKnurU37PZh06TrjQUN0WsmWEda_Q5s-51sRauCzk"/>
<div class="flex-1">
<div class="flex justify-between items-center mb-1">
<span class="text-xs font-bold">Blue Jay</span>
<span class="text-[10px] font-black text-gray-400">12 Det/hr</span>
</div>
<div class="w-full bg-gray-100 dark:bg-white/10 h-1.5 rounded-full overflow-hidden">
<div class="bg-gray-400 h-full w-[12%]"></div>
</div>
</div>
</div>
</div>
</div>
<button class="mt-6 w-full py-3 bg-[#111813] text-white font-bold text-xs rounded-lg flex items-center justify-center gap-2 hover:bg-black transition-colors">
<span class="material-symbols-outlined text-sm">hearing</span>
                                Listen to Audio Stream
                            </button>
</div>
</div>
</div>
</div>
<div class="col-span-12 xl:col-span-4 space-y-6">
<div class="bg-white dark:bg-[#1a2e21] p-6 rounded-xl border border-[#dbe6df] dark:border-[#2a3a2e]">
<h3 class="text-xs font-bold text-[#61896f] uppercase tracking-wider mb-6">Top Species Detected</h3>
<div class="grid grid-cols-2 gap-4">
<div class="p-4 bg-background-light dark:bg-background-dark/50 rounded-xl border border-transparent hover:border-primary transition-all cursor-pointer group text-center">
<div class="size-20 rounded-full overflow-hidden mb-3 mx-auto ring-4 ring-primary/10 group-hover:ring-primary transition-all">
<img alt="Macaw" class="size-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAT3XXHEOaOXgx2Cuwkhlpm-elLSkF842I4KdYw68Uaoab5J2BEMKxdgs3ToK0q2ekgZR1GUbK0tWDA0-SnsOnuGDUYHAsoYokw-xqW7PJpu-udzI8BPmLPUaP0csh_w7PBYzive4ERV9PSd8oIapuxcZAm87WJwOXLUAjSw_v1bBsLe5nuk938bzRsBwJheTLILyDlb8SkRGe2EeLzBi6l8Xa0aM5dxIQ4LMaJlwwyAumd7iiWle-kfcususry_f_jgKVXm6uSz68"/>
</div>
<p class="text-xs font-bold truncate">Scarlet Macaw</p>
<p class="text-[10px] text-primary font-bold mt-1">42% Frequency</p>
</div>
<div class="p-4 bg-background-light dark:bg-background-dark/50 rounded-xl border border-transparent hover:border-accent-blue transition-all cursor-pointer group text-center">
<div class="size-20 rounded-full overflow-hidden mb-3 mx-auto ring-4 ring-accent-blue/10 group-hover:ring-accent-blue transition-all">
<img alt="Toucan" class="size-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAYuje81hopaw7IMeg57X5hVP4dJ7-O_ik67gJsEzsMkfw2SjDwa3DZEVoR3qtsNIKTRhp0QvwOwCOU7Jvivoe-4kQ4-NAFq8bDWkHkJX7pdv9PPBjjUx7k-pWcH2liLLpxVHrQbh6M-XRIaUWk9JeZBTRXhhu7l6E15XB9JcIE7z0bZ5IDjzVwgTJfUKZ0lEHQp0IL-XL8vx0W7D7idH0gPOo_sdg3ovwrmn9M-H8HCnQmVCXE1Mx1qcBAsTQ4Pancgp1FaYpbKpU"/>
</div>
<p class="text-xs font-bold truncate">Keel Toucan</p>
<p class="text-[10px] text-accent-blue font-bold mt-1">28% Frequency</p>
</div>
</div>
</div>
<div class="bg-white dark:bg-[#1a2e21] p-6 rounded-xl border border-[#dbe6df] dark:border-[#2a3a2e] flex flex-col items-center">
<h3 class="text-xs font-bold text-[#61896f] uppercase tracking-wider mb-6 self-start">Eco-Health Index Score</h3>
<div class="relative size-40">
<div class="gauge-gradient rounded-full size-full p-4">
<div class="bg-white dark:bg-[#1a2e21] rounded-full size-full flex flex-col items-center justify-center">
<span class="text-4xl font-black">88</span>
<span class="text-[10px] font-bold text-primary uppercase">Optimal</span>
</div>
</div>
</div>
<div class="grid grid-cols-2 w-full mt-6 gap-4 border-t border-[#dbe6df] dark:border-[#2a3a2e] pt-6">
<div class="text-center">
<p class="text-[10px] text-[#61896f] uppercase font-bold">Varieties</p>
<p class="text-xl font-bold">24</p>
</div>
<div class="text-center border-l border-[#dbe6df] dark:border-[#2a3a2e]">
<p class="text-[10px] text-[#61896f] uppercase font-bold">Signals/hr</p>
<p class="text-xl font-bold">1.2k</p>
</div>
</div>
</div>
<div class="bg-white dark:bg-[#1a2e21] rounded-xl border border-[#dbe6df] dark:border-[#2a3a2e] overflow-hidden">
<div class="p-4 border-b border-[#dbe6df] dark:border-[#2a3a2e] flex items-center justify-between bg-gray-50 dark:bg-white/5">
<h3 class="font-bold text-sm">Live Signals</h3>
<span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full">3 Alert</span>
</div>
<div class="divide-y divide-[#dbe6df] dark:divide-[#2a3a2e]">
<div class="p-4 flex gap-3 hover:bg-[#f0f4f2] dark:hover:bg-white/5 cursor-pointer">
<span class="material-symbols-outlined text-red-500">warning</span>
<div>
<p class="text-xs font-bold">Signal Drop - AMZ-042</p>
<p class="text-[10px] text-[#61896f]">2m ago</p>
</div>
</div>
<div class="p-4 flex gap-3 hover:bg-[#f0f4f2] dark:hover:bg-white/5 cursor-pointer">
<span class="material-symbols-outlined text-orange-500">sensors</span>
<div>
<p class="text-xs font-bold">Migration Pattern Shift</p>
<p class="text-[10px] text-[#61896f]">14m ago</p>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="bg-white dark:bg-[#1a2e21] p-8 rounded-xl border border-[#dbe6df] dark:border-[#2a3a2e]">
<div class="flex flex-wrap justify-between items-center mb-8 gap-4">
<div>
<h2 class="text-2xl font-bold">6-Month Historical Trends</h2>
<p class="text-[#61896f] text-sm font-medium">Tracking ecosystem translation data over the last half year</p>
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
<button class="px-4 py-1.5 text-xs font-bold rounded-md hover:bg-white transition-colors">1 Month</button>
<button class="px-4 py-1.5 text-xs font-bold bg-white dark:bg-primary dark:text-background-dark rounded-md shadow-sm">6 Months</button>
<button class="px-4 py-1.5 text-xs font-bold rounded-md hover:bg-white transition-colors">1 Year</button>
</div>
</div>
</div>
<div class="relative h-[320px] w-full mt-10">
<div class="absolute inset-0 chart-grid opacity-20"></div>
<div class="absolute left-0 top-0 h-full flex flex-col justify-between text-[10px] font-bold text-[#61896f] -translate-x-full pr-4 pb-8">
<span>100%</span>
<span>75%</span>
<span>50%</span>
<span>25%</span>
<span>0%</span>
</div>
<svg class="w-full h-full overflow-visible" preserveAspectRatio="none" viewBox="0 0 1200 300">
<path class="chart-line stroke-primary" d="M 100,200 L 300,160 L 500,80 L 700,220 L 900,140 L 1100,100"></path>
<path class="chart-line stroke-accent-blue" d="M 100,140 L 300,180 L 500,120 L 700,100 L 900,130 L 1100,60"></path>
<circle class="chart-dot fill-primary" cx="100" cy="200" r="5"></circle>
<circle class="chart-dot fill-primary" cx="300" cy="160" r="5"></circle>
<circle class="chart-dot fill-primary" cx="500" cy="80" r="5"></circle>
<circle class="chart-dot fill-primary" cx="700" cy="220" r="5"></circle>
<circle class="chart-dot fill-primary" cx="900" cy="140" r="5"></circle>
<circle class="chart-dot fill-primary" cx="1100" cy="100" r="5"></circle>
<circle class="chart-dot fill-accent-blue" cx="100" cy="140" r="5"></circle>
<circle class="chart-dot fill-accent-blue" cx="300" cy="180" r="5"></circle>
<circle class="chart-dot fill-accent-blue" cx="500" cy="120" r="5"></circle>
<circle class="chart-dot fill-accent-blue" cx="700" cy="100" r="5"></circle>
<circle class="chart-dot fill-accent-blue" cx="900" cy="130" r="5"></circle>
<circle class="chart-dot fill-accent-blue" cx="1100" cy="60" r="5"></circle>
<g transform="translate(450, 45)">
<rect fill="#111813" height="24" rx="4" width="100" x="0" y="0"></rect>
<text fill="white" font-size="10" font-weight="bold" text-anchor="middle" x="50" y="16">ANNUAL PEAK</text>
<path d="M 50,24 L 50,32" stroke="#111813" stroke-width="2"></path>
</g>
</svg>
<div class="absolute inset-x-0 bottom-0 flex justify-between px-[8.33%] translate-y-full pt-4">
<span class="text-[10px] font-bold text-[#61896f]">JAN</span>
<span class="text-[10px] font-bold text-[#61896f]">FEB</span>
<span class="text-[10px] font-bold text-[#111813] dark:text-white underline decoration-primary decoration-2 underline-offset-4">MAR</span>
<span class="text-[10px] font-bold text-[#61896f]">APR</span>
<span class="text-[10px] font-bold text-[#61896f]">MAY</span>
<span class="text-[10px] font-bold text-[#61896f]">JUN</span>
</div>
</div>
<div class="mt-16 pt-8 border-t border-[#dbe6df] dark:border-[#2a3a2e] grid grid-cols-1 md:grid-cols-3 gap-8">
<div class="p-5 rounded-xl bg-background-light dark:bg-background-dark/30 border border-[#dbe6df] dark:border-white/5">
<h4 class="text-[10px] font-bold text-[#61896f] uppercase tracking-widest mb-2">Translation Insight</h4>
<p class="text-sm font-medium">Acoustic translations indicate 12% rise in canopy-level interactions during peak dawn hours.</p>
</div>
<div class="p-5 rounded-xl bg-background-light dark:bg-background-dark/30 border border-[#dbe6df] dark:border-white/5">
<h4 class="text-[10px] font-bold text-[#61896f] uppercase tracking-widest mb-2">Stability Report</h4>
<p class="text-sm font-medium">Eco-health metrics maintained 88% stability despite heavy seasonal rainfall events.</p>
</div>
<div class="p-5 rounded-xl bg-background-light dark:bg-background-dark/30 border border-[#dbe6df] dark:border-white/5">
<h4 class="text-[10px] font-bold text-[#61896f] uppercase tracking-widest mb-2">Migration Hubs</h4>
<p class="text-sm font-medium">North Sector 4 identified as primary migratory corridor for 18 specific species.</p>
</div>
</div>
</div>
</main>
</div>

</body></html>