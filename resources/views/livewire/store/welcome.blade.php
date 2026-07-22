<div>
    
    <!-- 🌟 HERO MARKETING ARRIVALS BANNER -->
    <div class="relative overflow-hidden rounded-2xl bg-white border border-slate-200 dark:bg-slate-900 dark:border-slate-800 transition-colors duration-200 mb-12 shadow-sm">
        <div class="px-6 py-12 sm:px-12 sm:py-20 max-w-2xl relative z-10">
            <span class="text-xs font-bold tracking-widest uppercase text-blue-600 dark:text-blue-400">New Season Collection 2026</span>
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-slate-900 dark:text-white mt-3 leading-tight">
                Refined Styles. <br class="hidden sm:block"/>Made to Wear.
            </h1>
            <p class="mt-4 text-sm sm:text-base text-slate-500 dark:text-slate-400 leading-relaxed">
                Discover a curated collection of modern essentials designed for men and women. From precision-crafted watches to classic everyday wardrobe layers, explore pieces engineered to last.
            </p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="#catalog" class="px-5 py-3 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-sm transition">
                    Shop The Collection
                </a>
                <a href="/about" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold uppercase tracking-wider rounded-lg transition">
                    Learn Our Story
                </a>
            </div>
        </div>
        <!-- Elegant Visual Background Accents -->
        <div class="absolute right-0 bottom-0 top-0 w-1/2 bg-gradient-to-l from-blue-500/5 dark:from-blue-500/10 to-transparent pointer-events-none hidden md:block"></div>
    </div>

    <!-- 🗂️ DEPARTMENTS & LIFESTYLE CATEGORIES QUICK-SELECTOR -->
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Browse Departments</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @php
                $departments = [
                    'Men\'s Apparel' => '34 Items',
                    'Women\'s Apparel' => '42 Items',
                    'Luxury Watches' => '18 Items',
                    'Fine Accessories' => '25 Items'
                ];
            @endphp
            @foreach($departments as $name => $count)
                <a href="#" class="group p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl transition hover:border-blue-500 dark:hover:border-blue-400 flex flex-col justify-between h-24 shadow-sm">
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        {{ $name }}
                    </span>
                    <span class="text-[10px] self-start font-mono font-bold bg-slate-50 dark:bg-slate-950 px-2 py-0.5 border border-slate-200 dark:border-slate-800 rounded-md text-slate-400">
                        {{ $count }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- 📦 PRIMARY PRODUCT SHOWCASE GRID -->
    <div id="catalog" class="scroll-mt-20">
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-200 dark:border-slate-800">
            <div>
                <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">Featured Trends & Essentials</h3>
                <p class="text-xs text-slate-400 mt-0.5">Select a variant size or color right from the product layout card.</p>
            </div>
            
            <!-- Structural Counter Anchor using Eye SVG -->
            <span class="inline-flex items-center gap-x-1.5 text-xs text-slate-400 font-medium">
                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Showing 8 New Styles
            </span>
        </div>

        <!-- Product Cards Grid Loop Layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            @foreach ($products as $index => $product)
                <div class="group relative flex flex-col justify-between p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl transition hover:shadow-md">
    
                    <!-- Thumbnail Media Container -->
                    <div class="relative aspect-square w-full rounded-lg bg-slate-100 dark:bg-slate-950 flex items-center justify-center overflow-hidden border border-slate-200 dark:border-slate-850">
                        
                        @if($product->primary_image)
                            <img 
                                src="{{ Storage::url($product->primary_image) }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            />
                        @else
                            <!-- Fallback if no image is uploaded -->
                            <div class="flex flex-col items-center justify-center p-4 text-center font-mono text-[10px] text-slate-400 dark:text-slate-600 uppercase tracking-widest">
                                <svg class="w-6 h-6 mb-1 text-slate-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0z" />
                                </svg>
                                <span>No Image</span>
                            </div>
                        @endif
                        
                        <!-- Hover Action Quick View Trigger Layer -->
                        <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition duration-200 flex items-center justify-center">
                            <a href="#" class="p-2.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg shadow transition" title="Quick Product Preview">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Meta details mapping matching luxury retail specifications -->
                    <div class="mt-4 flex-1">
                        <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">{{ $product->category->name }}</span>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-slate-100 mt-0.5 line-clamp-1">{{ $product->name }}</h4>
                    </div>

                    <!-- CTA Actions Footer Layer -->
                    <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100 dark:border-slate-850">
                        {{-- <span class="text-sm font-black text-slate-900 dark:text-white">${{ number_format($product->productDetails->price, 2) }}</span> --}}
                        <span class="text-sm font-black text-slate-900 dark:text-white">$80</span>
                        
                        <!-- Reactive Add to Bag Trigger via Plus SVG -->
                        <button 
                            wire:click="addToCart({{ $product->id }})" 
                            wire:loading.attr="disabled"
                            wire:target="addToCart({{ $product->id }})"
                            class="inline-flex items-center gap-x-1.5 px-3 py-1.5 bg-slate-900 hover:bg-blue-600 dark:bg-slate-800 dark:hover:bg-blue-600 text-white rounded-md text-xs font-semibold shadow-sm transition disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <!-- Default Icon (hidden while loading) -->
                            <svg wire:loading.remove wire:target="addToCart({{ $product->id }})" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>

                            <!-- Loading Spinner (shown only while loading) -->
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
    </div>

</div>
