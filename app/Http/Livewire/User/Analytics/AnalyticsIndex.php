<?php

namespace App\Http\Livewire\User\Analytics;

use App\Models\Portfolio;
use App\Services\TradeAnalyticsService;
use Livewire\Component;

class AnalyticsIndex extends Component
{
    public Portfolio $portfolio;
    public string $currency;
    public $trades;
    public $filteredTrades;
    public $selectedPortfolio;
    public $portfolios;
    public $netProfitData;
    public $balanceGrowthData;
    public $winLoseData;
    public $essentialsData;

    public $bestTradeReturn;
    public $worstTradeReturn;
    public $bestTradePercentage;
    public $worstTradePercentage;

    public $filter = 'All';

    public function mount()
    {
        $this->portfolios = current_user()->portfolios;
        $this->portfolio = $this->portfolios->first();
        $this->currency = $this->portfolio->currency;
    }

    public function initData()
    {
        $this->updateChart();
    }

    public function updateChart()
    {
        $trades = $this->filterTrades();

        if (!$trades->isEmpty()) {
            $tradeAnalyticsService = app(TradeAnalyticsService::class, ['trades' => $trades, 'balance' => $this->portfolio->balance]);
            $this->netProfitData = $tradeAnalyticsService->getRangeNetProfit();
            $this->balanceGrowthData = $tradeAnalyticsService->getTotalBalanceGrowthPercentage();
            $this->winLoseData = $tradeAnalyticsService->getWinLossPercentage();
            $this->essentialsData = $tradeAnalyticsService->getEssentialsData();

            $this->bestTradeReturn = $tradeAnalyticsService->getBestTradeReturn();
            $this->worstTradeReturn = $tradeAnalyticsService->getWorstTradeReturn();
            $this->emit('updateData');
        }
    }

    public function filterTrades()
    {
        $trades = $this->portfolio->trades->sortBy('entry_date');
        switch ($this->filter) {
            case '7D':
                return $trades->filter(function ($value, $key) {
                    return $value->entry_date > now()->subDays(7);
                });
                break;
            case '1M':
                return $trades->filter(function ($value, $key) {
                    return $value->entry_date > now()->subDays(30);
                });
                break;
            case '3M':
                return $trades->filter(function ($value, $key) {
                    return $value->entry_date > now()->subDays(90);
                });
                break;
            case '6M':
                return $trades->filter(function ($value, $key) {
                    return $value->entry_date > now()->subDays(180);
                });
                break;
            case '1Y':
                return $trades->filter(function ($value, $key) {
                    return $value->entry_date > now()->subDays(365);
                });
                break;
            case '2Y':
                return $trades->filter(function ($value, $key) {
                    return $value->entry_date > now()->subDays(730);
                });
                break;
            case '3Y':
                return $trades->filter(function ($value, $key) {
                    return $value->entry_date > now()->subDays(1095);
                });
                break;

            default:
                return $trades;
                break;
        }
    }

    public function changeFilter($field)
    {
        $this->filter = $field;
        $this->updateChart();
    }

    public function changePortfolio()
    {
        $this->portfolio = Portfolio::findOrFail($this->selectedPortfolio);
        $this->trades = $trades->sortBy('entry_date');
        $this->currency = $this->portfolio->currency;
        $this->updateChart();
    }

    public function render()
    {
        return view('livewire.user.analytics.analytics-index');
    }
}
