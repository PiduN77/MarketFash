<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('isAdmin', function (User $user) {
            return $user->userType == 'A';
        });

        Gate::define('isSeller', function (User $user) {
            return $user->userType == 'S';
        });

        Gate::define('isCustomer', function (User $user) {
            return $user->userType == 'C';
        });
    }
}
