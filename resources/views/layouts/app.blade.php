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

        @yield('meta')

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap');
            
            :root {
                --primary: #98cbff;
                --surface: #0a0c10;
                --surface-container: #1a1d23;
            }

            body {
                background-color: var(--surface);
                -webkit-tap-highlight-color: transparent;
            }

            .glass-card {
                background: rgba(26, 29, 35, 0.6);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.05);
                box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);
            }

            .machined-edge {
                position: relative;
                clip-path: polygon(0 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%);
            }

            .safe-area-bottom { padding-bottom: env(safe-area-inset-bottom); }

            /* Interactive Feedback */
            button:active, a:active { transform: scale(0.96); }
            
            .nav-active-pill {
                position: absolute;
                bottom: -2px;
                left: 50%;
                transform: translateX(-50%);
                width: 4px;
                height: 4px;
                background: var(--primary);
                border-radius: 50%;
                box-shadow: 0 0 10px var(--primary);
            }

            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
                transition: all 0.3s ease;
            }
            .fill-1 { font-variation-settings: 'FILL' 1; }
        </style>
    </head>
    <body x-data="comparisonTray()" class="bg-background text-on-surface selection:bg-primary selection:text-on-primary font-sans antialiased">
        <!-- Notification Toast -->
        @if (session('success'))
            <div x-data="{ show: true }" 
                 x-init="setTimeout(() => show = false, 4000)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-y-2 opacity-0"
                 x-transition:enter-end="translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed top-24 right-8 z-[100] glass-card border-primary/50 p-4 flex items-center gap-4 shadow-2xl">
                <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                </div>
                <div>
                    <p class="font-label-caps text-[10px] text-secondary">SYSTEM CONFIRMATION</p>
                    <p class="font-body-md text-on-surface">{{ session('success') }}</p>
                </div>
            </div>
        @endif
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
                    <form action="{{ route('home') }}" method="GET" class="relative hidden lg:block group">
                        <input name="search" value="{{ request('search') }}" class="bg-surface-container-high border-none border-b border-secondary/30 focus:ring-0 focus:border-primary text-body-md font-body-md px-4 py-2 w-64 transition-all" placeholder="Search technical database..." type="text"/>
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2">
                            <span class="material-symbols-outlined text-secondary group-hover:text-primary transition-colors">search</span>
                        </button>
                    </form>
                    <a href="{{ route('favorites.index') }}" class="p-2 hover:bg-white/5 rounded-full transition-colors active:scale-95 flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-surface-variant">favorite</span>
                    </a>
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

                                <a href="{{ route('profile.show', Auth::user()) }}" class="flex items-center gap-3 px-4 py-2 text-on-surface hover:bg-primary/10 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-sm">person</span>
                                    <span class="font-label-caps text-xs">Tactical Profile</span>
                                </a>

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

        <!-- Mobile Bottom Navigation -->
        <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-surface-container/90 backdrop-blur-3xl border-t border-outline-variant/10 z-[110] px-4 py-3 safe-area-bottom shadow-[0_-10px_40px_rgba(0,0,0,0.4)]">
            <div class="flex justify-around items-center max-w-md mx-auto relative">
                <a href="{{ url('/') }}" class="flex flex-col items-center gap-1 relative group {{ Request::is('/') ? 'text-primary' : 'text-on-surface-variant' }}">
                    <span class="material-symbols-outlined {{ Request::is('/') ? 'fill-1 scale-110' : 'opacity-70' }} transition-all">home</span>
                    <span class="text-[9px] font-label-caps tracking-tighter">Home</span>
                    @if(Request::is('/')) <div class="nav-active-pill"></div> @endif
                </a>
                <a href="{{ route('cars.index') }}" class="flex flex-col items-center gap-1 relative group {{ Request::is('cars*') && !Request::is('cars/favorites') ? 'text-primary' : 'text-on-surface-variant' }}">
                    <span class="material-symbols-outlined {{ Request::is('cars*') && !Request::is('cars/favorites') ? 'fill-1 scale-110' : 'opacity-70' }} transition-all">explore</span>
                    <span class="text-[9px] font-label-caps tracking-tighter">Explore</span>
                    @if(Request::is('cars*') && !Request::is('cars/favorites')) <div class="nav-active-pill"></div> @endif
                </a>
                <a href="{{ route('compare') }}" class="flex flex-col items-center gap-1 relative group {{ Request::is('compare*') ? 'text-primary' : 'text-on-surface-variant' }}">
                    <span class="material-symbols-outlined {{ Request::is('compare*') ? 'fill-1 scale-110' : 'opacity-70' }} transition-all">compare_arrows</span>
                    <span class="text-[9px] font-label-caps tracking-tighter">Compare</span>
                    @if(Request::is('compare*')) <div class="nav-active-pill"></div> @endif
                </a>
                <a href="{{ route('favorites.index') }}" class="flex flex-col items-center gap-1 relative group {{ Request::is('*favorites*') ? 'text-primary' : 'text-on-surface-variant' }}">
                    <span class="material-symbols-outlined {{ Request::is('*favorites*') ? 'fill-1 scale-110' : 'opacity-70' }} transition-all">favorite</span>
                    <span class="text-[9px] font-label-caps tracking-tighter">Saved</span>
                    @if(Request::is('*favorites*')) <div class="nav-active-pill"></div> @endif
                </a>
                @auth
                    <a href="{{ route('garage') }}" class="flex flex-col items-center gap-1 relative group {{ Request::is('garage*') ? 'text-primary' : 'text-on-surface-variant' }}">
                        <span class="material-symbols-outlined {{ Request::is('garage*') ? 'fill-1 scale-110' : 'opacity-70' }} transition-all">garage</span>
                        <span class="text-[9px] font-label-caps tracking-tighter">Garage</span>
                        @if(Request::is('garage*')) <div class="nav-active-pill"></div> @endif
                    </a>
                @endauth
            </div>
        </nav>

        <footer class="w-full bg-surface-container-lowest border-t border-outline-variant/20 mb-20 lg:mb-0">
            <div class="w-full py-stack-lg px-margin-page flex flex-col md:flex-row justify-between items-start gap-gutter max-w-container-max mx-auto">
                <div class="flex flex-col gap-stack-sm max-w-sm">
                    <span class="font-headline-md text-headline-md text-on-surface-variant font-extrabold tracking-tighter">PCAR</span>
                    <p class="font-body-md text-body-md text-on-surface-variant/70">© {{ date('Y') }} PCAR Automotive Encyclopedia. Precision Engineered for Enthusiasts.</p>
                </div>
                <div class="grid grid-cols-2 gap-stack-lg">
                    <div class="flex flex-col gap-3">
                        <span class="font-label-caps text-label-caps text-primary">RESOURCES</span>
                        <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300" href="{{ route('about') }}">About PCAR</a>
                        <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300" href="{{ route('contribution') }}">Contribution Guidelines</a>
                        <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300" href="#">API Documentation</a>
                    </div>
                    <div class="flex flex-col gap-3">
                        <span class="font-label-caps text-label-caps text-primary">LEGAL</span>
                        <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300" href="{{ route('privacy') }}">Privacy Policy</a>
                        <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors duration-300" href="#">Contact Support</a>
                    </div>
                </div>
            </div>
        </footer>

    <div id="floating-exhaust-player" class="fixed bottom-[72px] lg:bottom-6 right-6 z-[120] w-[calc(100%-48px)] sm:w-[380px] transition-all duration-500 transform translate-y-32 opacity-0">
        <div class="glass-card machined-edge p-4 flex items-center justify-between gap-4 shadow-[0_20px_50px_rgba(0,0,0,0.5)] border-primary/20 backdrop-blur-2xl">
            <div class="flex items-center gap-3 min-w-0">
                <button id="floating-play-btn" class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center hover:scale-105 active:scale-95 transition-all shadow-[0_0_15px_rgba(152,203,255,0.4)]">
                    <span class="material-symbols-outlined text-sm">pause</span>
                </button>
                <div class="min-w-0">
                    <p class="font-label-caps text-[8px] text-primary tracking-widest uppercase">EXHAUST RESONANCE SPECIMEN</p>
                    <p id="floating-exhaust-title" class="font-body-md font-bold text-on-surface truncate pr-2">Vehicle Model</p>
                </div>
            </div>
            
            <div class="flex items-center gap-1.5 h-4 shrink-0 pr-1" id="floating-visualizer">
                @for($i=0; $i<8; $i++)
                    <div class="w-[3px] bg-primary/40 rounded-full h-1.5 floating-wave-bar"></div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Floating Comparison Tray (Adjusted for Bottom Nav) -->
    <div x-show="compareList.length > 0" 
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         class="fixed bottom-[72px] lg:bottom-6 left-1/2 -translate-x-1/2 z-[100] w-[95%] max-w-4xl"
         style="display: none;">
        <div class="glass-card machined-edge p-3 md:p-4 flex items-center justify-between gap-4 md:gap-6 shadow-[0_30px_60px_rgba(0,0,0,0.5)] border-primary/20 backdrop-blur-2xl">
                <div class="flex items-center gap-4 overflow-x-auto pb-1 scrollbar-none">
                    <template x-for="car in compareList" :key="car.model_id">
                        <div class="relative flex-shrink-0 group">
                            <img :src="car.image" onerror="imgError(this)" class="w-20 h-14 object-cover rounded border border-outline-variant/50 group-hover:border-primary transition-colors">
                            <button @click="removeFromCompare(car.model_id)" class="absolute -top-2 -right-2 bg-error text-on-error rounded-full p-0.5 scale-0 group-hover:scale-100 transition-transform shadow-lg">
                                <span class="material-symbols-outlined text-[12px]">close</span>
                            </button>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-1">
                                <span class="text-[8px] font-label-caps truncate text-white" x-text="car.model"></span>
                            </div>
                        </div>
                    </template>
                    <div x-show="compareList.length < 3" class="w-20 h-14 border-2 border-dashed border-outline-variant/30 rounded flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined">add</span>
                    </div>
                </div>

                <div class="flex items-center gap-4 shrink-0">
                    <div class="hidden sm:block">
                        <p class="font-label-caps text-[10px] text-secondary">READY TO COMPARE</p>
                        <p class="font-headline-md text-headline-md text-on-surface"><span x-text="compareList.length"></span> / 3 Selected</p>
                    </div>
                    <div class="flex gap-2">
                        <button @click="compareList = []" class="px-4 py-2 font-label-caps text-[11px] text-secondary hover:text-error transition-colors">CLEAR</button>
                        <button @click="proceedToCompare()" 
                                :disabled="compareList.length < 2"
                                class="bg-primary text-on-primary px-6 py-2 rounded-sm font-label-caps text-[11px] tracking-widest disabled:opacity-30 disabled:grayscale transition-all active:scale-95 shadow-[0_0_15px_rgba(152,203,255,0.3)]">
                            LAUNCH COMPARISON
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function comparisonTray() {
                return {
                    compareList: JSON.parse(localStorage.getItem('pcar_compare_list') || '[]'),
                    isTrayOpen: false,

                    init() {
                        // Cleanup zombie records (nulls or malformed data)
                        this.compareList = this.compareList.filter(c => c && c.model_id);
                        
                        this.$watch('compareList', (value) => {
                            localStorage.setItem('pcar_compare_list', JSON.stringify(value));
                        });
                    },

                    addToCompare(car) {
                        if (this.compareList.length >= 3 && !this.isInCompare(car.model_id)) {
                            this.$dispatch('notify', { message: 'Comparison vault is full (Max 3 specimens)', type: 'warning' });
                            return;
                        }
                        if (this.isInCompare(car.model_id)) {
                            this.removeFromCompare(car.model_id);
                            return;
                        }
                        this.compareList.push(car);
                        this.isTrayOpen = true;
                        this.$dispatch('notify', { message: car.model + ' added to comparison tray', type: 'success' });
                    },

                    removeFromCompare(modelId) {
                        this.compareList = this.compareList.filter(c => c.model_id !== modelId);
                        this.$dispatch('notify', { message: 'Specimen removed from tray', type: 'info' });
                    },

                    isInCompare(modelId) {
                        return this.compareList.some(c => c.model_id === modelId);
                    },

                    proceedToCompare() {
                        if (this.compareList.length < 2) return;
                        const car1 = this.compareList[0].model_id;
                        const car2 = this.compareList[1].model_id;
                        const car3 = this.compareList[2] ? this.compareList[2].model_id : '';
                        
                        let url = `{{ route('compare') }}?car1=${car1}&car2=${car2}`;
                        if (car3) url += `&car3=${car3}`;
                        
                        window.location.href = url;
                    }
                }
            }

            function imgError(image) {
                image.onerror = "";
                image.src = "https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&q=80&w=800";
                return true;
            }

            // Global Floating Exhaust Player Controller
            window.globalExhaustPlayer = {
                activeAudio: null,
                activeYtPlayer: null,
                activeBtn: null,
                currentTitle: '',
                isPlaying: false,

                show(title, isPlaying) {
                    const el = document.getElementById('floating-exhaust-player');
                    document.getElementById('floating-exhaust-title').innerText = title;
                    el.classList.remove('translate-y-32', 'opacity-0');
                    el.classList.add('translate-y-0', 'opacity-100');
                    this.updateUI(isPlaying);
                },

                hide() {
                    const el = document.getElementById('floating-exhaust-player');
                    el.classList.add('translate-y-32', 'opacity-0');
                    el.classList.remove('translate-y-0', 'opacity-100');
                },

                updateUI(isPlaying) {
                    this.isPlaying = isPlaying;
                    const btnIcon = document.querySelector('#floating-play-btn span');
                    const bars = document.querySelectorAll('.floating-wave-bar');
                    
                    if (btnIcon) {
                        btnIcon.innerText = isPlaying ? 'pause' : 'play_arrow';
                    }
                    
                    bars.forEach((bar, i) => {
                        if (isPlaying) {
                            bar.style.animation = `soundWave 0.5s ease-in-out infinite alternate ${i * 0.05}s`;
                        } else {
                            bar.style.animation = 'none';
                            bar.style.height = '6px';
                        }
                    });
                }
            };

            // Global floating play button click event
            document.getElementById('floating-play-btn').addEventListener('click', () => {
                if (window.globalExhaustPlayer.activeAudio) {
                    const audio = window.globalExhaustPlayer.activeAudio;
                    if (audio.paused) {
                        audio.play();
                        window.globalExhaustPlayer.updateUI(true);
                        if (window.globalExhaustPlayer.activeBtn) {
                            window.globalExhaustPlayer.activeBtn.querySelector('.play-icon').classList.add('hidden');
                            window.globalExhaustPlayer.activeBtn.querySelector('.pause-icon').classList.remove('hidden');
                            window.globalExhaustPlayer.activeBtn.closest('.glass-card').querySelectorAll('.wave-bar').forEach((bar, i) => {
                                bar.style.animation = `soundWave 0.5s ease-in-out infinite alternate ${i * 0.05}s`;
                            });
                        }
                    } else {
                        audio.pause();
                        window.globalExhaustPlayer.updateUI(false);
                        if (window.globalExhaustPlayer.activeBtn) {
                            window.globalExhaustPlayer.activeBtn.querySelector('.play-icon').classList.remove('hidden');
                            window.globalExhaustPlayer.activeBtn.querySelector('.pause-icon').classList.add('hidden');
                            window.globalExhaustPlayer.activeBtn.closest('.glass-card').querySelectorAll('.wave-bar').forEach(bar => {
                                bar.style.animation = 'none';
                                bar.style.height = '8px';
                            });
                        }
                    }
                } else if (window.globalExhaustPlayer.activeYtPlayer) {
                    const yt = window.globalExhaustPlayer.activeYtPlayer;
                    const state = yt.getPlayerState();
                    if (state === 1) { // playing
                        yt.pauseVideo();
                        window.globalExhaustPlayer.updateUI(false);
                        if (window.globalExhaustPlayer.activeBtn) {
                            window.globalExhaustPlayer.activeBtn.querySelector('.play-icon').classList.remove('hidden');
                            window.globalExhaustPlayer.activeBtn.querySelector('.pause-icon').classList.add('hidden');
                            window.globalExhaustPlayer.activeBtn.closest('.glass-card').querySelectorAll('.wave-bar').forEach(bar => {
                                bar.style.animation = 'none';
                                bar.style.height = '8px';
                            });
                        }
                    } else {
                        yt.playVideo();
                        window.globalExhaustPlayer.updateUI(true);
                        if (window.globalExhaustPlayer.activeBtn) {
                            window.globalExhaustPlayer.activeBtn.querySelector('.play-icon').classList.add('hidden');
                            window.globalExhaustPlayer.activeBtn.querySelector('.pause-icon').classList.remove('hidden');
                            window.globalExhaustPlayer.activeBtn.closest('.glass-card').querySelectorAll('.wave-bar').forEach((bar, i) => {
                                bar.style.animation = `soundWave 0.5s ease-in-out infinite alternate ${i * 0.05}s`;
                            });
                        }
                    }
                }
            });
        </script>
    </body>
</html>
