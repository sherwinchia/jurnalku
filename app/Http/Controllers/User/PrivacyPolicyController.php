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
        $appSetting = AppSetting::where('name', 'policy')->firstOrFail();
        $updated_at = date_to_human($appSetting->updated_at, 'd/m/Y');
        $policy = json_decode($appSetting->data);
        return view(self::PATH . 'show', compact('policy', 'updated_at'));
    }
}
