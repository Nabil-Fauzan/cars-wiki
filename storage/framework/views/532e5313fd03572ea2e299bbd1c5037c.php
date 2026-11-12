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

    <div class="max-w-container-max mx-auto px-margin-page py-stack-lg">
        <div class="flex flex-col md:flex-row justify-between items-center mb-stack-lg gap-gutter">
            <div>
                <h1 class="font-headline-lg text-headline-xl text-on-surface">Brand Registry</h1>
                <p class="text-on-surface-variant font-body-md">Manage automotive manufacturers and co-branding relations.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
            <!-- Add New Brand -->
            <div class="lg:col-span-1">
                <div class="glass-card p-stack-md machined-edge">
                    <h2 class="font-headline-md text-headline-md text-on-surface mb-stack-md">Add New Manufacturer</h2>
                    <form action="<?php echo e(route('admin.brands.store')); ?>" method="POST" class="space-y-4">
                        <?php echo csrf_field(); ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="p-4 text-on-surface font-body-md"><?php echo e($brand->name); ?></td>
                                    <td class="p-4 text-on-surface-variant font-body-sm"><?php echo e($brand->slug); ?></td>
                                    <td class="p-4 text-center">
                                        <span class="bg-surface-container px-2 py-1 rounded text-primary font-label-caps text-[10px]">
                                            <?php echo e($brand->cars_count); ?> ASSETS
                                        </span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <form action="<?php echo e(route('admin.brands.destroy', $brand->id)); ?>" method="POST" onsubmit="return confirm('Decommission this brand?')" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="text-error hover:scale-110 transition-transform">
                                                <span class="material-symbols-outlined">delete_forever</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-on-surface-variant italic">No brands registered in the tactical database.</td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH D:\laragon\www\pcar\resources\views/brands/admin.blade.php ENDPATH**/ ?>