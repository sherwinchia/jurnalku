<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Alert;
use App\Models\Transaction;
use App\Services\TripayService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function handleTripayCallback(Request $request)
    {
        try {
            $tripayService = app(TripayService::class);
            $valid = $tripayService->handleCallback($request);

            if ($valid) {
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
