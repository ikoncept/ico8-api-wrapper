<?php

namespace Ikoncept\Ico8\Tests;

use Ikoncept\Ico8\Facades\Ico8;
use Orchestra\Testbench\TestCase as Orchestra;
use Ikoncept\Ico8\PortalFacade;
use Ikoncept\Ico8\Ico8ServiceProvider;

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
            Ico8ServiceProvider::class,
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
            'Ico8' => Ico8::class,
        ];
    }
}
