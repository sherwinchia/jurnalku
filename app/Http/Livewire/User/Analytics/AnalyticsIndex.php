<?php

namespace App\Http\Livewire\User\Analytics;

use App\Models\Portfolio;
use App\Services\TradeAnalyticsService;
use Livewire\Component;

class AnalyticsIndex extends Component
{
    public Portfolio $portfolio;
    public $selectedPortfolio;
    public $portfolios;
    public $netProfitData;
    public $balanceGrowthData;
    public $winLoseData;

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
        $this->netProfitData = $tradeAnalyticsService->getRangeNetProfit();
        $this->balanceGrowthData = $tradeAnalyticsService->getTotalBalanceGrowthPercentage();
        $this->winLoseData = $tradeAnalyticsService->getWinLossPercentage();
        // dd($this->winLoseData);
        $this->emit('updateData');
    }

    public function changePortfolio()
    {
        $this->portfolio = Portfolio::findOrFail($this->selectedPortfolio);
        $this->updateChart();
    }

    public function render()
    {
        return view('livewire.user.analytics.analytics-index');
    }
}
