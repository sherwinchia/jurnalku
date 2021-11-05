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
        'currency'
    ];

    public function getCalculateBalanceAttribute()
    {
        return $this->balances->where('type','=','deposit')->sum('amount') - $this->balances->where('type','=','withdraw')->sum('amount') + $this->trades->sum('return');
    }


    public function getCalculateGrowthPercentageAttribute()
    {
        $initial = $this->balances->where('type','=','deposit')->sum('amount') - $this->balances->where('type','=','withdraw')->sum('amount');
        if ($initial === 0) {
            return 0;
        }
        return ($this->calculate_balance - $initial) / $initial * 100;
    }

    public function getTotalWinAttribute()
    {
        return $this->trades->where('status','=','win')->count();
    }
    public function getTotalLoseAttribute()
    {
        return $this->trades->where('status','=','lose')->count();
    }

    public function trades()
    {
        return $this->hasMany('App\Models\Trade');
    }

    public function balances()
    {
        return $this->hasMany('App\Models\PortfolioBalance');
    }
}
