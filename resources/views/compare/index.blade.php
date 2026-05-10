<x-app-layout>
    <div class="flex min-h-[calc(100vh-80px)]">
        <!-- SideNavBar -->
        <aside class="hidden lg:flex flex-col w-64 bg-surface-container border-r border-outline-variant/20 py-8 overflow-y-auto">
            <div class="px-6 mb-8">
                <h2 class="font-headline-md text-headline-md font-bold text-primary">PCAR Wiki</h2>
                <p class="font-body-md text-body-md text-on-surface-variant/70">Technical Encyclopedia</p>
            </div>
            <nav class="flex flex-col gap-1">
                <a class="flex items-center gap-4 text-on-surface-variant hover:text-on-surface px-4 py-3 transition-colors" href="{{ url('/') }}">
                    <span class="material-symbols-outlined">home</span>
                    <span class="font-label-caps text-label-caps">Home</span>
                </a>
                <a class="flex items-center gap-4 text-on-surface-variant hover:text-on-surface px-4 py-3 transition-colors" href="{{ route('cars.index') }}">
                    <span class="material-symbols-outlined">directions_car</span>
                    <span class="font-label-caps text-label-caps">Explore Cars</span>
                </a>
                <a class="flex items-center gap-4 bg-secondary-container/50 text-primary border-l-4 border-primary px-4 py-3" href="{{ route('compare') }}">
                    <span class="material-symbols-outlined">compare_arrows</span>
                    <span class="font-label-caps text-label-caps">Compare</span>
                </a>
                <a class="flex items-center gap-4 {{ request()->is('brands*') ? 'bg-secondary-container/50 text-primary border-l-4 border-primary' : 'text-on-surface-variant hover:text-on-surface' }} px-4 py-3 transition-colors" href="{{ route('brands') }}">
                    <span class="material-symbols-outlined">factory</span>
                    <span class="font-label-caps text-label-caps">Brands</span>
                </a>
                <a class="flex items-center gap-4 {{ request()->is('categories*') ? 'bg-secondary-container/50 text-primary border-l-4 border-primary' : 'text-on-surface-variant hover:text-on-surface' }} px-4 py-3 transition-colors" href="{{ route('categories') }}">
                    <span class="material-symbols-outlined">category</span>
                    <span class="font-label-caps text-label-caps">Categories</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 px-margin-page py-stack-lg max-w-7xl mx-auto w-full">
            <!-- Battle Sheet Header Section -->
            <section class="mb-stack-lg">
                <div class="flex flex-col md:flex-row justify-between items-end gap-gutter mb-stack-md">
                    <div>
                        <span class="font-label-caps text-label-caps text-primary border-l-2 border-primary pl-2 mb-2 block uppercase">Comparison Engine v4.2</span>
                        <h1 class="font-headline-xl text-headline-xl text-on-surface">Battle Sheet</h1>
                    </div>
                    <div class="flex items-center gap-4 bg-surface-container-low/50 p-2 rounded-lg border border-outline-variant/30">
                        <span class="font-label-caps text-label-caps text-secondary">Highlight Differences</span>
                        <button type="button" id="toggleDiffs" class="relative inline-flex h-6 w-11 items-center rounded-full bg-surface-variant transition-colors focus:outline-none">
                            <span id="toggleKnob" class="inline-block h-4 w-4 transform rounded-full bg-on-surface-variant transition-transform translate-x-1"></span>
                        </button>
                    </div>
                </div>
                
                <!-- Comparison Selectors -->
                <form action="{{ route('compare') }}" method="GET" class="sticky top-20 z-40 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter py-4 bg-background/80 backdrop-blur-md">
                    <!-- Slot 1 -->
                    <div class="glass-card p-stack-sm rounded shadow-lg group relative overflow-hidden">
                        <div class="flex justify-between items-start mb-4">
                            <span class="font-label-caps text-label-caps text-primary">SLOT_01</span>
                        </div>
                        <select name="car1" onchange="this.form.submit()" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface font-headline-md mb-4 p-2 appearance-none">
                            <option value="">Select Vehicle</option>
                            @foreach($allCars as $car)
                                <option value="{{ $car->model_id }}" {{ (isset($car1) && $car1->model_id == $car->model_id) ? 'selected' : '' }}>
                                    {{ $car->brands->pluck('name')->implode(' • ') }} {{ $car->model }}
                                </option>
                            @endforeach
                        </select>
                        @if($car1)
                            <img class="w-full h-32 object-cover rounded mb-4" src="{{ $car1->image_url }}" alt="{{ $car1->brands->first()->name ?? '' }} {{ $car1->model }}"/>
                        @else
                            <div class="w-full h-32 bg-surface-container-low rounded mb-4 flex items-center justify-center">
                                <span class="material-symbols-outlined text-on-surface-variant">directions_car</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Slot 2 -->
                    <div class="glass-card p-stack-sm rounded shadow-lg group relative overflow-hidden">
                        <div class="flex justify-between items-start mb-4">
                            <span class="font-label-caps text-label-caps text-primary">SLOT_02</span>
                        </div>
                        <select name="car2" onchange="this.form.submit()" class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface font-headline-md mb-4 p-2 appearance-none">
                            <option value="">Select Vehicle</option>
                            @foreach($allCars as $car)
                                <option value="{{ $car->model_id }}" {{ (isset($car2) && $car2->model_id == $car->model_id) ? 'selected' : '' }}>
                                    {{ $car->brands->pluck('name')->implode(' • ') }} {{ $car->model }}
                                </option>
                            @endforeach
                        </select>
                        @if($car2)
                            <img class="w-full h-32 object-cover rounded mb-4" src="{{ $car2->image_url }}" alt="{{ $car2->brands->first()->name ?? '' }} {{ $car2->model }}"/>
                        @else
                            <div class="w-full h-32 bg-surface-container-low rounded mb-4 flex items-center justify-center">
                                <span class="material-symbols-outlined text-on-surface-variant">directions_car</span>
                            </div>
                        @endif
                    </div>

                    <div class="hidden lg:flex border-2 border-dashed border-outline-variant/30 p-stack-sm rounded flex-col items-center justify-center bg-surface-container-low/20">
                        <span class="material-symbols-outlined text-on-surface-variant">analytics</span>
                        <p class="font-label-caps text-label-caps text-on-surface-variant">Analysis Active</p>
                    </div>
                </form>
            </section>

            @if($car1 && $car2)
                <!-- Technical Matrix -->
                <section class="space-y-stack-lg mt-8">
                    @php
                        $metrics = [
                            'brands' => 'Manufacturer',
                            'category' => 'Category',
                            'year' => 'Year',
                            'hp' => 'Horsepower',
                            'torque' => 'Torque',
                            'engine' => 'Engine',
                            'transmission' => 'Transmission',
                            'drivetrain' => 'Drivetrain',
                            'zero_to_sixty' => '0-60 MPH',
                            'top_speed' => 'Top Speed',
                            'aerodynamics' => 'Aerodynamics',
                            'braking' => 'Braking',
                        ];
                    @endphp

                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <h2 class="font-label-caps text-label-caps text-secondary tracking-widest uppercase">Technical Specifications</h2>
                            <div class="h-px flex-1 bg-gradient-to-r from-outline-variant/50 to-transparent"></div>
                        </div>
                        <div class="bg-surface-container/30 rounded-lg overflow-hidden border border-outline-variant/20">
                            @foreach($metrics as $key => $label)
                                @php
                                    $val1 = $car1->$key;
                                    $val2 = $car2->$key;
                                    $winner = null;

                                    if ($key == 'brands' || $key == 'category' || $key == 'engine' || $key == 'transmission' || $key == 'drivetrain') {
                                        // Non-comparable text fields
                                    } elseif ($key == 'year' && !empty($val1) && !empty($val2)) {
                                        // Extract first 4 digits from year (e.g. 1990 from 1990-1996)
                                        preg_match('/\d{4}/', $val1, $y1);
                                        preg_match('/\d{4}/', $val2, $y2);
                                        $n1 = isset($y1[0]) ? (int)$y1[0] : 0;
                                        $n2 = isset($y2[0]) ? (int)$y2[0] : 0;
                                        if ($n1 > $n2) $winner = 1;
                                        elseif ($n2 > $n1) $winner = 2;
                                    } elseif (!empty($val1) && !empty($val2) && is_numeric($val1) && is_numeric($val2)) {
                                        if ($key == 'zero_to_sixty' || $key == 'braking' || $key == 'aerodynamics') {
                                            if ($val1 < $val2) $winner = 1;
                                            elseif ($val2 < $val1) $winner = 2;
                                        } else {
                                            if ($val1 > $val2) $winner = 1;
                                            elseif ($val2 > $val1) $winner = 2;
                                        }
                                    } elseif ($key == 'hp' && !empty($val1) && !empty($val2) && is_array($val1) && is_array($val2)) {
                                        preg_match('/\d+/', $val1[0] ?? '', $matches1);
                                        preg_match('/\d+/', $val2[0] ?? '', $matches2);
                                        $n1 = isset($matches1[0]) ? (int)$matches1[0] : 0;
                                        $n2 = isset($matches2[0]) ? (int)$matches2[0] : 0;
                                        if ($n1 > $n2) $winner = 1;
                                        elseif ($n2 > $n1) $winner = 2;
                                    } elseif ($key == 'torque' && !empty($val1) && !empty($val2)) {
                                        preg_match('/\d+/', $val1, $matches1);
                                        preg_match('/\d+/', $val2, $matches2);
                                        $n1 = isset($matches1[0]) ? (int)$matches1[0] : 0;
                                        $n2 = isset($matches2[0]) ? (int)$matches2[0] : 0;
                                        if ($n1 > $n2) $winner = 1;
                                        elseif ($n2 > $n1) $winner = 2;
                                    }
                                    
                                    $isDifferent = in_array($key, $differences);
                                @endphp
                                <div class="grid grid-cols-1 md:grid-cols-3 border-b border-outline-variant/10 transition-colors duration-300 {{ $isDifferent ? 'diff-row' : '' }}">
                                    <div class="p-4 bg-surface-container-high/40 font-label-caps text-label-caps text-on-surface-variant flex items-center gap-2">
                                        {{ $label }}
                                        @if($isDifferent)
                                            <span class="material-symbols-outlined text-[14px] text-primary opacity-0 diff-indicator">priority_high</span>
                                        @endif
                                    </div>
                                    <div class="p-4 flex items-center justify-center font-body-md text-center {{ $winner == 1 ? 'text-primary font-bold bg-primary/5' : 'text-on-surface' }}">
                                        @if(empty($val1) && $key != 'brands') 
                                            <span class="opacity-30">—</span>
                                        @elseif($key == 'brands') {{ $car1->brands->pluck('name')->implode(' / ') }}
                                        @elseif($key == 'zero_to_sixty') {{ $val1 }}s 
                                        @elseif($key == 'top_speed') {{ $val1 }} MPH
                                        @elseif($key == 'braking') {{ $val1 }} FT
                                        @elseif($key == 'aerodynamics') {{ $val1 }} CD
                                        @elseif($key == 'engine' && is_array($val1)) {{ implode(' / ', $val1) }}
                                        @elseif($key == 'hp' && is_array($val1)) 
                                            {{ collect($val1)->map(fn($h) => str_ireplace(' hp', '', $h))->implode(' / ') }} HP
                                        @else {{ $val1 }} @endif
                                    </div>
                                    <div class="p-4 flex items-center justify-center font-body-md text-center border-l border-outline-variant/10 {{ $winner == 2 ? 'text-primary font-bold bg-primary/5' : 'text-on-surface' }}">
                                        @if(empty($val2) && $key != 'brands') 
                                            <span class="opacity-30">—</span>
                                        @elseif($key == 'brands') {{ $car2->brands->pluck('name')->implode(' / ') }}
                                        @elseif($key == 'zero_to_sixty') {{ $val2 }}s 
                                        @elseif($key == 'top_speed') {{ $val2 }} MPH
                                        @elseif($key == 'braking') {{ $val2 }} FT
                                        @elseif($key == 'aerodynamics') {{ $val2 }} CD
                                        @elseif($key == 'engine' && is_array($val2)) {{ implode(' / ', $val2) }}
                                        @elseif($key == 'hp' && is_array($val2)) 
                                            {{ collect($val2)->map(fn($h) => str_ireplace(' hp', '', $h))->implode(' / ') }} HP
                                        @else {{ $val2 }} @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @else
                <div class="py-20 text-center glass-card">
                    <span class="material-symbols-outlined text-headline-xl text-primary mb-4" style="font-size: 64px">compare_arrows</span>
                    <h3 class="font-headline-md text-on-surface">Select vehicles to compare</h3>
                    <p class="text-on-surface-variant">Choose two specimens from the technical database to begin analysis.</p>
                </div>
            @endif
        </main>
    </div>

    <style>
        .highlight-diffs .diff-row {
            background-color: rgba(152, 203, 255, 0.05);
        }
        .highlight-diffs .diff-indicator {
            opacity: 1;
        }
    </style>

    <script>
        document.getElementById('toggleDiffs').addEventListener('click', function() {
            const body = document.querySelector('main');
            const knob = document.getElementById('toggleKnob');
            const bg = this;
            
            if (body.classList.contains('highlight-diffs')) {
                body.classList.remove('highlight-diffs');
                knob.classList.remove('translate-x-6', 'bg-primary');
                knob.classList.add('translate-x-1', 'bg-on-surface-variant');
                bg.classList.remove('bg-primary/20');
                bg.classList.add('bg-surface-variant');
            } else {
                body.classList.add('highlight-diffs');
                knob.classList.remove('translate-x-1', 'bg-on-surface-variant');
                knob.classList.add('translate-x-6', 'bg-primary');
                bg.classList.remove('bg-surface-variant');
                bg.classList.add('bg-primary/20');
            }
        });
    </script>
</x-app-layout>
