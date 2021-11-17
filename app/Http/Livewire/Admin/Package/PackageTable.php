<?php

namespace App\Http\Livewire\Admin\Package;

use App\Http\Traits\Alert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Package;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class PackageTable extends Component
{
    use WithPagination, Alert;
    protected $listeners = ['tableRefresh' => '$refresh'];
    public $search = "";
    public $sortField = "id";
    public $sortAsc = true;
    public $perPage = 10;
    public $modalVisible = false;
    public $encryptedId;
    public $actions = ["search", "create", "edit", "delete"];
    public $columns = [
        [
            "name" => "ID",
            "field" => "id",
            "sortable" => true,
        ],
        [
            "name" => "Name",
            "field" => "name",
            "sortable" => true,
        ],
        [
            "name" => "Price",
            "field" => "price",
            "sortable" => true,
            "format" => ["decimal_to_human", "Rp"]
        ],
        [
            "name" => "Type",
            "field" => "type",
            "sortable" => true,
            "format" => ["ucfirst"]
        ],
        [
            "name" => "Value",
            "field" => "value",
            "sortable" => true,
        ],
        [
            "name" => "Active",
            "field" => "active",
            "sortable" => true,
            "format" => ["get_boolean_value"]
        ],
        [
            "name" => "Action",
            "field" => "action",
            "sortable" => false,
        ],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function showModal($id)
    {
        $this->modalVisible = true;
        $this->encryptedId = $id;
    }

    public function delete()
    {
        try {
            $id = Crypt::decrypt($this->encryptedId);
            Package::find($id)->delete();
            $this->alert([
                "type" => "success",
                "message" => "Package has been successfully deleted."
            ]);
        } catch (\Exception $e) {
            $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
        $this->modalVisible = false;
    }

    public function createPackage()
    {
        return redirect(route("admin.packages.create"));
    }

    public function paginationView()
    {
        return "admin.partials.pagination";
    }

    public function render()
    {
        return view("livewire.admin.package.package-table", [
            "packages" => Package::query()
                ->where("id", "LIKE", "%{$this->search}%")
                ->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage)
        ]);
    }
}
