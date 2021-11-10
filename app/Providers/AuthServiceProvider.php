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
        'App\Models\Portfolio' => 'App\Policies\PortfolioPolicy',
        'App\Models\Trade' => 'App\Policies\TradePolicy',
        'App\Models\Transaction' => 'App\Policies\TransactionPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
