<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class TermsOfServiceController extends Controller
{
    const PATH = "user.terms.";

    public function show()
    {
        $appSetting = AppSetting::where('name', 'terms')->firstOrFail();
        $updated_at = date_to_human($appSetting->updated_at, 'd/m/Y');
        $terms = json_decode($appSetting->data);
        return view(self::PATH . 'show', compact('terms', 'updated_at'));
    }
}
