<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return view('admin.transaction.index');
    }

    public function edit()
    {
        return view('admin.transaction.edit');
    }
}
