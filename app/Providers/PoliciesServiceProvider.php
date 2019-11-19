<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PoliciesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Adverts policies
        Gate::define('advert-create', 'App\Policies\AdvertPolicy@create');
        Gate::define('advert-update', 'App\Policies\AdvertPolicy@update');

        // Users policies
        Gate::define('user-update', 'App\Policies\UserPolicy@update');
        Gate::define('user-updatePassword', 'App\Policies\UserPolicy@updatePassword');
    }
}
