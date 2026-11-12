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

    <section class="max-w-container-max mx-auto px-margin-page py-stack-lg">
        <div class="mb-stack-lg flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-center md:text-left">
                <h1 class="font-headline-xl text-headline-xl text-on-surface mb-2">Automotive Excellence by Brand</h1>
                <p class="text-on-surface-variant font-body-lg">Explore the technical lineage of the world's most prestigious manufacturers.</p>
            </div>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', App\Models\Brand::class)): ?>
                <a href="<?php echo e(route('admin.brands')); ?>" class="bg-primary px-stack-md py-3 text-on-primary font-label-caps text-label-caps rounded-[4px] hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined">settings</span> Manage Brands
                </a>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="glass-card group relative overflow-hidden transition-all duration-300 hover:border-primary">
                    <?php $firstCar = $brand->cars->first(); ?>
                    <div class="aspect-square relative overflow-hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($firstCar): ?>
                            <img src="<?php echo e($firstCar->image_url); ?>" alt="<?php echo e($brand->name); ?>" class="w-full h-full object-cover opacity-40 group-hover:opacity-60 transition-opacity grayscale group-hover:grayscale-0">
                        <?php else: ?>
                            <div class="w-full h-full bg-surface-container-highest flex items-center justify-center opacity-40">
                                <span class="material-symbols-outlined text-headline-xl">factory</span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-background to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center p-6">
                            <!-- Brand Logo / Icon Badge -->
                            <div class="w-20 h-20 mb-4 flex items-center justify-center bg-surface-container/60 backdrop-blur-md rounded-full p-4 border border-outline-variant/30 shadow-lg group-hover:scale-110 group-hover:border-primary/50 group-hover:bg-surface-container/85 transition-all duration-300">
                                <?php
                                    $logoPath = null;
                                    $extensions = ['png', 'svg', 'webp', 'jpg', 'jpeg'];
                                    foreach ($extensions as $ext) {
                                        if (file_exists(public_path("images/brands/{$brand->slug}.{$ext}"))) {
                                            $logoPath = "images/brands/{$brand->slug}.{$ext}";
                                            break;
                                        } elseif (file_exists(public_path("images/brands/{$brand->slug}-preview.{$ext}"))) {
                                            $logoPath = "images/brands/{$brand->slug}-preview.{$ext}";
                                            break;
                                        }
                                    }
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($brand->logo_url && file_exists(public_path($brand->logo_url))): ?>
                                    <img src="<?php echo e(asset($brand->logo_url)); ?>" alt="<?php echo e($brand->name); ?> Logo" class="max-w-full max-h-full object-contain">
                                <?php elseif($logoPath): ?>
                                    <img src="<?php echo e(asset($logoPath)); ?>" alt="<?php echo e($brand->name); ?> Logo" class="max-w-full max-h-full object-contain">
                                <?php else: ?>
                                    <span class="material-symbols-outlined text-[36px] text-primary/80 group-hover:text-primary transition-colors">factory</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <span class="font-headline-lg text-headline-lg text-on-surface text-center uppercase tracking-tighter"><?php echo e($brand->name); ?></span>
                            <span class="font-label-caps text-label-caps text-primary mt-2"><?php echo e($brand->cars_count); ?> SPECIMENS</span>
                        </div>
                    </div>
                    <a href="<?php echo e(route('cars.index')); ?>?brand=<?php echo e($brand->slug); ?>" class="absolute inset-0 z-10"></a>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="col-span-full py-20 text-center glass-card">
                    <span class="material-symbols-outlined text-headline-xl text-primary mb-4" style="font-size: 64px">factory</span>
                    <h3 class="font-headline-md text-on-surface">No brands registered</h3>
                    <p class="text-on-surface-variant">Deploy assets to populate the manufacturer database.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>
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
<?php /**PATH C:\xampp\htdocs\p-car\resources\views/brands/index.blade.php ENDPATH**/ ?>