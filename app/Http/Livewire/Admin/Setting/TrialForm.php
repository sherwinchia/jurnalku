<?php

namespace App\Http\Livewire\Admin\Setting;

use App\Http\Traits\Alert;
use App\Models\AppSetting;
use Livewire\Component;

class TrialForm extends Component
{
    use Alert;
    // Trial 
    public $trial;
    public $trialActive;
    public $trialDuration;
    public $maxPortfolio;

    public function mount()
    {
        $this->trial = AppSetting::where('name', 'trial')->firstOrFail();
        $trialData = json_decode($this->trial->data, true);
        $this->trialActive = $trialData['active'];
        $this->trialDuration = $trialData['duration'];
        $this->maxPortfolio = $trialData['max_portfolio'];
    }

    public function submit()
    {
        $rawData = $this->validate([
            'trialActive' => 'required|boolean',
            'trialDuration' => 'required|numeric|min:0',
            'maxPortfolio' => 'required|numeric|min:1'
        ]);

        $data = [
            'active' => $rawData['trialActive'],
            'duration' => $rawData['trialDuration'],
            'max_portfolio' => $rawData['maxPortfolio']
        ];

        try {
            $this->trial->update([
                'data' => json_encode($data)
            ]);
            return $this->alert([
                "type" => "success",
                "message" => "Trial has been successfully updated."
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
        return view('livewire.admin.setting.trial-form');
    }
}
