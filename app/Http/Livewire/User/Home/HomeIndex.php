<?php

namespace App\Http\Livewire\User\Home;

use App\Models\Trade;
use App\Models\Portfolio;
use App\Services\TradeAnalyticsService;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class HomeIndex extends Component
{
    public $portfolios;
    public $trades;
    public $performanceData = [];

    public function mount()
    {
        $tradeAnalyticsService = app(TradeAnalyticsService::class, ['trades' => current_user()->trades, 'balance' => current_user()->total_balance]);
        dd($tradeAnalyticsService->getRangeNetProfit());
    }

    public function initData()
    {
    }

    public function loadData()
    {
        // $this->portfolios = current_user()->portfolios;

        // $this->trades = current_user()->trades()->latest()->take(10)->get();

        // $this->performance = [];
    }

    public function render()
    {
        return view('livewire.user.home.home-index', []);
    }
}
