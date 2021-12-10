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
        $terms = json_decode(AppSetting::where('name', 'terms')->firstOrFail()->data);
        return view(self::PATH . 'show', compact('terms'));
    }
}
