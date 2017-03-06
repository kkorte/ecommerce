<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use View;
use App\Shop as Shop;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('admin')->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/admin/security/login');
            }
        }

        if (Auth::guard('admin')->check()) {
            View::share('this_user', Auth::guard('admin')->user());
            
            View::share('available_shops', Shop::all());
        }

        return $next($request);
    }
}
