<?php

namespace App\Services;

use stdClass;

class TradeAnalyticsService
{
    private $trades;
    private $balance = 0;

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

    public function getWinCount()
    {
        return $this->filterTrade('win')->count();
    }

    public function getLoseCount()
    {
        return $this->filterTrade('lose')->count();
    }

    public function getTradeCount()
    {
        return $this->trades->count();
    }

    public function getWinLossPercentage()
    {
        $win = $this->filterTrade('win')->count() / ($this->filterTrade('win')->count() + $this->filterTrade('lose')->count()) * 100;
        $lose = 100 - $win;

        $data = [
            "win" => $win,
            "lose" => $lose
        ];

        return (object) $data;
    }

    public function getBalanceGrowthPercentage()
    {
        $initial = $this->balance;
        if ($initial <= 0) {
            return 0;
        }
        return ($this->getBalanceGrowth() - $initial)  / $initial * 100;
    }

    public function getRangeNetProfit()
    {
        $data = array();
        $rawData = $this->trades->whereIn('status', ['win', 'lose'])->groupBy(function ($item) {
            return $item->entry_date->format('d M y');
        });;

        dd($rawData);
    }

    private function filterTrade(string $status)
    {
        return $this->trades->where('status', $status);
    }
}
