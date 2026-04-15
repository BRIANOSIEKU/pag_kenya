<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (!$user->hasAnyRole([
            'super_admin',
            'admin',
            'general_superintendent',
            'general_treasurer',
            'general_secretary'
        ])) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}