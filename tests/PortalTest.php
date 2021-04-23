<?php

namespace Ikoncept\Ico8Portal\Tests;

use Ikoncept\Ico8Portal\Exceptions\InvalidConfiguration;
use Ikoncept\Ico8Portal\Portal;
use Ikoncept\Ico8Portal\PortalClient;
use Ikoncept\Ico8Portal\PortalFacade;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Mockery;

class PortalTest extends TestCase
{

    /** @var \Ikoncept\Ico8Portal\PortalClient|\Mockery\Mock */
    protected $portalClient;

    /** @var int */
    protected $portalId;

    /** @var string */
    protected $tenantId;

    /** @var string */
    protected $host;

    /** @var \Ikoncept\Ico8Portal\Portal */
    protected $portal;

    public function setUp(): void
    {
        $this->portalClient = Mockery::mock(PortalClient::class);

        $this->portalId = '91283';
        $this->tenantId = '2183091-213-1012312-231';
        $this->apiKey = '231';
        $this->host = 'https://example.com';

        $this->portal = new Portal($this->portalClient);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    /** @test **/
    public function it_can_fetch_the_portal()
    {
        $expectedArguments = [
            '/portals/1',
            []
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

        $this->portalClient
            ->shouldReceive('getPortalId')
            ->once()
            ->andReturn('1');

        $response = $this->portal->fetchPortal();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals('The portal name', $response['data']['name']);
        $this->assertEquals('shared', $response['data']['type']);
    }

    public function it_can_fetch_portalized_media()
    {
        $expectedArguments = [
            '/api/portals/1/media',
            []
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

        $response = $this->portal->fetchPortal();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals('The portal name', $response['data']['name']);
        $this->assertEquals('shared', $response['data']['type']);
    }
}