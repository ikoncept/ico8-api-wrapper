<?php

namespace Ikoncept\Ico8\Tests;

use Ikoncept\Ico8\ApiClient;
use Mockery;

class MediaTest extends TestCase
{

    /** @var \Ikoncept\Ico8\ApiClient|\Mockery\Mock */
    protected $mediaClient;

    /** @var string */
    protected $tenantId;

    /** @var string */
    protected $host;

    /** @var \Ikoncept\Ico8\Portal */
    protected $portal;

    public function setUp(): void
    {
        $this->mediaClient = Mockery::mock(ApiClient::class);

        $this->tenantId = '2183091-213-1012312-231';
        $this->apiKey = '231';
        $this->host = 'https://example.com';
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
}
