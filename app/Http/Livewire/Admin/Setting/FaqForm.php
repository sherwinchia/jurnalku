<?php

namespace App\Http\Livewire\Admin\Setting;

use App\Http\Traits\Alert;
use App\Models\AppSetting;
use Livewire\Component;

class FaqForm extends Component
{
    use Alert;

    public $faq;
    public $faqData;

    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    protected $rules = [
        'faqData.*.question' => 'required|string',
        'faqData.*.answer' => 'required|string',
    ];

    public function mount()
    {
        $this->faq = AppSetting::where('name', 'faq')->firstOrFail();
        $this->faqData = json_decode($this->faq->data, true);
    }

    public function add()
    {
        $data = array(
            'question' => '',
            'answer' => '',
        );
        array_push($this->faqData, $data);
        $this->emitSelf('refreshComponent');
    }

    public function delete($index)
    {
        unset($this->faqData[$index]);
    }

    public function submit()
    {
        $this->validate();
        try {
            $this->faq->update([
                'data' => json_encode($this->faqData)
            ]);
            return $this->alert([
                "type" => "success",
                "message" => "FAQ has been successfully updated."
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
        return view('livewire.admin.setting.faq-form');
    }
}
