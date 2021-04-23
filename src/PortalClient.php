<?php

namespace Ikoncept\Ico8Portal;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PortalClient
{

    /**
     * The api key
     *
     * @var string
     */
    protected $apiKey;

    /**
     * The host path
     *
     * @var string
     */
    protected $host;

    /**
     * Portal id
     *
     * @var string
     */
    protected $portalId;


    public function __construct(string $host, string $apiKey, string $tenantId, int $portalId)
    {
        $this->host = $host;
        $this->tenantId = $tenantId;
        $this->apiKey = $apiKey;
        $this->portalId = $portalId;
    }

    public function performQuery(string $endpoint, array $other = []) : Response
    {
        $response = Http::withHeaders([
            'X-Token' => $this->apiKey,
            'X-Tenant' => $this->tenantId,
        ])->get($this->host . '/' . $endpoint, $other);

        return $response;
    }

}