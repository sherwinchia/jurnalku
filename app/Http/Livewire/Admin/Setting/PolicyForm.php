<?php

namespace App\Http\Livewire\Admin\Setting;

use App\Http\Traits\Alert;
use App\Models\AppSetting;
use Livewire\Component;

class PolicyForm extends Component
{
    use Alert;
    public $policy;
    public $policyData;

    protected $listeners = ["updateData"];

    protected $rules = [
        'policyData' => 'required'
    ];

    public function mount()
    {
        $this->policy = AppSetting::where('name', 'policy')->firstOrFail();
        $this->policyData = json_decode($this->policy->data);
    }

    public function updateData($data)
    {
        $this->policyData = $data;
        $this->submit();
    }

    public function submit()
    {
        $this->validate();
        try {
            $this->policy->update([
                'data' => json_encode($this->policyData)
            ]);
            return $this->alert([
                "type" => "success",
                "message" => "Policy has been successfully updated."
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
        return view('livewire.admin.setting.policy-form');
    }
}
