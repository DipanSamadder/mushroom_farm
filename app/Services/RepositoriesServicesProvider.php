<?php

namespace App\Services;


use Illuminate\Support\ServiceProvider;
use App\Interfaces\PostInterfaces;
use App\Repositories\PostRepositories;


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
    }
}