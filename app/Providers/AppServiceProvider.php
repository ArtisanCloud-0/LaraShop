<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use App\Models\User;
use Illuminate\Support\Facades\URL;

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
        // Only users with the 'admin' role can access the control panel
        Gate::define('access-control-panel', function (User $user) {
            return $user->isAdmin() || $user->isSuperAdmin();
        });

        // Make Laravel force HTTPS
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
