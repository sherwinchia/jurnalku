<?php

namespace App\Http\Livewire\User\Trade;

use App\Models\Trade;
use Livewire\Component;

class TradeShow extends Component
{
    public Trade $trade;
    public $modal = true;
    public function render()
    {
        return view('livewire.user.trade.trade-show');
    }
}
