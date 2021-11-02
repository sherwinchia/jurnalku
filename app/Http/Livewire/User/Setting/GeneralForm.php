<?php

namespace App\Http\Livewire\User\Setting;

use App\Helpers\UserSettings;
use App\Http\Traits\Alert;
use App\Models\Setting;
use Livewire\Component;

class GeneralForm extends Component
{
    use Alert;

    public $generals;

    protected $rules = [
        'generals.currency' => 'required|string|min:1|max:10',
        'generals.decimals' => 'required|integer|min:0|max:6',
        'generals.public_page' => 'nullable|boolean',
    ];

    public function mount()
    {
        $this->generals = (array) UserSettings::all()->generals;
    }

    public function submit()
    {
        $this->validate();

        $settings = Setting::find(current_user()->id);

        $settings_data = json_decode($settings->data);
        $settings_data->generals = (object) $this->generals;

        $settings->data = json_encode($settings_data);
        $settings->save();

        $this->alert([
            "type" => "success",
            "message" => "Settings has been successfully updated."
        ]);
    }

    public function render()
    {
        return view('livewire.user.setting.general-form');
    }
}
