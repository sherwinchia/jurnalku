<?php

namespace App\Http\Livewire\Admin\Setting;

use App\Http\Traits\Alert;
use App\Models\AppSetting;
use Livewire\Component;

class TermsForm extends Component
{
    use Alert;
    public $terms;
    public $termsData;

    protected $listeners = ["updateData"];

    protected $rules = [
        'termsData' => 'required'
    ];

    public function mount()
    {
        $this->terms = AppSetting::where('name', 'terms')->firstOrFail();
        $this->termsData = json_decode($this->terms->data);
    }

    public function updateData($data)
    {
        $this->termsData = $data;
        $this->submit();
    }

    public function submit()
    {
        $this->validate();
        try {
            $this->terms->update([
                'data' => json_encode($this->termsData)
            ]);
            return $this->alert([
                "type" => "success",
                "message" => "Terms has been successfully updated."
            ]);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }
    public function render()
    {
        return view('livewire.admin.setting.terms-form');
    }
}
