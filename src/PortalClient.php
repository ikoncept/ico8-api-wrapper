<?php

namespace Ikoncept\Ico8Portal;

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
    protected $portal_id;


    public function __construct(string $host, string $apiKey, string $portal_id)
    {
        $this->host = $host;
        $this->apiKey = $apiKey;
        $this->portal_id = $portal_id;
    }

    public function performQuery(string $endpoint, array $other = []) : array
    {
        $response = Http::get('https://example.com/' . $endpoint, [
            'all-the-stuff' => true
        ]);

        return collect($response)->toArray();
    }

}