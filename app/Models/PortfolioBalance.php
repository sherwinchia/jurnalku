<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'type',
        'amount'
    ];

    public function portfolio()
    {
        return $this->belongsTo('App\Models\Portfolio');
    }
}
