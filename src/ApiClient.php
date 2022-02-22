<?php

namespace Ikoncept\Ico8;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ApiClient
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



    public function __construct(string $host, string $apiKey, string $tenantId)
    {
        $this->host = $host;
        $this->tenantId = $tenantId;
        $this->apiKey = $apiKey;
    }

    /**
     * Perform the http request
     *
     * @param string $endpoint
     * @param array $parameters
     * @return mixed
     */
    public function performQuery(string $endpoint, array $parameters = [])
    {
        $response = Http::withHeaders([
            'X-Token' => $this->apiKey,
            'X-Tenant' => $this->tenantId,
        ])->get($this->host . $endpoint, $parameters);

        dd($response);

        $response->throw();

        return $response->json();
    }
}
