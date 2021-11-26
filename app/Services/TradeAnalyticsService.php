<?php

namespace App\Services;

use App\Models\Portfolio;
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
        $winCount = $this->filterTrade('win')->count();
        $winLoseCount = $this->trades->whereIn('status', ['win', 'lose'])->count();

        if ($winCount < 1 || $winLoseCount < 1) {
            return 0;
        }

        return $winCount / $winLoseCount * 100;
    }

    public function getAverageTradeNetProfit()
    {
        $winLoseCount = $this->trades->whereIn('status', ['win', 'lose'])->count();

        if ($winLoseCount < 1) {
            return 0;
        }
        return $this->getNetProfit() / $winLoseCount;
    }

    public function getAverageWinner()
    {
        $sum = $this->filterTrade('win')->sum('return');
        $count = $this->filterTrade('win')->count();
        // dd($sum, $count);
        if ($count < 1) {
            return 0;
        }
        return $sum / $count;
    }

    public function getAverageLoser()
    {
        $sum = $this->filterTrade('lose')->sum('return');
        $count = $this->filterTrade('lose')->count();
        // dd($sum, $count);
        if ($count == 0) {
            return 0;
        }
        return $sum / $count;
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
            'net_profit' => $this->getNetProfit(),
            'longest_win_streaks' => $this->getLongestWinStreaks(),
            'longest_lose_streaks' => $this->getLongestLoseStreaks(),
            'average_winner' => $this->getAverageWinner(),
            'average_loser' => $this->getAverageLoser(),
        ];
    }

    public function getWinLossPercentage()
    {
        $winCount = $this->filterTrade('win')->count();
        $loseCount = $this->filterTrade('lose')->count();
        if ($winCount + $loseCount == 0) {
            return 0;
        }
        $win = $winCount / ($winCount + $loseCount) * 100;

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
        $trades = $this->trades->whereIn('status', ['win', 'lose']);
        $rawDatas = $trades->groupBy(function ($item) {
            return format_string_date($item->entry_date, 'd/m/y');
        });;

        if ($rawDatas->count() > 30) {
            $rawDatas = $trades->groupBy(function ($item) {
                return format_string_date($item->entry_date, 'm/y');
            });;
        }

        foreach ($rawDatas as $key => $rawData) {
            $tempData = [
                'x' => $key,
                'y' => $this->netProfit($rawData)
            ];
            array_push($data, $tempData);
        }
        return $data;
    }

    public function getLongestWinStreaks()
    {
        $currentStreak = 0;
        $longestStreak = 0;

        foreach ($this->trades->whereIn('status', ['win', 'lose']) as $trade) {
            if (!($trade->status == "win")) {
                $currentStreak = 0;
                continue;
            }
            $currentStreak++;
            if ($currentStreak > $longestStreak) {
                $longestStreak = $currentStreak;
            }
        }
        return $longestStreak;
    }

    public function getLongestLoseStreaks()
    {
        $currentStreak = 0;
        $longestStreak = 0;

        foreach ($this->trades->whereIn('status', ['win', 'lose']) as $trade) {
            if (!($trade->status == "lose")) {
                $currentStreak = 0;
                continue;
            }
            $currentStreak++;
            if ($currentStreak > $longestStreak) {
                $longestStreak = $currentStreak;
            }
        }

        return $longestStreak;
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
