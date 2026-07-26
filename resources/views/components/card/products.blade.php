<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @foreach ($products as $index => $product)
            
                @php
                    // Get default/first variant price or formatted fallback price
                    $firstVariant = $product->productDetails->first();
                    $formattedPrice = $firstVariant ? number_format($firstVariant->price, 2) : '0.00';
                @endphp

                <div 
                    x-data="{ showVariants: false, selectedVariantId: '{{ $firstVariant?->id }}' }"
                    @mouseleave="showVariants = false"
                    class="group relative flex flex-col justify-between p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl transition hover:shadow-md"
                >
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

                        <!-- Variant Selection Popover -->
                        <div 
                            x-show="showVariants"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute inset-0 bg-slate-50 dark:bg-slate-950/80 backdrop-blur-xs p-3 flex flex-col justify-between z-10"
                            style="display: none;"
                        >
                            <div class="flex items-center justify-between border-b border-slate-700/50 pb-2">
                                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-600 dark:text-slate-300">Select Variant</span>
                                <button @click="showVariants = false" type="button" class="text-slate-400 hover:text-white text-xs">✕</button>
                            </div>

                            <!-- Options list -->
                            <div class="space-y-1.5 my-auto max-h-36 overflow-y-auto pr-1">

                                @foreach($product->productDetails as $variant)
                                
                                    @php
                                        $label = is_array($variant->options) 
                                            ? implode(' / ', $variant->options) 
                                            : ($variant->code ?? 'Option');
                                    @endphp
                                
                                    <button 
                                        type="button"
                                        @click="selectedVariantId = '{{ $variant->id }}'"
                                        :class="selectedVariantId == '{{ $variant->id }}' ? 'bg-blue-600 text-white border-blue-500' : 'bg-slate-100 dark:bg-slate-900/80 text-slate-600 dark:text-slate-300 border-slate-300 dark:border-slate-700 hover:border-slate-500'"
                                        class="w-full text-left px-2.5 py-1.5 rounded-md border text-xs font-mono flex items-center justify-between transition"
                                    >
                                        <span class="truncate">{{ $label }}</span>
                                        <span class="font-bold ml-2">${{ number_format($variant->price, 2) }}</span>
                                    </button>

                                @endforeach
                            </div>

                            <!-- Confirm button -->
                            <button 
                                type="button"
                                @click="$wire.addToCart(selectedVariantId); showVariants = false"
                                :disabled="!selectedVariantId"
                                class="w-full py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded-md text-xs font-bold uppercase tracking-wider transition disabled:opacity-50"
                            >
                                Confirm Add
                            </button>
                        </div>

                        <!-- Hover Action Quick View Trigger Layer -->
                        <div x-show="!showVariants" class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition duration-200 flex items-center justify-center">
                            <a href="#" class="p-2.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg shadow transition" title="Quick Product Preview">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Meta details -->
                    <div class="mt-4 flex-1">
                        <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">{{ $product->category->name }}</span>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-slate-100 mt-0.5 line-clamp-1"><a href="{{ route('product.details', $product->slug) }}">{{ $product->name }}</a></h4>
                    </div>

                    <!-- CTA Actions Footer Layer -->
                    <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100 dark:border-slate-850">
                        <span class="text-sm font-black text-slate-900 dark:text-white">${{ $formattedPrice }}</span>

                        <!-- Reactive Trigger -->
                        <button 
                            type="button"
                            @click="showVariants = !showVariants"
                            class="inline-flex items-center gap-x-1.5 px-3 py-1.5 bg-slate-800 hover:bg-blue-500 dark:bg-slate-800 dark:hover:bg-blue-600 text-white rounded-md text-xs font-semibold shadow-sm transition"
                        >
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Add to Bag</span>
                        </button>
                    </div>
                </div>
            @endforeach
            
        </div>