<?php

namespace App\Services;


use Illuminate\Support\ServiceProvider;
use App\Interfaces\PostInterfaces;
use App\Repositories\PostRepositories;
use App\Interfaces\TypeInterfaces;
use App\Repositories\TypeRepositories;


class RepositoriesServicesProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostInterfaces::class, PostRepositories::class);
        $this->app->bind(TypeInterfaces::class, TypeRepositories::class);
    }
}