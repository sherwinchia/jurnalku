<?php

namespace App\Http\Livewire\User\Setting;

use App\Helpers\UserSettings;
use App\Http\Traits\Alert;
use App\Models\Setting;
use Livewire\Component;

class BalanceForm extends Component
{
    use Alert;

    public $balances;
    public $generals;

    public $type;
    public $amount;

    protected $rules = [

    ];

    public function mount()
    {
        $user_settings = UserSettings::all();
        $this->balances = (array) $user_settings->balances;
        $this->generals = (array) $user_settings->generals;
    }

    public function submit()
    {
        $this->validate();

        $settings = Setting::find(current_user()->id);

        $this->alert([
            "type" => "success",
            "message" => "Settings has been successfully updated."
        ]);
    }

    public function render()
    {
        return view('livewire.user.setting.balance-form');
    }
}
