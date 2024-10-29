<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    /**
     * Kiểm tra vai trò người dùng
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Session::get('user_role');

        if ($userRole === $role) {
            return $next($request);
        }

        return abort(403, 'Unauthorized action.');
    }
}
