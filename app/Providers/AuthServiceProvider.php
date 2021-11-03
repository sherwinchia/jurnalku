<?php

namespace App\Providers;

use App\Models\Portfolio;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-trade', function (User $user, Trade $trade) {
            return $user->id === $trade->portfolio->user_id;
        });

        Gate::define('add-trade', function (User $user, Portfolio $portfolio) {
            return $user->id === $portfolio->user_id;
        });

        Gate::define('manage-portfolio', function (User $user, Portfolio $portfolio) {
            return $user->id === $portfolio->user_id;
        });
    }
}
