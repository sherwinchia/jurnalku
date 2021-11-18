<?php

namespace App\Models;

use App\Services\TradeAnalyticsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $tradeAnalyticsService;

    protected $fillable = [
        'user_id',
        'name',
        'currency',
        'balance'
    ];

    public function getAnalyticsAttribute()
    {
        if (!isset($this->tradeAnalyticsService)) {
            $this->tradeAnalyticsService = app(TradeAnalyticsService::class, ["trades" => $this->trades, "balance" => $this->balance]);
        }
        return $this->tradeAnalyticsService;
    }

    public function trades()
    {
        return $this->hasMany('App\Models\Trade');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
