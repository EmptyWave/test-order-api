<?php

declare(strict_types=1);

namespace App\Service\Api\HttpClient;

use GuzzleHttp\Client;

class ApiHttpClient
{
    /** @var Client */
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param Service\RequestInterface $request
     *
     * @return Service\ResponseInterface
     *
     * @throws Exception\ApiHttpClientException
     * @throws Exception\ApiHttpClientForbiddenException
     * @throws Exception\ApiHttpClientUnauthorizedException
     */
    public function request(Service\RequestInterface $request): Service\ResponseInterface
    {
        return $request->execute($this->httpClient);
    }
}
