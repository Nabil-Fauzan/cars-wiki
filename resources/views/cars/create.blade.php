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
                    <input type="text" name="model_id" placeholder="e.g. PC-911-GTS" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">MAKE / BRAND</label>
                    <input type="text" name="make" placeholder="e.g. Porsche" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">MODEL NAME</label>
                    <input type="text" name="model" placeholder="e.g. 911 GT3 RS" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">YEAR (e.g. 1984-1989)</label>
                    <input type="text" name="year" placeholder="1984-1989" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3" required>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">HORSEPOWER</label>
                    <input type="number" name="hp" placeholder="500" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">CATEGORY</label>
                    <input type="text" name="category" placeholder="Supercar" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">0-60 MPH (SECONDS)</label>
                    <input type="number" step="0.1" name="zero_to_sixty" placeholder="2.4" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">TOP SPEED (MPH)</label>
                    <input type="number" name="top_speed" placeholder="218" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">AERODYNAMICS (CD)</label>
                    <input type="number" step="0.01" name="aerodynamics" placeholder="0.24" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">BRAKING (FT)</label>
                    <input type="number" name="braking" placeholder="98" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">ENGINE PRIMARY (REQUIRED)</label>
                    <input type="text" name="engine_primary" placeholder="4.0L Twin-Turbo" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">ENGINE SECONDARY (OPTIONAL)</label>
                    <input type="text" name="engine_secondary" placeholder="Hybrid Drive System" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">TORQUE</label>
                    <input type="text" name="torque" placeholder="650 LB-FT" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">TRANSMISSION</label>
                    <input type="text" name="transmission" placeholder="8-Speed Dual-Clutch" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">DRIVETRAIN</label>
                    <input type="text" name="drivetrain" placeholder="All-Wheel Drive" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
                <div class="col-span-full space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">LEGACY & HERITAGE (HISTORY)</label>
                    <textarea name="history" rows="4" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3"></textarea>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">STRATEGIC ADVANTAGES (ONE PER LINE)</label>
                    <textarea name="pros" rows="4" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3"></textarea>
                </div>
                <div class="space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">ENGINEERING TRADE-OFFS (ONE PER LINE)</label>
                    <textarea name="cons" rows="4" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3"></textarea>
                </div>
                <div class="col-span-full space-y-2">
                    <label class="font-label-caps text-label-caps text-secondary">HERO IMAGE URL</label>
                    <input type="url" name="image_url" placeholder="https://..." class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-3">
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-outline-variant text-on-surface-variant font-label-caps text-label-caps hover:bg-white/5 transition-all">CANCEL</a>
                <button type="submit" class="bg-primary text-on-primary px-8 py-3 font-label-caps text-label-caps hover:brightness-110 transition-all">DEPLOY ASSET</button>
            </div>
        </form>
    </div>
</x-app-layout>
