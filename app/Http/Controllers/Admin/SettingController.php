<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    const PATH = "admin.setting.";

    public function index()
    {
        return view(self::PATH . 'index');
    }
}
