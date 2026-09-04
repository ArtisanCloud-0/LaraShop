<div>
    @if($isMobile)
        {{-- Mobile Navigation Auth Block --}}
        <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
            @guest
                <div class="flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="block text-center rounded-xl border border-slate-300 dark:border-slate-700 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200">Sign in</a>
                    <a href="{{ route('register') }}" class="block text-center rounded-xl bg-orange-600 py-2 text-xs font-semibold text-white">Sign up</a>
                </div>
            @else
                <div class="space-y-2">
                    <div class="flex items-center gap-2.5 pb-2">
                        @if($user->image)
                            <img src="{{ Storage::url($user->image) }}" alt="{{ $user->name }}" class="h-8 w-8 rounded-full object-cover border border-slate-200 dark:border-slate-700" />
                        @else
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-500 text-xs font-bold text-white shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="text-xs font-bold text-slate-800 dark:text-slate-100">{{ $user->name }}</p>
                            <p class="text-[10px] text-slate-400">{{ $user->email }}</p>
                        </div>
                    </div>

                    @if($user->isAdmin() || $user->isSuperAdmin())
                        <a href="{{ route('dashboard') }}" class="block text-xs text-slate-700 dark:text-slate-200">Admin Dashboard</a>
                    @endif
                    <a href="{{ route('customer.profile') }}" class="block text-xs text-slate-700 dark:text-slate-200 hover:text-orange-500">My Profile</a>
                    <a href="{{ route('show.orders') }}" class="block text-xs text-slate-700 dark:text-slate-200 hover:text-orange-500 hover:dark:text-orange-300">My Orders</a>
                    <a href="{{ route('logout') }}" class="block text-xs text-rose-500 hover:text-rose-600">Sign Out</a>
                </div>
            @endguest
        </div>
    @else
        {{-- Desktop Pill Dropdown Menu --}}
        <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false">
            @guest
                <div class="flex items-center gap-4 text-sm font-medium">
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-orange-500 dark:text-slate-300 dark:hover:text-orange-300 {{ request()->routeIs('login') ? 'text-orange-500 dark:text-orange-300' : '' }}">Sign in</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-orange-600 px-3.5 py-1.5 text-xs font-semibold text-white shadow-md hover:bg-orange-500">Sign up</a>
                </div>
            @else
                {{-- User Trigger Button (Pill Layout) --}}
                <button
                    @click="userMenuOpen = !userMenuOpen"
                    type="button"
                    class="flex items-center gap-2 rounded-full border border-slate-300 bg-slate-100 p-1 dark:border-slate-700 dark:bg-slate-800 focus:outline-none transition hover:border-slate-400 dark:hover:border-slate-600"
                >
                    @if($user->image)
                        <img 
                            src="{{ Storage::url($user->image) }}" 
                            alt="{{ $user->name }}" 
                            class="h-7 w-7 rounded-full object-cover border border-slate-200 dark:border-slate-700"
                        />
                    @else
                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-500 text-xs font-bold text-white shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="text-xs font-semibold text-slate-700 dark:text-slate-200 pr-1">{{ $user->name }}</span>
                    <svg class="w-3.5 h-3.5 text-slate-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Dropdown Body --}}
                <div
                    x-show="userMenuOpen"
                    x-cloak
                    x-transition
                    class="absolute right-0 mt-2 w-48 rounded-xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-800 dark:bg-slate-900 z-50 divide-y divide-slate-100 dark:divide-slate-800/60"
                >
                    <div class="py-1">
                        @if($user->isAdmin() || $user->isSuperAdmin())
                            <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-orange-50 hover:text-orange-600 dark:text-slate-200 dark:hover:bg-slate-800">
                                Admin Dashboard
                            </a>
                        @endif
                        <a href="{{ route('customer.profile') }}" class="block rounded-lg px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-orange-50 hover:text-orange-500 dark:text-slate-200 dark:hover:bg-slate-800">
                            My Profile
                        </a>
                        <a href="{{ route('show.orders') }}" class="block rounded-lg px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-orange-50 hover:text-orange-500 dark:text-slate-200 dark:hover:bg-slate-800">
                            My Orders
                        </a>
                    </div>
                    <div class="pt-1">
                        <a href="{{ route('logout') }}" class="block w-full text-left rounded-lg px-3 py-2 text-xs font-semibold text-red-500 hover:bg-red-50 dark:hover:bg-red-950/40">
                            Sign Out
                        </a>
                    </div>
                </div>
            @endguest
        </div>
    @endif
</div>