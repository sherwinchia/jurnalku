<?php

namespace App\Services;

use App\Models\Promocode;
use App\Models\User;

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

    public function checkAvailability(Promocode $promocode, float $total, User $user)
    {
        if ($promocode->first_time_user && $user->transactions->contains('promocode_id', $promocode->id)) {
            throw new \Exception("You've used this promocode.");
        }

        if (!($promocode->started && !$promocode->expired)) {
            throw new \Exception("Promocode has expired.");
        }
        if (isset($promocode->max_use_count) && ($promocode->use_count >= $promocode->max_use_count)) {
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
            $discount = $promocode->value;
        }
        if (isset($promocode->max_discount) && $discount > $promocode->max_discount) {
            $discount = $promocode->max_discount;
        }
        if ($discount > $total) $discount = $total;
        return (float) $discount;
    }

    public function apply(Promocode $promocode, float $total, User $user)
    {
        $this->checkAvailability($promocode, $total, $user);
        return $this->calculate($promocode, $total);
    }
}
