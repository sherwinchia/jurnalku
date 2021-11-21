<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    const PATH = "user.analytics.";

    public function index()
    {
        return view(self::PATH . 'index');
    }
}
