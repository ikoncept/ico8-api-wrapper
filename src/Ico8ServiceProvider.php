<?php

namespace Ikoncept\Ico8;

use Ikoncept\Ico8\Exceptions\InvalidConfiguration;
use Illuminate\Support\ServiceProvider;

class Ico8ServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ico8-api-wrapper.php' => config_path('ico8-api-wrapper.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ico8-api-wrapper.php', 'ico8-api-wrapper');
        $icoConfig = config('ico8-api-wrapper');

        $this->app->bind(ApiClient::class, function () use ($icoConfig) {
            return ApiClientFactory::createForConfig($icoConfig);
        });

        $this->app->bind(Media::class, function () use ($icoConfig) {
            $this->guardAgainstInvalidConfiguration($icoConfig);

            $client = app(ApiClient::class);

            return new Media($client);
        });

        $this->app->alias(Media::class, 'ico8-api-wrapper');
    }

    /**
     * Check for invalid configuration
     *
     * @param array $icoConfig
     * @return void
     */
    protected function guardAgainstInvalidConfiguration($icoConfig)
    {
        if (! $icoConfig['api_key']) {
            throw InvalidConfiguration::apiKeyNotSpecified();
        }
    }
}
