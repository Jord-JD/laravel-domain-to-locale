<?php

namespace JordJD\LaravelDomainToLocale;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
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