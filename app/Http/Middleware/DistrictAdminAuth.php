<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DistrictAdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the specific session key you used in the view exists
        if (!$request->session()->has('district_admin_id')) {
            return redirect()->route('district.admin.login')
                ->with('error', 'Session expired. Please login again.');
        }

        return $next($request);
    }
}