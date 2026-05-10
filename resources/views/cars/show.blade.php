<x-app-layout>
    <main class="pt-0">
        <!-- Hero Section & Gallery -->
        <section class="relative w-full h-[716px] overflow-hidden bg-surface-container-lowest">
            <img alt="{{ $car->brands->first()->name ?? 'Vehicle' }} {{ $car->model }}" class="w-full h-full object-cover opacity-80" src="{{ $car->image_url }}"/>
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
                                    <span class="font-label-caps text-[10px] text-primary">{{ $rival->make }}</span>
                                    <h4 class="font-label-caps text-on-surface">{{ $rival->model }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            </div>

            <!-- Lightbox Modal -->
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
            </script>
        </div>
    </main>
</x-app-layout>
