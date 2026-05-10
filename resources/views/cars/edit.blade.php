<x-app-layout>
    <div class="max-w-4xl mx-auto px-margin-page py-stack-lg">
        <div class="mb-stack-md">
            <h1 class="font-headline-xl text-headline-xl text-on-surface">Synchronize Asset</h1>
            <p class="text-on-surface-variant font-body-lg">Updating technical parameters for {{ $car->model_id }}.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-error/10 border border-error/30 text-error font-label-caps text-label-caps rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cars.update', $car) }}" method="POST" class="glass-card p-stack-md rounded-lg space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">ASSOCIATED BRANDS (MULTI-SELECT)</label>
                    <select name="brand_ids[]" multiple class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3 h-32">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $car->brands->contains($brand->id) ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-on-surface-variant italic">Hold Ctrl/Cmd to select multiple</p>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">MODEL NAME</label>
                    <input type="text" name="model" value="{{ $car->model }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">YEAR (e.g. 1984-1989)</label>
                    <input type="text" name="year" value="{{ $car->year }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">HORSEPOWER PRIMARY (e.g. 145 (NA))</label>
                    <input type="text" name="hp_primary" value="{{ $car->hp[0] ?? '' }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">HORSEPOWER SECONDARY (OPTIONAL)</label>
                    <input type="text" name="hp_secondary" value="{{ $car->hp[1] ?? '' }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">CATEGORY</label>
                    <input type="text" name="category" list="category_list" value="{{ $car->category }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                    <datalist id="category_list">
                        @foreach($categories as $category)
                            <option value="{{ $category }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="col-span-full space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">HERO IMAGE URL</label>
                    <input type="url" name="image_url" value="{{ $car->image_url }}" data-preview="main-preview" class="preview-trigger w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                    <div id="main-preview" class="mt-2 w-32 h-20 bg-surface-container overflow-hidden rounded border border-outline-variant hidden">
                        <img src="{{ $car->image_url }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">0-60 MPH (SECONDS)</label>
                    <input type="number" step="0.1" name="zero_to_sixty" value="{{ $car->zero_to_sixty }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">TOP SPEED (MPH)</label>
                    <input type="number" name="top_speed" value="{{ $car->top_speed }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">AERODYNAMICS (CD)</label>
                    <input type="number" step="0.01" name="aerodynamics" value="{{ $car->aerodynamics }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">BRAKING (FT)</label>
                    <input type="number" name="braking" value="{{ $car->braking }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">ENGINE PRIMARY (REQUIRED)</label>
                    <input type="text" name="engine_primary" value="{{ $car->engine[0] ?? '' }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">ENGINE SECONDARY (OPTIONAL)</label>
                    <input type="text" name="engine_secondary" value="{{ $car->engine[1] ?? '' }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">TORQUE</label>
                    <input type="text" name="torque" value="{{ $car->torque }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">TRANSMISSION</label>
                    <input type="text" name="transmission" value="{{ $car->transmission }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">DRIVETRAIN</label>
                    <input type="text" name="drivetrain" value="{{ $car->drivetrain }}" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="col-span-full space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">LEGACY & HERITAGE (HISTORY)</label>
                    <textarea name="history" rows="4" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">{{ $car->history }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">STRATEGIC ADVANTAGES (ONE PER LINE)</label>
                    <textarea name="pros" rows="4" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">{{ implode("\n", $car->pros) }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">ENGINEERING TRADE-OFFS (ONE PER LINE)</label>
                    <textarea name="cons" rows="4" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">{{ implode("\n", $car->cons) }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">STATUS</label>
                    <select name="status" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3 appearance-none">
                        <option value="Live" {{ $car->status == 'Live' ? 'selected' : '' }}>Live</option>
                        <option value="Draft" {{ $car->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Archived" {{ $car->status == 'Archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">GALLERY IMAGE 1 (URL)</label>
                    <input type="url" name="gallery_1" value="{{ $car->gallery[0] ?? '' }}" data-preview="gal1-preview" class="preview-trigger w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                    <div id="gal1-preview" class="mt-2 w-20 h-14 bg-surface-container overflow-hidden rounded border border-outline-variant hidden">
                        <img src="{{ $car->gallery[0] ?? '' }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">GALLERY IMAGE 2 (URL)</label>
                    <input type="url" name="gallery_2" value="{{ $car->gallery[1] ?? '' }}" data-preview="gal2-preview" class="preview-trigger w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                    <div id="gal2-preview" class="mt-2 w-20 h-14 bg-surface-container overflow-hidden rounded border border-outline-variant hidden">
                        <img src="{{ $car->gallery[1] ?? '' }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">GALLERY IMAGE 3 (URL)</label>
                    <input type="url" name="gallery_3" value="{{ $car->gallery[2] ?? '' }}" data-preview="gal3-preview" class="preview-trigger w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                    <div id="gal3-preview" class="mt-2 w-20 h-14 bg-surface-container overflow-hidden rounded border border-outline-variant hidden">
                        <img src="{{ $car->gallery[2] ?? '' }}" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-outline-variant text-on-surface-variant font-label-caps text-label-caps hover:bg-white/5 transition-all">CANCEL</a>
                <button type="submit" class="bg-primary text-on-primary px-8 py-3 font-label-caps text-label-caps hover:brightness-110 transition-all">SYNC CHANGES</button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image Preview logic
            const triggers = document.querySelectorAll('.preview-trigger');
            triggers.forEach(trigger => {
                const previewId = trigger.dataset.preview;
                const container = document.getElementById(previewId);
                const img = container.querySelector('img');

                function updatePreview() {
                    if (trigger.value) {
                        img.src = trigger.value;
                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                    }
                }

                trigger.addEventListener('input', updatePreview);
                updatePreview(); // Initial check
            });
        });
    </script>
</x-app-layout>
