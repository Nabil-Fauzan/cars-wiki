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
                    <div class="flex flex-wrap items-center gap-4">
                        @auth
                            @if($car1 && $car2)
                                <form action="{{ route('compare.save') }}" method="POST" class="flex items-center gap-2 bg-primary/10 p-1 pl-3 rounded-lg border border-primary/30">
                                    @csrf
                                    <input type="hidden" name="car1_id" value="{{ $car1->model_id }}">
                                    <input type="hidden" name="car2_id" value="{{ $car2->model_id }}">
                                    <input type="hidden" name="car3_id" value="{{ $car3 ? $car3->model_id : '' }}">
                                    <input type="text" name="name" placeholder="Name this set..." class="bg-transparent border-none focus:ring-0 text-xs font-label-caps text-on-surface w-32 placeholder:opacity-50" required>
                                    <button type="submit" class="bg-primary text-on-primary px-3 py-1 rounded text-[10px] font-label-caps hover:bg-primary-container transition-colors">SAVE BATTLE</button>
                                </form>
                            @endif
                        @endauth

                        <div class="flex items-center gap-4 bg-surface-container-low/50 p-2 rounded-lg border border-outline-variant/30 h-[42px]">
                            <span class="font-label-caps text-label-caps text-secondary">Highlight Differences</span>
                            <button type="button" id="toggleDiffs" class="relative inline-flex h-6 w-11 items-center rounded-full bg-surface-variant transition-colors focus:outline-none">
                                <span id="toggleKnob" class="inline-block h-4 w-4 transform rounded-full bg-on-surface-variant transition-transform translate-x-1"></span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Comparison Selectors -->
                <form action="{{ route('compare') }}" method="GET" class="sticky top-[64px] md:top-20 z-40 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter py-2 md:py-4 bg-background/90 backdrop-blur-xl border-b border-outline-variant/10">
                    @foreach([1, 2, 3] as $idx)
                        @php $car = ${"car$idx"}; @endphp
                        <div class="glass-card p-2 md:p-stack-sm rounded shadow-lg group relative overflow-hidden flex md:flex-col items-center md:items-stretch gap-3 md:gap-0">
                            <div class="flex-shrink-0 md:mb-4">
                                @if($car)
                                    <img class="w-16 h-12 md:w-full md:h-32 object-cover rounded" src="{{ $car->image_url }}" alt="{{ $car->model }}"/>
                                @else
                                    <div class="w-16 h-12 md:w-full md:h-32 bg-surface-container-low rounded flex items-center justify-center border-2 border-dashed border-outline-variant/30">
                                        <span class="material-symbols-outlined text-on-surface-variant text-sm">add</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center mb-1 md:mb-4">
                                    <span class="font-label-caps text-[8px] md:text-label-caps text-primary">SLOT_0{{ $idx }}</span>
                                    @if($car)
                                        <button type="button" @click="addToCompare({ model_id: '{{ $car->model_id }}', model: '{{ $car->model }}', image: '{{ $car->image_url }}' })" 
                                                class="text-xs font-label-caps" :class="isInCompare('{{ $car->model_id }}') ? 'text-primary' : 'text-secondary hover:text-on-surface'">
                                            <span class="material-symbols-outlined text-sm" x-text="isInCompare('{{ $car->model_id }}') ? 'check_circle' : 'add_circle'"></span>
                                        </button>
                                    @endif
                                </div>
                                <select name="car{{ $idx }}" onchange="this.form.submit()" class="w-full bg-transparent border-none border-b border-outline-variant/30 focus:ring-0 focus:border-primary text-on-surface font-headline-sm md:font-headline-md p-1 appearance-none text-sm md:text-base truncate">
                                    <option value="">{{ $idx == 3 ? 'Optional' : 'Select Vehicle' }}</option>
                                    @foreach($allCars as $c)
                                        <option value="{{ $c->model_id }}" {{ ($car && $car->model_id == $c->model_id) ? 'selected' : '' }}>
                                            {{ $c->model }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
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
                            'min_price' => 'Entry Price',
                            'max_price' => 'Peak Price',
                            'data_completion' => 'Data Quality',
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
                                    $val1 = $car1 ? $car1->$key : null;
                                    $val2 = $car2 ? $car2->$key : null;
                                    $val3 = $car3 ? $car3->$key : null;
                                    
                                    $allValues = [];
                                    if ($car1) $allValues[1] = $val1;
                                    if ($car2) $allValues[2] = $val2;
                                    if ($car3) $allValues[3] = $val3;

                                    $winner = null;
                                    $winnerVal = null;

                                    if ($key == 'brands' || $key == 'category' || $key == 'engine' || $key == 'transmission' || $key == 'drivetrain') {
                                        // Non-comparable
                                    } else {
                                        // Numeric comparison logic
                                        $numericValues = [];
                                        foreach ($allValues as $idx => $v) {
                                            if ($v === null || $v === '') continue;
                                            $n = 0;
                                            if ($key == 'hp' && is_array($v)) preg_match('/\d+/', $v[0] ?? '', $m);
                                            elseif ($key == 'year') preg_match('/\d{4}/', $v, $m);
                                            else preg_match('/\d+/', (string)$v, $m);
                                            
                                            if (isset($m[0])) $numericValues[$idx] = (float)$m[0];
                                            elseif (is_numeric($v)) $numericValues[$idx] = (float)$v;
                                        }

                                        if (count($numericValues) >= 2) {
                                            if ($key == 'zero_to_sixty' || $key == 'braking' || $key == 'aerodynamics' || $key == 'min_price' || $key == 'max_price') {
                                                $winnerVal = min($numericValues);
                                            } else {
                                                $winnerVal = max($numericValues);
                                            }
                                            // Check if only one has this value (to avoid highlighting all if they are same)
                                            if (count(array_keys($numericValues, $winnerVal)) < count($numericValues)) {
                                                $winner = array_search($winnerVal, $numericValues);
                                            }
                                        }
                                    }
                                    
                                    $isDifferent = in_array($key, $differences);
                                @endphp
                                <div class="grid grid-cols-4 md:grid-cols-4 border-b border-outline-variant/10 transition-colors duration-300 {{ $isDifferent ? 'diff-row' : '' }}">
                                    <div class="p-2 md:p-4 bg-surface-container-high/40 font-label-caps text-[8px] md:text-[10px] text-on-surface-variant flex items-center gap-1 md:gap-2 leading-tight">
                                        {{ $label }}
                                        @if($isDifferent)
                                            <span class="material-symbols-outlined text-[10px] md:text-[12px] text-primary opacity-0 diff-indicator">priority_high</span>
                                        @endif
                                    </div>
                                    
                                    @foreach([1, 2, 3] as $idx)
                                        @php 
                                            $car = ${"car$idx"}; 
                                            $val = ${"val$idx"};
                                            $isWinner = ($winner == $idx);
                                        @endphp
                                        <div class="p-2 md:p-4 flex flex-col items-center justify-center font-body-sm md:font-body-md text-center border-l border-outline-variant/10 transition-all {{ $isWinner ? 'bg-primary/[0.03] text-primary font-bold' : 'text-on-surface' }}">
                                            @if(!$car)
                                                <span class="opacity-10 material-symbols-outlined text-xs md:text-base">hide_source</span>
                                            @elseif($key == 'data_completion')
                                                <div class="w-full max-w-[80px] bg-surface-container-highest h-1.5 rounded-full overflow-hidden mb-1">
                                                    <div class="h-full {{ $val > 80 ? 'bg-success' : ($val > 50 ? 'bg-primary' : 'bg-warning') }}" style="width: {{ $val }}%"></div>
                                                </div>
                                                <span class="text-[9px] md:text-[10px] font-mono">{{ $val }}%</span>
                                            @elseif(empty($val) && $key != 'brands') 
                                                <span class="opacity-30">—</span>
                                            @elseif($key == 'brands') <span class="text-[9px] md:text-sm leading-tight">{{ $car->brands->pluck('name')->implode('/') }}</span>
                                            @elseif($key == 'zero_to_sixty') {{ $val }}s 
                                            @elseif($key == 'top_speed') {{ $val }}<span class="hidden md:inline"> MPH</span>
                                            @elseif($key == 'braking') {{ $val }}<span class="hidden md:inline"> FT</span>
                                            @elseif($key == 'aerodynamics') {{ $val }}
                                            @elseif($key == 'min_price' || $key == 'max_price') 
                                                ${{ $val >= 1000 ? number_format($val/1000, 0).'k' : number_format($val) }}
                                            @elseif($key == 'engine' && is_array($val)) 
                                                <div class="flex flex-col gap-0.5">
                                                    @foreach($val as $v)
                                                        <span class="text-[9px] md:text-xs leading-tight">{{ $v }}</span>
                                                    @endforeach
                                                </div>
                                            @elseif($key == 'hp' && is_array($val)) 
                                                <div class="flex flex-col gap-0.5">
                                                    @foreach($val as $v)
                                                        <span class="text-[9px] md:text-xs leading-tight">{{ str_ireplace(' hp', '', $v) }}<span class="hidden md:inline"> HP</span></span>
                                                    @endforeach
                                                </div>
                                            @else <span class="truncate w-full">{{ $val }}</span> @endif

                                            @if($isWinner)
                                                <span class="text-[7px] md:text-[8px] font-label-caps text-primary mt-0.5 md:mt-1 flex items-center gap-0.5 md:gap-1">
                                                    <span class="material-symbols-outlined text-[8px] md:text-[10px]">workspace_premium</span> <span class="hidden md:inline">BEST</span>
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
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
