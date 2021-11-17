<?php

namespace App\Http\Livewire\User\Billing;

use App\Http\Traits\Alert;
use App\Models\Package;
use App\Models\Transaction;
use App\Services\PromocodeService;
use App\Services\TripayService;
use Livewire\Component;

class BuyForm extends Component
{
    use Alert;

    public $selectedPackage;
    public $packages;
    public $code;
    public $packageModal = false;
    public $inputPromocode = false;
    public $discount;
    public $total;
    public $paymentMethods = [];
    public $selectedPaymentMethod;
    public $promoCode;

    protected $rules = [
        "selectedPackage" => "required",
        "selectedPaymentMethod" => "required",
    ];

    protected $messages = [
        'selectedPaymentMethod.required' => 'Please select the payment method.',
    ];

    public function mount()
    {
        $this->packages = Package::where('active', true)->where('price', '>', 0)->get();
    }

    public function getPaymentMethods()
    {
        try {
            $tripayService = app(TripayService::class);
            $paymentMethods = $tripayService->getPaymentChannels()->data;
            $paymentMethods = array_filter($paymentMethods, function ($obj) {
                return $obj->active;
            });
            $paymentMethods = array_map(function ($obj) {
                return (array) $obj;
            }, $paymentMethods);
            $this->paymentMethods = $paymentMethods;
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function selectPackage($id)
    {
        try {
            $this->selectedPackage = Package::findOrFail($id);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => "Package not found."
            ]);
        }
        $this->total = $this->selectedPackage->price;
        $this->packageModal = true;
    }

    public function selectPaymentMethod(string $code)
    {
        $this->selectedPaymentMethod = $code;
    }

    public function applyCode()
    {
        $this->discount = null;
        $this->promoCode = null;
        $this->validate(['code' => 'required']);
        try {
            $promocodeService = app(PromocodeService::class);
            $this->promoCode = $promocodeService->find($this->code);
            $this->discount = $promocodeService->apply($this->promoCode, $this->selectedPackage->price);
            $this->inputPromocode = false;
        } catch (\Exception $e) {
            $this->discount = null;
            $this->promoCode = null;
            $this->code = null;
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function checkout()
    {
        $this->validate();
        try {
            $promocodeService = app(PromocodeService::class);
            $tripayService = app(TripayService::class);
            $discount = 0;
            if (isset($this->promoCode)) {
                $discount = $promocodeService->apply($this->promoCode, $this->selectedPackage->price);
            }

            $net_total = $this->selectedPackage->price - $discount;
            if ($net_total < 0) $net_total = 0;

            $payload = $tripayService->requestTransaction(current_user(), $this->selectedPackage, $this->selectedPaymentMethod, $net_total);

            if (!$payload->success) {
                throw new \Exception($payload->message);
            }

            $transaction = Transaction::create([
                'user_id' => current_user()->id,
                'package_id' => $this->selectedPackage->id,
                'promocode_id' => $this->promoCode ? $this->promoCode->id : null,
                'gross_total' => $this->selectedPackage->price,
                'discount' => $this->discount ?? 0,
                'reference' => $payload->data->reference,
                'merchant_ref' => $payload->data->merchant_ref,
                'net_total' => $net_total
            ]);

            return redirect()->route('user.billings.index', ['section' => 'history', 'merchant_ref' => $transaction->merchant_ref]);
        } catch (\Exception $e) {
            return $this->alert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.user.billing.buy-form');
    }
}
