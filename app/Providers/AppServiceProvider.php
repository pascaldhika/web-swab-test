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
        Gate::define('isSuperAdmin', function($user) {
            foreach ($user->role as $key => $value) {
                return $value->name == 'super admin';
            }
        });

        Gate::define('isNakes', function($user) {
            foreach ($user->role as $key => $value) {
                return $value->name == 'nakes';
            }
        });

        Gate::define('isKasir', function($user) {
            foreach ($user->role as $key => $value) {
                return $value->name == 'kasir';
            }
        });

        Gate::define('isAdmin', function($user) {
            foreach ($user->role as $key => $value) {
                return $value->name == 'admin';
            }
        });
    }
}
