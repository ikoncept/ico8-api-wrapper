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

    /**
     * Fetches Media from iCatServer API.
     * Accepts an array of compatible filters,
     * which will be merged to already configured filters on the Media instance
     *
     * @param array $parameters
     * @return Collection
     */
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

    /**
     * Shorthand function to define a free text search.
     *
     * @param string $searchQuery
     * @return Media
     */
    public function search(string $searchQuery) : Media
    {
        return $this->filter('text', $searchQuery);
    }

    /**
     * Shorthand function to define filters
     *
     * @param string $filterName
     * @param mixed $value
     * @return Media
     */
    public function filter(string $filterName, mixed $value) : Media
    {
        $this->filters[$filterName] = $value;

        return $this;
    }

    /**
     * Shorthand function to define page for query
     *
     * @param integer $page
     * @return Media
     */
    public function page(int $page) : Media
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Shorthand function to define sort for query
     *
     * @param string $sort
     * @return Media
     */
    public function sort(string $sort) : Media
    {
        $this->sort = $sort;
        
        return $this;
    }

    /**
     * Shorthand function to define result limit for query
     *
     * @param integer $limit
     * @return Media
     */
    public function limit(int $limit) : Media
    {
        $this->limit = $limit;
        
        return $this;
    }

    /**
     * Shorthand function to define relations to be included in response
     *
     * @param string $include
     * @return Media
     */
    public function include(string $include) : Media
    {
        $this->include = $include;
        
        return $this;
    }

    /**
     * Fetch a single Media object
     *
     * @param integer $mediaId
     * @return object
     */
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
