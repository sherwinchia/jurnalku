<?php

namespace App\Http\Livewire\Admin\Setting;

use App\Http\Traits\Alert;
use App\Models\AppSetting;
use Livewire\Component;

class SettingForm extends Component
{
    public $section = "policy";

    public function changeSection(string $section)
    {
        $this->section = $section;
    }

    public function render()
    {
        return view('livewire.admin.setting.setting-form');
    }
}
