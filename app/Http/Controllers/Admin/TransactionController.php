<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{

    const PATH = "admin.transaction.";

    public function index()
    {
        return view(self::PATH . "index");
    }

    public function create()
    {
        return view(self::PATH . "create");
    }

    public function show(Transaction $transaction)
    {
        return view(self::PATH . "show", compact("transaction"));
    }

    public function edit(Transaction $transaction)
    {
        return view(self::PATH . "edit", compact("transaction"));
    }
}
