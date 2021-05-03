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

        return collect($response);
    }

    public function fetchPortalMedia(array $parameters = []) : Collection
    {
        $response = $this->performQuery('/portals/' . $this->client->getPortalId() . '/media', $parameters);

        return collect($response);
    }

    public function searchPortalMedia(string $searchQuery, array $parameters = []) : Collection
    {
        if(! $searchQuery) {
            return $this->fetchPortalMedia($parameters);
        }
        $parameters['filter[search]'] = $searchQuery;

        return $this->fetchPortalMedia($parameters);
    }

    public function validatePassword(string $password) : Collection
    {
        $response = $this->performQuery('/portals/' . $this->client->getPortalId() . '/validate', [
            'password' => $password
        ]);

        return collect($response);
    }


    /**
     * Call the query method on the authenticated client.
     *
     * @return array|null
     */
    public function performQuery(string $endpoint, array $parameters = [])
    {
        return $this->client->performQuery(
            $endpoint,
            $parameters
        );
    }
}
