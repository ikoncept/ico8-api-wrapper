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

    /** @test **/
    public function it_can_fetch_portal_media()
    {
        $expectedArguments = [
            '/portals/1/media',
            ['per_page' => 15]
        ];

        $this->portalClient
            ->shouldReceive('performQuery')->withArgs($expectedArguments)
            ->once()
            ->andReturn($this->sampleMediaResponse());
        $this->portalClient
            ->shouldReceive('getPortalId')
            ->once()
            ->andReturn('1');

        $response = $this->portal->fetchPortalMedia(['per_page' => 15]);

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals(8, $response['data'][0]['id']);
        $this->assertEquals('#fff', $response['data'][0]['avg_color']);
        $this->assertEquals('15', $response['meta']['per_page']);
    }

    /** @test **/
    public function it_can_search_for_media()
    {
        $expectedArguments = [
            '/portals/1/media',
            ['filter[search]' => 'rolfmedia', 'per_page' => 15]
        ];

        $this->portalClient
            ->shouldReceive('performQuery')->withArgs($expectedArguments)
            ->once()
            ->andReturn($this->sampleSearchResponse());
        $this->portalClient
            ->shouldReceive('getPortalId')
            ->once()
            ->andReturn('1');

        $response = $this->portal->searchPortalMedia('rolfmedia', ['per_page' => 15]);

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals('rolfmedia', $response['data'][0]['name']);
        $this->assertCount(1, $response['data']);
    }

    /** @test **/
    public function it_can_validate_a_password()
    {
        $expectedArguments = [
            '/portals/1/validate',
            ['password' => 'the_password']
        ];

        $this->portalClient
            ->shouldReceive('performQuery')->withArgs($expectedArguments)
            ->once()
            ->andReturn([
                'message' => 'Supplied password was correct'
            ]);
        $this->portalClient
            ->shouldReceive('getPortalId')
            ->once()
            ->andReturn('1');

        $response = $this->portal->validatePassword('the_password');
        $this->assertInstanceOf(Collection::class, $response);
    }

    protected function sampleSearchResponse()
    {
        return json_decode('{
            "data": [
            {
                "id": 8,
                "uuid": null,
                "name": "rolfmedia",
                "url": "http://localhost/store/",
                "type": null,
                "mime_type": null,
                "folder": null,
                "category_id": 10,
                "category": {
                "id": 10,
                "name": "Mrs. Addie Green",
                "slug": "mrs-addie-green"
                },
                "created_at": "2021-04-23T09:29:38.000000Z",
                "filesize": "12894764",
                "width": null,
                "height": null,
                "user_id": null,
                "avg_color": "#fff",
                "public": "1",
                "locked": "0",
                "files": [],
                "favorited": 0,
                "trashed": false,
                "tags": [],
                "albums": [
                    {
                        "id": 2,
                        "name": "incidunt cum",
                        "type": "shared",
                        "user_id": null,
                        "count": 2
                    }
                ]
            }
            ]
        }', true);
    }
    protected function sampleMediaResponse()
    {
       return json_decode('{
        "data": [
          {
            "id": 8,
            "uuid": null,
            "name": null,
            "url": "http://localhost/store/",
            "type": null,
            "mime_type": null,
            "folder": null,
            "category_id": 10,
            "category": {
              "id": 10,
              "name": "Mrs. Addie Green",
              "slug": "mrs-addie-green"
            },
            "created_at": "2021-04-23T09:29:38.000000Z",
            "filesize": "12894764",
            "width": null,
            "height": null,
            "user_id": null,
            "avg_color": "#fff",
            "public": "1",
            "locked": "0",
            "files": [],
            "favorited": 0,
            "trashed": false,
            "tags": [],
            "albums": [
              {
                "id": 2,
                "name": "incidunt cum",
                "type": "shared",
                "user_id": null,
                "count": 2
              }
            ]
          },
          {
            "id": 9,
            "uuid": null,
            "name": null,
            "url": "http://localhost/store/",
            "type": null,
            "mime_type": null,
            "folder": null,
            "category_id": 13,
            "category": {
              "id": 13,
              "name": "Daisha Klein",
              "slug": "daisha-klein"
            },
            "created_at": "2021-04-23T09:29:38.000000Z",
            "filesize": "37460196",
            "width": null,
            "height": null,
            "user_id": null,
            "avg_color": "#fff",
            "public": "1",
            "locked": "0",
            "files": [],
            "favorited": 0,
            "trashed": false,
            "tags": [],
            "albums": [
              {
                "id": 2,
                "name": "incidunt cum",
                "type": "shared",
                "user_id": null,
                "count": 2
              }
            ]
          }
        ],
        "links": {
          "first": "http://localhost/v1/portals/2/media?page=1",
          "last": "http://localhost/v1/portals/2/media?page=1",
          "prev": null,
          "next": null
        },
        "meta": {
          "current_page": 1,
          "from": 1,
          "last_page": 1,
          "links": [
            {
              "url": null,
              "label": "&laquo; Previous",
              "active": false
            },
            {
              "url": "http://localhost/v1/portals/2/media?page=1",
              "label": "1",
              "active": true
            },
            {
              "url": null,
              "label": "Next &raquo;",
              "active": false
            }
          ],
          "path": "http://localhost/v1/portals/2/media",
          "per_page": 15,
          "to": 7,
          "total": 7
        }
      }', true);
    }
}
