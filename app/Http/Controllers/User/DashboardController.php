<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    const PATH = "user.dashboard.";

    public function index()
    {
        return view(self::PATH . 'index');
    }
}
