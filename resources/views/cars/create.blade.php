<x-app-layout>
    <div class="max-w-4xl mx-auto px-margin-page py-stack-lg">
        <div class="mb-stack-md">
            <h1 class="font-headline-xl text-headline-xl text-on-surface">Deploy New Asset</h1>
            <p class="text-on-surface-variant font-body-lg">Initialize technical data for the PCAR global database.</p>
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

        <form action="{{ route('cars.store') }}" method="POST" class="glass-card p-stack-md rounded-lg space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">MODEL ID (UNIQUE)</label>
                    <input type="text" name="model_id" value="{{ $duplicate->model_id ?? old('model_id') }}" placeholder="e.g. PC-911-GTS" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">MAKE / BRAND</label>
                    <input type="text" name="make" value="{{ $duplicate->make ?? old('make') }}" placeholder="e.g. Porsche" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">MODEL NAME</label>
                    <input type="text" name="model" value="{{ $duplicate->model ?? old('model') }}" placeholder="e.g. 911 GT3 RS" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">YEAR (e.g. 1984-1989)</label>
                    <input type="text" name="year" value="{{ $duplicate->year ?? old('year') }}" placeholder="1984-1989" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">HORSEPOWER PRIMARY (e.g. 145 (NA))</label>
                    <input type="text" name="hp_primary" value="{{ isset($duplicate) ? ($duplicate->hp[0] ?? '') : old('hp_primary') }}" placeholder="145 (NA)" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">HORSEPOWER SECONDARY (OPTIONAL)</label>
                    <input type="text" name="hp_secondary" value="{{ isset($duplicate) ? ($duplicate->hp[1] ?? '') : old('hp_secondary') }}" placeholder="165 (Supercharged)" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">CATEGORY</label>
                    <input type="text" name="category" value="{{ $duplicate->category ?? old('category') }}" placeholder="Supercar" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">0-60 MPH (SECONDS)</label>
                    <input type="number" step="0.1" name="zero_to_sixty" value="{{ $duplicate->zero_to_sixty ?? old('zero_to_sixty') }}" placeholder="2.4" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">TOP SPEED (MPH)</label>
                    <input type="number" name="top_speed" value="{{ $duplicate->top_speed ?? old('top_speed') }}" placeholder="218" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">AERODYNAMICS (CD)</label>
                    <input type="number" step="0.01" name="aerodynamics" value="{{ $duplicate->aerodynamics ?? old('aerodynamics') }}" placeholder="0.24" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">BRAKING (FT)</label>
                    <input type="number" name="braking" value="{{ $duplicate->braking ?? old('braking') }}" placeholder="98" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">ENGINE PRIMARY (REQUIRED)</label>
                    <input type="text" name="engine_primary" value="{{ isset($duplicate) ? ($duplicate->engine[0] ?? '') : old('engine_primary') }}" placeholder="4.0L Twin-Turbo" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">ENGINE SECONDARY (OPTIONAL)</label>
                    <input type="text" name="engine_secondary" value="{{ isset($duplicate) ? ($duplicate->engine[1] ?? '') : old('engine_secondary') }}" placeholder="Hybrid Drive System" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">TORQUE</label>
                    <input type="text" name="torque" value="{{ $duplicate->torque ?? old('torque') }}" placeholder="650 LB-FT" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">TRANSMISSION</label>
                    <input type="text" name="transmission" value="{{ $duplicate->transmission ?? old('transmission') }}" placeholder="8-Speed Dual-Clutch" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">DRIVETRAIN</label>
                    <input type="text" name="drivetrain" value="{{ $duplicate->drivetrain ?? old('drivetrain') }}" placeholder="All-Wheel Drive" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="col-span-full space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">LEGACY & HERITAGE (HISTORY)</label>
                    <textarea name="history" rows="4" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">{{ $duplicate->history ?? old('history') }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">STRATEGIC ADVANTAGES (ONE PER LINE)</label>
                    <textarea name="pros" rows="4" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">{{ isset($duplicate) ? implode("\n", $duplicate->pros) : old('pros') }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">ENGINEERING TRADE-OFFS (ONE PER LINE)</label>
                    <textarea name="cons" rows="4" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">{{ isset($duplicate) ? implode("\n", $duplicate->cons) : old('cons') }}</textarea>
                </div>
                <div class="col-span-full space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">HERO IMAGE URL</label>
                    <input type="url" name="image_url" value="{{ $duplicate->image_url ?? old('image_url') }}" data-preview="main-preview" placeholder="https://..." class="preview-trigger w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                    <div id="main-preview" class="mt-2 w-32 h-20 bg-surface-container overflow-hidden rounded border border-outline-variant hidden">
                        <img src="{{ $duplicate->image_url ?? '' }}" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">GALLERY IMAGE 1 (URL)</label>
                    <input type="url" name="gallery_1" value="{{ isset($duplicate) ? ($duplicate->gallery[0] ?? '') : '' }}" data-preview="gal1-preview" placeholder="https://..." class="preview-trigger w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                    <div id="gal1-preview" class="mt-2 w-20 h-14 bg-surface-container overflow-hidden rounded border border-outline-variant hidden">
                        <img src="{{ isset($duplicate) ? ($duplicate->gallery[0] ?? '') : '' }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">GALLERY IMAGE 2 (URL)</label>
                    <input type="url" name="gallery_2" value="{{ isset($duplicate) ? ($duplicate->gallery[1] ?? '') : '' }}" data-preview="gal2-preview" placeholder="https://..." class="preview-trigger w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                    <div id="gal2-preview" class="mt-2 w-20 h-14 bg-surface-container overflow-hidden rounded border border-outline-variant hidden">
                        <img src="{{ isset($duplicate) ? ($duplicate->gallery[1] ?? '') : '' }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">GALLERY IMAGE 3 (URL)</label>
                    <input type="url" name="gallery_3" value="{{ isset($duplicate) ? ($duplicate->gallery[2] ?? '') : '' }}" data-preview="gal3-preview" placeholder="https://..." class="preview-trigger w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                    <div id="gal3-preview" class="mt-2 w-20 h-14 bg-surface-container overflow-hidden rounded border border-outline-variant hidden">
                        <img src="{{ isset($duplicate) ? ($duplicate->gallery[2] ?? '') : '' }}" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-outline-variant text-on-surface-variant font-label-caps text-label-caps hover:bg-white/5 transition-all">CANCEL</a>
                <button type="submit" class="bg-primary text-on-primary px-8 py-3 font-label-caps text-label-caps hover:brightness-110 transition-all">DEPLOY ASSET</button>
            </div>
        </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const makeInput = document.querySelector('input[name="make"]');
            const modelInput = document.querySelector('input[name="model"]');
            const idInput = document.querySelector('input[name="model_id"]');

            function suggestId() {
                if (!idInput.value || idInput.dataset.auto === 'true') {
                    const make = makeInput.value.substring(0, 3).toUpperCase();
                    const model = modelInput.value.replace(/\s+/g, '-').toUpperCase();
                    if (make && model) {
                        idInput.value = `${make}-${model}`;
                        idInput.dataset.auto = 'true';
                    }
                }
            }

            makeInput.addEventListener('input', suggestId);
            modelInput.addEventListener('input', suggestId);
            idInput.addEventListener('input', () => idInput.dataset.auto = 'false');

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
