<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    const PATH = "admin.package.";

    public function index()
    {
        return view(self::PATH . 'index');
    }

    public function edit(Package $package)
    {
        return view(self::PATH . 'edit', compact('package'));
    }

    public function create()
    {
        return view(self::PATH . 'create');
    }
}
