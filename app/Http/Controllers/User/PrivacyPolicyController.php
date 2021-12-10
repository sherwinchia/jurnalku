<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    const PATH = "user.policy.";

    public function show()
    {
        $policy = json_decode(AppSetting::where('name', 'policy')->firstOrFail()->data);
        return view(self::PATH . 'show', compact('policy'));
    }
}
