<?php

namespace App\Services;

use App\Models\Transaction;
use stdClass;

class AppAnalyticsService
{
    private $transactions;
    private $users;

    public function __construct($transactions, $users)
    {
        $this->transactions = $transactions;
        $this->users = $users;
    }

    public function getRevenueData()
    {
        $data = array();
        $rawDatas = $this->transactions->groupBy(function ($item) {
            return format_string_date($item->updated_at, 'm/y');
        });

        foreach ($rawDatas as $key => $rawData) {
            $tempData = [
                'x' => $key,
                'y' => $rawData->sum('net_total')
            ];
            array_push($data, $tempData);
        }
        return $data;
    }

    public function getUsersData()
    {
        return [
            'total_users' => $this->getTotalUsers(),
            'monthly_users' => $this->getMonthlyUsers(),
            'daily_users' => $this->getDailyUsers(),
            'latest_users' => $this->getLatestUsers()
        ];
    }

    public function getTransactionsData()
    {
        return [
            'total_transactions' => $this->getTotalTransactions(),
            'monthly_transactions' => $this->getMonthlyTransactions(),
            'daily_transactions' => $this->getDailyTransactions(),
            'latest_transactions' => $this->getLatestTransactions()
        ];
    }

    public function getTotalUsers()
    {
        if (isset($this->users)) return $this->users->count();
    }

    public function getMonthlyUsers()
    {
        if (isset($this->users)) return $this->users->where('created_at', '<=', now()->endOfMonth())->where('created_at', '>=', now()->startOfMonth())->count();
    }

    public function getDailyUsers()
    {
        if (isset($this->users)) return $this->users->where('created_at', '<=', now()->endOfDay())->where('created_at', '>=', now()->startOfDay())->count();
    }

    public function getLatestUsers()
    {
        if (isset($this->users)) return $this->users->take(5);
    }

    public function getTotalTransactions()
    {
        if (isset($this->transactions)) return $this->transactions->count();
    }

    public function getMonthlyTransactions()
    {
        if (isset($this->transactions)) return $this->transactions->where('created_at', '<=', now()->endOfMonth())->where('created_at', '>=', now()->startOfMonth())->count();
    }

    public function getDailyTransactions()
    {
        if (isset($this->transactions)) return $this->transactions->where('created_at', '<=', now()->endOfDay())->where('created_at', '>=', now()->startOfDay())->count();
    }

    public function getLatestTransactions()
    {
        // if (isset($this->transactions)) return $this->transactions->take(5);
        return Transaction::latest()->get(['id', 'net_total', 'merchant_ref', 'updated_at', 'status'])->take(5);
    }

    public function getTotalRevenue()
    {
        return $this->transactions->sum('net_total');
    }
}
