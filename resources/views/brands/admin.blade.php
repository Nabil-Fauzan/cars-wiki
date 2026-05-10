<x-app-layout>
    <div class="max-w-container-max mx-auto px-margin-page py-stack-lg">
        <div class="flex flex-col md:flex-row justify-between items-center mb-stack-lg gap-gutter">
            <div>
                <h1 class="font-headline-lg text-headline-xl text-on-surface">Brand Registry</h1>
                <p class="text-on-surface-variant font-body-md">Manage automotive manufacturers and co-branding relations.</p>
            </div>
            <form action="{{ route('admin.brands.sync') }}" method="POST">
                @csrf
                <button type="submit" class="bg-secondary/20 hover:bg-secondary/30 text-secondary px-stack-md py-3 rounded-lg font-label-caps text-label-caps transition-all flex items-center gap-2 border border-secondary/30">
                    <span class="material-symbols-outlined">sync</span> Sync from Car Data
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
            <!-- Add New Brand -->
            <div class="lg:col-span-1">
                <div class="glass-card p-stack-md machined-edge">
                    <h2 class="font-headline-md text-headline-md text-on-surface mb-stack-md">Add New Manufacturer</h2>
                    <form action="{{ route('admin.brands.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="space-y-2">
                            <label class="font-label-caps text-label-caps text-secondary">BRAND NAME</label>
                            <input type="text" name="name" placeholder="e.g. Koenigsegg" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required>
                        </div>
                        <button type="submit" class="w-full bg-primary text-on-primary py-3 rounded-lg font-label-caps text-label-caps hover:scale-[1.02] active:scale-[0.98] transition-all">
                            REGISTER BRAND
                        </button>
                    </form>
                </div>
            </div>

            <!-- Brand List -->
            <div class="lg:col-span-2">
                <div class="glass-card overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-highest/50 border-b border-outline-variant">
                                <th class="p-4 font-label-caps text-label-caps text-secondary">NAME</th>
                                <th class="p-4 font-label-caps text-label-caps text-secondary">SLUG</th>
                                <th class="p-4 font-label-caps text-label-caps text-secondary text-center">CARS</th>
                                <th class="p-4 font-label-caps text-label-caps text-secondary text-right">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/30">
                            @forelse($brands as $brand)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="p-4 text-on-surface font-body-md">{{ $brand->name }}</td>
                                    <td class="p-4 text-on-surface-variant font-body-sm">{{ $brand->slug }}</td>
                                    <td class="p-4 text-center">
                                        <span class="bg-surface-container px-2 py-1 rounded text-primary font-label-caps text-[10px]">
                                            {{ $brand->cars_count }} ASSETS
                                        </span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" onsubmit="return confirm('Decommission this brand?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-error hover:scale-110 transition-transform">
                                                <span class="material-symbols-outlined">delete_forever</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-on-surface-variant italic">No brands registered in the tactical database.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
