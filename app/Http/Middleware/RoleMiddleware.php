<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(
        Request $request,
        Closure $next,
    ) {
        // if (!Auth::check()) {
        //     abort(403, 'Unauthorized');
        // }

        return $next($request);
    }
}
