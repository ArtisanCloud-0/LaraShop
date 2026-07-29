<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Services\DashboardService;

class Dashboard extends Component
{
    public function render()
    {
        $metrics = resolve(DashboardService::class)->getMetrics();

        return view('livewire.admin.dashboard', [
            'totalRevenue'      => $metrics['totalRevenue'],
            'ordersCount'       => $metrics['ordersCount'],
            'customersCount'    => $metrics['customersCount'],
            'lowStockCount'     => $metrics['lowStockCount'],
            'recentOrders'      => resolve(DashboardService::class)->getRecentOrders(5),
            'topProducts'       => resolve(DashboardService::class)->getTopSellingProducts(4),
            'categoryShare'     => resolve(DashboardService::class)->getCategorySalesDistribution(),
            'weeklyTrend'       => resolve(DashboardService::class)->getWeeklyTrend(),
        ]);
    }
}