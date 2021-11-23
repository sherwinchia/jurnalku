<?php

namespace App\Http\Livewire\User\Home;

use App\Models\Trade;
use App\Models\Portfolio;
use App\Services\TradeAnalyticsService;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class HomeIndex extends Component
{
    public Portfolio $portfolio;
    public $selectedPortfolio;
    public $portfolios;
    public $trades;
    public $chartData = [];

    public function mount()
    {
        $this->portfolios = current_user()->portfolios->load('trades');
        $this->trades = current_user()->trades()->latest()->take(10)->get();
        $this->portfolio = $this->portfolios->first();
        // dd($this->portfolio);
    }

    public function initData()
    {
        $this->updateChart();
    }

    public function updateChart()
    {
        $tradeAnalyticsService = app(TradeAnalyticsService::class, ['trades' => $this->portfolio->trades, 'balance' => $this->portfolio->balance]);
        $this->chartData = $tradeAnalyticsService->getRangeNetProfit();
        $this->emit('changeData');
    }

    public function changePortfolio()
    {
        $this->portfolio = Portfolio::findOrFail($this->selectedPortfolio);
        $this->updateChart();
    }

    public function loadData()
    {
    }

    public function render()
    {
        return view('livewire.user.home.home-index', []);
    }
}
