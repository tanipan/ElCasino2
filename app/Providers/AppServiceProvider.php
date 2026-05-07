<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrap();
        
        try {
            $hour = date('H');
            $tema = ($hour >= 19 && $hour <= 23) ? 1 : 0;
            \Illuminate\Support\Facades\View::share('tema', $tema);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\View::share('tema', 0);
        }
    }
}
