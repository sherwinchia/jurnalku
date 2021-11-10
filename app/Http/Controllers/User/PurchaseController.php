<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Alert;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    use AuthorizesRequests, Alert;

    const PATH = "user.purchase.";

    public function index()
    {
        return view(self::PATH . 'index');
    }

    public function show(Transaction $transaction)
    {
        return view(self::PATH . 'index');
    }
}
