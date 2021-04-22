<?php

namespace Ikoncept\Ico8Portal;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;

class Portal
{
    use Macroable;

    protected PortalClient $client;

    protected string $viewId;

    public function __construct(PortalClient $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function fetchPortalizedMedia() : Collection
    {
        $response = $this->performQuery('/api/portals/1/media');

        return collect($response);
    }

    /**
     * Call the query method on the authenticated client.
     *
     */
    public function performQuery(string $endpoint, array $others = []) : array
    {
        return $this->client->performQuery(
            $endpoint
        );
    }

}