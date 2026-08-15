<div class="min-h-screen bg-slate-950 py-12 px-4 sm:px-6 lg:px-8 text-slate-100">
    <div class="max-w-3xl mx-auto space-y-8">

        {{-- Success Banner Header --}}
        <div class="text-center space-y-3">
            <div class="inline-flex items-center justify-center size-16 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-lg shadow-emerald-500/5">
                <svg class="size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight">Thank you for your order!</h1>
            <p class="text-xs text-slate-400">
                Order <span class="font-bold text-indigo-400">#{{ $order->order_number }}</span> has been placed successfully.
            </p>
        </div>

        {{-- Order Info Card --}}
        <div class="bg-slate-900 border border-slate-800/80 rounded-2xl p-6 sm:p-8 shadow-2xl space-y-6">

            {{-- Summary Bar --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pb-6 border-b border-slate-800 text-xs">
                <div>
                    <span class="text-slate-400 block mb-1">Order Date</span>
                    <span class="font-bold text-white">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-1">Status</span>
                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold border border-emerald-500/30 bg-emerald-500/10 text-emerald-400">
                        {{-- {{ strtoupper($order->status) }} --}}
                        {{ $order->status }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-1">Customer</span>
                    <span class="font-bold text-white truncate block">
                        {{ $order->user->name ?? 'Guest Customer' }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-1">Total Paid</span>
                    <span class="font-black text-indigo-400">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            {{-- Items List --}}
            <div>
                <h3 class="text-sm font-bold text-white mb-4">Items Ordered</h3>
                <div class="divide-y divide-slate-800/60">
                    @foreach($order->items as $item)
                        <div class="py-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="size-12 rounded-xl bg-slate-800 border border-slate-700/50 flex items-center justify-center shrink-0 font-bold text-xs text-slate-500">
                                    IMG
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-white">
                                        {{ $item->productDetail->product->name ?? 'Product' }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">
                                        Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                    </p>
                                </div>
                            </div>
                            <span class="text-xs font-black text-white">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Total Calculation Breakdown --}}
            <div class="pt-4 border-t border-slate-800 space-y-2 text-xs">
                <div class="flex justify-between text-slate-400">
                    <span>Subtotal</span>
                    <span class="text-slate-200 font-semibold">${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-slate-400">
                    <span>Shipping</span>
                    <span class="text-emerald-400 font-semibold">Free</span>
                </div>
                <div class="flex justify-between text-sm font-black text-white pt-2 border-t border-slate-800">
                    <span>Total</span>
                    <span class="text-indigo-400">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

        </div>

        {{-- Footer Actions --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
            <a 
                href="{{ route('products') }}" 
                class="w-full sm:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs rounded-xl shadow-lg shadow-indigo-600/20 text-center transition"
            >
                Continue Shopping
            </a>

            @auth
                <a 
                    href="{{ route('admin.orders.index') }}" 
                    class="w-full sm:w-auto px-6 py-3 bg-slate-900 hover:bg-slate-800 border border-slate-800 text-slate-300 font-bold text-xs rounded-xl text-center transition"
                >
                    Track in Admin Panel &rarr;
                </a>
            @else
                <a 
                    href="{{ route('login') }}" 
                    class="w-full sm:w-auto px-6 py-3 bg-slate-900 hover:bg-slate-800 border border-slate-800 text-slate-300 font-bold text-xs rounded-xl text-center transition"
                >
                    Create Account to Track Orders
                </a>
            @endauth
        </div>

    </div>
</div>