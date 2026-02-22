<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Multi-Tenant E-Commerce Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen bg-gray-50 selection:bg-indigo-500 selection:text-white">
        <!-- Site Header Navigation -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex justify-between items-center">
                <h1 class="text-3xl font-bold tracking-tight text-indigo-600">Platform</h1>
                <div>
                    @if (Route::has('login'))
                        <div class="flex space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-base font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-base font-semibold text-gray-600 hover:text-gray-900">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-base font-semibold text-gray-600 hover:text-gray-900">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <livewire:store-onboarding />
        </main>
        
        <footer class="text-center text-sm text-gray-500 py-6">
            Powered by Laravel and Stancl/Tenancy
        </footer>
    </div>
    @livewireScripts
</body>
</html>
