<div class="py-6 space-y-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Store Analytics & Reports</h2>
        <p class="text-xs text-gray-500 dark:text-gray-400">Track total revenue, sales velocity, and inventory metrics.</p>
    </div>

    <!-- Key Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-5 bg-white dark:bg-gray-800/50 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
            <span class="text-xs font-semibold text-gray-400">Total Paid Revenue</span>
            <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">${{ number_format($metrics['total_revenue'], 2) }}</div>
        </div>
        <div class="p-5 bg-white dark:bg-gray-800/50 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
            <span class="text-xs font-semibold text-gray-400">Total Orders</span>
            <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($metrics['total_orders']) }}</div>
        </div>
        <div class="p-5 bg-white dark:bg-gray-800/50 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
            <span class="text-xs font-semibold text-gray-400">Registered Users</span>
            <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($metrics['total_users']) }}</div>
        </div>
        <div class="p-5 bg-white dark:bg-gray-800/50 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
            <span class="text-xs font-semibold text-gray-400">Low Stock Alert</span>
            <div class="text-2xl font-bold text-amber-500 mt-1">{{ $metrics['low_stock'] }} items</div>
        </div>
    </div>

    <!-- Top Selling Products Table -->
    <div class="bg-white dark:bg-gray-800/50 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 p-6 space-y-4">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Top Performing Products</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/60 text-gray-400 uppercase font-semibold">
                        <th class="py-3">Product Name</th>
                        <th class="py-3">Units Sold</th>
                        <th class="py-3 text-right">Revenue Generated</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700/40 text-gray-700 dark:text-gray-300">
                    @forelse($topItems as $item)
                        <tr>
                            <td class="py-3 font-bold text-gray-900 dark:text-white">{{ $item->name }}</td>
                            <td class="py-3">{{ number_format($item->total_qty) }} units</td>
                            <td class="py-3 text-right font-bold text-emerald-400">${{ number_format($item->total_revenue, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-4 text-center text-gray-400">No sales data recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>