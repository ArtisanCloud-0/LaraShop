<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100 dark:bg-gray-900">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Panel: {{ $title ?? config('app.name') }}</title>

        <!-- Theme Initialization Script (Prevents flash & fixes state persistence) -->
        <script>
            (function () {
                const isDark = localStorage.getItem('theme') === 'dark' || 
                    (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
                
                if (isDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();

            // Re-apply on Livewire wire:navigate requests
            document.addEventListener('livewire:navigated', () => {
                const isDark = localStorage.getItem('theme') === 'dark' || 
                    (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
                
                if (isDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            });
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="h-full antialiased">

        <div class="min-h-full">

            <livewire:admin.navbar />

            <header class="relative bg-white shadow-sm dark:bg-gray-800 dark:shadow-none dark:after:pointer-events-none dark:after:absolute dark:after:inset-x-0 dark:after:inset-y-0 dark:after:border-y dark:after:border-white/10">
                <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $title ?? "Dashboard" }}</h1>
                </div>
            </header>

            <main>
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                    {{ $slot }}

                </div>
            </main>

        </div>

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </body>
</html>