<?php

namespace Ikoncept\Ico8Portal\Tests;

use Ikoncept\Ico8Portal\Exceptions\InvalidConfiguration;
use Ikoncept\Ico8Portal\Portal;
use Ikoncept\Ico8Portal\PortalClient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Mockery;

class PortalTest extends TestCase
{

    /** @var \Ikoncept\Ico8Portal\PortalClient|\Mockery\Mock */
    protected $portalClient;

    /** @var string */
    protected $portalId;

    /** @var \Ikoncept\Ico8Portal\Portal */
    protected $portal;

    public function setUp(): void
    {
        $this->portalClient = Mockery::mock(PortalClient::class);

        $this->portalId = '91283';

        $this->portal = new Portal($this->portalClient, $this->portalId);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    /** @test */
    public function it_can_fetch_portalized_media()
    {
        $expectedArguments = [
            '/api/portals/1/media'
        ];

        $this->portalClient
            ->shouldReceive('performQuery')->withArgs($expectedArguments)
            ->once()
            ->andReturn([
                "data" => [
                    "id" => 1,
                    "user_id" => "1",
                    "name" => "The portal name",
                    "type" => "shared",
                    "albums" => [],
                    "categories" => []
                  ]
            ]);

        $response = $this->portal->fetchPortalizedMedia();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals('The portal name', $response['data']['name']);
        $this->assertEquals('shared', $response['data']['type']);
    }

}