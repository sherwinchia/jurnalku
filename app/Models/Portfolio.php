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
        return $this->balances->where('type','=','deposit')->sum('amount') - $this->balances->where('type','=','withdraw')->sum('amount') + $this->trades->sum('gain_loss');
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
