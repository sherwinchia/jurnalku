<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('admin.subscription.index');
    }
    public function create()
    {
        return view('admin.subscription.create');
    }
    public function edit()
    {
        return view('admin.subscription.edit');
    }
}
