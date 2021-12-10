<?php

namespace App\Http\Livewire\Admin\Setting;

use App\Http\Traits\Alert;
use App\Models\AppSetting;
use Livewire\Component;

class BannerForm extends Component
{
    use Alert;
    public $promotionBanner;
    public $promotionBannerActive;
    public $promotionBannerTextColor;
    public $promotionBannerBackgroundColor;
    public $promotionBannerHtml;

    public function mount()
    {
        $this->promotionBanner = AppSetting::where('name', 'promotion_banner')->firstOrFail();
        $promotionBannerData = json_decode($this->promotionBanner->data, true);
        $this->promotionBannerActive = $promotionBannerData['active'];
        $this->promotionBannerTextColor = $promotionBannerData['text-color'];
        $this->promotionBannerBackgroundColor = $promotionBannerData['background-color'];
        $this->promotionBannerHtml = $promotionBannerData['html'];
    }

    public function submit()
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
        return view('livewire.admin.setting.banner-form');
    }
}
