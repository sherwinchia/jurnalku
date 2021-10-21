<?php

namespace App\Http\Livewire\Admin\Form;

use App\Http\Traits\Alert;
use Livewire\Component;
use App\Models\Package;

class PackageForm extends Component
{
    use Alert;

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
            $this->alert([
                "type" => "success",
                "message" => "Package has been successfully updated."
            ]);
        } else {
            $this->alert([
                "type" => "success",
                "message" => "Package has been successfully created.",
                "session" => true
            ]);
            return redirect()->route("admin.packages.edit", $this->package->id);
        }
    }

    public function render()
    {
        return view("livewire.admin.form.package-form");
    }
}