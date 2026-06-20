@php
    $links = [
        ['name' => 'Dasboard',   'route' => 'panel',            'pattern' => ['panel']],
        ['name' => 'Categories', 'route' => 'panel.categories', 'pattern' => ['panel.categories*']],
        ['name' => 'Products',   'route' => 'panel.products',   'pattern' => ['panel.products*']],
        ['name' => 'orders',     'route' => 'panel.orders',     'pattern' => ['panel.orders*']],
        ['name' => 'Reports',    'route' => 'panel.reports',    'pattern' => ['panel.reports*']],
    ];

    $profileLinks = [
        ['name' => 'Your Profile'],
        ['name' => 'Setting'],
        ['name' => 'Sign out'],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100 dark:bg-gray-900">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Panel: {{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="h-full">

        <div class="min-h-full">

            <nav class="bg-gray-50 dark:bg-gray-800/50">

                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                    <div class="flex h-16 items-center justify-between">

                        <div class="flex items-center">

                            <div class="shrink-0">
                                <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" class="size-8" />
                            </div>

                            <x-menu.lg :links="$links"></x-menu.lg>

                        </div>

                        <div class="hidden md:block">

                            <div class="ml-4 flex items-center md:ml-6">

                                <button 
                                    type="button" 
                                    class="
                                        relative
                                        rounded-full
                                        p-1
                                        text-gray-400
                                        hover:text-gray-500
                                        focus:outline-2
                                        focus:outline-offset-2
                                        focus:outline-gray-200
                                        dark:text-gray-400 
                                        dark:hover:text-white
                                    "
                                >
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">View notifications</span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                                        <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>

                                {{-- Profile dropdown --}}
                                <x-menu.profile-lg :links="$profileLinks"></x-menu.profile-lg>

                            </div>
                        </div>

                        <div class="-mr-2 flex md:hidden">

                            {{-- Mobile menu button --}}
                            <button 
                                type="button" 
                                command="--toggle" 
                                commandfor="mobile-menu" 
                                class="
                                    relative 
                                    inline-flex 
                                    items-center 
                                    justify-center 
                                    rounded-md 
                                    p-2 
                                    text-gray-400 
                                    hover:bg-gray-200/5 
                                    hover:text-gray-500
                                    dark:text-gray-400 
                                    dark:hover:bg-white/5 
                                    dark:hover:text-white 
                                    focus:outline-2 
                                    focus:outline-offset-2 
                                    focus:outline-gray-200
                                "
                            >
                                <span class="absolute -inset-0.5"></span>
                                <span class="sr-only">Open main menu</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                                    <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>

                    </div>

                </div>

                <el-disclosure id="mobile-menu" hidden class="block md:hidden">
                    
                    <x-menu.sm :links="$links"></x-menu.sm>

                    <x-menu.profile-sm :links="$profileLinks"></x-menu.profile-sm>

                </el-disclosure>
            </nav>

            <header class="relative bg-white shadow-sm dark:bg-gray-800 dark:shadow-none dark:after:pointer-events-none dark:after:absolute dark:after:inset-x-0 dark:after:inset-y-0 dark:after:border-y dark:after:border-white/10">
                
                <div class="mx-auto max-w-7xl px-6 py-5 sm:px-4 lg:px-8">
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
    </body>
</html>
