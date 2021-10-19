<?php
namespace App\Http\Livewire\Admin\Table;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Package;

class PackageTable extends Component
{
    use WithPagination;
    protected $listeners = ['tableRefresh' => '$refresh'];
    public $search = "";
    public $sortField = "id";
    public $sortAsc = true;
    public $perPage = 10;
    public $modalVisible;
    public $modalId;

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
        $this->modalId = $id;
    }

    public function delete()
    {
        $package = Package::find($this->modalId);
        $package->delete();
        $package->modalVisible = false;
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
        return view("livewire.admin.table.package-table", [
            "packages" => Package::query()
                ->where("name", "LIKE", "%{$this->search}%")
                ->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage)
        ]);
    }
}