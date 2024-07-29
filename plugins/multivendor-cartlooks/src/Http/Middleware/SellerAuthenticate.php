<?php

namespace Plugin\Multivendor\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SellerAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() != null && auth()->user()->user_type == config('cartlookscore.user_type.seller')) {
            return $next($request);
        }
        if (isActivePlugin('multivendor-cartlooks')) {
            return redirect('/seller/login');
        }
        return redirect('/');
    }
}
