<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('isManager', function($user) {
            foreach ($user->role as $key => $value) {
                return $value->name == 'manager';
            }
        });

        Gate::define('isMedis', function($user) {
            foreach ($user->role as $key => $value) {
                return $value->name == 'medis';
            }
        });

        Gate::define('isKasir', function($user) {
            foreach ($user->role as $key => $value) {
                return $value->name == 'kasir';
            }
        });
    }
}
