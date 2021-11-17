<?php

namespace App\Http\Livewire\User\Transaction;

use App\Http\Traits\Alert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use App\Services\TripayService;
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
    public $targetTransaction;
    public $transactionDetail = [];
    public $detailModal = false;
    public $actions = ["show"];
    public $columns = [
        [
            "name" => "Reference",
            "field" => "merchant_ref",
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

    public function mount($merchant_ref = null)
    {
        if (isset($merchant_ref)) {
            try {
                $transaction = Transaction::where('merchant_ref', $merchant_ref)->firstOrFail();
                $this->showDetailModal($transaction->id);
            } catch (\Exception $e) {
                return $this->alert([
                    "type" => "error",
                    "message" => $e->getMessage()
                ]);
            }
        }
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
            $this->targetTransaction = Transaction::findOrFail($id);
            $this->authorize('view', $this->targetTransaction);
            $this->detailModal = true;

            if ($this->targetTransaction->status == "pending") {
                $this->getPaymentGuide();
            }
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function getPaymentGuide()
    {
        $tripayService = app(TripayService::class);
        $payload = $tripayService->getTransactionDetail($this->targetTransaction->reference)->data;
        $this->transactionDetail = (array) $payload;
        $this->transactionDetail['order_items'] = array_map(function ($obj) {
            return (array) $obj;
        }, $this->transactionDetail['order_items']);
        $this->transactionDetail['instructions'] = array_map(function ($obj) {
            return (array) $obj;
        }, $this->transactionDetail['instructions']);
    }

    public function paginationView()
    {
        return "admin.partials.pagination";
    }

    public function render()
    {
        return view("livewire.user.transaction.transaction-table", [
            "transactions" => current_user()->transactions()->latest()->paginate($this->perPage)
        ]);
    }
}
