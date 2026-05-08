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
                <a class="flex items-center gap-4 text-on-surface-variant hover:text-on-surface px-4 py-3 transition-colors" href="#">
                    <span class="material-symbols-outlined">factory</span>
                    <span class="font-label-caps text-label-caps">Brands</span>
                </a>
                <a class="flex items-center gap-4 text-on-surface-variant hover:text-on-surface px-4 py-3 transition-colors" href="#">
                    <span class="material-symbols-outlined">category</span>
                    <span class="font-label-caps text-label-caps">Categories</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 px-margin-page py-stack-lg max-w-container-max mx-auto w-full">
            <!-- Battle Sheet Header Section -->
            <section class="mb-stack-lg">
                <div class="flex flex-col md:flex-row justify-between items-end gap-gutter mb-stack-md">
                    <div>
                        <span class="font-label-caps text-label-caps text-primary border-l-2 border-primary pl-2 mb-2 block uppercase">Comparison Engine v4.2</span>
                        <h1 class="font-headline-xl text-headline-xl text-on-surface">Battle Sheet</h1>
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
                                <option value="{{ $car->model_id }}" {{ (isset($car1) && $car1->model_id == $car->model_id) ? 'selected' : '' }}>{{ $car->make }} {{ $car->model }}</option>
                            @endforeach
                        </select>
                        @if($car1)
                            <img class="w-full h-32 object-cover rounded mb-4" src="{{ $car1->image_url }}"/>
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
                                <option value="{{ $car->model_id }}" {{ (isset($car2) && $car2->model_id == $car->model_id) ? 'selected' : '' }}>{{ $car->make }} {{ $car->model }}</option>
                            @endforeach
                        </select>
                        @if($car2)
                            <img class="w-full h-32 object-cover rounded mb-4" src="{{ $car2->image_url }}"/>
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
                            'make' => 'Manufacturer',
                            'category' => 'Category',
                            'year' => 'Year',
                            'hp' => 'Horsepower',
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

                                    if ($key == 'make' || $key == 'category' || $key == 'engine' || $key == 'transmission' || $key == 'drivetrain' || $key == 'year') {
                                        // Non-comparable text fields
                                    } elseif (is_numeric($val1) && is_numeric($val2)) {
                                        if ($key == 'zero_to_sixty' || $key == 'braking' || $key == 'aerodynamics') {
                                            if ($val1 < $val2) $winner = 1;
                                            elseif ($val2 < $val1) $winner = 2;
                                        } else {
                                            if ($val1 > $val2) $winner = 1;
                                            elseif ($val2 > $val1) $winner = 2;
                                        }
                                    } elseif ($key == 'hp' && is_array($val1) && is_array($val2)) {
                                        // Extract first number from HP string (e.g. "145 hp (NA)" -> 145)
                                        preg_match('/\d+/', $val1[0] ?? '', $matches1);
                                        preg_match('/\d+/', $val2[0] ?? '', $matches2);
                                        $n1 = isset($matches1[0]) ? (int)$matches1[0] : 0;
                                        $n2 = isset($matches2[0]) ? (int)$matches2[0] : 0;
                                        if ($n1 > $n2) $winner = 1;
                                        elseif ($n2 > $n1) $winner = 2;
                                    }
                                @endphp
                                <div class="grid grid-cols-1 md:grid-cols-3 border-b border-outline-variant/10">
                                    <div class="p-4 bg-surface-container-high/40 font-label-caps text-label-caps text-on-surface-variant">{{ $label }}</div>
                                    <div class="p-4 flex items-center justify-center font-body-md text-center {{ $winner == 1 ? 'text-primary font-bold bg-primary/5' : 'text-on-surface' }}">
                                        @if($key == 'zero_to_sixty') {{ $val1 }}s 
                                        @elseif($key == 'top_speed') {{ $val1 }} MPH
                                        @elseif($key == 'braking') {{ $val1 }} FT
                                        @elseif($key == 'aerodynamics') {{ $val1 }} CD
                                        @elseif($key == 'engine' && is_array($val1)) {{ implode(' / ', $val1) }}
                                        @elseif($key == 'hp' && is_array($val1)) {{ implode(' HP / ', $val1) }} HP
                                        @else {{ $val1 }} @endif
                                    </div>
                                    <div class="p-4 flex items-center justify-center font-body-md text-center border-l border-outline-variant/10 {{ $winner == 2 ? 'text-primary font-bold bg-primary/5' : 'text-on-surface' }}">
                                        @if($key == 'zero_to_sixty') {{ $val2 }}s 
                                        @elseif($key == 'top_speed') {{ $val2 }} MPH
                                        @elseif($key == 'braking') {{ $val2 }} FT
                                        @elseif($key == 'aerodynamics') {{ $val2 }} CD
                                        @elseif($key == 'engine' && is_array($val2)) {{ implode(' / ', $val2) }}
                                        @elseif($key == 'hp' && is_array($val2)) {{ implode(' HP / ', $val2) }} HP
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
</x-app-layout>
