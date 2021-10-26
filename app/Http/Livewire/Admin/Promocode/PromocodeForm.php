<?php

namespace App\Http\Livewire\Admin\Promocode;

use App\Http\Traits\Alert;
use Livewire\Component;
use App\Models\Promocode;

class PromocodeForm extends Component
{
    use Alert;

    public $promocode, $unlimited_use;

    public $edit = false;

    public $button_text = "Create";

    protected $rules = [
        "promocode.code" => "required|unique:promocodes",
        "promocode.type" => "required",
        "promocode.value" => "required|numeric",
        "promocode.min_spending" => "required|numeric",
        "promocode.max_discount" => "required|numeric",
        "promocode.max_use_count" => "nullable|required_if:unlimited_use,limited",
        "promocode.first_time_user" => "required|boolean",
        "promocode.start_at" => "required|date",
        "promocode.expired_at" => "required|date",
        "promocode.active" => "required|boolean",
        "unlimited_use" => "required",
    ];

    public function mount($model = null)
    {

        if (isset($model)) {
            $this->edit = true;
            $this->promocode = $model;
            $this->button_text = "Update";

            if (isset($this->promocode->max_use_count)) {
                $this->unlimited_use = "Limited";
            } else {
                $this->unlimited_use = "Unlimited";
            }
        } else {
            $this->promocode = new Promocode();
        }
    }

    public function submit()
    {
        $this->validate();

        $this->promocode->save();

        if ($this->edit) {
            return $this->alert([
                "type" => "success",
                "message" => "Promocode has been successfully updated."
            ]);
        } else {
            $this->alert([
                "type" => "success",
                "message" => "Promocode has been successfully created.",
                "session" => true
            ]);
            return redirect()->route("admin.promocodes.edit", $this->promocode->id);
        }
    }

    public function render()
    {
        return view("livewire.admin.promocode.promocode-form");
    }
}
