<?php

namespace App\Http\Livewire\User\Setting;

use Livewire\Component;
use App\Http\Traits\Alert;
use App\Models\Portfolio;
use App\Models\PortfolioBalance;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Crypt;

class BalanceForm extends Component
{
    use Alert, AuthorizesRequests;

    public $balance;
    public $deleteModal = false;
    public $formModal = false;

    protected $rules = [
        'balance.portfolio_id'=>'required',
        'balance.type'=>'required|string',
        'balance.amount'=>'required|numeric',
    ];

    protected $messages = [
        'balance.portfolio_id.required' => 'The portfolio cannot be empty.',
    ];

    public function mount()
    {
        $this->balance = new PortfolioBalance();
    }

    public function showBlankFormModal()
    {
        $this->formModal = true;
    }

    public function submit()
    {
        $this->validate();

        $portfolio = Portfolio::findOrFail($this->decrypt($this->balance->portfolio_id));

        try {
            $this->authorize('add-portfolio-balance', $portfolio);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        $this->balance->portfolio_id = $portfolio->id;
        $this->balance->save();

        $portfolio->balance = $portfolio->calculate_balance;
        $portfolio->save();

        $this->formModal = false;
        $this->edit = false;
        $this->balance = new PortfolioBalance();

        return $this->alert([
            "type" => "success",
            "message" => 'Portfolio has been successfully added.'
        ]);
    }

    public function showDeleteModal($encryptedId)
    {
        $this->balance = PortfolioBalance::findOrFail($this->decrypt($this->encryptedId));
        $this->deleteModal = true;
    }

    public function delete()
    {
        $portfolioBalance = $this->balance;

        try {
            $this->authorize('delete-portfolio-balance', $portfolioBalance);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        $portfolioBalance->delete();
        $this->alert([
            "type" => "success",
            "message" => "Balance has been successfully deleted."
        ]);
        $this->deleteModal = false;
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

    public function render()
    {
        return view('livewire.user.setting.balance-form',[
            'portfolios' => Portfolio::with('balances')->where('user_id', '=', current_user()->id)->get(),
        ]);
    }
}
