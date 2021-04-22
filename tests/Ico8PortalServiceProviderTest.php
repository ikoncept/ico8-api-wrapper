<?php

namespace Ikoncept\Ico8Portal\Tests;

use Ikoncept\Ico8Portal\Exceptions\InvalidConfiguration;
use Ikoncept\Ico8Portal\PortalFacade;
use Illuminate\Support\Facades\Config;
use Portal;

class Ico8PortalServiceProviderTest extends TestCase
{

    /** @test */
    public function it_will_throw_an_exception_if_the_api_key_is_not_set()
    {
        Config::set('ico8-portal.api_key', '');

        $this->expectException(InvalidConfiguration::class);

        Portal::fetchPortalizedMedia();
    }
}