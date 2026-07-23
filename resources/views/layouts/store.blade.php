<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $title ?? 'LaraShop Marketplace' }}</title>
	
	{{-- Tailwind css Fonts & Styles --}}
	@vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [wire\:cloak], [x-cloak] { display: none !important; }
    </style>
	
    {{-- Prevent Theme Flashing --}}
	<script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

</head>
<body class="h-full bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-50 font-sans antialiased transition-colors duration-100">

	<div class="flex flex-col min-h-full">
		
		{{-- Navbar --}}
		<nav class="sticky top-0 z-40 w-full border-b border-slate-200 bg-white/50 backdrop-blur dark:border-slate-800 dark:bg-slate-900/80">
			
            <div class="container mx-auto flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                
                {{-- Logo & Links --}}
                <div class="flex items-center gap-8">

                    <a href="/" class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                        LaraShop<span class="text-blue-600">.</span>
                    </a>

                    <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600 dark:text-slate-300">
                        <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Shop</a>
                        <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Categories</a>
                        <a href="/about" class="hover:text-blue-600 dark:hover:text-blue-400">About</a>
                    </div>

                </div>

                {{-- Actions (Theme Toggle & Cart) --}}
                <div class="flex items-center gap-4">

                    {{-- Theme Toggle Button --}}
                    <button id="theme-toggle" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 focus:outline-none">
                        
                        {{-- Sun Icon (Visible in Dark Mode) --}}
                        <svg id="theme-toggle-sun" class="hidden h-5 w-5 text-yellow-300/90" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21M5.146 5.146l1.591 1.591m9.082 9.082l1.591 1.591M3 12h2.25m13.5 0H21M5.146 18.854l1.591-1.591m9.082-9.082l1.591-1.591M12 6.75a5.25 5.25 0 100 10.5 5.25 5.25 0 000-10.5z" />
                        </svg>
                        
                        {{-- Moon Icon (Visible in Light Mode) --}}
                        <svg id="theme-toggle-moon" class="h-5 w-5 dark:hidden" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                        </svg>

                    </button>

                    {{-- Cart Summary Link --}}
                    <livewire:store.navigation.cart-counter />
                    
                </div>

            </div>


		</nav>

		{{-- Main Content --}}
		<main class="flex-1 container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <x-message.session></x-message.session>
			{{ $slot }}
		</main>

		{{-- Footer --}}
		<footer class="border-t border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
			<div class="container mx-auto px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">
				&copy; {{ (date('Y')) }} LaraShop. All rights reserved.
			</div>
		</footer>

	</div>

</body>
</html>
