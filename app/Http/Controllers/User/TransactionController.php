<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Alert;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use AuthorizesRequests, Alert;

    const PATH = "user.transaction.";

    public function index()
    {
        return view(self::PATH . 'index');
    }

    public function show($merchant_ref)
    {
        try {
            $transaction = Transaction::where('merchant_ref', $merchant_ref)->firstOrFail();
            $this->authorize('view', $transaction);
        } catch (\Exception $e) {
            $this->altAlert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
            return redirect()->route('user.billings.index');
        }
        return view(self::PATH . 'show', compact('transaction'));
    }

    public function handleTripayCallback()
    {
        # code...
    }
}
