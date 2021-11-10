<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'currency',
        'balance'
    ];

    public function getCalculateBalanceAttribute()
    {
        return $this->balance + $this->trades->sum('return');
    }

    public function getCalculateGrowthPercentageAttribute()
    {
        $initial = $this->balance;
        if ($initial <= 0) {
            return 0;
        }
        return ($this->calculate_balance - $initial)  / $initial * 100;
    }

    public function getTotalWinAttribute()
    {
        return $this->trades->where('status', '=', 'win')->count();
    }
    public function getTotalLoseAttribute()
    {
        return $this->trades->where('status', '=', 'lose')->count();
    }

    public function getTotalTradesAttribute()
    {
        return $this->trades->count();
    }

    public function getWinPercentageAttribute()
    {
        return $this->total_win / ($this->total_win + $this->total_lose) * 100 . '%';
    }

    public function getLosePercentageAttribute()
    {
        return $this->total_lose / ($this->total_win + $this->total_lose) * 100 . '%';
    }

    public function trades()
    {
        return $this->hasMany('App\Models\Trade');
    }
}
