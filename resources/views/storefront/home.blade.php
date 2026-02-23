<x-storefront-layout>
    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-10 px-4 sm:px-6 lg:px-8">
                <main class="mt-10 mx-auto max-w-7xl sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Welcome to</span>
                            <span class="block text-brand-primary">{{ tenant('name') ?? 'Our Store' }}</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Discover our curated collection of high-quality products. We are dedicated to providing the best shopping experience with exceptional service and value.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="/products" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-brand-primary hover:bg-brand-secondary transition md:py-4 md:text-lg md:px-10">
                                    Shop Now
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="/about" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-brand-primary bg-indigo-100 hover:bg-indigo-200 transition md:py-4 md:text-lg md:px-10">
                                    Learn More
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="Storefront Hero Image">
        </div>
    </div>

    <!-- Featured Categories Section -->
    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-baseline sm:justify-between mb-8">
                <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Shop by Category</h2>
                <a href="/categories" class="hidden sm:block text-sm font-semibold text-brand-primary hover:text-brand-secondary transition">Browse all categories<span aria-hidden="true"> &rarr;</span></a>
            </div>

            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:grid-rows-2 sm:gap-x-6 lg:gap-8">
                <div class="group aspect-w-2 aspect-h-1 rounded-lg overflow-hidden sm:aspect-h-1 sm:aspect-w-1 sm:row-span-2 relative">
                    <img src="https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80" alt="Menswear Collection" class="object-center object-cover group-hover:opacity-75 transition duration-300">
                    <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-50 absolute inset-0"></div>
                    <div class="absolute inset-0 flex items-end p-6">
                        <div>
                            <h3 class="font-semibold text-white">
                                <a href="#">
                                    <span class="absolute inset-0"></span>
                                    New Arrivals
                                </a>
                            </h3>
                            <p aria-hidden="true" class="mt-1 text-sm text-white">Shop now</p>
                        </div>
                    </div>
                </div>
                <div class="group aspect-w-2 aspect-h-1 rounded-lg overflow-hidden sm:relative sm:aspect-none sm:h-full relative">
                    <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80" alt="Womenswear Collection" class="object-center object-cover group-hover:opacity-75 transition duration-300 sm:absolute sm:inset-0 sm:h-full sm:w-full">
                    <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-50 absolute inset-0"></div>
                    <div class="absolute inset-0 flex items-end p-6">
                        <div>
                            <h3 class="font-semibold text-white">
                                <a href="#">
                                    <span class="absolute inset-0"></span>
                                    Accessories
                                </a>
                            </h3>
                            <p aria-hidden="true" class="mt-1 text-sm text-white">Shop now</p>
                        </div>
                    </div>
                </div>
                <div class="group aspect-w-2 aspect-h-1 rounded-lg overflow-hidden sm:relative sm:aspect-none sm:h-full relative">
                    <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1160&q=80" alt="Footwear Collection" class="object-center object-cover group-hover:opacity-75 transition duration-300 sm:absolute sm:inset-0 sm:h-full sm:w-full">
                    <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-50 absolute inset-0"></div>
                    <div class="absolute inset-0 flex items-end p-6">
                        <div>
                            <h3 class="font-semibold text-white">
                                <a href="#">
                                    <span class="absolute inset-0"></span>
                                    Footwear
                                </a>
                            </h3>
                            <p aria-hidden="true" class="mt-1 text-sm text-white">Shop now</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 sm:hidden">
                <a href="/categories" class="block text-sm font-semibold text-brand-primary hover:text-brand-secondary transition">Browse all categories<span aria-hidden="true"> &rarr;</span></a>
            </div>
        </div>
    </div>
</x-storefront-layout>
