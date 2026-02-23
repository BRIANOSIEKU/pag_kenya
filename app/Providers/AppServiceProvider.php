<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Department;
use App\Models\ContactInfo;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Use Bootstrap pagination
        Paginator::useBootstrap();

        // Share departments with all views
        View::composer('*', function ($view) {
            $departments = Department::orderBy('name', 'asc')->get();
            $view->with('navDepartments', $departments);

            // Share contact info with all views
            $contactInfo = ContactInfo::first();
            $view->with('contactInfo', $contactInfo);
        });
    }
}