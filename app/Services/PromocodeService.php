<?php

namespace App\Services;

use App\Models\Promocode;

class PromocodeService
{
    public function find(string $code)
    {
        try {
            return Promocode::where('code', $code)->where('active', true)->firstOrFail();
        } catch (\Exception $e) {
            throw new \Exception("Promocode not found");
        }
    }

    public function checkAvailability(Promocode $promocode, float $total)
    {
        if (!($promocode->started && !$promocode->expired)) {
            throw new \Exception("Promocode has expired.");
        }
        if ($promocode->use_count < $promocode->max_use_count) {
            throw new \Exception("Promocode has reached the limit usage.");
        }
        if ($total < $promocode->min_spending) {
            throw new \Exception("You doesn't meet the requirement to use this promocode.");
        }
    }

    public function calculate(Promocode $promocode, float $total)
    {
        $discount = 0;
        if ($promocode->type == 'percentage') {
            $discount = $total * $promocode->value / 100;
        }
        if ($promocode->type == 'fixed') {
            $discount = $total - $promocode->value;
        }
        if (isset($promocode->max_discount) && $discount > $promocode->max_discount) {
            $discount = $promocode->max_discount;
        }
        return (float) $discount;
    }

    public function apply(string $code, float $total)
    {
        $promocode = $this->find($code);
        $this->checkAvailability($promocode, $total);
        return $this->calculate($promocode, $total);
    }
}
