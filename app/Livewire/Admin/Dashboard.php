<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            // Dummy stats for now — we'll wire these to real Services later
            'totalRevenue' => 14850.00,
            'ordersCount' => 124,
            'customersCount' => 89,
            'lowStockCount' => 3,
        ]);
    }
}