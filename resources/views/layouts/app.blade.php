<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PCAR') }} | Precision Automotive Wiki</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Metropolis:wght@700;800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }
        </style>
    </head>
    <body class="bg-background text-on-surface selection:bg-primary selection:text-on-primary font-sans antialiased">
        <!-- Top Navigation Bar -->
        <nav class="fixed top-0 z-50 w-full bg-surface/60 backdrop-blur-[20px] border-b border-outline-variant/30 shadow-[0_20px_50px_rgba(0,163,255,0.05)]">
            <div class="flex justify-between items-center w-full px-margin-page h-20 max-w-container-max mx-auto">
                <div class="flex items-center gap-stack-lg">
                    <a href="{{ url('/') }}" class="font-headline-lg text-headline-lg font-extrabold tracking-tighter text-on-surface">PCAR</a>
                    <div class="hidden md:flex items-center gap-gutter">
                        <a class="font-headline-md text-headline-md {{ request()->is('/') ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-on-surface' }} pb-1 transition-all duration-200" href="{{ url('/') }}">Home</a>
                        <a class="font-headline-md text-headline-md {{ request()->is('cars*') ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-on-surface' }} pb-1 transition-all duration-200" href="{{ route('cars.index') }}">Explore Cars</a>
                        <a class="font-headline-md text-headline-md {{ request()->is('compare*') ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-on-surface' }} pb-1 transition-all duration-200" href="{{ route('compare') }}">Compare</a>
                        <a class="font-headline-md text-headline-md {{ request()->is('brands*') ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-on-surface' }} pb-1 transition-all duration-200" href="{{ route('brands') }}">Brands</a>
                        <a class="font-headline-md text-headline-md {{ request()->is('categories*') ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-on-surface' }} pb-1 transition-all duration-200" href="{{ route('categories') }}">Categories</a>
                    </div>
                </div>
                <div class="flex items-center gap-stack-sm">
                    <div class="relative hidden lg:block group">
                        <input class="bg-surface-container-high border-none border-b border-secondary/30 focus:ring-0 focus:border-primary text-body-md font-body-md px-4 py-2 w-64 transition-all" placeholder="Search technical database..." type="text"/>
                        <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-secondary group-hover:text-primary transition-colors">search</span>
                    </div>
                    <button class="p-2 hover:bg-white/5 rounded-full transition-colors active:scale-95">
                        <span class="material-symbols-outlined text-on-surface-variant">favorite</span>
                    </button>
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 pl-3 pr-1 py-1 bg-surface-container-high hover:bg-surface-container-highest rounded-full border border-outline-variant/30 transition-all active:scale-95">
                                <span class="font-label-caps text-[10px] text-primary hidden md:block">{{ Auth::user()->name }}</span>
                                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center font-bold text-on-primary text-xs">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-3 w-56 glass-card machined-edge border border-outline-variant/50 shadow-2xl py-2 z-[60]"
                                 style="display: none;">
                                
                                <div class="px-4 py-2 border-b border-outline-variant/20 mb-2">
                                    <p class="text-[10px] font-label-caps text-secondary">Authorized Operator</p>
                                    <p class="font-body-md text-on-surface truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-on-surface hover:bg-primary/10 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-sm">dashboard</span>
                                    <span class="font-label-caps text-xs">Admin Dashboard</span>
                                </a>

                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-on-surface hover:bg-primary/10 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-sm">person_gear</span>
                                    <span class="font-label-caps text-xs">Profile Settings</span>
                                </a>

                                <div class="border-t border-outline-variant/20 mt-2 pt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-error hover:bg-error/10 transition-colors">
                                            <span class="material-symbols-outlined text-sm">logout</span>
                                            <span class="font-label-caps text-xs uppercase">Terminate Session</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="font-label-caps text-label-caps text-secondary hover:text-primary transition-colors">LOGIN</a>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="pt-20 min-h-screen">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="w-full bg-surface-container-lowest border-t border-outline-variant/20">
            <div class="w-full py-stack-lg px-margin-page flex flex-col md:flex-row justify-between items-start gap-gutter max-w-container-max mx-auto">
                <div class="flex flex-col gap-stack-sm max-w-sm">
                    <span class="font-headline-md text-headline-md text-on-surface-variant font-extrabold tracking-tighter">PCAR</span>
                    <p class="font-body-md text-body-md text-on-surface-variant/70">© {{ date('Y') }} PCAR Automotive Encyclopedia. Precision Engineered for Enthusiasts.</p>
                </div>
                <div class="grid grid-cols-2 gap-stack-lg">
                    <div class="flex flex-col gap-3">
                        <span class="font-label-caps text-label-caps text-primary">RESOURCES</span>
                        <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300" href="#">About PCAR</a>
                        <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300" href="#">Contribution Guidelines</a>
                        <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300" href="#">API Documentation</a>
                    </div>
                    <div class="flex flex-col gap-3">
                        <span class="font-label-caps text-label-caps text-primary">LEGAL</span>
                        <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300" href="#">Privacy Policy</a>
                        <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300" href="#">Contact Support</a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
