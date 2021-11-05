<?php

namespace App\Http\Livewire\User\Portfolio;

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

class PortfolioShow extends Component
{
    use WithPagination, Alert, AuthorizesRequests;
    protected $listeners = ['component-refresh' => '$refresh'];

    public Portfolio $portfolio;
    public $entryFeeType;
    public $exitFeeType;
    public $trade;
    public $tab = 0;
    public $edit = false;
    public $sortField = "id";
    public $sortAsc = false;
    public $perPage = 10;
    public $tradeFormModal = false;
    public $deleteTradeModal = false;

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
        $this->trade = new Trade();
    }

    public function showAddTradeModal()
    {
        try {
            $this->authorize('add-trade', $this->portfolio);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        $this->trade = new Trade();
        $this->trade->entry_fee = 0;
        $this->trade->exit_fee = 0;
        $this->edit = false;
        $this->tab = 0;
        $this->tradeFormModal = true;
    }

    public function showEditFormModal($id)
    {
        try {
            $trade = Trade::findOrFail($id);
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
        if ($this->edit) {
            try {
                $this->authorize('manage-trade', $this->trade);
                $message = 'Trade has been successfully updated.';
            } catch (\Exception $e) {
                return $this->alert([
                    "type" => "error",
                    "message" => $e->getMessage()
                ]);
            }
        } else {
            try {
                $this->authorize('add-trade', $this->portfolio);
                $message = 'Trade has been successfully added.';
            } catch (\Exception $e) {
                return $this->alert([
                    "type" => "error",
                    "message" => $e->getMessage()
                ]);
            }
        }

        $this->validate();

        $this->trade->portfolio_id = $this->portfolio->id;

        if (!isset($this->trade->exit_fee)) {
            $this->trade->exit_fee = 0;
        }

        if ($this->entryFeeType == '%') {
            $this->trade->entry_fee = $this->trade->entry_price * $this->trade->quantity * $this->trade->entry_fee / 100;
            $this->entryFeeType = $this->portfolio->currency;
        }

        if ($this->exitFeeType == '%') {
            $this->trade->exit_fee = $this->trade->exit_price * $this->trade->quantity * $this->trade->exit_fee / 100;
            $this->exitFeeType = $this->portfolio->currency;
        }

        if ( isset($this->trade->exit_date) && isset($this->trade->exit_price)) {
            $this->trade->return = $this->trade->calculate_net;
            $this->trade->return_percentage = $this->trade->calculate_percentage;

            if ($this->trade->return > 0) {
                $this->trade->status = "win";
            }
            if ($this->trade->return < 0) {
                $this->trade->status = "lose";
            }
            if ($this->trade->return == 0) {
                $this->trade->status = "neutral";
            }
        }

        $this->trade->save();
        $this->tradeFormModal = false;

        return $this->alert([
            "type" => "success",
            "message" => $message
        ]);
    }

    public function showDeleteModal($id)
    {
        try {
            $trade = Trade::findOrFail($id);
            $this->authorize('manage-trade', $trade);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        $this->deleteTradeModal = true;
        $this->trade = $trade;
    }

    public function deleteTrade()
    {
        try {
            $this->authorize('manage-trade', $this->trade);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        $this->trade->delete();
        $this->alert([
            "type" => "success",
            "message" => "Trade has been successfully deleted."
        ]);
        $this->deleteTradeModal = false;
    }

    public function favorite($id)
    {
        try {
            $trade = Trade::findOrFail($id);
            $this->authorize('manage-trade', $trade);
            $trade->favorite = !$trade->favorite;
            $trade->save();
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function exportPortfolio()
    {
        return redirect()->route('user.portfolio.export', $this->portfolio);
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

    public function paginationView()
    {
        return "admin.partials.pagination";
    }

    public function render()
    {
        return view('livewire.user.portfolio.portfolio-show', [
            "trades" => $this->portfolio->trades()->orderBy($this->sortField, $this->sortAsc ? "asc" : "desc")
                ->paginate($this->perPage),
            "settings" => UserSettings::all()
        ]);
    }
}
