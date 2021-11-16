<?php

namespace App\Http\Livewire\User\Billing;

use App\Models\Package;
use Livewire\Component;

class BillingIndex extends Component
{
    public $section = "topup";
    public $merchant_ref;

    public function mount()
    {
        $section = request()->query('section');

        if (isset($section)) {
            $this->section = $section;
        }

        $merchant_ref = request()->query('merchant_ref');

        if (isset($merchant_ref)) {
            $this->merchant_ref = $merchant_ref;
        }
    }

    public function changeSection(string $section)
    {
        $this->section = $section;
    }

    public function render()
    {
        return view('livewire.user.billing.billing-index');
    }
}
