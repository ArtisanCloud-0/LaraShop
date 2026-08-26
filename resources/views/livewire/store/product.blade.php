<div>
    <div class="flex flex-col lg:flex-row gap-8 items-start">
        
        {{-- 🔍 SIDEBAR FILTER PANEL --}}
        <aside class="w-full lg:w-64 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-6 transition shadow-sm shrink-0">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-sm font-black uppercase tracking-wider text-slate-900 dark:text-white">Filters</h2>
                @if($category || !empty($productLines) || !empty($selectedSizes))
                    <button wire:click="resetFilters" class="text-xs text-orange-600 dark:text-orange-400 font-semibold hover:underline">
                        Reset All
                    </button>
                @endif
            </div>

            {{-- Dynamic Product Line Filter --}}
            <div class="mb-6">
                <h3 class="text-xs font-bold uppercase tracking-wide text-slate-400 dark:text-slate-500 mb-3">Product Line</h3>
                <div class="space-y-2">
                    @foreach($availableCategories as $cat)
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                            <input type="checkbox" wire:model.live="productLines" value="{{ $cat->slug }}" class="rounded border-slate-300 dark:border-slate-700 text-orange-600 focus:ring-orange-500 bg-slate-50 dark:bg-slate-950">
                            <span>{{ $cat->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Size Matrix Filter --}}
            <div class="border-t border-slate-100 dark:border-slate-800 pt-4">
                <h3 class="text-xs font-bold uppercase tracking-wide text-slate-400 dark:text-slate-500 mb-3">Select Size</h3>
                <div class="grid grid-cols-4 gap-2">
                    @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                        @php $isSelected = in_array($size, $selectedSizes); @endphp
                        <button 
                            type="button"
                            wire:click="toggleSize('{{ $size }}')"
                            class="py-1.5 border rounded-md text-xs font-bold transition {{ $isSelected ? 'border-orange-500 bg-orange-500 text-white' : 'border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-950 hover:border-orange-500' }}"
                        >
                            {{ $size }}
                        </button>
                    @endforeach
                </div>
            </div>
        </aside>

        {{-- 📦 MAIN CATALOG DISPLAY --}}
        <div class="flex-1 w-full">
            
            {{-- Header & Sorting Toolbar --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 mb-6 shadow-sm transition">
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-base font-black text-slate-900 dark:text-white">
                            {{ $activeCategory ? $activeCategory->name : 'All Merchandise' }}
                        </h1>
                        @if($activeCategory)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/40 dark:text-orange-300">
                                {{ $activeCategory->name }}
                                <button wire:click="$set('category', '')" class="hover:text-orange-900 dark:hover:text-white">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                    </p>
                </div>
                
                {{-- Sort Selector --}}
                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <label for="sort" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Sort By</label>
                    <select id="sort" wire:model.live="sortBy" class="text-xs font-semibold bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 rounded-md px-3 py-1.5 focus:outline-none focus:border-orange-500">
                        <option value="newest">Newest Arrivals</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                    </select>
                </div>
            </div>

            {{-- Products Grid --}}
            @if($products->isNotEmpty())
                <x-card.products :products="$products"></x-card.products>
            @else
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-bold text-slate-900 dark:text-white">No products found</h3>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Try adjusting your filters or search terms.</p>
                    <div class="mt-6">
                        <button wire:click="resetFilters" class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-semibold rounded-xl text-white bg-orange-600 hover:bg-orange-500">
                            Clear all filters
                        </button>
                    </div>
                </div>
            @endif

            {{-- Livewire Pagination --}}
            <div class="mt-8">
                {{ $products->links() }}
            </div>

        </div>

    </div>
</div>