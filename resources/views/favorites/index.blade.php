<x-app-layout>
    <div class="flex min-h-[calc(100vh-80px)]">
        <!-- SideNavBar (Reusing stats) -->
        <aside class="hidden lg:flex flex-col w-64 bg-surface-container border-r border-outline-variant/20 py-8 overflow-y-auto">
            <div class="px-6 mb-8">
                <h2 class="font-headline-md text-headline-md font-bold text-primary">PCAR Wiki</h2>
                <p class="font-body-md text-body-md text-on-surface-variant/70">Personal Collection</p>
            </div>
            <nav class="flex flex-col gap-1">
                <a class="flex items-center gap-4 text-on-surface-variant hover:text-on-surface px-4 py-3 transition-colors" href="{{ url('/') }}">
                    <span class="material-symbols-outlined">home</span>
                    <span class="font-label-caps text-label-caps">Home</span>
                </a>
                <a class="flex items-center gap-4 bg-secondary-container/50 text-primary border-l-4 border-primary px-4 py-3" href="{{ route('favorites.index') }}">
                    <span class="material-symbols-outlined">favorite</span>
                    <span class="font-label-caps text-label-caps">Wishlist</span>
                </a>
                <a class="flex items-center gap-4 text-on-surface-variant hover:text-on-surface px-4 py-3 transition-colors" href="{{ route('compare') }}">
                    <span class="material-symbols-outlined">compare_arrows</span>
                    <span class="font-label-caps text-label-caps">Compare</span>
                </a>
            </nav>

            <div class="mt-auto px-6 space-y-4 pt-8 border-t border-outline-variant/10">
                <div class="bg-surface-container-low/50 p-3 rounded border-l-2 border-primary">
                    <span class="font-label-caps text-[10px] text-secondary block">YOUR COLLECTION</span>
                    <span class="font-headline-md text-primary">{{ $cars->total() }}</span>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 px-margin-page py-stack-lg max-w-7xl mx-auto w-full">
            <section class="mb-stack-lg">
                <div class="flex justify-between items-end gap-gutter mb-stack-md">
                    <div>
                        <span class="font-label-caps text-label-caps text-primary border-l-2 border-primary pl-2 mb-2 block uppercase">Private Registry</span>
                        <h1 class="font-headline-xl text-headline-xl text-on-surface">Your Favorites</h1>
                    </div>
                </div>
            </section>

            <!-- Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
                @forelse($cars as $car)
                    <div class="glass-card group flex flex-col transition-all duration-300">
                        <div class="relative aspect-video overflow-hidden">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="{{ $car->brands->first()->name ?? 'Vehicle' }} {{ $car->model }}" src="{{ $car->image_url }}"/>
                            <div class="absolute top-4 right-4 bg-primary text-on-primary px-2 py-1 font-label-caps text-label-caps">{{ $car->model_id }}</div>
                            
                            <!-- Add to Compare Button Overlay -->
                            <div class="absolute inset-0 bg-black/20 lg:bg-black/40 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                <button @click="addToCompare({ model_id: '{{ $car->model_id }}', model: '{{ $car->model }}', image: '{{ $car->image_url }}' })" 
                                        class="p-4 lg:p-3 rounded-full backdrop-blur-md transition-all active:scale-90 shadow-lg"
                                        :class="isInCompare('{{ $car->model_id }}') ? 'bg-primary text-on-primary' : 'bg-white/30 text-white hover:bg-white/50'">
                                    <span class="material-symbols-outlined text-2xl lg:text-base" x-text="isInCompare('{{ $car->model_id }}') ? 'check_circle' : 'compare_arrows'"></span>
                                </button>
                            </div>
                        </div>
                        <div class="p-stack-sm flex flex-col gap-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-label-caps text-label-caps text-primary flex flex-wrap gap-1">
                                        @foreach($car->brands as $brand)
                                            <span>{{ strtoupper($brand->name) }}</span>
                                            @if(!$loop->last) <span class="opacity-30">•</span> @endif
                                        @endforeach
                                    </p>
                                    <h3 class="font-headline-md text-headline-md text-on-surface">{{ $car->model }}</h3>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span class="font-headline-md text-headline-md text-on-surface">{{ $car->year }}</span>
                                    <form action="{{ route('cars.favorite', $car) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-primary hover:scale-110 transition-transform">
                                            <span class="material-symbols-outlined fill-1">favorite</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <a href="{{ route('cars.show', $car->model_id) }}" class="w-full py-3 bg-secondary-container/30 hover:bg-primary hover:text-on-primary transition-all font-label-caps text-label-caps machined-edge text-center">
                                VIEW DETAILS
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center glass-card">
                        <span class="material-symbols-outlined text-headline-xl text-primary mb-4" style="font-size: 64px">favorite_border</span>
                        <h3 class="font-headline-md text-on-surface">Your collection is empty</h3>
                        <p class="text-on-surface-variant">Start exploring the encyclopedia and save your favorite specimens.</p>
                        <a href="{{ url('/') }}" class="inline-block mt-8 px-8 py-3 bg-primary text-on-primary font-label-caps text-label-caps rounded hover:scale-105 transition-transform">
                            EXPLORE CARS
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-stack-lg">
                {{ $cars->links() }}
            </div>
        </main>
    </div>
</x-app-layout>
