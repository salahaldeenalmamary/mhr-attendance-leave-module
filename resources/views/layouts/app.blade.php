<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" x-data="{ drawerOpen: true }">
    <div class="min-h-screen bg-gray-100 flex">

        {{-- Include Drawer Component --}}
        <x-drawer />

        <div class="flex-1 flex flex-col min-h-screen">

            <header class="bg-white shadow flex items-center justify-between px-4 py-3">
                <button @click="drawerOpen = !drawerOpen" class="text-gray-600 focus:outline-none md:hidden">
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        viewBox="0 0 24 24"
                    >
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex-1 text-center md:text-left">
                    @isset($header)
                        <div class="text-xl font-semibold text-gray-800 leading-tight">
                            {{ $header }}
                        </div>
                    @endisset
                </div>
                <div>
                    @include('layouts.navigation')
                </div>
            </header>

            <main class="flex-1 p-6 overflow-auto">
                {{ $slot }}
            </main>

        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
