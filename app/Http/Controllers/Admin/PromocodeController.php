<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promocode;

class PromocodeController extends Controller
{

    const PATH = "admin.promocode.";

    public function index()
    {
        return view(self::PATH . "index");
    }

    public function create()
    {
        return view(self::PATH . "create");
    }

    public function show(Promocode $promocode)
    {
        return view(self::PATH . "show", compact("promocode"));
    }

    public function edit(Promocode $promocode)
    {
        return view(self::PATH . "edit", compact("promocode"));
    }
}
