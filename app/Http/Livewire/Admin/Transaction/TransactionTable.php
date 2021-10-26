<?php

namespace App\Http\Livewire\Admin\Transaction;

use App\Http\Traits\Alert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class TransactionTable extends Component
{
    use WithPagination, Alert;
    protected $listeners = ['tableRefresh' => '$refresh'];
    public $search = "";
    public $sortField = "id";
    public $sortAsc = true;
    public $perPage = 10;
    public $modalVisible = false;
    public $encryptedId;
    public $actions = ["create"];

    public $columns = [
        [
            "name" => "ID",
            "field" => "id",
            "sortable" => true,
        ],
        [
            "name" => "Name",
            "relation" => "user.name",
            "sortable" => false,
        ],
        [
            "name" => "Package",
            "relation" => "package.name",
            "sortable" => false,
        ],
        [
            "name" => "Status",
            "field" => "status",
            "sortable" => false,
        ],
        [
            "name" => "Net Total",
            "field" => "net_total",
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
            Transaction::find($id)->delete();
            $this->alert([
                "type" => "success",
                "message" => "Transaction has been successfully deleted."
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
        $this->modalVisible = false;
    }

    public function createTransaction()
    {
        return redirect(route("admin.transactions.create"));
    }

    public function paginationView()
    {
        return "admin.partials.pagination";
    }

    public function render()
    {
        return view("livewire.admin.transaction.transaction-table", [
            "transactions" => Transaction::query()
                ->with(['user', 'package'])
                ->where("id", "LIKE", "%{$this->search}%")
                ->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage)
        ]);
    }
}
