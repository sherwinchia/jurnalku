<?php

namespace App\Http\Livewire\Admin\Form;

use Livewire\Component;

use App\Models\Subscription;

class SubscriptionForm extends Component
{
    public $subscription;

    public  $expired_at, $type, $user_id;
    public $edit;

    public $buttonText = "Create";

    protected $rules = ["expired_at" => "required",
                "type" => "required",
                "user_id" => "required"
                ];

    public function mount($model = null)
    {
        $this->edit = isset($model) ? true : false;

        if (isset($model)) {
            $this->subscription = $model;

            $this->buttonText = "Update";
        }
    }

    public function submit()
    {
        if (!$this->edit) {
            $data = $this->validate($this->rules);
        }

        if ($this->edit) {
            $data = null;
        }

        if ($this->edit) {
            $this->user->update($data);
            session()->flash("success", "Subscription successfully updated.");
        } else {
            $this->user = User::create($data);
            session()->flash("success", "Subscription successfully created.");
        }
        return redirect()->route("admin.subscriptions.edit", $this->subscription->id);
    }

    public function render()
    {
        return view("livewire.admin.form.subscription-form");
    }
}