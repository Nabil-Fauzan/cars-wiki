<x-app-layout>
    @section('meta')
        <meta property="og:title" content="{{ $car->brands->first()->name ?? '' }} {{ $car->model }} | PCAR Wiki">
        <meta property="og:description" content="{{ $car->history ? Str::limit($car->history, 160) : 'Explore technical specifications, performance metrics, and tactical data for the ' . $car->model . ' on PCAR Wiki.' }}">
        <meta property="og:image" content="{{ $car->image_url }}">
        <meta property="og:type" content="website">
        <meta name="twitter:card" content="summary_large_image">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endsection
    <main class="pt-0">
        <!-- Hero Section & Gallery -->
        <section class="relative w-full h-[716px] overflow-hidden bg-surface-container-lowest">
            <img alt="{{ $car->brands->first()->name ?? 'Vehicle' }} {{ $car->model }}" onerror="imgError(this)" class="w-full h-full object-cover opacity-80" src="{{ $car->image_url }}"/>
            <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent"></div>
            <div class="absolute bottom-margin-page left-margin-page right-margin-page max-w-container-max mx-auto">
                <div class="flex flex-col gap-2">
                <div class="flex items-center gap-3">
                    @foreach($car->brands as $brand)
                        <span class="font-label-caps text-label-caps text-primary-fixed uppercase tracking-widest">{{ $brand->name }}</span>
                        @if(!$loop->last) <span class="text-secondary/50">•</span> @endif
                    @endforeach
                    <span class="text-secondary/50 mx-2">|</span>
                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-widest">{{ $car->category }} Series</span>
                </div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface">{{ $car->model }}</h1>
                    <div class="flex items-center gap-4 mt-stack-sm">
                        <button @click="addToCompare({ model_id: '{{ $car->model_id }}', model: '{{ $car->model }}', image: '{{ $car->image_url }}' })" 
                                class="px-stack-md py-3 font-label-caps text-label-caps rounded-[4px] hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2"
                                :class="isInCompare('{{ $car->model_id }}') ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface border border-outline-variant/30'">
                            <span class="material-symbols-outlined" x-text="isInCompare('{{ $car->model_id }}') ? 'check_circle' : 'compare_arrows'"></span>
                            <span x-text="isInCompare('{{ $car->model_id }}') ? 'In Comparison Tray' : 'Compare with another car'"></span>
                        </button>
                        @auth
                            <form action="{{ route('cars.favorite', $car) }}" method="POST">
                                @csrf
                                <button type="submit" class="border border-secondary px-stack-md py-3 text-on-surface font-label-caps text-label-caps rounded-[4px] hover:bg-white/5 transition-all flex items-center gap-2">
                                    <span class="material-symbols-outlined {{ auth()->user()->favorites->contains($car->id) ? 'fill-1 text-primary' : '' }}">favorite</span> 
                                    {{ auth()->user()->favorites->contains($car->id) ? 'In Favorites' : 'Add to Favorites' }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="border border-secondary px-stack-md py-3 text-on-surface font-label-caps text-label-caps rounded-[4px] hover:bg-white/5 transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined">favorite</span> Add to Favorites
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-container-max mx-auto px-margin-page py-stack-lg flex flex-col lg:flex-row gap-gutter">
            <!-- Left Column: Specs & History -->
            <div class="flex-1 space-y-stack-lg">
                @php
                    $extractNumeric = function ($val) {
                        if (is_numeric($val)) return (float) $val;
                        if (empty($val)) return 0.0;
                        preg_match('/[\d\.]+/', $val, $matches);
                        return isset($matches[0]) ? (float) $matches[0] : 0.0;
                    };
                @endphp
                <!-- Performance Gauges (Modern Digital Style) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-stack-sm">
                    <div class="glass-card p-stack-sm machined-edge opacity-0 gsap-gauge">
                        <p class="font-label-caps text-label-caps text-secondary">0-60 MPH</p>
                        <p class="font-headline-md text-headline-md text-primary mt-1">
                            {{ is_numeric($car->zero_to_sixty) ? $car->zero_to_sixty . 's' : $car->zero_to_sixty }}
                        </p>
                        <div class="flex gap-1 mt-2">
                            @php
                                $val = $extractNumeric($car->zero_to_sixty);
                                $segments = max(0, min(5, floor(($val / 5) * 5)));
                            @endphp
                            @for($i=0; $i<5; $i++)
                                <div class="gauge-segment flex-1 {{ $i < (5 - $segments) ? '' : 'opacity-20' }}"></div>
                            @endfor
                        </div>
                    </div>
                    <div class="glass-card p-stack-sm machined-edge opacity-0 gsap-gauge">
                        <p class="font-label-caps text-label-caps text-secondary">TOP SPEED</p>
                        <p class="font-headline-md text-headline-md text-primary mt-1">
                            {{ (is_numeric($car->top_speed) || !str_contains(strtolower($car->top_speed), 'mph')) ? $car->top_speed . ' MPH' : $car->top_speed }}
                        </p>
                        <div class="flex gap-1 mt-2">
                            @php
                                $val = $extractNumeric($car->top_speed);
                                $segments = max(0, min(5, floor(($val / 250) * 5)));
                            @endphp
                            @for($i=0; $i<5; $i++)
                                <div class="gauge-segment flex-1 {{ $i < $segments ? '' : 'opacity-20' }}"></div>
                            @endfor
                        </div>
                    </div>
                    <div class="glass-card p-stack-sm machined-edge opacity-0 gsap-gauge">
                        <p class="font-label-caps text-label-caps text-secondary">AERODYNAMICS</p>
                        <p class="font-headline-md text-headline-md text-primary mt-1">
                            {{ (is_numeric($car->aerodynamics) || !str_contains(strtolower($car->aerodynamics), 'cd')) ? $car->aerodynamics . ' CD' : $car->aerodynamics }}
                        </p>
                        <div class="flex gap-1 mt-2">
                            @php
                                $val = $extractNumeric($car->aerodynamics);
                                $segments = max(0, min(5, floor((1 - $val) * 5)));
                            @endphp
                            @for($i=0; $i<5; $i++)
                                <div class="gauge-segment flex-1 {{ $i < $segments ? '' : 'opacity-20' }}"></div>
                            @endfor
                        </div>
                    </div>
                    <div class="glass-card p-stack-sm machined-edge opacity-0 gsap-gauge">
                        <p class="font-label-caps text-label-caps text-secondary">BRAKING</p>
                        <p class="font-headline-md text-headline-md text-primary mt-1">
                            {{ (is_numeric($car->braking) || !str_contains(strtolower($car->braking), 'ft')) ? $car->braking . ' FT' : $car->braking }}
                        </p>
                        <div class="flex gap-1 mt-2">
                            @php
                                $val = $extractNumeric($car->braking);
                                $segments = max(0, min(5, floor((150 - $val) / 10)));
                            @endphp
                            @for($i=0; $i<5; $i++)
                                <div class="gauge-segment flex-1 {{ $i < $segments ? '' : 'opacity-20' }}"></div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Engine Sound & Market Insights -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-sm">
                    <!-- Engine Sound Library -->
                    <div class="glass-card p-stack-md machined-edge flex flex-col justify-center gap-4">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">graphic_eq</span>
                            <h3 class="font-label-caps text-label-caps text-on-surface">Engine Sound Library</h3>
                        </div>
                        @if($car->engine_sound_url)
                            <div class="bg-surface-container-low/50 p-4 rounded-lg border border-outline-variant/30 flex items-center gap-4">
                                <button onclick="toggleSound(this, '{{ $car->engine_sound_url }}')" class="w-12 h-12 rounded-full bg-primary text-on-primary flex items-center justify-center hover:scale-105 transition-transform active:scale-95 shadow-[0_0_15px_rgba(152,203,255,0.4)]">
                                    <span class="material-symbols-outlined play-icon">play_arrow</span>
                                    <span class="material-symbols-outlined pause-icon hidden">pause</span>
                                </button>
                                <div class="flex-1">
                                    <p class="font-label-caps text-[10px] text-primary">TACTICAL AUDIO FEED</p>
                                    <p class="font-body-md text-on-surface">Powerplant Resonance</p>
                                </div>
                                <div class="flex gap-0.5 items-center h-4">
                                    @for($i=0; $i<12; $i++)
                                        <div class="w-0.5 bg-primary/30 rounded-full h-2 wave-bar"></div>
                                    @endfor
                                </div>
                            </div>
                        @else
                            <div class="py-6 text-center border border-dashed border-outline-variant/30 rounded">
                                <p class="text-xs font-body-md text-on-surface-variant opacity-50">Audio specimen not yet recorded.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Marketplace Insights -->
                    <div class="glass-card p-stack-md machined-edge">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">payments</span>
                                <h3 class="font-label-caps text-label-caps text-on-surface">Market Insights</h3>
                            </div>
                            @if($car->price_trend)
                                <div class="flex items-center gap-1 {{ $car->price_trend == 'up' ? 'text-success' : ($car->price_trend == 'down' ? 'text-error' : 'text-secondary') }}">
                                    <span class="material-symbols-outlined text-sm">
                                        {{ $car->price_trend == 'up' ? 'trending_up' : ($car->price_trend == 'down' ? 'trending_down' : 'trending_flat') }}
                                    </span>
                                    <span class="font-label-caps text-[10px]">{{ strtoupper($car->price_trend) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <p class="font-label-caps text-[10px] text-secondary">FAIR MARKET VALUE</p>
                                <p class="font-headline-md text-on-surface">
                                    @if($car->avg_price >= 1000)
                                        ${{ number_format($car->avg_price / 1000, 0) }}k
                                    @else
                                        ${{ number_format($car->avg_price ?? 0) }}
                                    @endif
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-label-caps text-[10px] text-secondary">RANGE</p>
                                <p class="font-body-md text-on-surface-variant">
                                    @if($car->min_price >= 1000)
                                        ${{ number_format($car->min_price / 1000, 0) }}k
                                    @else
                                        ${{ number_format($car->min_price ?? 0) }}
                                    @endif
                                    — 
                                    @if($car->max_price >= 1000)
                                        ${{ number_format($car->max_price / 1000, 0) }}k
                                    @else
                                        ${{ number_format($car->max_price ?? 0) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 h-1 w-full bg-surface-container-highest rounded-full overflow-hidden relative">
                            <div class="absolute inset-y-0 bg-primary/20" style="left: 20%; right: 20%;"></div>
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-2 h-2 bg-primary rounded-full shadow-[0_0_10px_#98cbff]"></div>
                        </div>
                    </div>
                </div>

                <!-- History Section -->
                <section class="glass-card p-stack-md machined-edge">
                    <h2 class="font-headline-lg text-headline-lg mb-stack-sm">Legacy & Heritage</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                        {{ $car->history }}
                    </p>
                </section>
                <!-- Technical Specifications Table -->
                <div x-data="{ correctionModalOpen: false }">
                    <section class="glass-card machined-edge overflow-hidden">
                        <div class="p-stack-sm bg-surface-container-highest border-b border-outline-variant/30 flex justify-between items-center">
                            <h3 class="font-label-caps text-label-caps">Technical Specifications</h3>
                            @auth
                                <button type="button" @click="correctionModalOpen = true" class="text-xs text-primary font-semibold flex items-center gap-1 hover:underline">
                                    <span class="material-symbols-outlined text-[14px]">edit_note</span> Propose Correction
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="text-xs text-secondary/70 flex items-center gap-1 hover:underline">
                                    <span class="material-symbols-outlined text-[14px]">edit_note</span> Login to Propose Correction
                                </a>
                            @endauth
                        </div>
                        <div class="divide-y divide-outline-variant/10">
                            <div class="grid grid-cols-2 p-stack-sm hover:bg-white/5 transition-colors opacity-0 gsap-spec-row">
                                <span class="font-label-caps text-label-caps text-secondary">Engine Configuration</span>
                                <div class="flex flex-col gap-1">
                                    @if(is_array($car->engine))
                                        @foreach($car->engine as $variant)
                                            <span class="font-body-md text-body-md text-on-surface">{{ $variant }}</span>
                                        @endforeach
                                    @else
                                        <span class="font-body-md text-body-md text-on-surface">{{ $car->engine }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="grid grid-cols-2 p-stack-sm hover:bg-white/5 transition-colors">
                                <span class="font-label-caps text-label-caps text-secondary">Horsepower Output</span>
                                <div class="flex flex-col gap-1">
                                    @if(is_array($car->hp))
                                        @foreach($car->hp as $rating)
                                            <span class="font-body-md text-body-md text-on-surface">{{ $rating }} HP</span>
                                        @endforeach
                                    @else
                                        <span class="font-body-md text-body-md text-on-surface">{{ $car->hp }} HP</span>
                                    @endif
                                </div>
                            </div>
                            <div class="grid grid-cols-2 p-stack-sm hover:bg-white/5 transition-colors">
                                <span class="font-label-caps text-label-caps text-secondary">Torque</span>
                                <div class="flex flex-col gap-1">
                                    @if(is_array($car->torque))
                                        @foreach($car->torque as $rating)
                                            <span class="font-body-md text-body-md text-on-surface">{{ $rating }}</span>
                                        @endforeach
                                    @else
                                        <span class="font-body-md text-body-md text-on-surface">{{ $car->torque }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="grid grid-cols-2 p-stack-sm hover:bg-white/5 transition-colors">
                                <span class="font-label-caps text-label-caps text-secondary">Transmission</span>
                                <span class="font-body-md text-body-md text-on-surface">{{ $car->transmission }}</span>
                            </div>
                            <div class="grid grid-cols-2 p-stack-sm hover:bg-white/5 transition-colors opacity-0 gsap-spec-row">
                                <span class="font-label-caps text-label-caps text-secondary">Drivetrain</span>
                                <span class="font-body-md text-body-md text-on-surface">{{ $car->drivetrain }}</span>
                            </div>
                        </div>
                    </section>

                    <!-- Correction Modal -->
                    <div x-show="correctionModalOpen" 
                         style="display: none;" 
                         class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-background/80 backdrop-blur-md"
                         @keydown.escape.window="correctionModalOpen = false">
                        <div class="glass-card w-full max-w-2xl machined-edge overflow-hidden shadow-2xl relative" @click.away="correctionModalOpen = false">
                            <div class="p-stack-md border-b border-outline-variant/30 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">edit_note</span>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Propose Spec Correction</h3>
                                </div>
                                <button type="button" @click="correctionModalOpen = false" class="text-secondary hover:text-on-surface">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </div>
                            
                            <form action="{{ route('cars.suggest', $car) }}" method="POST" class="p-stack-md space-y-4">
                                @csrf
                                <p class="text-xs font-body-md text-on-surface-variant">
                                    Help keep the PCAR Wiki database absolute and perfect. Diffs are compared side-by-side by the moderation queue. Leaving fields blank will preserve the current values.
                                </p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block font-label-caps text-[10px] text-secondary mb-1">Horsepower Rating</label>
                                        <input type="text" name="hp" placeholder="e.g. 400 hp" value="{{ is_array($car->hp) ? implode(', ', $car->hp) : $car->hp }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded px-3 py-2 text-on-surface focus:outline-none focus:border-primary text-xs font-mono">
                                    </div>
                                    <div>
                                        <label class="block font-label-caps text-[10px] text-secondary mb-1">Torque</label>
                                        <input type="text" name="torque" placeholder="e.g. 369 lb-ft" value="{{ is_array($car->torque) ? implode(', ', $car->torque) : $car->torque }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded px-3 py-2 text-on-surface focus:outline-none focus:border-primary text-xs font-mono">
                                    </div>
                                    <div>
                                        <label class="block font-label-caps text-[10px] text-secondary mb-1">0-60 MPH</label>
                                        <input type="text" name="zero_to_sixty" placeholder="e.g. 7.0 detik (NA)" value="{{ $car->zero_to_sixty }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded px-3 py-2 text-on-surface focus:outline-none focus:border-primary text-xs font-mono">
                                    </div>
                                    <div>
                                        <label class="block font-label-caps text-[10px] text-secondary mb-1">Top Speed</label>
                                        <input type="text" name="top_speed" placeholder="e.g. 180 mph" value="{{ $car->top_speed }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded px-3 py-2 text-on-surface focus:outline-none focus:border-primary text-xs font-mono">
                                    </div>
                                    <div>
                                        <label class="block font-label-caps text-[10px] text-secondary mb-1">Transmission</label>
                                        <input type="text" name="transmission" value="{{ $car->transmission }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded px-3 py-2 text-on-surface focus:outline-none focus:border-primary text-xs font-mono">
                                    </div>
                                    <div>
                                        <label class="block font-label-caps text-[10px] text-secondary mb-1">Drivetrain</label>
                                        <input type="text" name="drivetrain" value="{{ $car->drivetrain }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded px-3 py-2 text-on-surface focus:outline-none focus:border-primary text-xs font-mono">
                                    </div>
                                    <div>
                                        <label class="block font-label-caps text-[10px] text-secondary mb-1">Entry Price ($)</label>
                                        <input type="number" name="min_price" value="{{ $car->min_price }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded px-3 py-2 text-on-surface focus:outline-none focus:border-primary text-xs font-mono">
                                    </div>
                                    <div>
                                        <label class="block font-label-caps text-[10px] text-secondary mb-1">Peak Price ($)</label>
                                        <input type="number" name="max_price" value="{{ $car->max_price }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded px-3 py-2 text-on-surface focus:outline-none focus:border-primary text-xs font-mono">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block font-label-caps text-[10px] text-secondary mb-1">Exhaust Sound URL</label>
                                        <input type="url" name="engine_sound_url" placeholder="https://youtube.com/watch?v=..." value="{{ $car->engine_sound_url }}" class="w-full bg-surface-container-low border border-outline-variant/30 rounded px-3 py-2 text-on-surface focus:outline-none focus:border-primary text-xs font-mono">
                                    </div>
                                </div>
                                
                                <div class="pt-4 border-t border-outline-variant/30 flex justify-end gap-3">
                                    <button type="button" @click="correctionModalOpen = false" class="px-4 py-2 border border-outline-variant/30 hover:bg-white/5 rounded text-xs font-label-caps text-on-surface transition-all">Cancel</button>
                                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-hover text-on-primary rounded text-xs font-label-caps transition-all flex items-center gap-1.5 shadow-[0_0_15px_rgba(152,203,255,0.3)]">
                                        <span class="material-symbols-outlined text-sm">publish</span> Submit Correction
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Pros & Cons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-sm">
                    <div class="glass-card p-stack-md machined-edge border-l-4 border-l-primary">
                        <h4 class="font-label-caps text-label-caps text-primary mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">add_circle</span> Strategic Advantages
                        </h4>
                        <ul class="space-y-3 font-body-md text-on-surface-variant">
                            @foreach($car->pros as $pro)
                                <li class="flex items-start gap-2"><span class="material-symbols-outlined text-primary text-sm mt-1">check</span> {{ $pro }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="glass-card p-stack-md machined-edge border-l-4 border-l-error">
                        <h4 class="font-label-caps text-label-caps text-error mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">remove_circle</span> Engineering Trade-offs
                        </h4>
                        <ul class="space-y-3 font-body-md text-on-surface-variant">
                            @foreach($car->cons as $con)
                                <li class="flex items-start gap-2"><span class="material-symbols-outlined text-error text-sm mt-1">close</span> {{ $con }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Rating System -->
                <section class="glass-card p-stack-md machined-edge space-y-stack-md">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">analytics</span>
                            <h3 class="font-label-caps text-label-caps text-on-surface">Community Assessment</h3>
                        </div>
                        @php
                            $avgComfort = $ratingStats->comfort ?? 0;
                            $avgPerformance = $ratingStats->performance ?? 0;
                            $avgDesign = $ratingStats->design ?? 0;
                            $avgValue = $ratingStats->value ?? 0;
                            $overall = ($avgComfort + $avgPerformance + $avgDesign + $avgValue) / 4;
                        @endphp
                        <div class="text-right">
                            <p class="font-label-caps text-[10px] text-secondary">OVERALL RATING</p>
                            <p class="font-headline-md text-primary">{{ number_format($overall, 1) }} / 5.0</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter items-center">
                        <!-- Radar Chart View -->
                        <div class="relative aspect-square max-w-[300px] mx-auto w-full">
                            <canvas id="specRadarChart"></canvas>
                        </div>

                        <div class="space-y-6">
                            <!-- Stats List -->
                            <div class="grid grid-cols-2 gap-4">
                                @foreach(['Comfort' => $avgComfort, 'Performance' => $avgPerformance, 'Design' => $avgDesign, 'Value' => $avgValue] as $label => $score)
                                    <div class="glass-card p-3 border-l-2 border-primary">
                                        <div class="flex justify-between items-center">
                                            <span class="text-[10px] font-label-caps text-secondary">{{ $label }}</span>
                                            <span class="text-lg font-headline-md text-on-surface">{{ number_format($score, 1) }}</span>
                                        </div>
                                        <div class="h-1 w-full bg-surface-container-highest mt-2 rounded-full overflow-hidden">
                                            <div class="h-full bg-primary" style="width: {{ ($score/5)*100 }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Rating Form -->
                            @auth
                                @php $myRating = $car->ratings()->where('user_id', Auth::id())->first(); @endphp
                                <form action="{{ route('cars.rate', $car) }}" method="POST" class="bg-surface-container-low/30 p-4 rounded space-y-4 border border-outline-variant/20">
                                    @csrf
                                    <div class="grid grid-cols-2 gap-4">
                                        @foreach(['comfort', 'performance', 'design', 'value'] as $field)
                                            <div class="flex flex-col gap-1">
                                                <label class="text-[10px] font-label-caps text-secondary uppercase">{{ $field }}</label>
                                                <input type="range" name="{{ $field }}" min="1" max="5" step="1" value="{{ $myRating ? $myRating->$field : 3 }}" class="w-full h-1 bg-surface-container-highest rounded-lg appearance-none cursor-pointer accent-primary">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="w-full py-2 bg-primary text-on-primary font-label-caps text-xs hover:brightness-110 transition-all shadow-[0_0_15px_rgba(152,203,255,0.2)]">
                                        {{ $myRating ? 'UPDATE MY ASSESSMENT' : 'SUBMIT ASSESSMENT' }}
                                    </button>
                                </form>
                            @else
                                <div class="flex flex-col items-center justify-center border border-dashed border-outline-variant/30 rounded p-6 text-center">
                                    <span class="material-symbols-outlined text-secondary mb-2">lock</span>
                                    <p class="text-xs font-body-md text-on-surface-variant mb-4">Authentication required to submit assessments.</p>
                                    <a href="{{ route('login') }}" class="text-primary font-label-caps text-[10px] border border-primary/30 px-4 py-2 hover:bg-primary/10 transition-all">LOG IN</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </section>

                <!-- Tactical Log (Comment Section) -->
                <section class="mt-stack-lg space-y-stack-md">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">forum</span>
                        <h3 class="font-label-caps text-label-caps text-on-surface">Tactical Discussion Log</h3>
                    </div>

                    @auth
                        <form action="{{ route('comments.store', $car->id) }}" method="POST" class="glass-card p-stack-sm machined-edge space-y-3">
                            @csrf
                            <textarea name="content" rows="3" class="w-full bg-surface-container-low border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3 font-body-md" placeholder="Enter transmission data..." required></textarea>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-primary text-on-primary px-6 py-2 font-label-caps text-label-caps hover:brightness-110 transition-all">DEPLOY COMMENT</button>
                            </div>
                        </form>
                    @else
                        <div class="glass-card p-stack-md machined-edge text-center border border-dashed border-outline-variant">
                            <p class="font-body-md text-on-surface-variant mb-4">Authorization required to access tactical logs.</p>
                            <a href="{{ route('login') }}" class="text-primary font-label-caps text-label-caps hover:underline">AUTHENTICATE NOW</a>
                        </div>
                    @endauth

                    <div class="space-y-4">
                        @forelse($car->comments()->latest()->get() as $comment)
                            <div class="glass-card p-stack-sm machined-edge border border-outline-variant/10 group">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-surface-container-highest flex items-center justify-center font-bold text-primary text-xs">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-label-caps text-xs text-primary">{{ $comment->user->name }}</p>
                                            <p class="text-[10px] text-on-surface-variant font-mono">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    @if(Auth::id() === $comment->user_id)
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-error hover:scale-110 transition-transform">
                                                <span class="material-symbols-outlined text-sm">delete</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="mt-3 font-body-md text-on-surface leading-relaxed">
                                    {{ $comment->content }}
                                </div>
                            </div>
                        @empty
                            <div class="py-10 text-center">
                                <p class="font-body-md text-on-surface-variant opacity-50 italic">No tactical data recorded for this specimen.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- Right Column: Gallery & Related -->
            <div class="lg:w-96 space-y-stack-lg">
                <!-- Asset Gallery -->
                @if(!empty($car->gallery))
                    <section class="space-y-stack-sm">
                        <h3 class="font-label-caps text-label-caps text-secondary">Asset Gallery</h3>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($car->gallery as $image)
                                <div class="glass-card overflow-hidden aspect-video group cursor-zoom-in" onclick="openLightbox('{{ $image }}')">
                                    <img src="{{ $image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Related Cars -->
                <section class="space-y-stack-sm">
                    <h3 class="font-label-caps text-label-caps text-secondary">Recommended Rivals</h3>
                    <div class="space-y-stack-sm">
                        @foreach($rivals as $rival)
                            <!-- Related Item -->
                            <a href="{{ route('cars.show', $rival->model_id) }}" class="glass-card machined-edge p-stack-sm flex gap-4 group cursor-pointer hover:border-primary transition-colors">
                                <div class="w-20 h-20 bg-surface-container-low flex-shrink-0">
                                    <img alt="{{ $rival->model }}" class="w-full h-full object-cover" src="{{ $rival->image_url }}"/>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <span class="font-label-caps text-[10px] text-primary">{{ $rival->brands->first()->name ?? '' }}</span>
                                    <h4 class="font-label-caps text-on-surface">{{ $rival->model }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                @auth
                <!-- Personal Curator Notes -->
                <section class="mt-stack-lg">
                    <div class="flex items-center gap-4 mb-6">
                        <h2 class="font-label-caps text-label-caps text-secondary tracking-widest uppercase">Private Curator Notes</h2>
                        <div class="h-px flex-1 bg-gradient-to-r from-outline-variant/50 to-transparent"></div>
                    </div>
                    <div class="glass-card p-stack-md machined-edge">
                        <form action="{{ route('cars.notes.save', $car) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-primary">edit_note</span>
                                </div>
                                <div class="flex-1">
                                    <label for="content" class="block font-label-caps text-[10px] text-on-surface-variant mb-2">PRIVATE OBSERVATIONS (VISIBLE ONLY TO YOU)</label>
                                    <textarea name="content" id="content" rows="3" 
                                              class="w-full bg-surface-container-low border border-outline-variant/30 rounded p-4 text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all"
                                              placeholder="Write your personal thoughts, VIN details, or restoration goals...">{{ $personalNote ? $personalNote->content : '' }}</textarea>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-primary text-on-primary px-6 py-2 font-label-caps text-label-caps hover:bg-primary-container hover:text-on-primary-container transition-all flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    {{ $personalNote ? 'Update Note' : 'Save Note' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
                @endauth
            </div>

            <!-- Lightbox Modal -->
            <div id="yt-player" class="hidden"></div>
            <div id="lightbox" class="fixed inset-0 z-[100] bg-background/95 backdrop-blur-xl hidden flex items-center justify-center p-8 transition-all duration-300 opacity-0" onclick="closeLightbox()">
                <img id="lightbox-img" src="" class="max-w-full max-h-full object-contain shadow-2xl scale-95 transition-transform duration-300">
                <button class="absolute top-8 right-8 text-on-surface hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[40px]">close</span>
                </button>
            </div>

            <script>
                function openLightbox(src) {
                    const lb = document.getElementById('lightbox');
                    const img = document.getElementById('lightbox-img');
                    img.src = src;
                    lb.classList.remove('hidden');
                    setTimeout(() => {
                        lb.classList.add('flex', 'opacity-100');
                        img.classList.remove('scale-95');
                        img.classList.add('scale-100');
                    }, 10);
                }

                function closeLightbox() {
                    const lb = document.getElementById('lightbox');
                    const img = document.getElementById('lightbox-img');
                    lb.classList.remove('opacity-100');
                    img.classList.remove('scale-100');
                    img.classList.add('scale-95');
                    setTimeout(() => {
                        lb.classList.add('hidden');
                        lb.classList.remove('flex');
                    }, 300);
                }

                const ctx = document.getElementById('specRadarChart');
                if (ctx) {
                    new Chart(ctx, {
                        // ... existing chart config ...
                        type: 'radar',
                        data: {
                            labels: ['Comfort', 'Performance', 'Design', 'Value'],
                            datasets: [{
                                label: 'Community Rating',
                                data: [{{ $avgComfort }}, {{ $avgPerformance }}, {{ $avgDesign }}, {{ $avgValue }}],
                                fill: true,
                                backgroundColor: 'rgba(152, 203, 255, 0.2)',
                                borderColor: '#98cbff',
                                pointBackgroundColor: '#98cbff',
                                pointBorderColor: '#fff',
                                pointHoverBackgroundColor: '#fff',
                                pointHoverBorderColor: '#98cbff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            scales: {
                                r: {
                                    angleLines: { color: 'rgba(255, 255, 255, 0.1)' },
                                    grid: { color: 'rgba(255, 255, 255, 0.1)' },
                                    pointLabels: {
                                        color: '#94a3b8',
                                        font: { family: 'Metropolis', size: 10 }
                                    },
                                    ticks: {
                                        display: false,
                                        stepSize: 1,
                                        max: 5
                                    },
                                    suggestedMin: 0,
                                    suggestedMax: 5
                                }
                            },
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    });
                }

                // Sound Player Logic
                let currentAudio = null;
                let currentBtn = null;
                let ytPlayer = null;
                let isYTReady = false;

                // Load YT API
                const tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api";
                const firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                window.onYouTubeIframeAPIReady = function() {
                    isYTReady = true;
                };

                function getYoutubeID(url) {
                    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                    const match = url.match(regExp);
                    return (match && match[2].length === 11) ? match[2] : null;
                }

                function toggleSound(btn, url) {
                    const ytId = getYoutubeID(url);
                    const carModel = "{{ $car->brands->first()->name ?? '' }} {{ $car->model }}";

                    if (ytId) {
                        if (!isYTReady) return;
                        
                        if (ytPlayer && ytPlayer.getVideoData().video_id === ytId) {
                            const state = ytPlayer.getPlayerState();
                            if (state === 1) { // playing
                                ytPlayer.pauseVideo();
                                updateUI(btn, false);
                                window.globalExhaustPlayer.updateUI(false);
                            } else {
                                ytPlayer.playVideo();
                                updateUI(btn, true);
                                window.globalExhaustPlayer.show(carModel, true);
                            }
                        } else {
                            if (ytPlayer) ytPlayer.destroy();
                            if (currentAudio) {
                                currentAudio.pause();
                                updateUI(currentBtn, false);
                            }

                            ytPlayer = new YT.Player('yt-player', {
                                height: '0',
                                width: '0',
                                videoId: ytId,
                                playerVars: { 'autoplay': 1, 'controls': 0 },
                                events: {
                                    'onReady': (e) => {
                                        e.target.playVideo();
                                        updateUI(btn, true);
                                        currentBtn = btn;
                                        window.globalExhaustPlayer.activeYtPlayer = ytPlayer;
                                        window.globalExhaustPlayer.activeAudio = null;
                                        window.globalExhaustPlayer.activeBtn = btn;
                                        window.globalExhaustPlayer.show(carModel, true);
                                    },
                                    'onStateChange': (e) => {
                                        if (e.data === 0) {
                                            updateUI(btn, false); // ended
                                            window.globalExhaustPlayer.hide();
                                        }
                                    }
                                }
                            });
                        }
                        return;
                    }

                    if (currentAudio && currentAudio.src === url) {
                        if (currentAudio.paused) {
                            if (ytPlayer) ytPlayer.pauseVideo();
                            currentAudio.play();
                            updateUI(btn, true);
                            window.globalExhaustPlayer.show(carModel, true);
                        } else {
                            currentAudio.pause();
                            updateUI(btn, false);
                            window.globalExhaustPlayer.updateUI(false);
                        }
                    } else {
                        if (currentAudio) {
                            currentAudio.pause();
                            updateUI(currentBtn, false);
                        }
                        if (ytPlayer) ytPlayer.pauseVideo();
                        
                        currentAudio = new Audio(url);
                        currentBtn = btn;
                        currentAudio.play();
                        updateUI(btn, true);
                        
                        window.globalExhaustPlayer.activeAudio = currentAudio;
                        window.globalExhaustPlayer.activeYtPlayer = null;
                        window.globalExhaustPlayer.activeBtn = btn;
                        window.globalExhaustPlayer.show(carModel, true);
                        
                        currentAudio.onended = () => {
                            updateUI(btn, false);
                            window.globalExhaustPlayer.hide();
                        };
                    }
                }

                function updateUI(btn, isPlaying) {
                    const playIcon = btn.querySelector('.play-icon');
                    const pauseIcon = btn.querySelector('.pause-icon');
                    const bars = btn.closest('.glass-card').querySelectorAll('.wave-bar');
                    
                    if (isPlaying) {
                        playIcon.classList.add('hidden');
                        pauseIcon.classList.remove('hidden');
                        bars.forEach((bar, i) => {
                            bar.style.animation = `soundWave 0.5s ease-in-out infinite alternate ${i * 0.05}s`;
                        });
                    } else {
                        playIcon.classList.remove('hidden');
                        pauseIcon.classList.add('hidden');
                        bars.forEach(bar => {
                            bar.style.animation = 'none';
                            bar.style.height = '8px';
                        });
                    }
                }
            </script>
            <style>
                @keyframes soundWave {
                    0% { height: 4px; }
                    100% { height: 16px; }
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    if (window.gsap) {
                        // Gauges Entrance
                        gsap.fromTo('.gsap-gauge', 
                            { scale: 0.8, opacity: 0 }, 
                            { 
                                scale: 1, 
                                opacity: 1, 
                                duration: 0.6, 
                                stagger: 0.1, 
                                ease: 'back.out(1.7)',
                                scrollTrigger: {
                                    trigger: '.gsap-gauge',
                                    start: 'top 90%'
                                }
                            }
                        );

                        // Spec Rows Entrance
                        gsap.fromTo('.gsap-spec-row', 
                            { x: -20, opacity: 0 }, 
                            { 
                                x: 0, 
                                opacity: 1, 
                                duration: 0.5, 
                                stagger: 0.05, 
                                ease: 'power2.out',
                                scrollTrigger: {
                                    trigger: '.gsap-spec-row',
                                    start: 'top 95%'
                                }
                            }
                        );
                    }
                });
            </script>
        </div>
    </main>
</x-app-layout>
