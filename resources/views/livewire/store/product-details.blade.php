<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    
    {{-- Left Column: Images --}}
    <div>
        <div class="aspect-square w-full rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 overflow-hidden">
            @if($product->primary_image)
                <img src="{{ Storage::url($product->primary_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
            @else
                <div class="h-full flex items-center justify-center text-slate-400 font-mono text-xs uppercase">No Image</div>
            @endif
        </div>
    </div>

    {{-- Right Column: Specs, Variant Selection & Actions --}}
    <div class="flex flex-col justify-between">
        <div>
            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">
                {{ $product->category->name }}
            </span>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white mt-1">
                {{ $product->name }}
            </h1>

            {{-- Dynamic Price Display --}}
            <div class="mt-4 flex items-baseline gap-x-2">
                @if($activeVariant)
                    <span class="text-2xl font-black text-slate-900 dark:text-white">
                        ${{ number_format($activeVariant->price / 100, 2) }}
                    </span>
                    <span class="text-xs font-mono text-slate-400">
                        SKU: {{ $activeVariant->code }}
                    </span>
                @else
                    <span class="text-2xl font-black text-slate-900 dark:text-white">
                        {{ $product->formatted_price }}
                    </span>
                @endif
            </div>

            <p class="text-sm text-slate-600 dark:text-slate-400 mt-4 leading-relaxed">
                {{ $product->description }}
            </p>

            <hr class="my-6 border-slate-200 dark:border-slate-800" />

            {{-- Dynamic Variant Selectors (Iterate through extracted keys) --}}
            @foreach($variantAttributes as $attribute => $values)
                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        {{ $attribute }}: <span class="text-blue-600 dark:text-blue-400">{{ $selectedOptions[$attribute] ?? '' }}</span>
                    </label>

                    <div class="flex flex-wrap gap-2">
                        @foreach($values as $val)
                            <button 
                                type="button"
                                wire:click="$set('selectedOptions.{{ $attribute }}', '{{ $val }}')"
                                class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition
                                    {{ ($selectedOptions[$attribute] ?? null) === $val 
                                        ? 'bg-blue-600 border-blue-600 text-white shadow-sm' 
                                        : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-400' 
                                    }}"
                            >
                                {{ $val }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- Stock Status Indicator --}}
            <div class="mt-4">
                @if($activeVariant)
                    @if($activeVariant->stock > 0)
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            In Stock ({{ $activeVariant->stock }} available)
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-rose-600 dark:text-rose-400">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            Out of Stock
                        </span>
                    @endif
                @else
                    <span class="text-xs text-amber-500">
                        Selection unavailable. Please choose valid options.
                    </span>
                @endif
            </div>
        </div>

        {{-- Add to Cart Row --}}
        <div class="mt-8 pt-4 border-t border-slate-200 dark:border-slate-800 flex gap-4">
            <button 
                wire:click="addToCart" 
                wire:loading.attr="disabled"
                @if(!$activeVariant || $activeVariant->stock <= 0) disabled @endif
                class="flex-1 py-3 px-6 bg-slate-900 hover:bg-blue-600 dark:bg-slate-800 dark:hover:bg-blue-600 text-white font-bold text-sm rounded-xl shadow-md transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
                <span wire:loading.remove wire:target="addToCart">
                    {{ ($activeVariant && $activeVariant->stock > 0) ? 'Add to Shopping Cart' : 'Unavailable' }}
                </span>
                <span wire:loading wire:target="addToCart">Adding to Cart...</span>
            </button>
        </div>
    </div>
</div>