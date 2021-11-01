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
        'instrument_id',
        'quantity',
        'setup_id',
        'mistake_id',
        'entry_price',
        'exit_price',
        'take_profit',
        'stop_loss',
        'fees',
        'gain_loss',
        'favorite',
        'note'
    ];

    public function portfolio()
    {
        return $this->belongsTo('App\Models\Portofolio');
    }

    public function instrument()
    {
        return $this->belongsTo('App\Models\Instrument');
    }

    public function setup()
    {
        return $this->belongsTo('App\Models\Setup');
    }

    public function mistake()
    {
        return $this->belongsTo('App\Models\Mistake');
    }
}
