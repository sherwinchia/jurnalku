<?php

namespace App\Http\Livewire\Admin\Transaction;

use Livewire\Component;

class TransactionShow extends Component
{
    public $transaction;

    public function mount($model)
    {
        $this->transaction = $model;
    }

    public function render()
    {
        return view('livewire.admin.transaction.transaction-show');
    }
}
