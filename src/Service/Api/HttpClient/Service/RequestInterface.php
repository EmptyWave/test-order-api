<?php

declare(strict_types=1);

namespace App\Service\Api\HttpClient\Service;

use GuzzleHttp\Client;
use App\Service\Api\HttpClient\Exception\ApiHttpClientException;
use App\Service\Api\HttpClient\Exception\ApiHttpClientForbiddenException;
use App\Service\Api\HttpClient\Exception\ApiHttpClientUnauthorizedException;

/**
 * @link https://redmine.book24.ru/issues/31696
 * @author Dmitriy Yudnkov <udenkov.d@book24.ru>
 */
interface RequestInterface
{
    /**
     * @param Client $httpClient
     *
     * @return ResponseInterface
     *
     * @throws ApiHttpClientException
     * @throws ApiHttpClientForbiddenException
     * @throws ApiHttpClientUnauthorizedException
     */
    public function execute(Client $httpClient): ResponseInterface;
}
