<?php

namespace Ikoncept\Ico8Portal;

use Ikoncept\Ico8Portal\Exceptions\InvalidConfiguration;
use Illuminate\Support\ServiceProvider;

class Ico8PortalServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ico8-portal.php' => config_path('ico8-portal.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ico8-portal.php', 'ico8-portal');
        $portalConfig = config('ico8-portal');

        $this->app->bind(PortalClient::class, function () use ($portalConfig) {
            return PortalClientFactory::createForConfig($portalConfig);
        });

        $this->app->bind(Portal::class, function () use ($portalConfig) {
            $this->guardAgainstInvalidConfiguration($portalConfig);

            $client = app(PortalClient::class);

            return new Portal($client, $portalConfig['api_key']);
        });

        $this->app->alias(Portal::class, 'ico8-portal');
    }

    /**
     * Check for invalid configuration
     *
     * @param array $portalConfig
     * @return void
     */
    protected function guardAgainstInvalidConfiguration($portalConfig)
    {
        if (! $portalConfig['api_key']) {
            throw InvalidConfiguration::apiKeyNotSpecified();
        }
    }
}
