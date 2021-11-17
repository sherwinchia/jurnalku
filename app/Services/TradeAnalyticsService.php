<?php

namespace App\Services;

class TradeAnalyticsService
{
    private $trades;
    private $totalTrades;
    private $totalWin;
    private $totalLose;

    public function __construct($trades)
    {
        $this->trades = $trades;
    }

    public function getNetProfit()
    {
    }

    public function getProfitFactor()
    {
    }

    public function getPercentProfitable()
    {
    }

    public function getAverageTradeNetProfit()
    {
    }

    public function getMaximumDrawdown()
    {
    }

    public function getBottomLine()
    {
    }

    public function getTotalWin()
    {
        return $this->trades->where('status', '=', 'win')->count();
    }

    public function getTotalLose()
    {
        return $this->trades->where('status', '=', 'lose')->count();
    }

    public function getTotalTrade()
    {
        return $this->trades->count();
    }
}
