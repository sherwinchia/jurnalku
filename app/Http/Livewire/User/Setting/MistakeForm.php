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
    public $deleteModal = false;
    public $formModal = false;
    public $edit = false;

    protected $rules = [
        'mistake' => 'required|regex:/^[\w\-\s]+$/'
    ];

    public function mount()
    {
        $this->mistakes = (array) UserSettings::all()->mistakes;
    }

    public function showBlankFormModal()
    {
        $this->formModal = true;
    }

    public function showFormModal($key)
    {
        $this->mistake = $this->mistakes[$key];
        $this->modalId = $key;
        $this->edit = true;
        $this->formModal = true;
    }

    public function submit()
    {
        $this->validate();

        if ($this->edit) {
            $this->mistakes[$this->modalId] = $this->mistake;
            $message = "Mistake has been successfully updated.";
        } else {
            array_push($this->mistakes, $this->mistake);
            $message = "Mistake has been successfully added.";
        }

        $this->updateDatabase();

        $this->mistake = '';
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
        unset($this->mistakes[$this->modalId]);

        $this->updateDatabase();

        $this->deleteModal = false;

        return $this->alert([
            "type" => "success",
            "message" => "Mistake has been successfully removed."
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
