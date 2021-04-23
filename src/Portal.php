<?php

namespace Ikoncept\Ico8Portal;

use Illuminate\Http\Client\Response;
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

    public function fetchPortalizedMedia() : Collection
    {
        $response = $this->performQuery('/portals', []);

        return $response->body();
    }

    /**
     * Call the query method on the authenticated client.
     *
     */
    public function performQuery(string $endpoint, array $others = []) : Response
    {
        return $this->client->performQuery(
            $endpoint, $others
        );
    }

}