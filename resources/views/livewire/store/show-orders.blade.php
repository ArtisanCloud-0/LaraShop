<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-slate-100">
                My Orders
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Track and review your previous purchase history.
            </p>
        </div>

        <!-- Export CSV Button -->
        <button 
            wire:click="exportCsv"
            wire:loading.attr="disabled"
            type="button"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800 transition"
        >
            <svg wire:loading.remove wire:target="exportCsv" class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <svg wire:loading wire:target="exportCsv" class="h-4 w-4 animate-spin text-orange-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Export CSV</span>
        </button>
    </div>

    <!-- Filters Bar -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
        <!-- Search Input -->
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input 
                wire:model.live.debounce.300ms="search"
                type="text" 
                placeholder="Search by product name or order #..."
                class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-9 pr-4 py-2 text-xs font-medium text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:bg-white focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-orange-400 dark:focus:bg-slate-800 transition"
            >
        </div>

        <!-- Status Dropdown Select -->
        <div class="w-full sm:w-48">
            <select 
                wire:model.live="status"
                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-700 focus:border-orange-500 focus:bg-white focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-orange-400 dark:focus:bg-slate-800 transition cursor-pointer"
            >
                <option value="" class="bg-white text-slate-800 dark:bg-slate-900 dark:text-slate-100">All Statuses</option>
                <option value="pending" class="bg-white text-slate-800 dark:bg-slate-900 dark:text-slate-100">Pending</option>
                <option value="processing" class="bg-white text-slate-800 dark:bg-slate-900 dark:text-slate-100">Processing</option>
                <option value="shipped" class="bg-white text-slate-800 dark:bg-slate-900 dark:text-slate-100">Shipped</option>
                <option value="completed" class="bg-white text-slate-800 dark:bg-slate-900 dark:text-slate-100">Completed</option>
                <option value="cancelled" class="bg-white text-slate-800 dark:bg-slate-900 dark:text-slate-100">Cancelled</option>
            </select>
        </div>
    </div>

    <!-- Orders List -->
    <div class="space-y-4">
        @forelse($orders as $order)
            <div 
                x-data="{ expanded: false }"
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition dark:border-slate-800 dark:bg-slate-900"
            >
                <!-- Order Overview Header -->
                <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 dark:border-slate-800/80">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                        <div>
                            <span class="block text-slate-400 dark:text-slate-500 font-medium">Order Number</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200">#{{ $order->order_number }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-400 dark:text-slate-500 font-medium">Date Placed</span>
                            <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-400 dark:text-slate-500 font-medium">Total Amount</span>
                            <span class="font-bold text-orange-600 dark:text-orange-400">
                                ${{ number_format($order->total_amount / 100, 2) }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-slate-400 dark:text-slate-500 font-medium">Status</span>
                            @php
                                $rawStatus = $order->status instanceof \BackedEnum ? $order->status->value : $order->status;
                                $statusKey = strtolower($rawStatus ?? 'pending');

                                $statusClasses = match($statusKey) {
                                    'completed', 'delivered', 'paid' => 'bg-emerald-50 text-emerald-600 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800',
                                    'processing', 'shipped' => 'bg-amber-50 text-amber-600 border-amber-200 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-800',
                                    'cancelled' => 'bg-rose-50 text-rose-600 border-rose-200 dark:bg-rose-950/40 dark:text-rose-400 dark:border-rose-800',
                                    default => 'bg-indigo-50 text-indigo-600 border-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-400 dark:border-indigo-800',
                                };
                            @endphp
                            <span class="inline-flex items-center rounded-md border px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $statusClasses }}">
                                {{ $rawStatus ?? 'Pending' }}
                            </span>
                        </div>
                    </div>

                    <button 
                        @click="expanded = !expanded" 
                        type="button"
                        class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 transition"
                    >
                        <span x-text="expanded ? 'Hide Details' : 'View Items'">View Items</span>
                        <svg class="h-3.5 w-3.5 transition-transform" :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>

                <!-- Order Item Details -->
                <div x-show="expanded" x-cloak x-collapse class="p-5 bg-slate-50/50 dark:bg-slate-900/50 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Order Items</h4>
                    <div class="divide-y divide-slate-200/60 dark:divide-slate-800">
                        @foreach($order->items as $item)
                            @php
                                $product = $item->product ?? $item->productDetails?->product;
                                $image = $product?->cover_image ? Storage::url($product->cover_image) : null;
                            @endphp
                            <div class="flex items-center justify-between py-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 shrink-0 overflow-hidden rounded-lg border border-slate-200 bg-slate-100 dark:border-slate-800 dark:bg-slate-800">
                                        @if($image)
                                            <img src="{{ $image }}" alt="{{ $product->name ?? 'Product' }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-xs text-slate-400">No Image</div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800 dark:text-slate-200">
                                            {{ $product->name ?? 'Item #' . $item->id }}
                                        </p>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                            Qty: {{ $item->quantity }} × ${{ number_format(($item->unit_price ?? $item->price) / 100, 2) }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300">
                                    ${{ number_format((($item->quantity) * ($item->unit_price ?? $item->price)) / 100, 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center dark:border-slate-800 dark:bg-slate-900">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-orange-50 dark:bg-orange-950/40 text-orange-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-sm font-bold text-slate-800 dark:text-slate-200">No matching orders found or you don't have any orders yet.</h3>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Try adjusting your search criteria or status filter.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="pt-2">
            {{ $orders->links() }}
        </div>
    @endif
</div>