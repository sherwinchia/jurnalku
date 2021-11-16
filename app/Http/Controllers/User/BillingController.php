<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    const PATH = "user.billing.";

    public function index()
    {
        return view(self::PATH . 'index');
    }
}
