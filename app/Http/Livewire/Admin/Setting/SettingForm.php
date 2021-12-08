<?php

namespace App\Http\Livewire\Admin\Setting;

use App\Http\Traits\Alert;
use App\Models\AppSetting;
use Livewire\Component;

class SettingForm extends Component
{
    use Alert;
    // Trial 
    public $trial;
    public $trialActive;
    public $trialDuration;

    // Promotion banner
    public $promotionBanner;
    public $promotionBannerActive;
    public $promotionBannerTextColor;
    public $promotionBannerBackgroundColor;
    public $promotionBannerHtml;


    public function mount()
    {
        $this->trial = AppSetting::where('name', 'trial')->first();
        $trialData = json_decode($this->trial->data, true);
        $this->trialActive = $trialData['active'];
        $this->trialDuration = $trialData['duration'];

        $this->promotionBanner = AppSetting::where('name', 'promotion_banner')->first();
        $promotionBannerData = json_decode($this->promotionBanner->data, true);
        $this->promotionBannerActive = $promotionBannerData['active'];
        $this->promotionBannerTextColor = $promotionBannerData['text-color'];
        $this->promotionBannerBackgroundColor = $promotionBannerData['background-color'];
        $this->promotionBannerHtml = $promotionBannerData['html'];
    }

    public function submitTrial()
    {
        $rawData = $this->validate([
            'trialActive' => 'required|boolean',
            'trialDuration' => 'required|numeric|min:0',
        ]);

        $data = [
            'active' => $rawData['trialActive'],
            'duration' => $rawData['trialDuration']
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

    public function submitPromotionBanner()
    {
        $rawData = $this->validate([
            'promotionBannerActive' => 'required|boolean',
            'promotionBannerTextColor' => 'required',
            'promotionBannerBackgroundColor' => 'required',
            'promotionBannerHtml' => 'required',
        ]);

        $data = [
            'active' => $rawData['promotionBannerActive'],
            'text-color' => $rawData['promotionBannerTextColor'],
            'background-color' => $rawData['promotionBannerBackgroundColor'],
            'html' => $rawData['promotionBannerHtml']
        ];

        try {
            $this->promotionBanner->update([
                'data' => json_encode($data)
            ]);
            return $this->alert([
                "type" => "success",
                "message" => "Promotion banner has been successfully updated."
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
        return view('livewire.admin.setting.setting-form');
    }
}
