<?php

namespace App\Http\Livewire\Admin\Transaction;

use App\Http\Traits\Alert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use App\Services\TripayService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class TransactionTable extends Component
{
    use WithPagination, Alert;
    protected $listeners = ['tableRefresh' => '$refresh'];
    public $search = "";
    public $sortField = "id";
    public $sortAsc = false;
    public $perPage = 10;
    public $modalVisible = false;
    public $editModalVisiblity = false;
    public $encryptedId;
    public $actions = ["show", "edit"];

    public $transactionNote;
    public $transactionStatus;

    public $columns = [
        [
            "name" => "ID",
            "field" => "id",
            "sortable" => true,
        ],
        [
            "name" => "Date",
            "field" => "created_at",
            "sortable" => true,
            "format" => ["date_to_human", "d F Y"]
        ],
        [
            "name" => "Reference",
            "field" => "reference",
            "sortable" => false,
        ],
        [
            "name" => "Name",
            "relation" => "user.name",
            "sortable" => false,
        ],
        [
            "name" => "Net Total",
            "field" => "net_total",
            "sortable" => true,
            "format" => ["decimal_to_human", "Rp"]
        ],
        [
            "name" => "Status",
            "field" => "status",
            "sortable" => true,
            "custom" => true,
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

    public function showEditModal($id)
    {
        try {
            $this->transaction = Transaction::findOrFail($id);
            $this->transactionNote = $this->transaction->note;
            $this->transactionStatus = $this->transaction->status;
            $this->editModalVisiblity = true;
        } catch (\Exception $e) {
            $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function submit()
    {
        $rawData = $this->validate([
            'transactionStatus' => 'required',
            'transactionNote' => 'nullable'
        ]);

        try {
            $this->transaction->update([
                'note' => $rawData['transactionNote']
            ]);

            $tripayService = app(TripayService::class);
            $tripayService->updateTransaction($this->transaction->merchant_ref, $rawData['transactionStatus']);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
        $this->transaction = null;
        $this->editModalVisiblity = false;
        return $this->alert([
            "type" => "success",
            "message" => "Transaction has been successfully updated."
        ]);
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
        } catch (\Exception $e) {
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
                ->whereHas('user', function ($query) {
                    $query->where("name", "ILIKE", "%{$this->search}%");
                })
                ->orWhere('reference', 'ILIKE', "%{$this->search}%")
                ->with('user', 'items', 'items.package')
                ->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage)
        ]);
    }
}
