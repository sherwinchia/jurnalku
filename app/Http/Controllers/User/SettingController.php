<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    const PATH = "user.setting.";

    public function index()
    {
        return view(self::PATH . 'index');
    }
}
