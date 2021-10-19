<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        return view('admin.package.index');
    }

    public function edit()
    {
        return view('admin.package.edit');
    }
    
    public function create()
    {
        return view('admin.package.edit');
    }
}
