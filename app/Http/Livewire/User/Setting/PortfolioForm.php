<?php

namespace App\Http\Livewire\User\Setting;

use App\Http\Traits\Alert;
use App\Models\Portfolio;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class PortfolioForm extends Component
{
    use Alert, AuthorizesRequests;

    public $portfolio;
    public $deleteModal = false;
    public $formModal = false;
    public $edit = false;

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

    public function showFormModal($encryptedId)
    {
        try {
            $portfolio = Portfolio::findOrFail($this->decrypt($encryptedId));
            $this->authorize('manage-portfolio', $portfolio);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }

        $this->portfolio = $portfolio;
        $this->edit = true;
        $this->formModal = true;
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

        return $this->alert([
            "type" => "success",
            "message" => $message
        ]);
    }

    public function showDeleteModal($encryptedId)
    {
        try {
            $portfolio = Portfolio::findOrFail($this->decrypt($encryptedId));
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
        return view('livewire.user.setting.portfolio-form',[
            'portfolios' => Portfolio::where('user_id', '=', current_user()->id)->get(),
        ]);
    }
}
