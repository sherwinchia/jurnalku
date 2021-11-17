<?php

namespace App\Http\Livewire\Admin\Promocode;

use App\Http\Traits\Alert;
use Livewire\Component;
use App\Models\Promocode;

class PromocodeForm extends Component
{
    use Alert;

    public $promocode;

    public $limited_use = false;
    public $discount_limit = false;
    public $min_spending = false;

    public $edit = false;

    public $button_text = "Create";

    protected $rules = [
        "promocode.code" => "required|unique:promocodes,code|alpha_num",
        "promocode.type" => "required",
        "promocode.value" => "required|numeric|min:0",
        "promocode.min_spending" => "nullable|required_if:min_spending,true|numeric|min:0",
        "promocode.max_discount" => "nullable|required_if:discount_limit,true|numeric|min:0",
        "promocode.max_use_count" => "nullable|required_if:limited_use,true|numeric",
        "promocode.first_time_user" => "nullable|boolean",
        "promocode.start_at" => "required|date",
        "promocode.expired_at" => "required|date",
        "promocode.active" => "nullable|boolean",
    ];

    public function mount($model = null)
    {

        if (isset($model)) {
            $this->edit = true;
            $this->promocode = $model;
            $this->button_text = "Update";
            $this->promocode->start_at = date_to_datetime_local($this->promocode->start_at);
            $this->promocode->expired_at = date_to_datetime_local($this->promocode->expired_at);

            if (isset($this->promocode->max_use_count)) {
                $this->limited_use = true;
            }
            if (isset($this->promocode->min_spending)) {
                $this->min_spending = true;
            }
            if ($this->promocode->type == "percentage" && isset($this->promocode->max_discount)) {
                $this->discount_limit = true;
            }
        } else {
            $this->promocode = new Promocode();
            $this->promocode->active = true;
        }
    }

    public function generateCode()
    {
        $this->promocode->code = get_unique_promocode(10);
    }

    public function codeInput()
    {
        $this->promocode->code = strtoupper($this->promocode->code);
    }

    public function submit()
    {
        if ($this->edit) {
            $this->validate([
                "promocode.code" => "required|unique:promocodes,code,{$this->promocode->id}|alpha_num",
                "promocode.type" => "required",
                "promocode.value" => "required|numeric|min:0",
                "promocode.min_spending" => "nullable|required_if:min_spending,true|numeric|min:0",
                "promocode.max_discount" => "nullable|required_if:discount_limit,true|numeric|min:0",
                "promocode.max_use_count" => "nullable|required_if:limited_use,true|numeric",
                "promocode.first_time_user" => "nullable|boolean",
                "promocode.start_at" => "required|date",
                "promocode.expired_at" => "required|date",
                "promocode.active" => "nullable|boolean",
            ]);
        } else {
            $this->validate();
        }

        if ($this->limited_use === false) {
            $this->promocode->max_use_count = null;
        }
        if ($this->discount_limit === false) {
            $this->promocode->max_discount = null;
        }
        if ($this->min_spending === false) {
            $this->promocode->min_spending = 0;
        }
        if ($this->promocode->type == "fixed") {
            $this->promocode->max_discount = (int) $this->promocode->value;
        }

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
