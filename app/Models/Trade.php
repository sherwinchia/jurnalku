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
        'gain_loss',
        'favorite',
        'note',
        'status'
    ];

    public function portfolio()
    {
        return $this->belongsTo('App\Models\Portofolio');
    }

    public function getCalculateTotalAttribute()
    {
        return $this->exit_price - $this->entry_price - $this->entry_fee - $this->exit_fee;
    }
}
