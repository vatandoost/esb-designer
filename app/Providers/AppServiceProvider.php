<?php

namespace App\Providers;

use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Inertia::share([
            'activeProject' => function () {
                return Session::get('active_project');
            },
            'toast' => function () {
                // return [
                //     'severity' => 'success',
                //     'summary' => 'success',
                //     'detail' => 'success'
                // ];
                return Session::get('toast_message');
            },
        ]);
    }
}
