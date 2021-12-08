<?php

namespace App\Http\Livewire\Admin\Package;

use App\Http\Traits\Alert;
use Livewire\Component;
use App\Models\Package;

class PackageForm extends Component
{
    use Alert;

    public $package;

    public $edit = false;

    public $buttonText = "Create";

    protected $rules = [
        "package.name" => "required|string",
        "package.description" => "required|string",
        "package.price" => "required|numeric|min:0",
        "package.value" => "required|integer",
        "package.type" => "required",
        "package.active" => "boolean",
        "package.display" => "boolean"
    ];

    protected $listeners = [
        'updateData'
    ];

    public function mount($model = null)
    {
        if (isset($model)) {
            $this->edit = true;
            $this->package = $model;
            $this->buttonText = "Update";
        } else {
            $this->package = new Package();
            $this->package->active = true;
        }
    }

    public function updateData($data)
    {
        $this->package->description = $data;
        $this->submit();
    }

    public function submit()
    {
        $this->validate();

        $this->package->save();

        if ($this->edit) {
            return $this->alert([
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
        return view("livewire.admin.package.package-form");
    }
}
