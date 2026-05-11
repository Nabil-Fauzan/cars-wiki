<x-app-layout>
    <div class="px-margin-page py-stack-lg max-w-7xl mx-auto w-full">
        <!-- Garage Header -->
        <header class="mb-stack-lg">
            <div class="flex flex-col md:flex-row justify-between items-end gap-gutter">
                <div>
                    <span class="font-label-caps text-label-caps text-primary border-l-2 border-primary pl-2 mb-2 block uppercase">Personal Sanctuary</span>
                    <h1 class="font-headline-xl text-headline-xl text-on-surface">{{ Auth::user()->name }}'s Garage</h1>
                </div>
                <div class="flex gap-6">
                    <div class="text-center">
                        <span class="block font-headline-md text-primary">{{ $favorites->count() }}</span>
                        <span class="font-label-caps text-[10px] text-on-surface-variant">VEHICLES</span>
                    </div>
                    <div class="text-center">
                        <span class="block font-headline-md text-primary">{{ $comparisonSets->count() }}</span>
                        <span class="font-label-caps text-[10px] text-on-surface-variant">SAVED BATTLES</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
            <!-- Left Column: Favorites & Comparison Sets -->
            <div class="lg:col-span-2 space-y-stack-lg">
                <!-- Saved Battles Section -->
                <section>
                    <div class="flex items-center gap-4 mb-6">
                        <h2 class="font-label-caps text-label-caps text-secondary tracking-widest uppercase">Saved Comparison Sets</h2>
                        <div class="h-px flex-1 bg-gradient-to-r from-outline-variant/50 to-transparent"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
                        @forelse($comparisonSets as $set)
                            <div class="glass-card machined-edge p-4 hover:border-primary/50 transition-all group">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="font-headline-md text-on-surface group-hover:text-primary transition-colors">{{ $set->name }}</h3>
                                    <span class="text-[10px] font-label-caps text-on-surface-variant">{{ $set->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex gap-2 mb-6">
                                    @foreach([$set->car1, $set->car2, $set->car3] as $car)
                                        @if($car)
                                            <div class="flex-1 aspect-video bg-surface-container-low rounded overflow-hidden border border-outline-variant/20">
                                                <img src="{{ $car->image_url }}" class="w-full h-full object-cover">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <a href="{{ route('compare', ['car1' => $set->car1_id, 'car2' => $set->car2_id, 'car3' => $set->car3_id]) }}" 
                                   class="block w-full bg-surface-container-high py-3 text-center font-label-caps text-label-caps text-on-surface hover:bg-primary hover:text-on-primary transition-all">
                                    LOAD BATTLE SHEET
                                </a>
                            </div>
                        @empty
                            <div class="md:col-span-2 glass-card p-12 text-center border-dashed border-2 border-outline-variant/30">
                                <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-4">compare_arrows</span>
                                <p class="text-on-surface-variant font-body-lg">No battle sets saved yet. Start comparing vehicles to save your first set.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <!-- My Vehicles (Favorites) -->
                <section>
                    <div class="flex items-center gap-4 mb-6">
                        <h2 class="font-label-caps text-label-caps text-secondary tracking-widest uppercase">The Main Showroom</h2>
                        <div class="h-px flex-1 bg-gradient-to-r from-outline-variant/50 to-transparent"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
                        @forelse($favorites as $car)
                            <div class="glass-card group flex flex-col transition-all duration-300">
                                <div class="relative aspect-video overflow-hidden">
                                    <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ $car->image_url }}"/>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                    <div class="absolute bottom-4 left-4">
                                        <p class="font-label-caps text-[10px] text-primary mb-1">{{ $car->brands->pluck('name')->implode('/') }}</p>
                                        <h4 class="font-headline-md text-white">{{ $car->model }}</h4>
                                    </div>
                                    <a href="{{ route('cars.show', $car->model_id) }}" class="absolute inset-0 z-10"></a>
                                </div>
                            </div>
                        @empty
                            <div class="md:col-span-2 glass-card p-12 text-center border-dashed border-2 border-outline-variant/30">
                                <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-4">directions_car</span>
                                <p class="text-on-surface-variant font-body-lg">Your showroom is empty. Explore the encyclopedia to add vehicles.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- Right Column: Personal Notes Feed -->
            <div class="space-y-stack-lg">
                <section>
                    <div class="flex items-center gap-4 mb-6">
                        <h2 class="font-label-caps text-label-caps text-secondary tracking-widest uppercase">Curator Logs</h2>
                        <div class="h-px flex-1 bg-gradient-to-r from-outline-variant/50 to-transparent"></div>
                    </div>
                    <div class="space-y-4">
                        @forelse($personalNotes as $note)
                            <div class="glass-card p-4 border-l-4 border-primary">
                                <div class="flex items-center gap-3 mb-3">
                                    <img src="{{ $note->car->image_url }}" class="w-10 h-10 rounded object-cover">
                                    <div class="min-w-0">
                                        <h4 class="font-label-caps text-on-surface truncate">{{ $note->car->model }}</h4>
                                        <span class="text-[8px] font-label-caps text-on-surface-variant uppercase">{{ $note->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <p class="font-body-md text-on-surface-variant italic line-clamp-3">"{{ $note->content }}"</p>
                                <div class="mt-4 flex justify-end">
                                    <a href="{{ route('cars.show', $note->car->model_id) }}" class="text-[10px] font-label-caps text-primary hover:underline">VIEW FULL FILE</a>
                                </div>
                            </div>
                        @empty
                            <div class="glass-card p-8 text-center border-dashed border-2 border-outline-variant/30">
                                <p class="text-on-surface-variant font-body-sm italic">No curator logs found.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
