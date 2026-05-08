<x-app-layout>
    <main class="pt-0">
        <!-- Hero Section & Gallery -->
        <section class="relative w-full h-[716px] overflow-hidden bg-surface-container-lowest">
            <img alt="{{ $car->make }} {{ $car->model }}" class="w-full h-full object-cover opacity-80" src="{{ $car->image_url }}"/>
            <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent"></div>
            <div class="absolute bottom-margin-page left-margin-page right-margin-page max-w-container-max mx-auto">
                <div class="flex flex-col gap-2">
                    <span class="font-label-caps text-label-caps text-primary-fixed uppercase tracking-widest">{{ $car->category }} Series</span>
                    <h1 class="font-headline-xl text-headline-xl text-on-surface">{{ $car->model }}</h1>
                    <div class="flex items-center gap-4 mt-stack-sm">
                        <a href="{{ route('compare') }}" class="bg-primary px-stack-md py-3 text-on-primary font-label-caps text-label-caps rounded-[4px] hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined">compare_arrows</span> Compare with another car
                        </a>
                        <button class="border border-secondary px-stack-md py-3 text-on-surface font-label-caps text-label-caps rounded-[4px] hover:bg-white/5 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined">favorite</span> Add to Favorites
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-container-max mx-auto px-margin-page py-stack-lg flex flex-col lg:flex-row gap-gutter">
            <!-- Left Column: Specs & History -->
            <div class="flex-1 space-y-stack-lg">
                <!-- Performance Gauges (Modern Digital Style) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-stack-sm">
                    <div class="glass-card p-stack-sm machined-edge">
                        <p class="font-label-caps text-label-caps text-secondary">0-60 MPH</p>
                        <p class="font-headline-md text-headline-md text-primary mt-1">{{ $car->zero_to_sixty }}s</p>
                        <div class="flex gap-1 mt-2">
                            @php $segments = floor(($car->zero_to_sixty / 5) * 5); @endphp
                            @for($i=0; $i<5; $i++)
                                <div class="gauge-segment flex-1 {{ $i < (5 - $segments) ? '' : 'opacity-20' }}"></div>
                            @endfor
                        </div>
                    </div>
                    <div class="glass-card p-stack-sm machined-edge">
                        <p class="font-label-caps text-label-caps text-secondary">TOP SPEED</p>
                        <p class="font-headline-md text-headline-md text-primary mt-1">{{ $car->top_speed }} MPH</p>
                        <div class="flex gap-1 mt-2">
                            @php $segments = floor(($car->top_speed / 250) * 5); @endphp
                            @for($i=0; $i<5; $i++)
                                <div class="gauge-segment flex-1 {{ $i < $segments ? '' : 'opacity-20' }}"></div>
                            @endfor
                        </div>
                    </div>
                    <div class="glass-card p-stack-sm machined-edge">
                        <p class="font-label-caps text-label-caps text-secondary">AERODYNAMICS</p>
                        <p class="font-headline-md text-headline-md text-primary mt-1">{{ $car->aerodynamics }} CD</p>
                        <div class="flex gap-1 mt-2">
                            @php $segments = floor((1 - $car->aerodynamics) * 5); @endphp
                            @for($i=0; $i<5; $i++)
                                <div class="gauge-segment flex-1 {{ $i < $segments ? '' : 'opacity-20' }}"></div>
                            @endfor
                        </div>
                    </div>
                    <div class="glass-card p-stack-sm machined-edge">
                        <p class="font-label-caps text-label-caps text-secondary">BRAKING</p>
                        <p class="font-headline-md text-headline-md text-primary mt-1">{{ $car->braking }} FT</p>
                        <div class="flex gap-1 mt-2">
                            @php $segments = floor((150 - $car->braking) / 10); @endphp
                            @for($i=0; $i<5; $i++)
                                <div class="gauge-segment flex-1 {{ $i < $segments ? '' : 'opacity-20' }}"></div>
                            @endfor
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
                <section class="glass-card machined-edge overflow-hidden">
                    <div class="p-stack-sm bg-surface-container-highest border-b border-outline-variant/30">
                        <h3 class="font-label-caps text-label-caps">Technical Specifications</h3>
                    </div>
                    <div class="divide-y divide-outline-variant/10">
                        <div class="grid grid-cols-2 p-stack-sm hover:bg-white/5 transition-colors">
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
                            <span class="font-label-caps text-label-caps text-secondary">Horsepower</span>
                            <span class="font-body-md text-body-md text-on-surface">{{ $car->hp }} HP</span>
                        </div>
                        <div class="grid grid-cols-2 p-stack-sm hover:bg-white/5 transition-colors">
                            <span class="font-label-caps text-label-caps text-secondary">Torque</span>
                            <span class="font-body-md text-body-md text-on-surface">{{ $car->torque }}</span>
                        </div>
                        <div class="grid grid-cols-2 p-stack-sm hover:bg-white/5 transition-colors">
                            <span class="font-label-caps text-label-caps text-secondary">Transmission</span>
                            <span class="font-body-md text-body-md text-on-surface">{{ $car->transmission }}</span>
                        </div>
                        <div class="grid grid-cols-2 p-stack-sm hover:bg-white/5 transition-colors">
                            <span class="font-label-caps text-label-caps text-secondary">Drivetrain</span>
                            <span class="font-body-md text-body-md text-on-surface">{{ $car->drivetrain }}</span>
                        </div>
                    </div>
                </section>

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
            </div>

            <!-- Right Column: Gallery & Related -->
            <div class="lg:w-96 space-y-stack-lg">
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
                                    <span class="font-label-caps text-[10px] text-primary">{{ $rival->make }}</span>
                                    <h4 class="font-label-caps text-on-surface">{{ $rival->model }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </main>
</x-app-layout>
