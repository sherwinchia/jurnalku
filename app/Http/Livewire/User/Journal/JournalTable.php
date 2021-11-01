<?php
namespace App\Http\Livewire\User\Journal;

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
    public $sortField = "id";
    public $sortAsc = true;
    public $perPage = 10;
    public $addTradeModal = false;
    public $deleteTradeModal = false;
    public $actions = [];
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
            "name" => "Entry Price",
            "field" => "entry_price",
            "sortable" => false,
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
        ],
        [
            "name" => "Take Profit",
            "field" => "take_profit",
            "sortable" => false,
        ],
        [
            "name" => "Stop Loss",
            "field" => "stop_loss",
            "sortable" => false,
        ],
        [
            "name" => "Fees",
            "field" => "fees",
            "sortable" => false,
        ],
        [
            "name" => "Gain/Loss",
            "field" => "gain_loss",
            "sortable" => false,
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
            "name" => "Action",
            "field" => "action",
            "sortable" => false,
        ],
    ];

    protected $rules = [
        "trade.instrument" => "required",
        "trade.setup" => "nullable",
        "trade.mistake" => "nullable",
        "trade.entry_date" => "required",
        "trade.exit_date" => "nullable",
        "trade.entry_price" => "required|numeric|min:1",
        "trade.exit_price" => "required|numeric|min:1",
        "trade.take_profit" => "required|numeric|min:1",
        "trade.stop_loss" => "required|numeric|min:1",
        "trade.fees" => "required|numeric|min:1",
        "trade.exit_date" => "nullable",
        "trade.quantity" => "required|numeric|min:0",
        "trade.note" => "nullable|string",

    ];

    public function mount()
    {
        $this->selectedPortfolio = Crypt::encrypt(current_user()->portfolios->first()->id);
        $this->decryptedPortfolioId = $this->decrypt($this->selectedPortfolio);
        $this->trade = new Trade();
    }

    public function addTrade()
    {
        dd("Create Trade");

        $this->trade = new Trade();
    }

    public function createJournal()
    {
        dd("Create Journal");
    }

    // public function delete()
    // {
    //     try{
    //         $id = Crypt::decrypt($this->encryptedId);
    //         Journal::find($id)->delete();
    //         $this->alert([
    //             "type" => "success",
    //             "message" => "Journal has been successfully deleted."
    //         ]);
    //     } catch(\Exception $e) {
    //         $this->alert([
    //             "type" => "error",
    //             "message" => $e->getMessage()
    //         ]);
    //     }
    //     $this->modalVisible = false;
    // }

    public function decrypt(string $string)
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

    public function showModal($id)
    {
        $this->modalVisible = true;
        $this->encryptedId = $id;
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
            "settings" => json_decode(current_user()->setting->data)
        ]);
    }
}
