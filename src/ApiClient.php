<?php

namespace Ikoncept\Ico8;

use Ikoncept\Ico8\Exceptions\ConnectionError;
use Illuminate\Http\Client\ConnectionException;
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
        try {
            $response = Http::acceptJson()->withHeaders([
                'X-Token' => $this->apiKey,
                'X-Tenant' => $this->tenantId,
                'accept'
            ])->get($this->host . $endpoint, $parameters);

            $response->throw();

            return $response->json();
        } catch (\Exception $exception) {
            $statusCode = $exception->response->getStatusCode();

            switch ($statusCode) {
                case 404:
                    throw ConnectionError::missing($exception);
                default:
                    throw ConnectionError::general($exception);
            }
        }
    }
}
