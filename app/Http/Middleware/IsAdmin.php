<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
   public function handle($request, Closure $next)
{
    if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'super_admin'])) {
        return redirect('/'); // or redirect()->route('admin.login');
    }
    return $next($request);
}
}
