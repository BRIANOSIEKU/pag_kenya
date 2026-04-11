<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        // ONLY protect admin area
        if ($request->is('admin/*')) {
            return route('admin.login');
        }

        // ONLY protect district admin area
        if ($request->is('district-admin/*')) {
            return route('district.admin.login');
        }

        // IMPORTANT: never redirect for public pages
        return null;
    }
}