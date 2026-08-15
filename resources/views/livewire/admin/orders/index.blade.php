<div class="py-6 space-y-6">

    @if (session()->has('message'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs font-bold">
            {{ session('message') }}
        </div>
    @endif

    <!-- Header Actions & Filters -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Customer Orders</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Monitor order progression, payment status, and customer fulfillment.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Search -->
            <input 
                type="search" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search order # or customer..." 
                class="rounded-xl border-slate-300 dark:border-gray-700/60 bg-white dark:bg-gray-800/80 text-xs text-gray-900 dark:text-white px-3 py-2 w-full sm:w-60 focus:ring-2 focus:ring-indigo-500"
            >

            <!-- Status Filter Dropdown -->
            <select 
                wire:model.live="statusFilter"
                class="rounded-xl border-gray-200 dark:border-gray-700/60 bg-white dark:bg-gray-800/80 text-xs text-gray-900 dark:text-white px-3 py-2 focus:ring-2 focus:ring-indigo-500"
            >
                <option value="all">All Statuses</option>
                @foreach(\App\Enums\OrderStatus::cases() as $status)
                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white dark:bg-gray-800/50 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/60 text-gray-400 uppercase tracking-wider font-semibold">
                        <th class="p-4">Order Details</th>
                        <th class="p-4">Customer</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Total</th>
                        <th class="p-4">Date</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/40 text-gray-700 dark:text-gray-300">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                            <td class="p-4">
                                <span class="font-bold text-gray-900 dark:text-white">#{{ $order->order_number }}</span>
                                <span class="block text-[10px] text-gray-400">{{ $order->items_count ?? $order->items->count() }} item(s)</span>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-gray-900 dark:text-white">{{ $order->user->name ?? 'Guest User' }}</div>
                                <div class="text-[10px] text-gray-400">{{ $order->user->email ?? $order->guest_email }}</div>
                            </td>
                            <td class="p-4">
                                <!-- Dynamic Table Badge from Enum -->
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $order->status->badgeColor() }}">
                                    {{ $order->status->label() }}
                                </span>
                            </td>
                            <td class="p-4 font-bold text-gray-900 dark:text-white">
                                ${{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="p-4 text-gray-400">{{ $order->created_at->format('M d, Y • H:i') }}</td>
                            <td class="p-4 text-right space-x-2">
                                <button wire:click="viewOrder({{ $order->id }})" class="font-bold text-indigo-400 hover:underline">
                                    View Details
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">No orders found matching your query.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100 dark:border-gray-700/60">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- Order Detail Modal -->
    @if($showDetailsModal && $selectedOrder)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/50 dark:border-gray-700 max-w-2xl w-full p-6 shadow-xl space-y-6">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-4">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">
                            Order #{{ $selectedOrder->order_number }}
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Placed on {{ $selectedOrder->created_at->format('M d, Y at H:i A') }}</p>
                    </div>

                    <!-- Change Status Dropdown -->
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-semibold text-gray-400">Status:</label>
                        <select 
                            wire:change="updateStatus({{ $selectedOrder->id }}, $event.target.value)"
                            class="rounded-lg border-gray-200 dark:border-gray-700 bg-slate-100 dark:bg-gray-900 text-xs text-gray-900 dark:text-white px-2.5 py-1.5 focus:ring-2 focus:ring-indigo-500"
                        >
                            @foreach(\App\Enums\OrderStatus::cases() as $status)
                                <option value="{{ $status->value }}" @selected($selectedOrder->status === $status)>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Purchased Items -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400">Items Ordered</h4>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700/50 max-h-48 overflow-y-auto">
                        @foreach($selectedOrder->items as $item)
                            <div class="py-2.5 flex items-center justify-between text-xs">
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                    <p class="text-[10px] text-gray-400">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                </div>
                                <span class="font-bold text-gray-900 dark:text-white">
                                    ${{ number_format($item->quantity * $item->price, 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Total Summary -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center text-sm font-bold text-gray-900 dark:text-white">
                    <span>Total Amount</span>
                    <span class="text-indigo-400">${{ number_format($selectedOrder->total_amount, 2) }}</span>
                </div>

                <!-- Modal Actions -->
                <div class="flex justify-end pt-2">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-white rounded-xl text-xs font-bold transition-colors">
                        Close
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>