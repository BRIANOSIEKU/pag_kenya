<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use App\Models\Department;
use App\Models\ContactInfo;
use Exception;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Bootstrap pagination for links()
        Paginator::useBootstrap();

        /**
         * Share departments and contact info with all views.
         * We wrap this in a try-catch to prevent the app from crashing 
         * if the database is down or during migrations.
         */
        View::composer('*', function ($view) {
            try {
                // Fetch data only if the connection is active
                $departments = Department::orderBy('name', 'asc')->get();
                $contactInfo = ContactInfo::first();

                $view->with([
                    'navDepartments' => $departments,
                    'contactInfo' => $contactInfo
                ]);
            } catch (Exception $e) {
                // If DB fails, pass empty data so the UI doesn't break
                $view->with([
                    'navDepartments' => collect(),
                    'contactInfo' => null
                ]);
            }
        });
    }
}