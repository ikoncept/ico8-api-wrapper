<?php

namespace Ikoncept\Ico8;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;

class Media
{
    use Macroable;

    protected ApiClient $client;

    public array $filters = [];
    public int $page = 1;
    public int $limit = 100;
    public string $sort = "";
    public string $include = "";

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function fetch(array $parameters = []) : Collection
    {
        $parameters = collect($this->filters)->mapWithKeys(function ($value, $filter) {
            return [sprintf('filter[%s]', $filter) => $value];
        })->merge($parameters)->toArray();

        $parameters['page'] = $this->page;
        $parameters['limit'] = $this->limit;
        $parameters['sort'] = $this->sort;
        $parameters['include'] = $this->include;
        
        $response = $this->performQuery('/media', $parameters);

        return collect($response);
    }

    public function search(string $searchQuery) : Media
    {
        return $this->filter('text', $searchQuery);
    }

    public function filter(string $filterName, mixed $value) : Media
    {
        $this->filters[$filterName] = $value;

        return $this;
    }

    public function page(int $page) : Media
    {
        $this->page = $page;

        return $this;
    }

    public function sort(string $sort) : Media
    {
        $this->sort = $sort;
        
        return $this;
    }

    public function limit(int $limit) : Media
    {
        $this->limit = $limit;
        
        return $this;
    }

    public function include(string $include) : Media
    {
        $this->include = $include;
        
        return $this;
    }


    public function get(int $mediaId): object
    {
        $response = $this->performQuery('/media/' . $mediaId);

        return (object)$response;
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
