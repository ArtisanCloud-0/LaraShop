<div class="min-h-screen bg-slate-50 dark:bg-slate-950 py-12 px-4 sm:px-6 lg:px-8 text-slate-600 dark:text-slate-100">
    <div class="max-w-6xl mx-auto space-y-8">

        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-black text-slate-600 dark:text-white tracking-tight">Checkout</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Complete your order details and finalize payment.</p>
        </div>

        {{-- Error Flash Message --}}
        <x-message.session></x-message.session>

        <form wire:submit.prevent="placeOrder" class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Column: Shipping & Payment Details -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Customer Details Card -->
                <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800/80 rounded-2xl p-6 shadow-xl space-y-4">
                    <h3 class="text-sm font-bold text-slate-600 dark:text-white mb-2">Customer & Shipping Information</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-1.5">Full Name</label>
                            <input 
                                type="text" 
                                wire:model="name"
                                @auth disabled @endauth
                                class="w-full bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-600 dark:text-slate-400 @auth cursor-not-allowed @endauth"
                                placeholder="John Doe"
                            >
                            @error('name') <span class="text-red-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-1.5">Email Address</label>
                            <input 
                                type="email" 
                                wire:model="email"
                                @auth disabled @endauth
                                class="w-full bg-slate-50 dark:bg-slate-950/60 border border-slate-300 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-600 dark:text-slate-400 @auth cursor-not-allowed @endauth"
                                placeholder="guest@example.com"
                            >
                            @error('email') <span class="text-red-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                </div>

                <!-- Simulated Payment Option Card -->
                <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800/80 rounded-2xl p-6 shadow-xl space-y-4">
                    <h3 class="text-sm font-bold text-slate-600 dark:text-white mb-2">Payment Option</h3>

                    <div class="p-4 rounded-xl bg-indigo-600/90 dark:bg-indigo-500/10 border border-indigo-500/30 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-lg bg-indigo-700 dark:bg-indigo-600/20 text-indigo-400 flex items-center justify-center font-bold text-xs">
                                ⚡
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">Instant Simulated Checkout</p>
                                <p class="text-[10px] text-slate-200 dark:text-slate-400">Processes order immediately & deducts inventory</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-slate-600 dark:text-emerald-400 bg-white dark:bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">
                            Ready
                        </span>
                    </div>
                </div>

            </div>

            <!-- Right Column: Order Summary Sidebar -->
            <div class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800/80 rounded-2xl p-6 shadow-xl flex flex-col justify-between h-fit space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-slate-600 dark:text-white mb-4">Order Summary</h3>

                    {{-- Cart Items Breakdown --}}
                    <div class="divide-y divide-slate-300 dark:divide-slate-800 max-h-60 overflow-y-auto mb-4 pr-1">
                        @forelse(session()->get('cart', []) as $item)
                            <div class="py-3 flex items-center justify-between gap-3 text-xs">
                                <div class="truncate">
                                    <p class="font-bold text-slate-500 dark:text-white truncate">{{ $item['name'] ?? 'Custom Product' }}</p>
                                    <p class="text-[10px] text-slate-600 dark:text-slate-400">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <span class="font-bold text-slate-500 dark:text-white shrink-0">
                                    ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-600 dark:text-slate-400 text-center py-4">Your bag is empty.</p>
                        @endforelse
                    </div>

                    {{-- Totals --}}
                    @php
                        $cartItems = session()->get('cart', []);
                        $subtotal = array_reduce($cartItems, fn($acc, $i) => $acc + ($i['price'] * $i['quantity']), 0);
                    @endphp

                    <div class="space-y-2 pt-4 border-t border-slate-300 dark:border-slate-800 text-xs">
                        <div class="flex justify-between text-slate-600 dark:text-slate-400">
                            <span>Subtotal</span>
                            <span class="text-slate-500 dark:text-white font-semibold">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-slate-500 dark:text-slate-400">
                            <span>Shipping</span>
                            <span class="text-emerald-400 font-semibold">Free</span>
                        </div>
                        <div class="flex justify-between text-sm font-black text-white pt-2 border-t border-slate-800">
                            <span>Total</span>
                            <span class="text-indigo-500 dark:text-indigo-400">${{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 text-white font-bold text-xs rounded-xl shadow-lg shadow-indigo-600/20 text-center transition flex items-center justify-center gap-2"
                >
                    <span wire:loading.remove>Place Order & Pay</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </div>

        </form>

        <div class="pt-4">
            <a 
                href="{{ url()->previous() !== request()->url() ? url()->previous() : route('cart') }}" 
                class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Cancel & Back to Shopping Bag
            </a>
        </div>

    </div>
</div>