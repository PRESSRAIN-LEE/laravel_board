<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;    //페이지네이션 추가
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
        //
        Paginator::useBootstrap();  //페이지네이션 추가
    }
}
