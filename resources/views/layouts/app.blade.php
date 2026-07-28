@php
    $links = [
        ['name' => 'Dashboard',  'route' => 'dashboard',             'pattern' => ['dashboard']],
        ['name' => 'Users',      'route' => 'panel.users',           'pattern' => ['panel.users*']],
        ['name' => 'Categories', 'route' => 'panel.categories',      'pattern' => ['panel.categories*']],
        ['name' => 'Products',   'route' => 'panel.products',        'pattern' => ['panel.products*']],
        ['name' => 'Orders',     'route' => 'panel.orders',          'pattern' => ['panel.orders*']],
        ['name' => 'Reports',    'route' => 'panel.reports',         'pattern' => ['panel.reports*']],
    ];

    $profileLinks = [
        ['name' => 'Your Profile', 'route' => 'profile.show'],
        ['name' => 'Settings',     'route' => 'profile.settings'],
        ['name' => 'Sign out',     'route' => 'logout'],
    ];
@endphp

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

            <nav 
                x-data="{ 
                    darkMode: document.documentElement.classList.contains('dark'),
                    toggleTheme() {
                        this.darkMode = !this.darkMode;
                        if (this.darkMode) {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                        }
                    }
                }"
                class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200/50 dark:border-gray-800"
            >

                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                    <div class="flex h-16 items-center justify-between gap-x-4">

                        <!-- Brand Logo & Main Navigation -->
                        <div class="flex items-center gap-x-6">
                            <div class="shrink-0">
                                <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Company Logo" class="size-8" />
                            </div>

                            <x-menu.lg :links="$links" />
                        </div>

                        <!-- Global Search Bar -->
                        <div class="flex-1 max-w-md hidden sm:block">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative text-gray-400 focus-within:text-gray-600 dark:focus-within:text-gray-200">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input 
                                    id="search" 
                                    name="search" 
                                    type="search" 
                                    placeholder="Search..." 
                                    class="block w-full rounded-md border-0 bg-gray-200/50 dark:bg-gray-700/50 py-1.5 pl-10 pr-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-500 dark:placeholder:text-gray-400 focus:bg-white dark:focus:bg-gray-800 focus:outline-2 focus:outline-indigo-500 transition-colors"
                                >
                            </div>
                        </div>

                        <!-- Desktop Right Navigation (Theme Toggle, Notifications & Profile) -->
                        <div class="hidden md:block">

                            <div class="ml-4 flex items-center gap-x-3">

                                <!-- Light / Dark Mode Toggle Button -->
                                <button 
                                    type="button" 
                                    @click="toggleTheme()"
                                    aria-label="Toggle theme"
                                    class="relative rounded-full p-1.5 text-gray-400 hover:text-gray-500 focus:outline-2 focus:outline-offset-2 focus:outline-gray-200 dark:text-gray-400 dark:hover:text-white transition-colors"
                                >
                                    <!-- Sun Icon (shows when dark mode is ON) -->
                                    <svg x-show="darkMode" x-cloak viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6">
                                        <path d="M12 3v2.25m0 13.5V21m8.966-8.966h-2.25M4.5 12H2.25m15.364-6.364l-1.591 1.591M6.75 17.25l-1.591 1.591m12.728 0l-1.591-1.591M6.75 6.75L5.159 5.159M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>

                                    <!-- Moon Icon (shows when dark mode is OFF) -->
                                    <svg x-show="!darkMode" x-cloak viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6">
                                        <path d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>

                                <!-- Notifications Button -->
                                <button 
                                    type="button" 
                                    class="relative rounded-full p-1.5 text-gray-400 hover:text-gray-500 focus:outline-2 focus:outline-offset-2 focus:outline-gray-200 dark:text-gray-400 dark:hover:text-white"
                                >
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">View notifications</span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" class="size-6">
                                        <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>

                                {{-- Profile dropdown component --}}
                                <x-menu.profile-lg :links="$profileLinks" />

                            </div>
                        </div>

                        <!-- Mobile Toggle Button -->
                        <div class="-mr-2 flex items-center gap-x-2 md:hidden">
                            <!-- Mobile Theme Toggle Icon -->
                            <button 
                                type="button" 
                                @click="toggleTheme()"
                                aria-label="Toggle theme"
                                class="rounded-md p-2 text-gray-400 hover:bg-gray-200/5 hover:text-gray-500 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
                            >
                                <svg x-show="darkMode" x-cloak viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6">
                                    <path d="M12 3v2.25m0 13.5V21m8.966-8.966h-2.25M4.5 12H2.25m15.364-6.364l-1.591 1.591M6.75 17.25l-1.591 1.591m12.728 0l-1.591-1.591M6.75 6.75L5.159 5.159M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <svg x-show="!darkMode" x-cloak viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6">
                                    <path d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>

                            <button 
                                type="button" 
                                command="--toggle" 
                                commandfor="mobile-menu" 
                                class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-200/5 hover:text-gray-500 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-gray-200"
                            >
                                <span class="absolute -inset-0.5"></span>
                                <span class="sr-only">Open main menu</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                                    <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>

                    </div>

                </div>

                <!-- Mobile Menu Container -->
                <el-disclosure id="mobile-menu" hidden class="block md:hidden border-t border-gray-200/50 dark:border-gray-800">
                    
                    <!-- Mobile Search Input -->
                    <div class="px-4 pt-3 pb-1 sm:hidden">
                        <div class="relative text-gray-400">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input 
                                type="search" 
                                placeholder="Search..." 
                                class="block w-full rounded-md border-0 bg-gray-200/50 dark:bg-gray-700/50 py-1.5 pl-10 pr-3 text-sm text-gray-900 dark:text-white placeholder:text-gray-500 dark:placeholder:text-gray-400 focus:bg-white dark:focus:bg-gray-800"
                            >
                        </div>
                    </div>

                    <x-menu.sm :links="$links" />
                    <x-menu.profile-sm :links="$profileLinks" />

                </el-disclosure>
            </nav>

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