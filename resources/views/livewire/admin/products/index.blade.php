<div>
    
    <div class="my-8 mx-auto max-w-7xl p-6 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-xl transition-colors duration-200">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 mb-6 border-b border-gray-200 dark:border-slate-800 gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100">Product Inventory Management</h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Review active catalog products, stock metrics, and dynamic variant rules.</p>
            </div>
            <div>
                <a href="{{ route('panel.products.upsert') }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-lg shadow transition-all">
                    + Register New Product
                </a>
            </div>
        </div>

        <x-message.session></x-message>

        @error('delete_failure')
            <div class="mb-6 p-4 bg-red-100 dark:bg-red-950/40 border border-red-300 dark:border-red-900 text-red-800 dark:text-red-400 text-sm rounded-lg">
                {{ $message }}
            </div>
        @enderror

        <div class="overflow-x-auto border border-gray-200 dark:border-slate-800 rounded-lg bg-white dark:bg-slate-950">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-slate-900 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400 border-b border-gray-200 dark:border-slate-800">
                        <th class="px-6 py-4">Item Details</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Visibility</th>
                        <th class="px-6 py-4">Registered SKU Variants Matrix</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-slate-800 text-gray-700 dark:text-slate-300">
                    @forelse($products as $product)
                        <tr wire:key="product-row-{{ $product->id }}" class="hover:bg-gray-50/50 dark:hover:bg-slate-900/40 transition-colors">
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-x-4">
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-slate-900 border border-gray-200 dark:border-slate-800 overflow-hidden shrink-0">
                                        @if(!empty($product->images) && isset($product->images[0]))
                                            <img src="{{ asset('storage/' . $product->images[0]) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[10px] uppercase font-bold text-gray-400">No Img</div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-slate-100">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-400 font-mono mt-0.5">{{ $product->slug }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-slate-900 text-gray-800 dark:text-slate-300 border border-gray-200 dark:border-slate-800">
                                    {{ $product->category->name }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->is_visible)
                                    <span class="inline-flex items-center gap-x-1.5 text-xs font-semibold text-green-600 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Live On Store
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-x-1.5 text-xs font-semibold text-gray-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Hidden Draft
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2 max-w-md">
                                    @if(count($product->productDetails) > 0)
                                        <a 
                                            href="{{ route('panel.products.skus', $product->id) }}"
                                            class="p-2 rounded-md leading-relaxed transition-colors border border-slate-300 hover:border-slate-800 dark:hover:border-slate-100 bg-slate-200/50 text-slate-800 hover:bg-slate-950 hover:text-slate-200 hover:border-slate-800 bg-slate-200 text-slate-800 hover:bg-slate-950 hover:text-slate-200"
                                            title="Edit Variants" 
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                    @endif

                                    @forelse($product->productDetails as $sku)
                                        <div class="pt-2 px-2 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-md text-xs font-mono text-gray-600 dark:text-slate-400 leading-relaxed" 
                                             title="Stock Level: {{ $sku->stock }}">
                                            <span class="font-semibold text-gray-900 dark:text-slate-200">{{ $sku->code }}</span> 
                                            <span class="text-indigo-500 dark:text-indigo-400 ml-1">${{ $sku->price }}</span>
                                            <span class="text-gray-400 dark:text-slate-600 mx-0.5">({{ $sku->stock }})</span>
                                        </div>
                                    @empty
                                        <span class="text-xs text-amber-500 italic p-2">No variants mapped yet</span>

                                        <a 
                                            href="{{ route('panel.products.skus', $product->id) }}"
                                            title="Add Variants"
                                            class="p-2 rounded-md leading-relaxed transition-colors border border-slate-300 hover:border-slate-800 dark:hover:border-slate-100 bg-slate-200/50 text-slate-800 hover:bg-slate-950 hover:text-slate-200 hover:border-slate-800 bg-slate-200 text-slate-800 hover:bg-slate-950 hover:text-slate-200"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        </a>
                                    @endforelse

                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right font-medium space-x-1">
                                <a href="{{ route('panel.products.edit', $product->id) }}" 
                                   class="inline-flex items-center p-2 bg-white dark:bg-slate-950 border border-gray-200 dark:border-slate-800 text-gray-500 hover:text-indigo-500 dark:hover:text-indigo-400 rounded-lg shadow-sm transition-colors"
                                   title="Modify Product Specification">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>

                                <button wire:click="deleteProduct({{ $product->id }})" 
                                        wire:confirm="Are you absolutely sure you want to permanently erase this product along with all attached SKU variant values?"
                                        class="inline-flex items-center p-2 bg-white dark:bg-slate-950 border border-gray-200 dark:border-slate-800 text-gray-500 hover:text-red-500 dark:hover:text-red-400 rounded-lg shadow-sm transition-colors"
                                        title="Purge Record">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-400 italic">
                                No inventory products match your active registry settings.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>

    </div>

</div>