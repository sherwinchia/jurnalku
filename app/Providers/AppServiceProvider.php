<?php

namespace App\Providers;

use App\Helpers\UserSettings;
use Illuminate\Support\Facades\Blade;
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
        $this->app->singleton(UserSettings::class, function () {
            return new UserSettings();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('admin', function () {
            if (auth()->user() && auth()->user()->is_admin) {
                return 1;
            }
            return 0;
        });

        Blade::if('user', function () {
            if (auth()->user() && auth()->user()->is_user) {
                return 1;
            }
            return 0;
        });
    }
}
