<x-app-layout>
    <section class="max-w-container-max mx-auto px-margin-page py-stack-lg">
        <div class="mb-stack-lg flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-center md:text-left">
                <h1 class="font-headline-xl text-headline-xl text-on-surface mb-2">Automotive Excellence by Brand</h1>
                <p class="text-on-surface-variant font-body-lg">Explore the technical lineage of the world's most prestigious manufacturers.</p>
            </div>
            @can('create', App\Models\Brand::class)
                <a href="{{ route('admin.brands') }}" class="bg-primary px-stack-md py-3 text-on-primary font-label-caps text-label-caps rounded-[4px] hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined">settings</span> Manage Brands
                </a>
            @endcan
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
            @forelse($brands as $brand)
                <div class="glass-card group relative overflow-hidden transition-all duration-300 hover:border-primary">
                    @php $firstCar = $brand->cars->first(); @endphp
                    <div class="aspect-square relative overflow-hidden">
                        @if($firstCar)
                            <img src="{{ $firstCar->image_url }}" alt="{{ $brand->name }}" class="w-full h-full object-cover opacity-40 group-hover:opacity-60 transition-opacity grayscale group-hover:grayscale-0">
                        @else
                            <div class="w-full h-full bg-surface-container-highest flex items-center justify-center opacity-40">
                                <span class="material-symbols-outlined text-headline-xl">factory</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-background to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center p-6">
                            <span class="font-headline-lg text-headline-lg text-on-surface text-center uppercase tracking-tighter">{{ $brand->name }}</span>
                            <span class="font-label-caps text-label-caps text-primary mt-2">{{ $brand->cars_count }} SPECIMENS</span>
                        </div>
                    </div>
                    <a href="{{ route('cars.index') }}?brand={{ $brand->slug }}" class="absolute inset-0 z-10"></a>
                </div>
            @empty
                <div class="col-span-full py-20 text-center glass-card">
                    <span class="material-symbols-outlined text-headline-xl text-primary mb-4" style="font-size: 64px">factory</span>
                    <h3 class="font-headline-md text-on-surface">No brands registered</h3>
                    <p class="text-on-surface-variant">Deploy assets to populate the manufacturer database.</p>
                </div>
            @endforelse
        </div>
    </section>
</x-app-layout>
