<?php
namespace App\Http\Livewire\User\Transaction;

use App\Http\Traits\Alert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Crypt;

class TransactionTable extends Component
{
    use WithPagination, Alert, AuthorizesRequests;
    protected $listeners = ['tableRefresh' => '$refresh'];
    public $search = "";
    public $sortField = "id";
    public $sortAsc = true;
    public $perPage = 10;
    public $transaction;
    public $detailModal = false;
    public $actions = ["show"];
    public $columns = [
        [
            "name" => "Reference",
            "field" => "reference",
            "sortable" => false,
        ],
        [
            "name" => "Date",
            "field" => "created_at",
            "sortable" => true,
            "format" => ["date_to_human", "d F Y"]
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

    public function mount()
    {
        $this->transaction = new Transaction();
    }

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

    public function showDetailModal($id)
    {
        try {
            $this->transaction = Transaction::findOrFail($id);
            $this->authorize('view', $this->transaction);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function paginationView()
    {
        return "admin.partials.pagination";
    }

    public function render()
    {
        return view("livewire.user.transaction.transaction-table", [
            "transactions" => current_user()->transactions()->paginate($this->perPage)
        ]);
    }
}