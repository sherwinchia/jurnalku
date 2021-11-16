<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!(isset(auth()->user()->subscription) && auth()->user()->subscription_active)) {
            return redirect()->route('user.profile.show');
        }
        return $next($request);
    }
}
