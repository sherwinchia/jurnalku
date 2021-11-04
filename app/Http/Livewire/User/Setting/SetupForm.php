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
    public $deleteModal = false;
    public $formModal = false;
    public $edit = false;

    protected $rules = [
        'setup' => 'required|regex:/^[\w\-\s]+$/'
    ];

    public function mount()
    {
        $this->setups = (array) UserSettings::all()->setups;
    }

    public function showBlankFormModal()
    {
        $this->formModal = true;
    }

    public function showFormModal($key)
    {
        $this->setup = $this->setups[$key];
        $this->modalId = $key;
        $this->edit = true;
        $this->formModal = true;
    }

    public function submit()
    {
        $this->validate();

        if ($this->edit) {
            $this->setups[$this->modalId] = $this->setup;
            $message = "Setup has been successfully updated.";
        } else {
            array_push($this->setups, $this->setup);
            $message = "Setup has been successfully added.";
        }

        $this->updateDatabase();

        $this->setup = '';
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
        unset($this->setups[$this->modalId]);

        $this->updateDatabase();

        $this->deleteModal = false;

        return $this->alert([
            "type" => "success",
            "message" => "Setup has been successfully removed."
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
