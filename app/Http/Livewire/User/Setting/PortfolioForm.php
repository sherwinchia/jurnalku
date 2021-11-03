<?php

namespace App\Http\Livewire\User\Setting;

use App\Http\Traits\Alert;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class PortfolioForm extends Component
{
    use Alert;

    public $portfolio;
    public $deleteModal = false;
    public $formModal = false;
    public $edit = false;
    public $encryptedId;

    protected $rules = [
        'portfolio.name'=>'required|string',
        'portfolio.currency'=>'required|string',
    ];

    public function mount()
    {
        $this->portfolio = new Portfolio();
    }

    public function showBlankFormModal()
    {
        $this->edit = false;
        $this->portfolio = new Portfolio();
        $this->formModal = true;
    }

    public function showFormModal($encryptedId)
    {
        $portfolio = Portfolio::findOrFail($this->decrypt($encryptedId));
        if (! Gate::allows('manage-portfolio', $portfolio)) {
            return $this->alert([
                "type" => "error",
                "message" => "Unauthorized action!"
            ]);
        }

        $this->portfolio = $portfolio;
        $this->edit = true;
        $this->formModal = true;
        $this->encryptedId = $encryptedId;
    }

    public function submit()
    {
        if ($this->edit) {
            if (! Gate::allows('manage-portfolio', Portfolio::findOrFail($this->decrypt($this->encryptedId)))) {
                return $this->alert([
                    "type" => "error",
                    "message" => "Unauthorized action!"
                ]);
            }
        }

        $this->validate();
        $this->portfolio->user_id = current_user()->id;
        $this->portfolio->save();
        $this->formModal = false;

        if($this->edit){
            $message = 'Portfolio has been successfully updated.';
        } else {
            $message = 'Portfolio has been successfully added.';
        }

        return $this->alert([
            "type" => "success",
            "message" => $message
        ]);
    }

    public function showDeleteModal($encryptedId)
    {
        if (! Gate::allows('manage-portfolio', Portfolio::findOrFail($this->decrypt($encryptedId)))) {
            return $this->alert([
                "type" => "error",
                "message" => "Unauthorized action!"
            ]);
        }
        $this->deleteModal = true;
        $this->encryptedId = $encryptedId;
    }

    public function delete()
    {
        $portfolio = Portfolio::findOrFail($this->decrypt($this->encryptedId));
        if (! Gate::allows('manage-portfolio', $portfolio)) {
            return $this->alert([
                "type" => "error",
                "message" => "Unauthorized action!"
            ]);
        }
        $portfolio->delete();
        $this->alert([
            "type" => "success",
            "message" => "Portfolio has been successfully deleted."
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
        return view('livewire.user.setting.portfolio-form',[
            'portfolios' => current_user()->portfolios
        ]);
    }
}
