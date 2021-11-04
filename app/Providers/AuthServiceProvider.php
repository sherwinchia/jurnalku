<?php

namespace App\Providers;

use App\Models\Portfolio;
use App\Models\PortfolioBalance;
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

        //Edit, view and delete portfolio
        Gate::define('manage-trade', function (User $user, Trade $trade) {
            return $user->id === $trade->portfolio->user_id;
        });

        //Add trade to portfolio
        Gate::define('add-trade', function (User $user, Portfolio $portfolio) {
            return $user->id === $portfolio->user_id;
        });

        //Edit and delete portfolio
        Gate::define('manage-portfolio', function (User $user, Portfolio $portfolio) {
            return $user->id === $portfolio->user_id;
        });

        //Add portfolio
        Gate::define('add-portfolio', function (User $user) {
            $subscription = $user->subscription_type;
            if ($subscription === "paid" && $user->portfolios->count() < $user->max_portfolio) {
                return true;
            }
            if ($subscription === "free" && $user->portfolios->count() < 1) {
                return true;
            }

        });

        //Add portfolio balance
        Gate::define('add-portfolio-balance', function (User $user, Portfolio $portfolio) {
            return $user->portfolios->contains($portfolio) ;
        });

        //Delete portfolio balance
        Gate::define('delete-portfolio-balance', function (User $user, PortfolioBalance $balance) {
            return $user->portfolios->contains($balance->portfolio) ;
        });
    }
}
