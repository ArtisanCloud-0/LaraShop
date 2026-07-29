<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use Livewire\Attributes\Title;

use App\Services\Report\ReportService;

class Index extends Component
{
    #[Title('LaraShop Reports')]
    public function render()
    {
        return view('livewire.admin.reports.index', [
            'metrics'   => resolve(ReportService::class)->getSummaryMetrics(),
            'statuses'  => resolve(ReportService::class)->getOrderStatusBreakdown(),
            'topItems'  => resolve(ReportService::class)->getTopSellingProducts(),
        ]);
    }
}
