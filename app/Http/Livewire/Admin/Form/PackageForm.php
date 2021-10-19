<?php

namespace App\Http\Livewire\Admin\Form;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;

use App\Models\Package;

class UserForm extends Component
{
    public $package;

    public  $name, $description, $price, $duration;
    public $edit;

    public $buttonText = "Create";

    protected $rules = ["name" => "required",
                "description" => "required",
                "price" => "required",
                "duration" => "required"
                ];

    public function mount($model = null)
    {
        $this->edit = isset($model) ? true : false;

        if (isset($model)) {
            $this->package = $model;

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
            session()->flash("success", "Package successfully updated.");
        } else {
            $this->user = User::create($data);
            session()->flash("success", "Package successfully created.");
        }
        return redirect()->route("admin.packages.edit", $this->package->id);
    }

    public function render()
    {
        return view("livewire.admin.form.package-form");
    }
}