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

    public $selectedPortfolio;
    public $portfolios;
    public $netProfitData;
    public $winLoseData;
    public $essentialsData;
    public $winStreaks;
    public $loseStreaks;

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

        $tradeAnalyticsService = app(TradeAnalyticsService::class, ['trades' => $trades, 'balance' => $this->portfolio->balance]);
        $this->netProfitData = $tradeAnalyticsService->getRangeNetProfit();
        $this->winLoseData = $tradeAnalyticsService->getWinLossPercentage();
        $this->bestTradeReturn = $tradeAnalyticsService->getBestTradeReturn();
        $this->worstTradeReturn = $tradeAnalyticsService->getWorstTradeReturn();
        $this->essentialsData = $tradeAnalyticsService->getEssentialsData();
        $this->emit('updateData');
    }

    public function changeFilter($field)
    {
        $this->filter = $field;
        $this->updateChart();
    }

    public function filterTrades()
    {
        $trades = $this->portfolio->trades->sortBy('entry_date');
        // dd($trades);

        switch ($this->filter) {
            case '7D':
                return $trades->where('entry_date', '<=', now()->endOfWeek())->where('entry_date', '>=', now()->startOfWeek());
                break;

            case '1M':
                return $trades->where('entry_date', '<=', now()->endOfMonth())->where('entry_date', '>=', now()->startOfMonth());
                break;

            case '3M':
                return $trades->where('entry_date', '<=', now()->endOfMonth())->where('entry_date', '>=', now()->startOfMonth()->subMonths(2));
                break;

            case '6M':
                return $trades->where('entry_date', '<=', now()->endOfMonth())->where('entry_date', '>=', now()->startOfMonth()->subMonth(5));
                break;

            case '1Y':
                return $trades->where('entry_date', '<=', now()->endOfYear())->where('entry_date', '>=', now()->startOfYear());
                break;

            case '2Y':
                return $trades->where('entry_date', '<=', now()->endOfYear())->where('entry_date', '>=', now()->startOfYear()->subYears(1));
                break;

            case '3Y':
                return $trades->where('entry_date', '<=', now()->endOfYear())->where('entry_date', '>=', now()->startOfYear()->subYears(2));
                break;

            case 'All':
                return $trades;
                break;

            default:
                return $trades;
                break;
        }
    }

    public function changePortfolio()
    {
        $this->portfolio = Portfolio::findOrFail($this->selectedPortfolio);
        $this->currency = $this->portfolio->currency;
        $this->updateChart();
    }

    public function render()
    {
        return view('livewire.user.analytics.analytics-index');
    }
}
