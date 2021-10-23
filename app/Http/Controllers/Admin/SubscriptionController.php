<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Subscription;

class SubscriptionController extends Controller{

    const PATH = "admin.subscription.";

    public function index()
    {
        return view(self::PATH . "index");
    }

    public function create()
    {
        return view(self::PATH . "create");
    }

    public function show(Subscription $subscription)
    {
        return view(self::PATH . "show", compact("subscription"));
    }

    public function edit(Subscription $subscription)
    {
        return view(self::PATH . "edit", compact("subscription"));
    }
}
        