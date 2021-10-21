<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller{

    const PATH = "admin.user.";

    public function index()
    {
        return view(self::PATH . "index");
    }

    public function create()
    {
        return view(self::PATH . "create");
    }

    public function show(User $user)
    {
        return view(self::PATH . "show", compact("user"));
    }

    public function edit(User $user)
    {
        return view(self::PATH . "edit", compact("user"));
    }
}
        