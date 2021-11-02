<?php

namespace App\Http\Livewire\User\Setting;

use App\Helpers\UserSettings;
use App\Http\Traits\Alert;
use App\Models\Setting;
use Livewire\Component;

class SetupForm extends Component
{
    use Alert;

    public $setups;
    public $setup;

    public $modalId;
    public $modalVisible = false;

    protected $rules = [
        'setup' => 'required|regex:/^[\pL\s\-]+$/u'
    ];

    public function mount()
    {
        $this->setups = (array) UserSettings::all()->setups;
    }

    public function showModal(int $key)
    {
        $this->modalId = $key;
        $this->modalVisible = true;
    }

    public function delete()
    {
        unset($this->setups[$this->modalId]);

        $this->updateDatabase();

        $this->modalVisible = false;

        return $this->alert([
            "type" => "success",
            "message" => "Setup has been successfully removed."
        ]);
    }

    public function submit()
    {
        $this->validate();

        array_push($this->setups, $this->setup);

        $this->updateDatabase();

        $this->setup = '';

        return $this->alert([
            "type" => "success",
            "message" => "Setup has been successfully added."
        ]);
    }

    public function updateDatabase()
    {
        $settings = Setting::find(current_user()->id);
        $settings_data = json_decode($settings->data);
        $settings_data->setups = (object) $this->setups;

        $settings->data = json_encode($settings_data);
        $settings->save();
    }

    public function render()
    {
        return view('livewire.user.setting.setup-form');
    }
}
