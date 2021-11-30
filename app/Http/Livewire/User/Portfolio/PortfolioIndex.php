<?php

namespace App\Http\Livewire\User\Portfolio;

use App\Http\Traits\Alert;
use App\Models\Portfolio;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class PortfolioIndex extends Component
{
    use Alert, AuthorizesRequests;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public $portfolio;
    public $deleteModal = false;
    public $formModal = false;
    public $edit = false;

    protected $rules = [
        'portfolio.name' => 'required|string',
        'portfolio.description' => 'nullable',
        'portfolio.currency' => 'required|string|max:4',
        'portfolio.balance' => 'required|numeric|min:1'
    ];

    public function showBlankFormModal()
    {
        try {
            $this->authorize('create', Portfolio::class);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => "You've reached limit number of portfolio."
            ]);
        }

        $this->portfolio = new Portfolio();
        $this->edit = false;
        $this->formModal = true;
    }

    public function showFormModal($id)
    {
        try {
            $portfolio = Portfolio::findOrFail($id);
            $this->authorize('update', $portfolio);
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

    public function submit()
    {
        if ($this->edit) {
            try {
                $this->authorize('update', $this->portfolio);
                $message = 'Portfolio has been successfully updated.';
            } catch (\Exception $e) {
                return $this->alert([
                    "type" => "error",
                    "message" => $e->getMessage()
                ]);
            }
        } else {
            try {
                $this->authorize('create', Portfolio::class);
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

    public function showDeleteModal($id)
    {
        try {
            $portfolio = Portfolio::findOrFail($id);
            $this->authorize('delete', $portfolio);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
                // "message" => "Failed to delete portfolio. Each user should have at least one portfolio."
            ]);
        }

        $this->deleteModal = true;
        $this->portfolio = $portfolio;
    }

    public function delete()
    {
        $portfolio = $this->portfolio;

        try {
            $this->authorize('delete', $portfolio);
            $portfolio->delete();
            $this->alert([
                "type" => "success",
                "message" => "Portfolio has been successfully deleted."
            ]);
            $this->emitSelf('refreshComponent');
            $this->deleteModal = false;
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => "Failed to delete portfolio. Each user should have at least one portfolio."
            ]);
        }
    }

    public function render()
    {
        return view('livewire.user.portfolio.portfolio-index', [
            'portfolios' => current_user()->portfolios->sortBy('id')
        ]);
    }
}
