<?php

namespace App\Http\Livewire\User\Billing;

use App\Models\Package;
use Livewire\Component;

class BillingIndex extends Component
{
    public $section = "topup";

    public function changeSection(string $section)
    {
        $this->section = $section;
    }

    public function render()
    {
        return view('livewire.user.billing.billing-index');
    }
}
