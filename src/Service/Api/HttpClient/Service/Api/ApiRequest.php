<?php

declare(strict_types=1);

namespace App\Service\Api\HttpClient\Service\Api;

use App\Dto\Api\ResponseData;
use App\Service\Api\HttpClient\ApiHttpClientResponseErrorHelper;
use App\Service\Api\HttpClient\Service\RequestInterface;
use App\Service\Api\HttpClient\Service\ResponseInterface;
use App\Service\Api\HttpClient\Exception;
use GuzzleHttp\Client;

class ApiRequest implements RequestInterface
{
    /**
     * @var string
     */
    private string $url;

    /**
     * @var float
     */
    private float $payment;

    /**
     * @param string $url
     * @param float $payment
     */
    public function __construct(string $url, float $payment)
    {
        $this->url = $url;
        $this->payment = $payment;
    }

    /**
     * @param Client $httpClient
     *
     * @return ResponseInterface
     *
     * @throws Exception\ApiHttpClientException
     * @throws Exception\ApiHttpClientForbiddenException
     * @throws Exception\ApiHttpClientUnauthorizedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute(Client $httpClient): ResponseInterface
    {
        $responseClient = $httpClient->post(
            $this->url,
            [
                'json' => [
                    'payment' => $this->payment,
                ],
            ]
        );

        $responseData = json_decode($responseClient->getBody()->getContents());

        ApiHttpClientResponseErrorHelper::checkAndThrow(
            $responseClient->getStatusCode(),
            $responseData
        );
        $responseData['statusCode'] = $responseClient->getStatusCode();

        return new ApiResponse(new ResponseData($responseData));
    }
}
