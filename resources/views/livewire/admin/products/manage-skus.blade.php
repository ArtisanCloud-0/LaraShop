<div>
    <div class="max-w-7xl mx-auto my-8 p-6 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-xl transition-colors duration-200">
        
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200 dark:border-slate-800">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100">Manage Variant SKUs</h2>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Configuring inventory variants for parent model: <span class="text-indigo-500 font-semibold">{{ $product->name }}</span></p>
            </div>
            <a href="{{ route('panel.products') }}" class="text-xs font-semibold text-gray-500 dark:text-slate-400 hover:underline">← Back to Products</a>
        </div>

        <x-message.session />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="p-5 bg-white dark:bg-slate-950 border border-gray-200 dark:border-slate-800 rounded-xl h-fit">
                <h3 class="text-sm font-bold text-gray-900 dark:text-slate-200 uppercase tracking-wider mb-4">
                    {{ $isEditMode ? 'Edit SKU Specifications' : 'Add New Variant SKU' }}
                </h3>

                <form wire:submit.prevent="saveSku" class="space-y-4">
                    <!-- Variant SKU Form Fields -->
                    <x-form.input
                        for="code"
                        label="SKU Unique Code"
                        placeholder="TSHIRT-SLATE-XL"
                        type="text"
                    />

                    <!-- Variant Price Form Field -->
                    <x-form.input
                        for="price"
                        label="Retail Price ($)"
                        placeholder="29.99"
                        type="number"
                        step="0.01"
                    />

                    <!-- Variant Stock Level Form Field -->
                    <x-form.input
                        for="stock"
                        label="Stock Level"
                        placeholder="100"
                        type="number"
                    />

                    <!-- Variant Dynamic Attributes Form Field -->
                    <x-form.input
                        for="options_raw"
                        label="Dynamic Attributes (Comma separated)"
                        placeholder="Color: Slate, Size: XL"
                        type="text"
                    />

                    <!-- Variant Multi-Image Upload Field -->
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-gray-700 dark:text-slate-300">
                            Variant Gallery Images (Up to 5)
                        </label>

                        <div class="relative border-2 border-dashed border-gray-300 dark:border-slate-800 rounded-lg p-4 text-center hover:border-indigo-500 transition cursor-pointer">
                            <input 
                                type="file" 
                                wire:model="new_images" 
                                multiple 
                                accept="image/png,image/jpeg,image/webp" 
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            >
                            <div class="space-y-1">
                                <svg class="mx-auto h-8 w-8 text-gray-400 dark:text-slate-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="text-xs text-gray-600 dark:text-slate-400">
                                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">Upload files</span> or drag and drop
                                </p>
                                <p class="text-[10px] text-gray-400 dark:text-slate-500">PNG, JPG, WEBP up to 2MB each</p>
                            </div>
                        </div>

                        <!-- Upload Loading State -->
                        <div wire:loading wire:target="new_images" class="text-xs text-indigo-500 font-medium animate-pulse">
                            Processing images...
                        </div>

                        @error('new_images') 
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p> 
                        @enderror
                        @error('new_images.*') 
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p> 
                        @enderror

                        <!-- Preview Newly Selected Temporary Images -->
                        @if (!empty($new_images))
                            <div class="mt-2">
                                <span class="text-[11px] font-semibold text-gray-500 dark:text-slate-400 block mb-1">New Staged Images:</span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($new_images as $index => $file)
                                        <div class="relative w-12 h-12 rounded border border-gray-200 dark:border-slate-800 overflow-hidden group">
                                            <img src="{{ $file->temporaryUrl() }}" class="w-full h-full object-cover">
                                            <button 
                                                type="button" 
                                                wire:click="removeTemporaryImage({{ $index }})" 
                                                class="absolute inset-0 bg-red-900/80 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                                title="Remove"
                                            >
                                                &times;
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Preview Existing Saved Images (When Editing) -->
                        @if ($isEditMode && !empty($images))
                            <div class="mt-2">
                                <span class="text-[11px] font-semibold text-gray-500 dark:text-slate-400 block mb-1">Saved Variant Images:</span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($images as $index => $path)
                                        <div class="relative w-12 h-12 rounded border border-gray-200 dark:border-slate-800 overflow-hidden group">
                                            <img src="{{ asset('storage/' . $path) }}" class="w-full h-full object-cover">
                                            <button 
                                                type="button" 
                                                wire:click="removeExistingImage({{ $index }})" 
                                                class="absolute inset-0 bg-red-900/80 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                                title="Delete Saved Image"
                                            >
                                                &times;
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-end gap-x-2 pt-2 border-t border-gray-100 dark:border-slate-900">
                        @if($isEditMode)
                            <button type="button" wire:click="resetForm" class="px-3 py-1.5 text-xs font-medium text-gray-500 hover:text-gray-700 dark:hover:text-slate-300">Cancel</button>
                        @endif
                        <button type="submit" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-md shadow">
                            {{ $isEditMode ? 'Save Changes' : 'Append Variant SKU' }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-2 overflow-hidden border border-gray-200 dark:border-slate-800 rounded-xl bg-white dark:bg-slate-950">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-slate-900 text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400 border-b border-gray-200 dark:border-slate-800">
                            <th class="px-4 py-3">Variant</th>
                            <th class="px-4 py-3">SKU Code</th>
                            <th class="px-4 py-3">Price</th>
                            <th class="px-4 py-3">Stock Level</th>
                            <th class="px-4 py-3">JSON Attributes</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-slate-800 text-gray-700 dark:text-slate-300">
                        @forelse($product->productDetails as $sku)
                            <tr wire:key="sku-table-row-{{ $sku->id }}" class="hover:bg-gray-50/50 dark:hover:bg-slate-900/30 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="w-10 h-10 rounded border border-slate-200 dark:border-slate-800 overflow-hidden bg-slate-100 dark:bg-slate-900 flex items-center justify-center">
                                        @if(!empty($sku->images) && isset($sku->images[0]))
                                            <img src="{{ asset('storage/' . $sku->images[0]) }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-[9px] text-slate-400 uppercase font-bold">No Img</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-mono font-bold text-gray-900 dark:text-slate-200">{{ $sku->code }}</td>
                                <td class="px-4 py-3 text-indigo-600 dark:text-indigo-400 font-semibold">${{ $sku->price }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 text-xs rounded font-medium {{ $sku->stock > 10 ? 'bg-green-100 dark:bg-green-950/40 text-green-700 dark:text-green-400' : 'bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400' }}">
                                        {{ $sku->stock }} units
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @if(is_array($sku->options))
                                            @foreach($sku->options as $key => $val)
                                                <span class="text-[10px] bg-gray-100 dark:bg-slate-900 text-gray-600 dark:text-slate-400 border border-gray-200 dark:border-slate-800 rounded px-1.5 py-0.5">
                                                    <strong>{{ $key }}:</strong> {{ $val }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-gray-400 italic text-xs">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right space-x-1 whitespace-nowrap">
                                    <button wire:click="editSku({{ $sku->id }})" class="p-1 text-gray-500 hover:text-indigo-500 dark:hover:text-indigo-400 rounded transition" title="Edit Variant">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                                    </button>
                                    <button wire:click="deleteSku({{ $sku->id }})" wire:confirm="Wipe out this custom SKU variant permanently?" class="p-1 text-gray-500 hover:text-red-500 dark:hover:text-red-400 rounded transition" title="Delete Variant">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-xs text-gray-400 italic">No SKU variants recorded yet for this product mapping context.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>