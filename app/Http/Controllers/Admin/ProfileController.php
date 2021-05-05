<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return view('admin.profile.show', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }
}
