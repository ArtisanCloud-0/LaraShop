<div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        
        {{-- 🔍 SIDEBAR FILTER PANEL --}}
        <aside class="w-full lg:w-64 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-6 transition shadow-sm shrink-0">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100 dark:border-slate-850">
                <h2 class="text-sm font-black uppercase tracking-wider text-slate-900 dark:text-white">Filters</h2>
                <button class="text-xs text-blue-600 dark:text-blue-400 hover:underline">Reset All</button>
            </div>

            {{-- Department Selector Section --}}
            <div class="mb-6">
                <h3 class="text-xs font-bold uppercase tracking-wide text-slate-400 dark:text-slate-500 mb-3">Gender & Fit</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                        <input type="checkbox" class="rounded border-slate-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 bg-slate-50 dark:bg-slate-950" checked>
                        <span>Men</span>
                    </label>
                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                        <input type="checkbox" class="rounded border-slate-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 bg-slate-50 dark:bg-slate-950" checked>
                        <span>Women</span>
                    </label>
                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                        <input type="checkbox" class="rounded border-slate-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 bg-slate-50 dark:bg-slate-950">
                        <span>Unisex</span>
                    </label>
                </div>
            </div>

            {{-- Categories Checklist Segment --}}
            <div class="mb-6 border-t border-slate-100 dark:border-slate-850 pt-4">
                <h3 class="text-xs font-bold uppercase tracking-wide text-slate-400 dark:text-slate-500 mb-3">Product Line</h3>
                <div class="space-y-2">
                    @foreach(['Apparel & Clothing', 'Luxury Watches', 'Leather Accessories', 'Eyewear'] as $cat)
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                            <input type="checkbox" class="rounded border-slate-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 bg-slate-50 dark:bg-slate-950">
                            <span>{{ $cat }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Standard Retail Size Matrix --}}
            <div class="border-t border-slate-100 dark:border-slate-850 pt-4">
                <h3 class="text-xs font-bold uppercase tracking-wide text-slate-400 dark:text-slate-500 mb-3">Select Size</h3>
                <div class="grid grid-cols-4 gap-2">
                    @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                        <button class="py-1.5 border border-slate-200 dark:border-slate-800 rounded-md text-xs font-bold text-slate-700 dark:text-slate-300 hover:border-blue-600 dark:hover:border-blue-400 bg-slate-50 dark:bg-slate-950 transition">
                            {{ $size }}
                        </button>
                    @endforeach
                </div>
            </div>
        </aside>

        {{-- 📦 MAIN MAIN SHOWCASE CATALOG CONTAINER --}}
        <div class="flex-1 w-full">
            
            {{-- Context Header Registry Settings Toolbar --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 mb-6 shadow-sm transition">
                <div>
                    <h1 class="text-base font-black text-slate-900 dark:text-white">All Merchandise</h1>
                    <p class="text-xs text-slate-400 mt-0.5">Showing 1 - 12 of 48 premium products</p>
                </div>
                
                <!-- Sorting & View Engine Trigger selectors -->
                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <label for="sort" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Sort By</label>
                    <select id="sort" class="text-xs font-semibold bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 rounded-md px-3 py-1.5 focus:outline-none focus:border-blue-500">
                        <option>Newest Arrivals</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Most Popular</option>
                    </select>
                </div>
            </div>

            {{-- Product Items Display Grid Frame --}}
            <x-card.products :products="$products"></x-card.products>

            <!-- Simple UI Pagination Blueprint Layer -->
            <div class="mt-10 flex items-center justify-between border-t border-slate-200 dark:border-slate-800 pt-6">
                <button class="px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-xs font-bold bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-950 transition text-slate-600 dark:text-slate-400">Previous</button>
                <div class="flex items-center gap-1 text-xs font-bold text-slate-700 dark:text-slate-300">
                    <span class="px-3 py-1.5 bg-blue-600 text-white rounded-md">1</span>
                    <span class="px-3 py-1.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md cursor-pointer">2</span>
                    <span class="px-3 py-1.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md cursor-pointer">3</span>
                </div>
                <button class="px-4 py-2 border border-slate-200 dark:border-slate-800 rounded-lg text-xs font-bold bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-950 transition text-slate-600 dark:text-slate-400">Next</button>
            </div>

        </div>

    </div>

</div>
