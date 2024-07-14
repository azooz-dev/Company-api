<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Buyer;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use App\Policies\BuyerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\SellerPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Buyer::class => BuyerPolicy::class,
        Seller::class => SellerPolicy::class,
        User::class => UserPolicy::class,
        Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('saleProduct', function (User $user, User $seller) {
            return $user->id === $seller->id;
        });

        Gate::define('allow-admin', function (User $user) {
            return $user->isAdmin();
        });
    }
}
