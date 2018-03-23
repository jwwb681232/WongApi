<?php

namespace Jwwb681232\WongApi;

use Illuminate\Support\ServiceProvider;
use Jwwb681232\WongApi\Console\WongApiCommand;

class WongApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([WongApiCommand::class]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
