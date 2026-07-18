<?php

namespace JordJD\LaravelDomainToLocale;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register package configuration.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/domain-to-locale.php', 'domain-to-locale');
    }

    /**
     * Bootstrap package.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/domain-to-locale.php' => config_path('domain-to-locale.php'),
        ]);
    }
}
