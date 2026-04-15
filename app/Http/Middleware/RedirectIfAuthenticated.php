<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                $user = Auth::user();

                // 🔥 Admin roles go to admin dashboard
                if ($user && $user->hasAnyRole([
                    'super-admin',
                    'admin',
                    'general-secretary',
                    'general-treasurer',
                    'general-superintendent',
                ])) {
                    return redirect('/admin/dashboard');
                }

                // 👇 All other users go to homepage
                return redirect('/');
            }
        }

        return $next($request);
    }
}