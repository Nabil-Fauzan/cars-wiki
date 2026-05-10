<x-app-layout>
    <section class="max-w-container-max mx-auto px-margin-page py-stack-lg">
        <div class="mb-stack-lg text-center">
            <h1 class="font-headline-xl text-headline-xl text-on-surface mb-2">Technical Categories</h1>
            <p class="text-on-surface-variant font-body-lg">Browse the encyclopedia by vehicle classification and engineering purpose.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
            @forelse($categories as $cat)
                <div class="glass-card group relative overflow-hidden transition-all duration-300 hover:border-primary">
                    <div class="aspect-square relative overflow-hidden">
                        @if($cat->image)
                            <img src="{{ $cat->image }}" alt="{{ $cat->category }}" class="w-full h-full object-cover opacity-40 group-hover:opacity-60 transition-opacity grayscale group-hover:grayscale-0">
                        @else
                            <div class="w-full h-full bg-surface-container-highest flex items-center justify-center opacity-40">
                                <span class="material-symbols-outlined text-headline-xl">category</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-background to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center p-6">
                            <span class="font-headline-lg text-headline-lg text-on-surface text-center uppercase tracking-tighter">{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $cat->category)) }}</span>
                            <span class="font-label-caps text-label-caps text-primary mt-2">{{ $cat->total }} SPECIMENS</span>
                        </div>
                    </div>
                    <a href="{{ route('cars.index') }}?category={{ urlencode($cat->category) }}" class="absolute inset-0 z-10"></a>
                </div>
            @empty
                <div class="col-span-full py-20 text-center glass-card">
                    <span class="material-symbols-outlined text-headline-xl text-primary mb-4" style="font-size: 64px">category</span>
                    <h3 class="font-headline-md text-on-surface">No categories defined</h3>
                    <p class="text-on-surface-variant">Categorize assets to populate the technical registry.</p>
                </div>
            @endforelse
        </div>
    </section>
</x-app-layout>
