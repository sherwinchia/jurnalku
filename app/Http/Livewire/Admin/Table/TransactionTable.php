<?php
namespace App\Http\Livewire\Admin\Table;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;

class TransactionTable extends Component
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
        $transaction = Transaction::find($this->modalId);
        $transaction->delete();
        $transaction->modalVisible = false;
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
        return view("livewire.admin.table.transaction-table", [
            "transactions" => Transaction::query()
                ->where("id", "LIKE", "%{$this->search}%")
                ->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage)
        ]);
    }
}