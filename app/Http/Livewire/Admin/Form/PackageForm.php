<?php

namespace App\Http\Livewire\Admin\Form;

use Livewire\Component;

use App\Models\Package;

class PackageForm extends Component
{
    public $package;

    public $edit = false;

    public $buttonText = "Create";

    protected $rules = ["package.name" => "required",
                "package.description" => "required",
                "package.price" => "required",
                "package.duration" => "required"
                ];

    public function mount($model = null)
    {
        
        if (isset($model)) {
            $this->edit = true;
            $this->package = $model;
            $this->buttonText = "Update";
        } else {
            $this->package = new Package();
        }
    }

    public function submit()
    {
        $this->validate();

        $this->package->save();

        if ($this->edit) {
            session()->flash("success", "Package successfully updated.");
        } else {
            session()->flash("success", "Package successfully created.");
        }
        return redirect()->route("admin.packages.edit", $this->package->id);
    }

    public function render()
    {
        return view("livewire.admin.form.package-form");
    }
}