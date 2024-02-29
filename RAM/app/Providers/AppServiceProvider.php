<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\TblSchedule;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // View::composer('*', function ($view) {
        //     $view->with('schedules', TblSchedule::all());
        // });
        View::composer(['superadmin', 'manage_appointmets.index'], function ($view) {
            $view->with('schedules', TblSchedule::all());
        });
        View::composer(['admin', 'manage_appointmets.index'], function ($view) {
            $view->with('schedules', TblSchedule::all());
        });

        Paginator::defaultView('pagination::bootstrap-5');
        // If you want to use simple pagination links
        Paginator::defaultSimpleView('pagination::simple-bootstrap-5');

    }
}
