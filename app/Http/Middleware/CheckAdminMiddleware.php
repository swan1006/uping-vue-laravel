<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminMiddleware
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
        if ($request->user()->is_admin == 0) {
            return redirect()->route('/dashboard/partner/');
        } elseif ($request->user()->is_admin == 2) {
            return redirect()->route('/dashboard/buyer/');
        }

        return $next($request);
    }
}
