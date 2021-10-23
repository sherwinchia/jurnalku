<?php

namespace App\Http\Livewire\Admin\Form;

use App\Http\Traits\Alert;
use Livewire\Component;
use App\Models\Subscription;

class SubscriptionForm extends Component
{
    use Alert;

    public $subscription;

    public $edit = false;

    public $buttonText = "Create";

    protected $rules = ["subscription.user_id" => "required",
                "subscription.type" => "required",
                "subscription.expired_at" => "required",
                "subscription.package_id" => "required"
                ];

    public function mount($model = null)
    {
        
        if (isset($model)) {
            $this->edit = true;
            $this->subscription = $model;
            $this->buttonText = "Update";
        } else {
            $this->subscription = new Subscription();
        }
    }

    public function submit()
    {
        $this->validate();

        $this->subscription->save();

        if ($this->edit) {
            return $this->alert([
                "type" => "success",
                "message" => "Subscription has been successfully updated."
            ]);
        } else {
            $this->alert([
                "type" => "success",
                "message" => "Subscription has been successfully created.",
                "session" => true
            ]);
            return redirect()->route("admin.subscriptions.edit", $this->subscription->id);
        }
    }

    public function render()
    {
        return view("livewire.admin.form.subscription-form");
    }
}