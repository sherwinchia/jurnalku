<?php
namespace App\Http\Livewire\User\Journal;

use App\Helpers\UserSettings;
use App\Http\Traits\Alert;
use App\Models\Instrument;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Journal;
use App\Models\Portfolio;
use App\Models\Setting;
use App\Models\Trade;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class JournalTable extends Component
{
    use WithPagination, Alert;
    protected $listeners = ['tableRefresh' => '$refresh'];
    private $decryptedPortfolioId;
    // public $search = "";
    public $trade;
    public $selectedPortfolio;

    public $edit = false;
    public $sortField = "id";
    public $sortAsc = false;
    public $perPage = 10;
    public $tradeFormModal = false;
    public $deleteTradeModal = false;
    public $actions = ["delete","edit"];
    public $columns = [
        [
            "name" => "Ticker",
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
            "name" => "Entry Price",
            "field" => "entry_price",
            "sortable" => false,
            "format" => ["decimal_to_human"]
        ],
        [
            "name" => "Quantity",
            "field" => "quantity",
            "sortable" => false,
            "format" => ["decimal_to_human"]
        ],
        [
            "name" => "Exit Price",
            "field" => "exit_price",
            "sortable" => false,
            "format" => ["decimal_to_human"]
        ],
        [
            "name" => "Take Profit",
            "field" => "take_profit",
            "sortable" => false,
            "format" => ["decimal_to_human"]
        ],
        [
            "name" => "Stop Loss",
            "field" => "stop_loss",
            "sortable" => false,
            "format" => ["decimal_to_human"]
        ],
        [
            "name" => "Gain/Loss",
            "field" => "gain_loss",
            "sortable" => false,
            "format" => ["decimal_to_human"]
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
        "trade.exit_date" => "nullable|after:trade.entry_date",
        "trade.entry_price" => "required|numeric|min:1",
        "trade.exit_price" => "required_with:trade.exit_date|numeric|min:0|nullable",
        "trade.take_profit" => "required|numeric|min:1",
        "trade.stop_loss" => "required|numeric|min:1",
        "trade.entry_fee" => "required_with:trade.entry_date|numeric|min:0|nullable",
        "trade.exit_fee" => "required_with:trade.exit_date|numeric|min:0|nullable",
        "trade.quantity" => "required|numeric|min:0",
        "trade.note" => "nullable|string",
        "trade.setup" => "nullable",
        "trade.mistake" => "nullable",
    ];

    public function mount()
    {
        $this->selectedPortfolio = Crypt::encrypt(current_user()->portfolios->first()->id);
        $this->decryptedPortfolioId = $this->decrypt($this->selectedPortfolio);
    }

    public function showAddTradeModal()
    {
        $this->edit = false;
        $this->trade = new Trade();
        $this->trade->entry_fee = 0;
        $this->trade->exit_fee = 0;
        $this->tradeFormModal = true;
    }

    public function showEditFormModal($encryptedTradeId)
    {
        $this->edit = true;
        try {
            $this->trade = Trade::findOrFail($this->decrypt($encryptedTradeId));

            if (isset($this->trade->entry_date)) {
                $this->trade->entry_date = date_to_datetime_local($this->trade->entry_date);
            }
            if (isset($this->trade->exit_date)) {
                $this->trade->exit_date = date_to_datetime_local($this->trade->exit_date);
            }


        } catch (\Exception $e) {
            $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
        $this->tradeFormModal = true;
    }

    public function submitTrade()
    {
        $this->validate();

        // dd($this->trade);
        $this->trade->portfolio_id = $this->decrypt($this->selectedPortfolio);

        if (!$this->edit) {
            $this->trade->exit_fee = 0;
        }

        if ($this->edit && isset($this->trade->exit_date) && isset($this->trade->exit_price)) {
            $this->trade->gain_loss = $this->trade->calculate_total;

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
        $this->tradeFormModal = false;

        return $this->alert([
            "type" => "success",
            "message" => "Trade has been successfully added."
        ]);
    }

    public function deleteTrade()
    {
        $id = $this->decrypt($this->encryptedTradeId);
        if (isset($id)) {
            Trade::find($id)->delete();
            $this->alert([
                "type" => "success",
                "message" => "Trade has been successfully deleted."
            ]);
        }
        $this->deleteTradeModal = false;
    }

    // public function updatingSearch()
    // {
    //     $this->resetPage();
    // }

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

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function showDeleteModal($encryptedTradeId)
    {
        $this->deleteTradeModal = true;
        $this->encryptedTradeId = $encryptedTradeId;
    }

    public function paginationView()
    {
        return "admin.partials.pagination";
    }

    public function render()
    {
        return view("livewire.user.journal.journal-table", [
            "trades" => Trade::query()
                ->where('portfolio_id',"=", $this->decrypt($this->selectedPortfolio))
                ->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage),
            "portfolios" => current_user()->portfolios,
            "settings" => UserSettings::all()
        ]);
    }
}
