<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    const PATH = "user.home.";

    public function index()
    {
        if (auth()->check()) {
            // if (auth()->user()->is_admin) {
            //     return redirect()->route('admin.dashboard.index');
            // }
            if (auth()->user()->is_user) {
                return redirect()->route('user.dashboard.index');
            }
        }
        $packages = Package::where('active', true)->where('display', true)->get();

        $promotionBanner = json_decode(AppSetting::where('name', 'promotion_banner')->first()->data, true);

        $faqs = json_decode(AppSetting::where('name', 'faq')->first()->data, true);

        return view(self::PATH . 'index', compact('packages', 'promotionBanner', 'faqs'));
    }
}
