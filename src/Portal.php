<?php

namespace Ikoncept\Ico8Portal;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;

class Portal
{
    use Macroable;

    protected PortalClient $client;


    public function __construct(PortalClient $client)
    {
        $this->client = $client;
    }

    public function fetchPortal() : Collection
    {
        $response = $this->performQuery('/portals/' . $this->client->getPortalId(), []);

        return collect($response, true);
    }


    /**
     * Call the query method on the authenticated client.
     *
     * @return array|null
     */
    public function performQuery(string $endpoint, array $others = [])
    {
        return $this->client->performQuery(
            $endpoint,
            $others
        );
    }
}