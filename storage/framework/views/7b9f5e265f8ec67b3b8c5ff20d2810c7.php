<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(tenant('name') ?? 'Storefront'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    <!-- Dynamic Theming CSS -->
    <style>
        :root {
            --color-primary: <?php echo e(tenant('color_primary') ?? '#4f46e5'); ?>;
            --color-secondary: <?php echo e(tenant('color_secondary') ?? '#4338ca'); ?>;
        }
        
        .bg-brand-primary {
            background-color: var(--color-primary);
        }
        
        .bg-brand-secondary {
            background-color: var(--color-secondary);
        }

        .text-brand-primary {
            color: var(--color-primary);
        }

        .border-brand-primary {
            border-color: var(--color-primary);
        }

        .hover\:bg-brand-secondary:hover {
            background-color: var(--color-secondary);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Store Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-2xl font-bold text-brand-primary tracking-tight">
                        <?php echo e(tenant('name') ?? 'Storefront'); ?>

                    </a>
                    <nav class="hidden md:flex space-x-6 text-sm font-medium text-gray-700">
                        <a href="/" class="hover:text-brand-primary transition">Home</a>
                        <a href="/products" class="hover:text-brand-primary transition">Products</a>
                        <a href="/about" class="hover:text-brand-primary transition">About</a>
                        <a href="/contact" class="hover:text-brand-primary transition">Contact</a>
                    </nav>
                </div>
                <div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('login')): ?>
                        <div class="flex space-x-4 items-center">
                            <a href="#" class="text-gray-500 hover:text-brand-primary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(url('/dashboard')); ?>" class="text-sm font-semibold text-gray-600 hover:text-brand-primary">Dashboard</a>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="text-sm font-semibold text-gray-600 hover:text-brand-primary">Log in</a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            <?php echo e($slot); ?>

        </main>
        
        <!-- Store Footer -->
        <footer class="bg-gray-800 text-white mt-12 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4"><?php echo e(tenant('name') ?? 'Storefront'); ?></h3>
                    <p class="text-sm text-gray-400">Discover amazing products curated just for you.</p>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Shop</a></li>
                        <li><a href="#" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Customer Service</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Shipping Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Returns & Exchanges</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Newsletter</h4>
                    <p class="text-sm text-gray-400 mb-4">Subscribe to get updates on new products and offers.</p>
                    <form class="flex">
                        <input type="email" placeholder="Your email address" class="w-full px-3 py-2 text-sm text-gray-900 rounded-l-md border-none focus:ring-brand-primary" required>
                        <button type="submit" class="bg-brand-primary hover:bg-brand-secondary px-4 py-2 text-sm font-medium rounded-r-md transition">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-gray-700 text-sm text-center text-gray-400">
                &copy; <?php echo e(date('Y')); ?> <?php echo e(tenant('name') ?? 'Storefront'); ?>. All rights reserved.
            </div>
        </footer>
    </div>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH C:\Users\MUHAMMAD\Desktop\Project\MTECP\resources\views/components/storefront-layout.blade.php ENDPATH**/ ?>