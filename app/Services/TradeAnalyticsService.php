<?php

namespace App\Services;

class TradeAnalyticsService
{
    private $trades;
    private $balance = 0;
    private $totalTrades;
    private $totalWin;
    private $totalLose;

    public function __construct($trades, int $balance)
    {
        $this->trades = $trades;
        $this->balance = $balance;
    }

    public function getNetProfit()
    {
        return $this->filterTrade('win')->sum('return') + $this->filterTrade('lose')->sum('return');
    }

    public function getProfitFactor()
    {
        return $this->filterTrade('win')->sum('return')  / abs($this->filterTrade('lose')->sum('return'));
    }

    public function getPercentProfitable()
    {
        return $this->filterTrade('win')->count() / $this->trades->whereIn('status', ['win', 'lose'])->count();
    }

    public function getAverageTradeNetProfit()
    {
        return $this->getNetProfit() / $this->trades->whereIn('status', ['win', 'lose'])->count();
    }

    public function getBestTradeReturn()
    {
        return $this->trades->max('return');
    }

    public function getWorstTradeReturn()
    {
        return $this->trades->min('return');
    }

    public function getBestTradeReturnPercentage()
    {
        return $this->trades->max('return_percentage');
    }

    public function getWorstTradeReturnPercentage()
    {
        return $this->trades->min('return_percentage');
    }

    public function getBalanceGrowth()
    {
        return $this->balance + $this->trades->sum('return');
    }

    public function getBalanceGrowthPercentage()
    {
        $initial = $this->balance;
        if ($initial <= 0) {
            return 0;
        }
        return ($this->getBalanceGrowth() - $initial)  / $initial * 100;
    }

    private function filterTrade(string $status)
    {
        return $this->trades->where('status', $status);
    }
}
