<?php

namespace Ikoncept\Ico8Portal\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Ikoncept\Ico8Portal\PortalFacade;
use Ikoncept\Ico8Portal\Ico8PortalServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            Ico8PortalServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Portal' => PortalFacade::class,
        ];
    }
}