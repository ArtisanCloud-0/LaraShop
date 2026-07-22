<div class="max-w-4xl mx-auto py-6">
    <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-200 dark:border-slate-800">
        <h1 class="text-2xl font-black text-slate-900 dark:text-white">Your Shopping Bag</h1>
        <span class="text-xs font-mono font-bold px-2.5 py-1 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-md">
            {{ count($cartItems) }} Items
        </span>
    </div>

    @if(empty($cartItems))
        <div class="text-center py-16 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl">
            <span class="text-4xl mb-3 block">🛍️</span>
            <h3 class="text-base font-bold text-slate-900 dark:text-white">Your bag is empty</h3>
            <p class="text-xs text-slate-400 mt-1 mb-6">Looks like you haven't added anything yet.</p>
            <a href="/" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-bold uppercase tracking-wider shadow-sm transition">
                Start Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Items List -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div 
                        x-data="{ 
                            qty: {{ $item['qty'] }},
                            originalQty: {{ $item['qty'] }},
                            updateBackend() {
                                if (this.qty !== this.originalQty) {
                                    $wire.updateQuantity({{ $item['id'] }}, this.qty);
                                    this.originalQty = this.qty;
                                }
                            }
                        }"
                        @mouseleave="updateBackend()"
                        class="flex items-center gap-4 p-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl"
                    >
                        <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center text-[8px] font-mono text-slate-400 uppercase shrink-0">
                            IMG
                        </div>

                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-slate-100 truncate">{{ $item['name'] }}</h4>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $item['variant'] }}</p>
                            
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-xs font-black text-slate-900 dark:text-white">
                                    $<span x-text="({{ $item['price'] }} * qty).toFixed(2)"></span>
                                </span>

                                <!-- Inline Alpine Increment/Decrement Controls -->
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 rounded-lg overflow-hidden">
                                        <button 
                                            type="button" 
                                            @click="if (qty > 1) qty--" 
                                            class="px-2.5 py-1 text-slate-500 hover:text-slate-900 dark:hover:text-white text-xs font-black select-none transition hover:bg-slate-100 dark:hover:bg-slate-800"
                                        >-</button>
                                        
                                        <span x-text="qty" class="px-2 font-mono text-xs font-bold text-slate-900 dark:text-white min-w-[20px] text-center"></span>
                                        
                                        <button 
                                            type="button" 
                                            @click="qty++" 
                                            class="px-2.5 py-1 text-slate-500 hover:text-slate-900 dark:hover:text-white text-xs font-black select-none transition hover:bg-slate-100 dark:hover:bg-slate-800"
                                        >+</button>
                                    </div>

                                    <button 
                                        type="button" 
                                        wire:click="removeItem({{ $item['id'] }})" 
                                        class="text-xs text-red-500 hover:underline font-medium"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="p-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Order Summary</h3>
                    
                    <div class="space-y-2 border-t border-slate-100 dark:border-slate-800 pt-3">
                        <div class="flex justify-between text-xs text-slate-400">
                            <span>Subtotal</span>
                            <span class="font-mono text-slate-700 dark:text-slate-300">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-black text-slate-900 dark:text-white border-t border-slate-100 dark:border-slate-800 pt-3">
                            <span>Total</span>
                            <span class="font-mono">${{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>

                    <a href="#" class="w-full h-11 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-bold uppercase tracking-wider shadow-md transition flex items-center justify-center">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>