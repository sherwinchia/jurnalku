<?php

namespace App\Http\Livewire\Admin\Analytics;

use App\Models\Transaction;
use App\Models\User;
use App\Services\AppAnalyticsService;
use Livewire\Component;

class AnalyticsIndex extends Component
{
    public $revenueData;
    public $usersData;
    public $transactionsData;
    public $totalRevenue;

    public function initData()
    {
        $this->updateChart();
    }

    public function updateChart()
    {
        $appAnalyticsService = app(AppAnalyticsService::class, ['transactions' => Transaction::where('status', 'success')->latest()->get(['net_total', 'updated_at']), 'users' => User::where('role_id', '!=', 1)->latest()->get(['id', 'name'])]);
        $this->usersData = $appAnalyticsService->getUsersData();
        $this->transactionsData = $appAnalyticsService->getTransactionsData();
        $this->totalRevenue = $appAnalyticsService->getTotalRevenue();
        $this->revenueData = $appAnalyticsService->getRevenueData();
        $this->emit('updateData');
    }

    public function render()
    {
        return view('livewire.admin.analytics.analytics-index');
    }
}
