<?php

namespace App\Http\Livewire\User\Portfolio;

use App\Http\Traits\Alert;
use App\Models\Portfolio;
use App\Models\PortfolioBalance;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class PortfolioIndex extends Component
{
    use Alert, AuthorizesRequests;

    protected $listeners = ['refreshComponent'=>'$refresh'];

    public $portfolio;
    public $deleteModal = false;
    public $formModal = false;
    public $balanceModal = false;
    public $edit = false;

    // Balance
    public $type;
    public $amount;

    protected $rules = [
        'portfolio.name'=>'required|string',
        'portfolio.currency'=>'required|string|max:4',
    ];

    public function mount()
    {
        $this->portfolio = new Portfolio();
    }

    public function showBlankFormModal()
    {
        $this->portfolio = new Portfolio();
        $this->edit = false;
        $this->formModal = true;
    }

    public function showFormModal($id)
    {
        try {
            $portfolio = Portfolio::findOrFail($id);
            $this->authorize('manage-portfolio', $portfolio);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        // $this->balance = new PortfolioBalance();
        $this->portfolio = $portfolio;
        $this->edit = true;
        $this->formModal = true;
    }

    public function showBalanceModal($id)
    {
        try {
            $portfolio = Portfolio::findOrFail($id);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
        $this->portfolio = $portfolio;
        $this->balanceModal = true;
        $this->amount = null;
        $this->type = null;
    }

    public function submit()
    {
        if ($this->edit) {
            try {
                $this->authorize('manage-portfolio', $this->portfolio);
                $message = 'Portfolio has been successfully updated.';
            } catch (\Exception $e) {
                return $this->alert([
                    "type" => "error",
                    "message" => $e->getMessage()
                ]);
            }
        } else {
            try {
                $this->authorize('add-portfolio');
                $message = 'Portfolio has been successfully added.';
            } catch (\Exception $e) {
                return $this->alert([
                    "type" => "error",
                    "message" => "You've reached limit number of portfolio."
                ]);
            }
        }

        $this->validate();
        $this->portfolio->user_id = current_user()->id;
        $this->portfolio->save();
        $this->formModal = false;


        $this->emitSelf('refreshComponent');
        return $this->alert([
            "type" => "success",
            "message" => $message
        ]);
    }

    public function submitBalance()
    {
        try {
            $this->authorize('add-portfolio-balance', $this->portfolio);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        $data = $this->validate([
            'type' => 'required',
            'amount' => 'required|numeric',
        ]);

        $data['portfolio_id'] = $this->portfolio->id;

        PortfolioBalance::create($data);

        $this->portfolio->balance = $this->portfolio->calculate_balance;
        $this->portfolio->save();

        $this->balanceModal = false;

        return $this->alert([
            "type" => "success",
            "message" => 'Balance has been successfully added.'
        ]);
    }

    public function showDeleteModal($id)
    {
        try {
            $portfolio = Portfolio::findOrFail($id);
            $this->authorize('manage-portfolio', $portfolio);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        $this->deleteModal = true;
        $this->portfolio = $portfolio;
    }

    public function delete()
    {
        $portfolio = $this->portfolio;

        try {
            $this->authorize('manage-portfolio', $portfolio);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        if (current_user()->portfolios->count() <= 1) {
            $this->alert([
                "type" => "error",
                "message" => "Failed to delete the portfolio. Each user must have at least one portfolio!"
            ]);
        }else {
            $portfolio->delete();
            $this->alert([
                "type" => "success",
                "message" => "Portfolio has been successfully deleted."
            ]);
        }

        $this->emitSelf('refreshComponent');
        $this->deleteModal = false;
    }

    public function render()
    {
        return view('livewire.user.portfolio.portfolio-index', [
            'portfolios' => current_user()->portfolios->load('trades','balances')
        ]);
    }
}
