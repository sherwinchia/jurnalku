<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    const PATH = "user.home.";

    public function index()
    {
        return view(self::PATH . 'index');
    }


}
