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
                        <a href="{{ route('dashboard') }}" class="p-2 hover:bg-white/5 rounded-full transition-colors active:scale-95">
                            <span class="material-symbols-outlined text-on-surface-variant">admin_panel_settings</span>
                        </a>
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
