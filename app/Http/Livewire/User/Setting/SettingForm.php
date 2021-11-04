<?php

namespace App\Http\Livewire\User\Setting;

use Livewire\Component;

class SettingForm extends Component
{

    public $section = "balance";

    public function changeSection(string $section)
    {
        $this->section = $section;
    }

    public function render()
    {
        return view('livewire.user.setting.setting-form');
    }
}
