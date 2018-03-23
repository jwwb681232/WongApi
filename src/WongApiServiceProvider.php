<?php

namespace Jwwb681232\WongApi;

use Illuminate\Support\ServiceProvider;

class WongApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands('Jwwb681232\WongApi\Console\WongApiCommand');
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
