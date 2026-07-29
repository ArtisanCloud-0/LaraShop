<?php 

namespace App\Services;

use App\Enums\OrderStatus;

use App\Models\User;
use App\Models\Product;
use App\Models\OrderLedger As Order;

use Illuminate\Support\Facades\DB;

class DashboardService {

	public function getMetrics(): array
    {
        return [
            'totalRevenue' => (float) Order::whereIn('status', [OrderStatus::PAID, OrderStatus::SHIPPED])->sum('total_amount'),
            'ordersCount' => Order::count(),
            'customersCount' => User::where('role', 'customer')->count(),
            
            // Count parent products whose combined variant stock in product_details is under 5
            'lowStockCount' => Product::query()
                ->withSum('productDetails as total_stock', 'stock')
                ->having('total_stock', '<', 5)
                ->count(),
        ];
    }

    public function getRecentOrders(int $limit = 5)
    {
        return Order::with(['user'])
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getTopSellingProducts(int $limit = 4)
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_details_id', '=', 'products.id')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_sales'),
                DB::raw('AVG(order_items.price) as avg_price')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sales')
            ->limit($limit)
            ->get();
    }

    public function getCategorySalesDistribution(): array
    {
        $distribution = DB::table('order_items')
            ->join('products', 'order_items.product_details_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(order_items.quantity * order_items.price) as revenue'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->get();

        return [
            'labels' => $distribution->pluck('name')->toArray() ?: ['No Data'],
            'series' => $distribution->pluck('revenue')->map(fn($val) => (float) $val)->toArray() ?: [100],
        ];
    }

    public function getWeeklyTrend(): array
    {
        $days = collect(range(6, 0))->map(fn($daysAgo) => now()->subDays($daysAgo)->format('Y-m-d'));

        $orders = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        $categories = [];
        $revenueData = [];
        $ordersData = [];

        foreach ($days as $day) {
            $categories[] = date('D', strtotime($day));
            $revenueData[] = (float) ($orders[$day]->revenue ?? 0);
            $ordersData[] = (int) ($orders[$day]->count ?? 0);
        }

        return [
            'categories' => $categories,
            'revenue' => $revenueData,
            'orders' => $ordersData,
        ];
    }

}
