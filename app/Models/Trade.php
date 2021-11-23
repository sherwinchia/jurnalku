<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillables = [
        'portfolio_id',
        'entry_date',
        'exit_date',
        'instrument',
        'quantity',
        'setup',
        'mistake',
        'entry_price',
        'exit_price',
        'take_profit',
        'stop_loss',
        'entry_fee',
        'exit_fee',
        'return',
        'favorite',
        'note',
        'status',
        'return_percentage'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function portfolio()
    {
        return $this->belongsTo('App\Models\Portfolio');
    }

    public function getCalculatePercentageAttribute()
    {
        $initial = $this->entry_price * $this->quantity + $this->entry_fee + $this->exit_fee;
        return ($this->exit_price * $this->quantity - $initial) / $initial * 100;
    }

    public function getCalculateNetAttribute()
    {
        $initial = $this->entry_price * $this->quantity + $this->entry_fee + $this->exit_fee;
        return $this->exit_price * $this->quantity - $initial;
    }
}
