<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\CartComposer;

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
        View::composer('layouts.navbar', CartComposer::class);

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
