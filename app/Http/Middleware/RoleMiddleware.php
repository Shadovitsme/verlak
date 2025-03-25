<?php

namespace App\Http\Middleware;

use App\Models\User;
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
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            dd('User not authenticated');
        }

        $user = Auth::user();
        echo (!$user->role == 'administrator');
        if ($user->role != 'administrator') {
            abort(403, 'Недостаточно прав');
        }

        return $next($request);
    }
}
