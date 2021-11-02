<?php

namespace App\Http\Livewire\User\Setting;

use App\Helpers\UserSettings;
use App\Http\Traits\Alert;
use App\Models\Setting;
use Livewire\Component;

class MistakeForm extends Component
{
    use Alert;

    public $mistakes;
    public $mistake;

    public $modalId;
    public $modalVisible = false;

    protected $rules = [
        'mistake' => 'required|regex:/^[\pL\s\-]+$/u'
    ];

    public function mount()
    {
        $this->mistakes = (array) UserSettings::all()->mistakes;
    }

    public function showModal(int $key)
    {
        $this->modalId = $key;
        $this->modalVisible = true;
    }

    public function delete()
    {
        unset($this->mistakes[$this->modalId]);

        $this->updateDatabase();

        $this->modalVisible = false;

        return $this->alert([
            "type" => "success",
            "message" => "Mistake has been successfully removed."
        ]);
    }

    public function submit()
    {
        $this->validate();

        array_push($this->mistakes, $this->mistake);

        $this->updateDatabase();

        $this->mistake = '';

        return $this->alert([
            "type" => "success",
            "message" => "Mistake has been successfully added."
        ]);
    }

    public function updateDatabase()
    {
        $settings = Setting::find(current_user()->id);
        $settings_data = json_decode($settings->data);
        $settings_data->mistakes = (object) $this->mistakes;

        $settings->data = json_encode($settings_data);
        $settings->save();
    }

    public function render()
    {
        return view('livewire.user.setting.mistake-form');
    }
}
