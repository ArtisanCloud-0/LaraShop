<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? "LaraShop Marketplace" }}</title>

    {{-- Tailwind CSS & Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
      [wire\:cloak],
      [x-cloak] {
        display: none !important;
      }
    </style>

    {{-- Prevent Theme Flashing --}}
    <script>
      if (
        localStorage.getItem("theme") === "dark" ||
        (!("theme" in localStorage) &&
          window.matchMedia("(prefers-color-scheme: dark)").matches)
      ) {
        document.documentElement.classList.add("dark");
      } else {
        document.documentElement.classList.remove("dark");
      }
    </script>
  </head>
  <body
    class="h-full bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-50 font-sans antialiased transition-colors duration-100"
  >
    @php
        // Fetch top-level visible categories with their child subcategories
        $navCategories = \App\Models\Category::query()
            ->whereNull('parent_id')
            ->where('is_visible', true)
            ->with(['children' => fn($q) => $q->where('is_visible', true)])
            ->get();
    @endphp

    <div class="flex flex-col min-h-full" x-data="{ mobileMenuOpen: false }">
      {{-- Navbar --}}
      <nav
        class="sticky top-0 z-40 w-full border-b border-slate-200 bg-white/80 backdrop-blur dark:border-slate-800 dark:bg-slate-900/80"
      >
        <div
          class="container mx-auto flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8"
        >
          {{-- Logo & Desktop Links --}}
          <div class="flex items-center gap-8">
            <a
              href="/"
              class="flex items-center gap-2.5 text-lg font-bold tracking-tight text-white"
            >
              <x-logo class="h-8 w-auto" />
              <span class="text-slate-800 dark:text-slate-100"
                >LaraShop<span class="text-orange-500">.</span></span
              >
            </a>

            <div
              class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600 dark:text-slate-300"
            >
              <a
                href="{{ route('products') }}"
                class="hover:text-orange-500 dark:hover:text-orange-300 {{ request()->routeIs('products') ? 'text-orange-500 dark:text-orange-300' : '' }}"
              >
                Shop
              </a>

              {{-- Categories Nested Dropdown (Desktop) --}}
              <div
                class="relative py-4"
                x-data="{ open: false, timeout: null }"
                @mouseleave="timeout = setTimeout(() => open = false, 150)"
                @mouseenter="clearTimeout(timeout)"
              >
                <button
                  @mouseenter="open = true"
                  @click="open = !open"
                  type="button"
                  class="inline-flex items-center gap-1 hover:text-orange-500 dark:hover:text-orange-300 focus:outline-none"
                >
                  <span>Categories</span>
                  <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>

                <div
                  x-show="open"
                  x-cloak
                  x-transition:enter="transition ease-out duration-150"
                  x-transition:enter-start="opacity-0 scale-95"
                  x-transition:enter-end="opacity-100 scale-100"
                  x-transition:leave="transition ease-in duration-100"
                  x-transition:leave-start="opacity-100 scale-100"
                  x-transition:leave-end="opacity-0 scale-95"
                  class="absolute left-0 top-full mt-0 w-56 rounded-xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-800 dark:bg-slate-900 z-50 divide-y divide-slate-100 dark:divide-slate-800/60"
                >
                  @forelse($navCategories as $category)
                    <div
                      class="relative group"
                      x-data="{ subOpen: false, subTimeout: null }"
                      @mouseleave="subTimeout = setTimeout(() => subOpen = false, 150)"
                      @mouseenter="clearTimeout(subTimeout)"
                    >
                      <a
                        href="{{ route('products', ['category' => $category->slug]) }}"
                        @mouseenter="subOpen = true"
                        class="flex items-center justify-between rounded-lg px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-orange-50 hover:text-orange-600 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-orange-400"
                      >
                        <span>{{ $category->name }}</span>
                        @if($category->children->isNotEmpty())
                          <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                          </svg>
                        @endif
                      </a>

                      {{-- Subcategories Side Dropdown --}}
                      @if($category->children->isNotEmpty())
                        <div
                          x-show="subOpen"
                          x-cloak
                          x-transition
                          class="absolute left-full top-0 ml-1 w-48 rounded-xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-800 dark:bg-slate-900"
                        >
                          @foreach($category->children as $sub)
                            <a
                              href="{{ route('products', ['category' => $sub->slug]) }}"
                              class="block rounded-lg px-3 py-1.5 text-xs text-slate-600 hover:bg-orange-50 hover:text-orange-600 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-orange-400"
                            >
                              {{ $sub->name }}
                            </a>
                          @endforeach
                        </div>
                      @endif
                    </div>
                  @empty
                    <span class="block px-3 py-2 text-xs text-slate-400">No categories found</span>
                  @endforelse
                </div>
              </div>

              <a
                href="{{ route('about') }}"
                class="hover:text-orange-500 dark:hover:text-orange-300 {{ request()->routeIs('about') ? 'text-orange-500 dark:text-orange-300' : '' }}"
                >About</a
              >
            </div>
          </div>

          {{-- Actions (Theme, Cart, Auth & Hamburger) --}}
          <div class="flex items-center gap-3 sm:gap-4">
            {{-- Theme Toggle Button --}}
            <button
              id="theme-toggle"
              class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 focus:outline-none"
            >
              <svg id="theme-toggle-sun" class="hidden h-5 w-5 text-yellow-300/90" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21M5.146 5.146l1.591 1.591m9.082 9.082l1.591 1.591M3 12h2.25m13.5 0H21M5.146 18.854l1.591-1.591m9.082-9.082l1.591-1.591M12 6.75a5.25 5.25 0 100 10.5 5.25 5.25 0 000-10.5z" />
              </svg>
              <svg id="theme-toggle-moon" class="h-5 w-5 dark:hidden" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
              </svg>
            </button>

            {{-- Cart Counter Component --}}
            <livewire:store.navigation.cart-counter />

            {{-- Desktop Auth Links / Profile Dropdown --}}
            <div class="hidden md:flex items-center gap-4 text-sm font-medium">
              @guest
                <a href="{{ route('login') }}" class="text-slate-600 hover:text-orange-500 dark:text-slate-300 dark:hover:text-orange-300 {{ request()->routeIs('login') ? 'text-orange-500 dark:text-orange-300' : '' }}">Sign in</a>
                <a href="{{ route('register') }}" class="rounded-xl bg-orange-600 px-3.5 py-1.5 text-xs font-semibold text-white shadow-md hover:bg-orange-500">Sign up</a>
              @else
                <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false">
                  <button
                    @click="userMenuOpen = !userMenuOpen"
                    type="button"
                    class="flex items-center gap-2 rounded-full border border-slate-300 bg-slate-100 p-1 dark:border-slate-700 dark:bg-slate-800 focus:outline-none"
                  >
                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-500 text-xs font-bold text-white">
                      {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="text-xs font-semibold text-slate-700 dark:text-slate-200 pr-1">{{ auth()->user()->name }}</span>
                    <svg class="w-3.5 h-3.5 text-slate-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                  </button>

                  <div
                    x-show="userMenuOpen"
                    x-cloak
                    x-transition
                    class="absolute right-0 mt-2 w-48 rounded-xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-800 dark:bg-slate-900 z-50"
                  >
                    @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                      <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-orange-50 hover:text-orange-600 dark:text-slate-200 dark:hover:bg-slate-800">
                        Admin Dashboard
                      </a>
                    @endif
                    <a href="#" class="block rounded-lg px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-orange-50 hover:text-orange-600 dark:text-slate-200 dark:hover:bg-slate-800">
                      My Orders
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="w-full text-left rounded-lg px-3 py-2 text-xs font-semibold text-red-500 hover:bg-red-50 dark:hover:bg-red-950/40">
                        Sign Out
                      </button>
                    </form>
                  </div>
                </div>
              @endguest
            </div>

            {{-- Mobile Menu Trigger Button --}}
            <button
              @click="mobileMenuOpen = !mobileMenuOpen"
              type="button"
              class="inline-flex md:hidden rounded-lg p-2 text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800 focus:outline-none"
            >
              <svg class="h-6 w-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <svg class="h-6 w-6" x-show="mobileMenuOpen" x-cloak fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        {{-- Mobile Drawer Menu --}}
        <div
          x-show="mobileMenuOpen"
          x-cloak
          x-transition
          class="md:hidden border-b border-slate-200 bg-white px-4 pt-2 pb-6 dark:border-slate-800 dark:bg-slate-900"
        >
          <div class="space-y-3 text-sm font-medium">
            <a href="{{ route('products') }}" class="block py-1.5 text-slate-700 dark:text-slate-200 hover:text-orange-500">Shop</a>

            {{-- Mobile Accordion for Categories --}}
            <div x-data="{ mobileCatOpen: false }">
              <button
                @click="mobileCatOpen = !mobileCatOpen"
                class="flex w-full items-center justify-between py-1.5 text-slate-700 dark:text-slate-200 hover:text-orange-500"
              >
                <span>Categories</span>
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': mobileCatOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>

              <div x-show="mobileCatOpen" x-cloak class="pl-4 space-y-2 pt-2 border-l-2 border-slate-200 dark:border-slate-800">
                @foreach($navCategories as $category)
                  <div x-data="{ mobileSubOpen: false }">
                    <div class="flex items-center justify-between py-1">
                      <a href="{{ route('products', ['category' => $category->slug]) }}" class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                        {{ $category->name }}
                      </a>
                      @if($category->children->isNotEmpty())
                        <button @click="mobileSubOpen = !mobileSubOpen" class="text-slate-400 p-1">
                          <svg class="w-3.5 h-3.5" :class="{ 'rotate-180': mobileSubOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                          </svg>
                        </button>
                      @endif
                    </div>
                    @if($category->children->isNotEmpty())
                      <div x-show="mobileSubOpen" x-cloak class="pl-3 space-y-1.5 py-1">
                        @foreach($category->children as $sub)
                          <a href="{{ route('products', ['category' => $sub->slug]) }}" class="block text-[11px] text-slate-500 dark:text-slate-400">
                            {{ $sub->name }}
                          </a>
                        @endforeach
                      </div>
                    @endif
                  </div>
                @endforeach
              </div>
            </div>

            <a href="{{ route('about') }}" class="block py-1.5 text-slate-700 dark:text-slate-200 hover:text-orange-500 {{ request()->routeIs('about') ? 'text-orange-500 dark:text-orange-300' : '' }}">About</a>

            {{-- Mobile User Authentication Links --}}
            <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
              @guest
                <div class="flex flex-col gap-2">
                  <a href="{{ route('login') }}" class="block text-center rounded-xl border border-slate-300 dark:border-slate-700 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200">Sign in</a>
                  <a href="{{ route('register') }}" class="block text-center rounded-xl bg-orange-600 py-2 text-xs font-semibold text-white">Sign up</a>
                </div>
              @else
                <div class="space-y-2">
                  <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Account ({{ auth()->user()->name }})</p>
                  @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                    <a href="{{ route('dashboard') }}" class="block text-xs text-slate-700 dark:text-slate-200">Admin Dashboard</a>
                  @endif
                  <a href="#" class="block text-xs text-slate-700 dark:text-slate-200">My Orders</a>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left text-xs font-semibold text-red-500 pt-1">Sign Out</button>
                  </form>
                </div>
              @endguest
            </div>
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
          &copy; {{ date("Y") }} LaraShop. All rights reserved.
        </div>
      </footer>
    </div>
    
    <x-message.toast />

  </body>
</html>