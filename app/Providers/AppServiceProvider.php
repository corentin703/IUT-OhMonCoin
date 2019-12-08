<?php

namespace App\Providers;

use App\Advert;
use App\Category;
use App\Observers\AdvertObserver;
use App\Observers\CategoryObserver;
use App\Observers\PictureObserver;
use App\Observers\UserObserver;
use App\Picture;
use App\User;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Advert::observe(AdvertObserver::class);
        Category::observe(CategoryObserver::class);
        Picture::observe(PictureObserver::class);
        User::observe(UserObserver::class);
    }
}
