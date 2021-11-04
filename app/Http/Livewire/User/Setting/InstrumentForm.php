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
    public $deleteModal = false;
    public $formModal = false;
    public $edit = false;

    protected $rules = [
        'instrument' => 'required|alpha'
    ];

    public function mount()
    {
        $this->instruments = (array) UserSettings::all()->instruments;
    }

    public function showBlankFormModal()
    {
        $this->formModal = true;
    }

    public function showFormModal($key)
    {
        $this->instrument = $this->instruments[$key];
        $this->modalId = $key;
        $this->edit = true;
        $this->formModal = true;
    }

    public function submit()
    {
        $this->validate();

        if ($this->edit) {
            $this->instruments[$this->modalId] = strtoupper($this->instrument);
            $message = "Instrument has been successfully updated.";
        } else {
            array_push($this->instruments, strtoupper($this->instrument));
            $message = "Instrument has been successfully added.";
        }

        $this->updateDatabase();

        $this->instrument = '';
        $this->formModal = false;
        $this->edit = false;

        return $this->alert([
            "type" => "success",
            "message" => $message
        ]);
    }

    public function showDeleteModal(int $key)
    {
        $this->modalId = $key;
        $this->deleteModal = true;
    }

    public function delete()
    {
        unset($this->instruments[$this->modalId]);

        $this->updateDatabase();

        $this->deleteModal = false;

        return $this->alert([
            "type" => "success",
            "message" => "Instrument has been successfully removed."
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
