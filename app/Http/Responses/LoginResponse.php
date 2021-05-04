<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param $request
     * @return mixed
     */
    public function toResponse($request)
    {
        if ($request->wantsJson()) {
            return response()->json(['two_factor' => false]);
        } else {
            $home = auth()->user()->is_admin ? route('admin.dashboard.index') : route('user.dashboard.index');
            return redirect()->intended($home);
        }
    }
}
