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
        return $this->netProfit($this->trades);
    }

    public function getProfitFactor()
    {
        $win = $this->filterTrade('win')->sum('return');
        $lose = abs($this->filterTrade('lose')->sum('return'));

        if ($win < 1 || $lose < 1) {
            return 0;
        }

        return $win / $lose;
    }

    public function getPercentProfitable()
    {
        return $this->filterTrade('win')->count() / $this->trades->whereIn('status', ['win', 'lose'])->count() * 100;
    }

    public function getAverageTradeNetProfit()
    {
        return $this->getNetProfit() / $this->trades->whereIn('status', ['win', 'lose'])->count();
    }

    public function getBestTradeReturn()
    {
        return $this->trades->sortByDesc('return')->first();
    }

    public function getWorstTradeReturn()
    {
        return $this->trades->sortBy('return')->first();
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

    public function getBalanceGrowth()
    {
        return $this->balanceGrowth($this->trades);
    }

    public function getBalanceGrowthPercentage()
    {
        return $this->balanceGrowthPercentage($this->balanceGrowth($this->trades));
    }

    public function getEssentialsData()
    {
        return [
            'profit_factor' => $this->getProfitFactor(),
            'percent_profitable' => $this->getPercentProfitable(),
            'average_trade_net_profit' => $this->getAverageTradeNetProfit(),
            'trade_count' => $this->getTradeCount(),
            'net_profit' => $this->getNetProfit()
        ];
    }

    public function getWinLossPercentage()
    {
        $win = $this->filterTrade('win')->count() / ($this->filterTrade('win')->count() + $this->filterTrade('lose')->count()) * 100;

        $data = [
            [
                'x' => 'Win',
                'y' => $win
            ],
            [
                'x' => 'Lose',
                'y' => 100 - $win
            ]
        ];
        $data = [$win, 100 - $win];

        return $data;
    }

    public function getRangeNetProfit()
    {
        $data = array();
        $rawDatas = $this->trades->whereIn('status', ['win', 'lose'])->groupBy(function ($item) {
            return $item->entry_date->format('d/m/y');
        });;

        foreach ($rawDatas as $key => $rawData) {
            $tempData = [
                'x' => $key,
                'y' => $this->netProfit($rawData)
            ];
            array_push($data, $tempData);
        }
        return $data;
    }

    public function getTotalBalanceGrowthPercentage()
    {
        $data = array();
        $rawDatas = $this->trades->whereIn('status', ['win', 'lose'])->groupBy(function ($item) {
            return $item->entry_date->format('d/m/y');
        });;

        foreach ($rawDatas as $key => $rawData) {
            $tempData = [
                'x' => $key,
                'y' => $this->balanceGrowthPercentage($this->balanceGrowth($rawData))
            ];
            array_push($data, $tempData);
        }
        return $data;
    }

    private function balanceGrowth($trades)
    {
        return $this->balance + $trades->sum('return');
    }

    private function balanceGrowthPercentage($balance)
    {
        $initial = $this->balance;
        if ($initial <= 0) {
            return 0;
        }
        return ($balance - $initial)  / $initial * 100;
    }

    private function netProfit($trades)
    {
        return $trades->whereIn('status', ['win', 'lose'])->sum('return');
    }

    private function filterTrade(string $status)
    {
        return $this->trades->where('status', $status);
    }
}
