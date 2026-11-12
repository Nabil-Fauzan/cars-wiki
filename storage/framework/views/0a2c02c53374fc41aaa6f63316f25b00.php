<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <!-- Hero Section -->
    <section class="relative h-[870px] w-full flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-background via-background/40 to-transparent z-10"></div>
            <img class="w-full h-full object-cover grayscale opacity-60" alt="Sleek sports car hero" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBnaNRTGVkrVQtkTHk0fEYHRgycwyI6hoSTtd8nXT1acn17y-Hu97z7R0JTUobYQQL1nHKiN9k4qknpCR1tlQjMLKzScXwN4lav9kZ29Wu5rI9drIpwx7hXAm6hx3mJ3E7Ot4cRNUGbpM4quk7_Cpi36bNAtrypyVSLGr0Kim2-j5A9lIV19-3jTjdyVG9Cnw-I0jD2BCn1qjrcTIhuWZjIIndbNGbrXp8N5B0sy95y5V4tSJfUUOFy7n_1r1UG6ITNxtBVPHlc-eUr"/>
        </div>
        <div class="relative z-20 px-margin-page max-w-container-max mx-auto w-full">
            <div class="max-w-2xl">
                <h1 class="font-headline-xl text-headline-xl text-primary mb-2 opacity-0 gsap-hero-title flex items-center">Car<span class="text-on-surface">Dex</span></h1>
                <p class="font-body-lg text-body-lg text-secondary mb-stack-md opacity-0 gsap-hero-text">Smart Automotive Wiki for Enthusiasts</p>
                <form action="<?php echo e(route('home')); ?>" method="GET" id="filterForm" class="space-y-stack-md opacity-0 gsap-hero-form">
                    <input type="hidden" name="sort" value="<?php echo e(request('sort', 'newest')); ?>">
                    
                    <!-- Search Bar Integrated -->
                    <div class="relative">
                        <input name="search" value="<?php echo e(request('search')); ?>" class="w-full bg-surface-container-highest/60 backdrop-blur-md border-b-2 border-secondary p-stack-sm font-body-md text-on-surface focus:border-primary focus:outline-none transition-all duration-300" placeholder="Search by model or brand..." type="text"/>
                        <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 bg-primary text-on-primary px-stack-sm py-2 rounded-lg font-label-caps text-label-caps active:scale-95 transition-transform">
                            SEARCH
                        </button>
                    </div>

                    <!-- Quick Filters -->
                    <div class="flex flex-wrap gap-stack-sm items-end">
                        <div class="flex flex-col gap-1 min-w-[150px]">
                            <span class="font-label-caps text-label-caps text-secondary">BRAND</span>
                            <select name="brand" onchange="this.form.submit()" class="bg-surface-container-low/50 border border-outline-variant rounded-lg text-on-surface px-3 py-2 font-body-md outline-none focus:border-primary cursor-pointer">
                                <option value="">All Brands</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $brandModels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_object($brand) && isset($brand->name)): ?>
                                        <option value="<?php echo e($brand->name); ?>" <?php echo e(request('brand') == $brand->name ? 'selected' : ''); ?>><?php echo e($brand->name); ?></option>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>
                        <div class="flex flex-col gap-1 min-w-[150px]">
                            <span class="font-label-caps text-label-caps text-secondary">CATEGORY</span>
                            <select name="category" onchange="this.form.submit()" class="bg-surface-container-low/50 border border-outline-variant rounded-lg text-on-surface px-3 py-2 font-body-md outline-none focus:border-primary cursor-pointer">
                                <option value="">All Categories</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_string($category)): ?>
                                        <option value="<?php echo e($category); ?>" <?php echo e(request('category') == $category ? 'selected' : ''); ?>><?php echo e($category); ?></option>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>
                        
                        <button type="button" onclick="document.getElementById('advancedFilters').classList.toggle('hidden')" class="flex items-center gap-2 text-primary font-label-caps text-label-caps py-2 px-4 hover:bg-primary/10 rounded transition-all">
                            <span class="material-symbols-outlined">tune</span>
                            ADVANCED FILTERS
                        </button>
                    </div>

                    <!-- Advanced Filters Hidden by Default -->
                    <div id="advancedFilters" class="hidden grid grid-cols-1 md:grid-cols-3 gap-gutter p-stack-sm bg-surface-container/30 backdrop-blur-md rounded-lg border border-outline-variant/20">
                        <div class="flex flex-col gap-1">
                            <span class="font-label-caps text-label-caps text-secondary">YEAR RANGE</span>
                            <div class="flex items-center gap-2">
                                <input name="year_min" value="<?php echo e(request('year_min')); ?>" placeholder="Min" class="w-full bg-surface-container-low border border-outline-variant rounded px-2 py-1 text-on-surface focus:border-primary outline-none" type="number"/>
                                <span class="text-secondary">—</span>
                                <input name="year_max" value="<?php echo e(request('year_max')); ?>" placeholder="Max" class="w-full bg-surface-container-low border border-outline-variant rounded px-2 py-1 text-on-surface focus:border-primary outline-none" type="number"/>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="font-label-caps text-label-caps text-secondary">MIN HORSEPOWER</span>
                            <select name="hp" class="bg-surface-container-low border border-outline-variant rounded px-2 py-1 text-on-surface focus:border-primary outline-none">
                                <option value="">Any Power</option>
                                <option value="200" <?php echo e(request('hp') == '200' ? 'selected' : ''); ?>>200+ HP</option>
                                <option value="400" <?php echo e(request('hp') == '400' ? 'selected' : ''); ?>>400+ HP</option>
                                <option value="600" <?php echo e(request('hp') == '600' ? 'selected' : ''); ?>>600+ HP</option>
                                <option value="800" <?php echo e(request('hp') == '800' ? 'selected' : ''); ?>>800+ HP</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="font-label-caps text-label-caps text-secondary">TRANSMISSION</span>
                            <select name="transmission" class="bg-surface-container-low border border-outline-variant rounded px-2 py-1 text-on-surface focus:border-primary outline-none">
                                <option value="">Any Trans</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($trans); ?>" <?php echo e(request('transmission') == $trans ? 'selected' : ''); ?>><?php echo e($trans); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>
                        <div class="md:col-span-3 flex justify-end">
                            <button type="submit" class="bg-secondary-container/50 text-on-surface px-6 py-2 rounded font-label-caps text-label-caps hover:bg-primary hover:text-on-primary transition-all">
                                APPLY FILTERS
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Main Browsing Section -->
    <section class="px-margin-page max-w-container-max mx-auto py-stack-lg">
        <div class="flex flex-col md:flex-row justify-between items-end mb-stack-lg gap-gutter">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Featured Specimens</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Precision curated data for the modern collector.</p>
            </div>
            <div class="flex flex-wrap gap-stack-sm border-b border-outline-variant pb-2">
                <a href="<?php echo e(route('home', array_merge(request()->query(), ['sort' => 'newest']))); ?>" class="font-label-caps text-label-caps <?php echo e(request('sort', 'newest') == 'newest' ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-on-surface'); ?> pb-1 transition-all">NEWEST</a>
                <a href="<?php echo e(route('home', array_merge(request()->query(), ['sort' => 'fastest']))); ?>" class="font-label-caps text-label-caps <?php echo e(request('sort') == 'fastest' ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-on-surface'); ?> pb-1 transition-all">FASTEST</a>
                <a href="<?php echo e(route('home', array_merge(request()->query(), ['sort' => 'acceleration']))); ?>" class="font-label-caps text-label-caps <?php echo e(request('sort') == 'acceleration' ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-on-surface'); ?> pb-1 transition-all">ACCELERATION</a>
                <a href="<?php echo e(route('home', array_merge(request()->query(), ['sort' => 'best']))); ?>" class="font-label-caps text-label-caps <?php echo e(request('sort') == 'best' ? 'text-primary border-b-2 border-primary' : 'text-secondary hover:text-on-surface'); ?> pb-1 transition-all">BEST RATED</a>
            </div>
        </div>

        <!-- Bento Grid / Card Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <!-- Card -->
                <div class="glass-card group flex flex-col transition-all duration-300 opacity-0 gsap-card">
                        <div class="relative aspect-video overflow-hidden">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="<?php echo e($car->brands->first()->name ?? 'Vehicle'); ?> <?php echo e($car->model); ?>" onerror="imgError(this)" src="<?php echo e($car->image_url); ?>"/>
                            <div class="absolute top-4 right-4 bg-primary text-on-primary px-2 py-1 font-label-caps text-label-caps"><?php echo e($car->model_id); ?></div>
                            
                            <!-- Add to Compare Button Overlay -->
                            <div class="absolute inset-0 bg-black/20 lg:bg-black/40 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                <button @click="addToCompare({ model_id: '<?php echo e($car->model_id); ?>', model: '<?php echo e($car->model); ?>', image: '<?php echo e($car->image_url); ?>' })" 
                                        class="p-4 lg:p-3 rounded-full backdrop-blur-md transition-all active:scale-90 shadow-lg"
                                        :class="isInCompare('<?php echo e($car->model_id); ?>') ? 'bg-primary text-on-primary' : 'bg-white/30 text-white hover:bg-white/50'">
                                    <span class="material-symbols-outlined text-2xl lg:text-base" x-text="isInCompare('<?php echo e($car->model_id); ?>') ? 'check_circle' : 'compare_arrows'"></span>
                                </button>
                            </div>
                        </div>
                    <div class="p-stack-sm flex flex-col gap-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-label-caps text-label-caps text-primary flex flex-wrap gap-1">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $car->brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <span><?php echo e(strtoupper($brand->name)); ?></span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$loop->last): ?> <span class="opacity-30">•</span> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </p>
                                <h3 class="font-headline-md text-headline-md text-on-surface"><?php echo e($car->model); ?></h3>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span class="font-headline-md text-headline-md text-on-surface"><?php echo e($car->year); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                                    <form action="<?php echo e(route('cars.favorite', $car)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="text-primary hover:scale-110 transition-transform">
                                            <span class="material-symbols-outlined <?php echo e(auth()->user()->favorites->contains($car->id) ? 'fill-1' : ''); ?>">
                                                <?php echo e(auth()->user()->favorites->contains($car->id) ? 'favorite' : 'favorite'); ?>

                                            </span>
                                        </button>
                                    </form>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 border-t border-outline-variant/30 pt-4">
                            <div>
                                <p class="font-label-caps text-label-caps text-secondary mb-1">HORSEPOWER</p>
                                <p class="font-body-md text-body-md text-on-surface"><?php echo e(str_ireplace(' hp', '', is_array($car->hp) ? ($car->hp[0] ?? 'N/A') : $car->hp)); ?> HP</p>
                            </div>
                            <div>
                                <p class="font-label-caps text-label-caps text-secondary mb-1">CATEGORY</p>
                                <p class="font-body-md text-body-md text-on-surface"><?php echo e($car->category); ?></p>
                            </div>
                        </div>
                        <a href="<?php echo e(route('cars.show', $car->model_id)); ?>" class="w-full py-3 bg-secondary-container/30 hover:bg-primary hover:text-on-primary transition-all font-label-caps text-label-caps machined-edge text-center">
                            TECHNICAL SPECS
                        </a>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="col-span-full py-20 text-center glass-card">
                    <span class="material-symbols-outlined text-headline-xl text-primary mb-4" style="font-size: 64px">search_off</span>
                    <h3 class="font-headline-md text-on-surface">No specimens found in database</h3>
                    <p class="text-on-surface-variant">The encyclopedia is currently awaiting technical data deployment.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-stack-lg">
            <?php echo e($cars->links()); ?>

        </div>
    </section>

    <!-- Technical Framework Section -->
    <section class="bg-surface-container py-stack-lg px-margin-page">
        <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-2 gap-stack-lg items-center">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-stack-sm">The Encyclopedia Framework</h2>
                <p class="font-body-lg text-body-lg text-secondary mb-gutter">CarDex is more than a database. It is a technical record of automotive history, utilizing precision data sources to provide enthusiasts with absolute accuracy.</p>
                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center bg-surface-container-low/50 p-4 border-l-2 border-primary">
                        <span class="font-label-caps text-label-caps text-secondary">ACTIVE ENTRIES</span>
                        <span class="font-headline-md text-headline-md text-primary"><?php echo e(number_format($totalCars)); ?></span>
                    </div>
                    <div class="flex justify-between items-center bg-surface-container-low/30 p-4 border-l-2 border-outline-variant">
                        <span class="font-label-caps text-label-caps text-secondary">DAILY CONTRIBUTIONS</span>
                        <span class="font-headline-md text-headline-md text-on-surface"><?php echo e(number_format($dailyCount)); ?></span>
                    </div>
                    <div class="flex justify-between items-center bg-surface-container-low/50 p-4 border-l-2 border-outline-variant">
                        <span class="font-label-caps text-label-caps text-secondary">VERIFIED SPECS</span>
                        <span class="font-headline-md text-headline-md text-on-surface"><?php echo e(number_format($averageCompletion, 1)); ?>%</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-gutter">
                <a href="<?php echo e(route('brands')); ?>" class="glass-card p-stack-sm flex flex-col gap-2 aspect-square justify-center text-center hover:border-primary transition-all group">
                    <span class="material-symbols-outlined text-primary text-[48px] group-hover:scale-110 transition-transform">factory</span>
                    <h4 class="font-headline-md text-headline-md text-on-surface">Brands</h4>
                    <p class="font-body-md text-body-md text-secondary">Historical depth on 200+ manufacturers.</p>
                </a>
                <a href="<?php echo e(route('compare')); ?>" class="glass-card p-stack-sm flex flex-col gap-2 aspect-square justify-center text-center hover:border-primary transition-all group">
                    <span class="material-symbols-outlined text-primary text-[48px] group-hover:scale-110 transition-transform">compare_arrows</span>
                    <h4 class="font-headline-md text-headline-md text-on-surface">Compare</h4>
                    <p class="font-body-md text-body-md text-secondary">Side-by-side technical metrics.</p>
                </a>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.gsap) {
                const tl = gsap.timeline();
                
                // Hero Animations
                tl.fromTo('.gsap-hero-title', 
                    { y: 50, opacity: 0 }, 
                    { y: 0, opacity: 1, duration: 1, ease: 'power4.out' }
                )
                .fromTo('.gsap-hero-text', 
                    { y: 30, opacity: 0 }, 
                    { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out' },
                    '-=0.6'
                )
                .fromTo('.gsap-hero-form', 
                    { y: 20, opacity: 0 }, 
                    { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out' },
                    '-=0.4'
                );

                // Card Staggered Entrance
                gsap.fromTo('.gsap-card', 
                    { y: 60, opacity: 0 }, 
                    { 
                        y: 0, 
                        opacity: 1, 
                        duration: 0.8, 
                        stagger: 0.1, 
                        ease: 'back.out(1.2)',
                        scrollTrigger: {
                            trigger: '.gsap-card',
                            start: 'top 85%',
                        }
                    }
                );

                // Section Reveal
                gsap.from('.font-headline-lg', {
                    scrollTrigger: {
                        trigger: '.font-headline-lg',
                        start: 'top 90%',
                    },
                    y: 30,
                    opacity: 0,
                    duration: 1,
                    ease: 'power2.out'
                });
            }
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\pcar\resources\views/welcome.blade.php ENDPATH**/ ?>