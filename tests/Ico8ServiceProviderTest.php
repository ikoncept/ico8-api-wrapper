<?php

namespace Ikoncept\Ico8\Tests;

use Ikoncept\Ico8\Exceptions\InvalidConfiguration;
use Ikoncept\Ico8\Facades\Ico8;
use Illuminate\Support\Facades\Config;
use Portal;

class Ico8ServiceProviderTest extends TestCase
{

    /** @test */
    public function it_will_throw_an_exception_if_the_api_key_is_not_set()
    {
        Config::set('ico8-api-wrapper.api_key', '');

        $this->expectException(InvalidConfiguration::class);

        Ico8::fetchIco8();
    }
}
