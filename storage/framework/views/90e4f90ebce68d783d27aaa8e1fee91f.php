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

    <div class="flex flex-1 min-h-[calc(100vh-80px)]">
        <!-- SideNavBar -->
        <aside class="hidden lg:flex flex-col w-64 bg-surface-container border-r border-outline-variant/20 py-8 overflow-y-auto">
            <div class="px-6 mb-8">
                <h2 class="font-headline-md text-headline-md font-bold flex items-center"><span class="text-primary">Car</span><span class="text-on-surface">Dex</span>&nbsp;Wiki</h2>
                <p class="font-body-md text-[12px] text-on-surface-variant uppercase tracking-widest">Technical Encyclopedia</p>
            </div>
            <nav class="flex-1 space-y-1">
                <a class="flex items-center gap-4 <?php echo e(request()->is('/') ? 'bg-secondary-container/50 text-primary border-l-4 border-primary' : 'text-on-surface-variant hover:text-on-surface'); ?> px-4 py-3 active:translate-x-1 transition-transform duration-200" href="<?php echo e(url('/')); ?>">
                    <span class="material-symbols-outlined">home</span>
                    <span class="font-label-caps text-label-caps">Home</span>
                </a>
                <a class="flex items-center gap-4 <?php echo e(request()->is('cars*') ? 'bg-secondary-container/50 text-primary border-l-4 border-primary' : 'text-on-surface-variant hover:text-on-surface'); ?> px-4 py-3 active:translate-x-1 transition-transform duration-200" href="<?php echo e(route('cars.index')); ?>">
                    <span class="material-symbols-outlined">directions_car</span>
                    <span class="font-label-caps text-label-caps">Explore Cars</span>
                </a>
                <a class="flex items-center gap-4 <?php echo e(request()->is('compare*') ? 'bg-secondary-container/50 text-primary border-l-4 border-primary' : 'text-on-surface-variant hover:text-on-surface'); ?> px-4 py-3 active:translate-x-1 transition-transform duration-200" href="<?php echo e(route('compare')); ?>">
                    <span class="material-symbols-outlined">compare_arrows</span>
                    <span class="font-label-caps text-label-caps">Compare</span>
                </a>
                <a class="flex items-center gap-4 <?php echo e(request()->is('brands*') ? 'bg-secondary-container/50 text-primary border-l-4 border-primary' : 'text-on-surface-variant hover:text-on-surface'); ?> px-4 py-3 active:translate-x-1 transition-transform duration-200" href="<?php echo e(route('brands')); ?>">
                    <span class="material-symbols-outlined">factory</span>
                    <span class="font-label-caps text-label-caps">Brands</span>
                </a>
                <a class="flex items-center gap-4 <?php echo e(request()->is('categories*') ? 'bg-secondary-container/50 text-primary border-l-4 border-primary' : 'text-on-surface-variant hover:text-on-surface'); ?> px-4 py-3 active:translate-x-1 transition-transform duration-200" href="<?php echo e(route('categories')); ?>">
                    <span class="material-symbols-outlined">category</span>
                    <span class="font-label-caps text-label-caps">Categories</span>
                </a>
                <a class="flex items-center gap-4 <?php echo e(request()->is('dashboard*') ? 'bg-secondary-container/50 text-primary border-l-4 border-primary' : 'text-on-surface-variant hover:text-on-surface'); ?> px-4 py-3 active:translate-x-1 transition-transform duration-200" href="<?php echo e(route('dashboard')); ?>">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">lock</span>
                    <span class="font-label-caps text-label-caps">Admin Panel</span>
                </a>
                <a class="flex items-center gap-4 <?php echo e(request()->is('admin/brands*') ? 'bg-secondary-container/50 text-primary border-l-4 border-primary' : 'text-on-surface-variant hover:text-on-surface'); ?> px-4 py-3 active:translate-x-1 transition-transform duration-200" href="<?php echo e(route('admin.brands.index')); ?>">
                    <span class="material-symbols-outlined">factory</span>
                    <span class="font-label-caps text-label-caps">Manage Brands</span>
                </a>
                <a class="flex items-center gap-4 <?php echo e(request()->is('admin/data-audit*') ? 'bg-secondary-container/50 text-primary border-l-4 border-primary' : 'text-on-surface-variant hover:text-on-surface'); ?> px-4 py-3 active:translate-x-1 transition-transform duration-200" href="<?php echo e(url('/admin/data-audit')); ?>">
                    <span class="material-symbols-outlined">shield</span>
                    <span class="font-label-caps text-label-caps">Pusat Penjaminan Mutu</span>
                </a>
            </nav>
            <div class="px-6 mt-auto">
                <a href="<?php echo e(route('cars.create')); ?>" class="w-full bg-primary text-on-primary py-3 px-4 font-label-caps text-label-caps rounded-lg hover:opacity-90 transition-all text-center block">
                    Submit Data
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 px-8 py-stack-lg max-w-7xl mx-auto w-full">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="mb-6 p-4 bg-primary/10 border border-primary/30 text-primary font-label-caps text-label-caps rounded flex items-center gap-3">
                    <span class="material-symbols-outlined">check_circle</span>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Dashboard Header -->
            <section class="mb-stack-lg">
                <h1 class="font-headline-xl text-headline-xl text-on-surface mb-2">Central Operations</h1>
                <p class="text-on-surface-variant font-body-lg">Precision data oversight for the global automotive database.</p>
            </section>

            <!-- Stats Bento Grid -->
            <section class="grid grid-cols-1 md:grid-cols-4 gap-gutter mb-stack-lg">
                <div class="glass-card p-6 rounded-lg col-span-1 border-t-2 border-t-primary">
                    <p class="font-label-caps text-label-caps text-secondary mb-2 uppercase">Total Database Entries</p>
                    <div class="flex items-end gap-2">
                        <span class="font-headline-lg text-headline-lg text-primary"><?php echo e($stats['total']); ?></span>
                        <span class="text-primary-fixed text-sm mb-2">+0%</span>
                    </div>
                </div>
                <div class="glass-card p-6 rounded-lg col-span-1">
                    <p class="font-label-caps text-label-caps text-secondary mb-2 uppercase">Active Users</p>
                    <div class="flex items-end gap-2">
                        <span class="font-headline-lg text-headline-lg text-on-surface">3.2k</span>
                        <span class="text-on-surface-variant text-sm mb-2">/daily</span>
                    </div>
                </div>
                <div class="glass-card p-6 rounded-lg col-span-2 relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="font-label-caps text-label-caps text-secondary mb-2 uppercase">Data Completion Index</p>
                        <div class="h-2 w-full bg-surface-container rounded-full overflow-hidden flex gap-0.5 mt-4">
                            <?php $comp = $stats['completion']; ?>
                            <div class="h-full bg-primary" style="width: <?php echo e($comp); ?>%"></div>
                        </div>
                        <p class="text-[10px] text-on-surface-variant mt-2">DATABASE HEALTH: <?php echo e($comp > 80 ? 'OPTIMAL' : 'REFINEMENT NEEDED'); ?> (<?php echo e(number_format($comp, 1)); ?>%)</p>
                    </div>
                </div>
            </section>

            <!-- Main Tables Section -->
            <div class="space-y-stack-md">
                <!-- Cars CRUD Table -->
                <div class="glass-card rounded-lg overflow-hidden border border-outline-variant/20">
                    <div class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-outline-variant/20 bg-surface-container-high">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">directions_car</span>
                            <h3 class="font-headline-md text-headline-md">Vehicle Inventory Management</h3>
                        </div>
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <form action="<?php echo e(route('dashboard')); ?>" method="GET" class="relative flex-1 md:w-64">
                                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search assets..." class="w-full bg-surface-container border-none border-b border-outline-variant focus:ring-0 focus:border-primary text-on-surface p-2 text-sm pl-8">
                                <span class="material-symbols-outlined absolute left-2 top-1/2 -translate-y-1/2 text-sm text-secondary">search</span>
                            </form>
                            <a href="<?php echo e(route('cars.create')); ?>" class="bg-primary text-on-primary px-4 py-2 font-label-caps text-label-caps hover:brightness-110 transition-all flex items-center gap-2 flex-shrink-0">
                                <span class="material-symbols-outlined text-sm">add</span>
                                DEPLOY NEW ASSET
                            </a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low border-b border-outline-variant/30">
                                    <th class="px-6 py-4 font-label-caps text-label-caps text-secondary">MODEL ID</th>
                                    <th class="px-6 py-4 font-label-caps text-label-caps text-secondary">MAKE / BRAND</th>
                                    <th class="px-6 py-4 font-label-caps text-label-caps text-secondary">STATUS</th>
                                    <th class="px-6 py-4 font-label-caps text-label-caps text-secondary">DATA COMPLETION</th>
                                    <th class="px-6 py-4 font-label-caps text-label-caps text-secondary text-right">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <tr class="hover:bg-white/5 transition-colors group">
                                        <td class="px-6 py-4 font-mono text-sm">
                                            <span class="cursor-copy hover:text-primary transition-colors active:scale-95 inline-block" onclick="copyToClipboard('<?php echo e($car->model_id); ?>', this)" title="Click to copy ID">
                                                <?php echo e($car->model_id); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_2 = true; $__currentLoopData = $car->brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                    <span class="bg-surface-container px-2 py-1 rounded text-on-surface font-label-caps text-[10px]">
                                                        <?php echo e($brand->name); ?>

                                                    </span>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                    <span class="text-error italic text-[10px]">NO BRAND LINKED</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="<?php echo e(route('cars.toggle-status', $car)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" title="Toggle Status" class="px-2 py-1 <?php echo e($car->status == 'Live' ? 'bg-primary/10 text-primary' : 'bg-outline-variant/20 text-on-surface-variant'); ?> text-[10px] font-bold uppercase tracking-tighter rounded hover:brightness-125 transition-all">
                                                    <?php echo e($car->status); ?>

                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="w-32 h-1 bg-surface-container rounded-full relative overflow-hidden">
                                                <?php
                                                    $color = 'bg-error';
                                                    if($car->data_completion > 80) $color = 'bg-primary';
                                                    elseif($car->data_completion > 50) $color = 'bg-warning';
                                                ?>
                                                <div class="absolute inset-0 <?php echo e($color); ?> transition-all duration-1000" style="width: <?php echo e($car->data_completion); ?>%"></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <a href="<?php echo e(route('cars.show', $car->model_id)); ?>" class="material-symbols-outlined text-secondary-fixed hover:text-primary text-lg" title="View Public Page">visibility</a>
                                                <a href="<?php echo e(route('cars.duplicate', $car)); ?>" class="material-symbols-outlined text-secondary-fixed hover:text-primary text-lg" title="Add Variant (Duplicate)">content_copy</a>
                                                <a href="<?php echo e(route('cars.edit', $car)); ?>" class="material-symbols-outlined text-secondary-fixed hover:text-primary text-lg" title="Edit Spec">edit</a>
                                                <form action="<?php echo e(route('cars.destroy', $car)); ?>" method="POST" onsubmit="return confirm('Confirm asset decommissioning?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="material-symbols-outlined text-secondary-fixed hover:text-error text-lg" title="Delete Asset">delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-20 text-center text-on-surface-variant font-body-md">
                                            No assets deployed. Initialize database with technical data.
                                        </td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        function copyToClipboard(text, el) {
            navigator.clipboard.writeText(text).then(() => {
                const originalText = el.innerText;
                el.innerText = 'COPIED!';
                el.classList.add('text-primary');
                setTimeout(() => {
                    el.innerText = originalText;
                    el.classList.remove('text-primary');
                }, 1000);
            });
        }
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
<?php /**PATH D:\laragon\www\pcar\resources\views/dashboard.blade.php ENDPATH**/ ?>