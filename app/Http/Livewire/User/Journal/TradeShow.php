<?php

namespace App\Http\Livewire\User\Journal;

use Livewire\Component;

class TradeShow extends Component
{
    public $trade;

    public function render()
    {
        return view('livewire.user.journal.trade-show');
    }
}
