<?php

namespace App\Http\Livewire\User\Setting;

use App\Helpers\UserSettings;
use App\Http\Traits\Alert;
use App\Models\Setting;
use Livewire\Component;

class InstrumentForm extends Component
{
    use Alert;

    public $instruments;
    public $instrument;

    public $modalId;
    public $modalVisible = false;

    protected $rules = [
        'instrument' => 'required|alpha'
    ];

    public function mount()
    {
        $this->instruments = (array) UserSettings::all()->instruments;
    }

    public function showModal(int $key)
    {
        $this->modalId = $key;
        $this->modalVisible = true;
    }

    public function delete()
    {
        unset($this->instruments[$this->modalId]);

        $this->updateDatabase();

        $this->modalVisible = false;

        return $this->alert([
            "type" => "success",
            "message" => "Instrument has been successfully removed."
        ]);
    }

    public function submit()
    {
        $this->validate();

        array_push($this->instruments, strtoupper($this->instrument));

        $this->updateDatabase();

        $this->instrument = '';

        return $this->alert([
            "type" => "success",
            "message" => "Instrument has been successfully added."
        ]);
    }

    public function updateDatabase()
    {
        $settings = Setting::find(current_user()->id);
        $settings_data = json_decode($settings->data);
        $settings_data->instruments = (object) $this->instruments;

        $settings->data = json_encode($settings_data);
        $settings->save();
    }

    public function render()
    {
        return view('livewire.user.setting.instrument-form');
    }
}
