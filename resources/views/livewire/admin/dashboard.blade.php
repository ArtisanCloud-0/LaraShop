<div class="space-y-8">

    {{-- Header Greeting --}}
    <div>
        <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
            Welcome back, {{ auth('panel')->user()->name ?? 'Admin' }} 👋
        </h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            Here is what's happening with LaraShop store today.
        </p>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- Total Revenue --}}
        <div class="p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total Revenue</p>
            <p class="text-2xl font-black text-slate-900 dark:text-white mt-2">
                ${{ number_format($totalRevenue, 2) }}
            </p>
            <span class="inline-block mt-2 text-[10px] font-bold text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded">
                +12.5% from last month
            </span>
        </div>

        {{-- Orders --}}
        <div class="p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total Orders</p>
            <p class="text-2xl font-black text-slate-900 dark:text-white mt-2">
                {{ $ordersCount }}
            </p>
            <span class="inline-block mt-2 text-[10px] font-bold text-blue-500 bg-blue-500/10 px-2 py-0.5 rounded">
                +8 new today
            </span>
        </div>

        {{-- Customers --}}
        <div class="p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total Customers</p>
            <p class="text-2xl font-black text-slate-900 dark:text-white mt-2">
                {{ $customersCount }}
            </p>
            <span class="inline-block mt-2 text-[10px] font-bold text-indigo-500 bg-indigo-500/10 px-2 py-0.5 rounded">
                Active buyers
            </span>
        </div>

        {{-- Low Stock Alert --}}
        <div class="p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm">
            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Low Stock Alerts</p>
            <p class="text-2xl font-black text-amber-500 mt-2">
                {{ $lowStockCount }} items
            </p>
            <span class="inline-block mt-2 text-[10px] font-bold text-amber-500 bg-amber-500/10 px-2 py-0.5 rounded">
                Requires restock
            </span>
        </div>

    </div>

    {{-- Quick Actions Banner --}}
    <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-lg">
        <div>
            <h3 class="text-lg font-bold">Ready to add new products?</h3>
            <p class="text-xs text-blue-100 mt-1">
                Upload product media, manage inventory, and configure custom variants.
            </p>
        </div>
        <a href="#" class="px-4 py-2.5 bg-white text-blue-600 hover:bg-blue-50 font-bold text-xs rounded-xl shadow transition shrink-0">
            + Add New Product
        </a>
    </div>

    <!-- Grid for Recent Orders & Top Products -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Recent Orders (2 Columns Wide on Large Screens) -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Recent Orders</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Latest transactions across your store</p>
                </div>
                <a href="#" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                    View all orders &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700/60 text-gray-400 uppercase tracking-wider font-semibold">
                            <th class="pb-3">Order</th>
                            <th class="pb-3">Customer</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Total</th>
                            <th class="pb-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/40 text-gray-700 dark:text-gray-300">
                        <tr>
                            <td class="py-3 font-medium text-gray-900 dark:text-white">#ORD-9082</td>
                            <td class="py-3">John Doe</td>
                            <td class="py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                    Paid
                                </span>
                            </td>
                            <td class="py-3 font-semibold">$120.00</td>
                            <td class="py-3 text-right">
                                <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold">View</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3 font-medium text-gray-900 dark:text-white">#ORD-9081</td>
                            <td class="py-3">Sarah Smith</td>
                            <td class="py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                    Pending
                                </span>
                            </td>
                            <td class="py-3 font-semibold">$85.50</td>
                            <td class="py-3 text-right">
                                <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold">View</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Category Sales Distribution Donut Chart -->
        <div 
            x-data="{
                donutChart: null,
                initDonut() {
                    const options = {
                        chart: {
                            type: 'donut',
                            height: 320,
                            fontFamily: 'inherit',
                            background: 'transparent'
                        },
                        series: [44, 25, 19, 12], // Dummy category revenue/sales percentages
                        labels: ['Electronics', 'Apparel', 'Accessories', 'Home & Living'],
                        colors: ['#6366f1', '#10b981', '#f59e0b', '#ec4899'], // Indigo, Emerald, Amber, Pink
                        stroke: {
                            width: 2,
                            colors: ['transparent']
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '75%',
                                    labels: {
                                        show: true,
                                        name: {
                                            show: true,
                                            fontSize: '12px',
                                            color: '#9ca3af'
                                        },
                                        value: {
                                            show: true,
                                            fontSize: '18px',
                                            fontWeight: 'bold',
                                            color: 'currentColor',
                                            formatter: (val) => val + '%'
                                        },
                                        total: {
                                            show: true,
                                            label: 'Top Category',
                                            fontSize: '11px',
                                            color: '#9ca3af',
                                            formatter: () => 'Electronics'
                                        }
                                    }
                                }
                            }
                        },
                        dataLabels: { enabled: false },
                        legend: {
                            position: 'bottom',
                            fontSize: '12px',
                            labels: { colors: '#9ca3af' },
                            markers: { radius: 12 }
                        },
                        tooltip: { theme: 'dark' }
                    };

                    this.donutChart = new ApexCharts(this.$refs.donutContainer, options);
                    this.donutChart.render();
                }
            }"
            x-init="initDonut()"
            class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-sm p-6 flex flex-col justify-between"
        >
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Sales by Category</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Revenue share breakdown</p>
                </div>
            </div>

            <!-- Donut Container -->
            <div x-ref="donutContainer" class="flex items-center justify-center min-h-[240px]"></div>
        </div>

        <!-- Top Selling Products Sidebar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-sm p-6">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1">Top Selling Products</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">Most popular items this month</p>

            <div class="space-y-4">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="size-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex-shrink-0 flex items-center justify-center font-bold text-gray-400 text-xs">
                            IMG
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900 dark:text-white">Wireless Headphones</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">42 sales</p>
                        </div>
                    </div>
                    <span class="text-xs font-black text-gray-900 dark:text-white">$99.00</span>
                </div>
            </div>
        </div>

        <!-- Revenue & Sales Analytics Chart -->
        <div 
            x-data="{
                chart: null,
                initChart() {
                    const options = {
                        chart: {
                            type: 'area',
                            height: 300,
                            toolbar: { show: false },
                            fontFamily: 'inherit',
                            background: 'transparent'
                        },
                        series: [{
                            name: 'Revenue ($)',
                            data: [1200, 1900, 1500, 2800, 2200, 3400, 3100]
                        }, {
                            name: 'Orders',
                            data: [12, 18, 14, 25, 20, 32, 29]
                        }],
                        colors: ['#6366f1', '#10b981'], // Indigo & Emerald
                        stroke: { curve: 'smooth', width: 2 },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.05,
                            }
                        },
                        dataLabels: { enabled: false },
                        xaxis: {
                            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                            labels: {
                                style: { colors: '#9ca3af', fontSize: '11px' }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: { colors: '#9ca3af', fontSize: '11px' },
                                formatter: (val) => '$' + val
                            }
                        },
                        grid: {
                            borderColor: 'rgba(156, 163, 175, 0.1)',
                            strokeDashArray: 4
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            labels: { colors: '#9ca3af' }
                        },
                        tooltip: { theme: 'dark' }
                    };

                    this.chart = new ApexCharts(this.$refs.chartContainer, options);
                    this.chart.render();
                }
            }"
            x-init="initChart()"
            class="mt-0 lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-sm p-6"
        >
            <!-- Chart Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Revenue & Sales Trend</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Weekly breakdown of total earnings and completed orders</p>
                </div>
                
                <!-- Time Filter Dropdown -->
                <select class="text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg px-3 py-1.5 border-0 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <option value="7d">Last 7 Days</option>
                    <option value="30d">Last 30 Days</option>
                    <option value="1y">This Year</option>
                </select>
            </div>

            <!-- Chart Container -->
            <div x-ref="chartContainer"></div>
        </div>

    </div>

</div>