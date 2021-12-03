<?php

namespace App\Http\Livewire\Admin\Promocode;

use App\Http\Traits\Alert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Promocode;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class PromocodeTable extends Component
{
    use WithPagination, Alert;
    protected $listeners = ['tableRefresh' => '$refresh'];
    public $search = "";
    public $sortField = "id";
    public $sortAsc = true;
    public $perPage = 10;
    public $modalVisible = false;
    public $encryptedId;
    public $actions = ["create", "edit", "delete"];

    public $columns = [
        [
            "name" => "ID",
            "field" => "id",
            "sortable" => true,
        ],
        [
            "name" => "Code",
            "field" => "code",
            "sortable" => true,
        ],
        [
            "name" => "Type",
            "field" => "type",
            "sortable" => true,
            "format" => ["ucfirst"]
        ],
        [
            "name" => "Active",
            "field" => "active",
            "sortable" => true,
            "format" => ["get_boolean_value"]
        ],
        [
            "name" => "Start",
            "field" => "start_at",
            "sortable" => true,
            "format" => ["date_to_human", "d F Y"]
        ],
        [
            "name" => "End",
            "field" => "expired_at",
            "sortable" => true,
            "format" => ["date_to_human", "d F Y"]
        ],
        [
            "name" => "Use Count",
            "relation" => "use_count",
            "sortable" => false,
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
            Promocode::find($id)->delete();
            $this->alert([
                "type" => "success",
                "message" => "Promocode has been successfully deleted."
            ]);
        } catch (\Exception $e) {
            $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
        $this->modalVisible = false;
    }

    public function createPromocode()
    {
        return redirect(route("admin.promocodes.create"));
    }

    public function paginationView()
    {
        return "admin.partials.pagination";
    }

    public function render()
    {
        return view("livewire.admin.promocode.promocode-table", [
            "promocodes" => Promocode::query()
                ->where("code", "ILIKE", "%{$this->search}%")
                ->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage)
        ]);
    }
}
