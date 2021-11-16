<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    const PATH = "user.home.";

    public function index()
    {
        if (auth()->check()) {
            if (auth()->user()->is_admin) {
                return redirect()->route('admin.dashboard.index');
            }
            if (auth()->user()->is_user) {
                return redirect()->route('user.dashboard.index');
            }
        }
        $packages = Package::where('active', true)->get();
        return view(self::PATH . 'index', compact('packages'));
    }
}
