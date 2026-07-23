<div>
    
    @dd($products)

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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($products as $product)
                    <div class="group relative flex flex-col justify-between p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl transition hover:shadow-md">
                        
                        {{-- Thumbnail Media Box Workspace --}}
                        <div class="relative aspect-square w-full rounded-lg bg-slate-100 dark:bg-slate-950 flex items-center justify-center font-mono text-[10px] text-slate-400 uppercase tracking-widest overflow-hidden border border-slate-200 dark:border-slate-850">
                            
                            @if($product->primary_image)
                                <img 
                                    src="{{ Storage::url($product->primary_image) }}" 
                                    alt="{{ $product->name }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                />
                            @else
                                {{-- Fallback if no image is uploaded --}}
                                <div class="flex flex-col items-center justify-center p-4 text-center font-mono text-[10px] text-slate-400 dark:text-slate-600 uppercase tracking-widest">
                                    <svg class="w-6 h-6 mb-1 text-slate-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0z" />
                                    </svg>
                                    <span>No Image</span>
                                </div>
                            @endif
                            
                            {{-- Hover Action Quick View Trigger via Eye SVG --}}
                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition duration-200 flex items-center justify-center">
                                <a href="#" class="p-2.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg shadow transition" title="Quick View Product">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Meta specifications naming mappings --}}
                        <div class="mt-4 flex-1">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">{{ $product->category->name }}</span>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-slate-100 mt-0.5 line-clamp-1">{{ $product->name }}</h4>
                        </div>

                        {{-- CTA Purchase Interface Row using Plus SVG --}}
                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100 dark:border-slate-850">
                            <span class="text-sm font-black text-slate-900 dark:text-white">{{ $product->formatted_price }}</span>
                            
                            <button 
                            wire:click="addToCart({{ $product->id }})" 
                            wire:loading.attr="disabled"
                            wire:target="addToCart({{ $product->id }})"
                            class="inline-flex items-center gap-x-1.5 px-3 py-1.5 bg-slate-900 hover:bg-blue-600 dark:bg-slate-800 dark:hover:bg-blue-600 text-white rounded-md text-xs font-semibold shadow-sm transition disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {{-- Default Icon (hidden while loading) --}}
                                <svg wire:loading.remove wire:target="addToCart({{ $product->id }})" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>

                                {{-- Loading Spinner (shown only while loading) --}}
                                <svg wire:loading wire:target="addToCart({{ $product->id }})" class="animate-spin w-3 h-3 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>

                                <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Bag</span>
                                <span wire:loading wire:target="addToCart({{ $product->id }})">Adding...</span>
                            
                            </button>

                        </div>
                        
                    </div>
                @endforeach
            </div>

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
