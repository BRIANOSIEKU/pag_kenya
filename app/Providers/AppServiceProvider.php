<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Department;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Use Bootstrap pagination (optional)
        Paginator::useBootstrap();

        // Share departments with all views
        View::composer('*', function ($view) {
            $departments = Department::orderBy('name', 'asc')->get();
            $view->with('navDepartments', $departments);
        });
    }
}
