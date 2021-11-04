<?php
namespace App\Http\Livewire\User\Journal;

use App\Helpers\UserSettings;
use App\Http\Traits\Alert;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Portfolio;
use App\Models\Trade;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;

class JournalTable extends Component
{
    use WithPagination, Alert, AuthorizesRequests;
    protected $listeners = ['tableRefresh' => '$refresh'];
    // public $search = "";
    public $entryFeeType;
    public $exitFeeType;
    public $trade;
    public $selectedPortfolioId;
    public $tab = 0;
    public $edit = false;
    public $sortField = "id";
    public $sortAsc = false;
    public $perPage = 10;
    public $tradeFormModal = false;
    public $deleteTradeModal = false;
    public $actions = ["delete","edit"];
    public $columns = [
        [
            "name" => "Instrument",
            "field" => "instrument",
            "sortable" => true,
        ],
        [
            "name" => "Entry Date",
            "field" => "entry_date",
            "sortable" => false,
            "format" => ["date_to_human"]
        ],
        [
            "name" => "Exit Date",
            "field" => "exit_date",
            "sortable" => false,
            "format" => ["date_to_human"]
        ],
        [
            "name" => "Gain/Loss",
            "field" => "gain_loss",
            "sortable" => false,
            "format" => ["decimal_to_human"],
            "align" => 'text-center'
        ],
        [
            "name" => "Setup",
            "field" => "setup",
            "sortable" => false,
        ],
        [
            "name" => "Mistake",
            "field" => "mistake",
            "sortable" => false,
        ],
        [
            "name" => "Status",
            "field" => "status",
            "sortable" => false,
            "align" => 'text-center'
        ],
        [
            "name" => "Action",
            "field" => "action",
            "sortable" => false,
        ],
    ];

    protected $rules = [
        "trade.instrument" => "required",
        "trade.entry_date" => "required",
        "trade.exit_date" => "after:trade.entry_date|nullable",
        "trade.entry_price" => "required|numeric|min:1",
        "trade.exit_price" => "required_with:trade.exit_date|numeric|min:0|nullable",
        "trade.take_profit" => "required|numeric|min:1",
        "trade.stop_loss" => "required|numeric|min:1",
        "trade.entry_fee" => "required_with:trade.entry_date|numeric|min:0",
        "trade.exit_fee" => "required_with:trade.exit_date|numeric|min:0|nullable",
        "trade.quantity" => "required|numeric|min:0",
        "trade.note" => "nullable|string",
        "trade.setup" => "nullable",
        "trade.mistake" => "nullable",
    ];

    public function mount()
    {
        $this->selectedPortfolioId = Crypt::encrypt(current_user()->portfolios->first()->id);
        $this->trade = new Trade();
    }

    public function showAddTradeModal()
    {
        try {
            $this->authorize('add-trade', Portfolio::findOrFail($this->decrypt($this->selectedPortfolioId)));
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        $this->tab = 0;
        $this->tradeFormModal = true;
    }

    public function showEditFormModal($tradeId)
    {
        $trade = Trade::findOrFail($tradeId);

        try {
            $this->authorize('manage-trade', $trade);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        $this->edit = true;
        $this->tab = 1;

        $this->trade = $trade;

        if (isset($this->trade->entry_date)) {
            $this->trade->entry_date = date_to_datetime_local($this->trade->entry_date);
        }
        if (isset($this->trade->exit_date)) {
            $this->trade->exit_date = date_to_datetime_local($this->trade->exit_date);
        }

        $this->tradeFormModal = true;
    }

    public function submitTrade()
    {
        $decrypt_portfolio_id = $this->decrypt($this->selectedPortfolioId);

        if ($this->edit) {
            try {
                $this->authorize('manage-trade', Trade::findOrFail($this->trade->id));
                $message = 'Trade has been successfully updated.';
            } catch (\Exception $e) {
                return $this->alert([
                    "type" => "error",
                    "message" => $e->getMessage()
                ]);
            }
        } else {
            try {
                $this->authorize('add-trade', Portfolio::findOrFail($decrypt_portfolio_id));
                $message = 'Trade has been successfully added.';
            } catch (\Exception $e) {
                return $this->alert([
                    "type" => "error",
                    "message" => $e->getMessage()
                ]);
            }
        }

        $this->validate();

        $this->trade->portfolio_id = $decrypt_portfolio_id;

        if (!isset($this->trade->exit_fee)) {
            $this->trade->exit_fee = 0;
        }

        if ($this->entryFeeType == '%') {
            $this->trade->entry_fee = $this->trade->entry_price * $this->trade->quantity * $this->trade->entry_fee / 100;
        }

        if ($this->exitFeeType == '%') {
            $this->trade->exit_fee = $this->trade->exit_price * $this->trade->quantity * $this->trade->exit_fee / 100;
        }

        if ( isset($this->trade->exit_date) && isset($this->trade->exit_price)) {
            $this->trade->gain_loss = $this->trade->calculate_net;

            if ($this->trade->gain_loss > 0) {
                $this->trade->status = "win";
            }
            if ($this->trade->gain_loss < 0) {
                $this->trade->status = "lose";
            }
            if ($this->trade->gain_loss == 0) {
                $this->trade->status = "neutral";
            }
        }

        $this->trade->save();
        $this->trade = new Trade();
        $this->trade->entry_fee = 0;
        $this->trade->exit_fee = 0;
        $this->tradeFormModal = false;
        $this->edit = false;

        return $this->alert([
            "type" => "success",
            "message" => $message
        ]);
    }

    public function showDeleteModal($id)
    {
        try {
            $this->authorize('manage-trade', Trade::findOrFail($id));
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        $this->deleteTradeModal = true;
        $this->tradeId = $id;
    }

    public function deleteTrade()
    {
        $trade = Trade::findOrFail($this->tradeId);

        try {
            $this->authorize('manage-trade', $trade);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        $trade->delete();
        $this->alert([
            "type" => "success",
            "message" => "Trade has been successfully deleted."
        ]);
        $this->deleteTradeModal = false;
    }

    // public function updatingSearch()
    // {
    //     $this->resetPage();
    // }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    private function decrypt(string $string)
    {
        try {
            return Crypt::decrypt($string);
        } catch (\Exception $e) {
            $this->alert([
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
        return view("livewire.user.journal.journal-table", [
            "trades" => Trade::query()
                ->where('portfolio_id',"=", $this->decrypt($this->selectedPortfolioId))
                ->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage),
            "portfolios" => current_user()->portfolios,
            "settings" => UserSettings::all()
        ]);
    }
}
