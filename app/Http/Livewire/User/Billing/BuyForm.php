<?php

namespace App\Http\Livewire\User\Billing;

use App\Http\Traits\Alert;
use App\Models\Package;
use App\Services\PromocodeService;
use Livewire\Component;

class BuyForm extends Component
{
    use Alert;

    public $package;
    public $packages;
    public $promocode;
    public $packageModal = false;
    public $inputPromocode = false;
    public $discount;
    public $total;

    protected $rules = [
        "package" => "required",
        "promocode" => "required",
    ];

    public function mount()
    {
        $this->packages = Package::where('active', true)->where('price', '>', 0)->get();
    }

    public function selectPackage($id)
    {
        try {
            $this->package = Package::findOrFail($id);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => "Package not found."
            ]);
        }
        $this->total = $this->package->price;
        $this->packageModal = true;
    }

    public function applyCode()
    {
        $this->validate();
        try {
            $promocodeService = new PromocodeService();
            $this->discount = $promocodeService->apply($this->promocode, $this->package->price);
        } catch (\Exception $e) {
            $this->code = null;
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function checkout()
    {
    }

    public function render()
    {
        return view('livewire.user.billing.buy-form');
    }
}
