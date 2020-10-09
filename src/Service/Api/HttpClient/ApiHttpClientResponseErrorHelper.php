<?php

declare(strict_types=1);

namespace App\Service\Api\HttpClient;

use App\Service\Api\HttpClient\Exception\ApiHttpClientException;
use App\Service\Api\HttpClient\Exception\ApiHttpClientForbiddenException;
use App\Service\Api\HttpClient\Exception\ApiHttpClientUnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class ApiHttpClientResponseErrorHelper
{
    /**
     * @param int $statusCode
     * @param array $responseData
     *
     * @throws ApiHttpClientException
     * @throws ApiHttpClientForbiddenException
     * @throws ApiHttpClientUnauthorizedException
     */
    public static function checkAndThrow(int $statusCode, array $responseData)
    {
        if ($statusCode > 399) {
            $errorMessage = sprintf(
                'Ошибка при запросе : http-статус ответа %d',
                $statusCode
            );

            if ($statusCode === Response::HTTP_UNAUTHORIZED) {
                throw new ApiHttpClientUnauthorizedException($errorMessage);
            }

            if ($statusCode === Response::HTTP_FORBIDDEN) {
                throw new ApiHttpClientForbiddenException($errorMessage);
            }

            throw new ApiHttpClientException($errorMessage);
        }
    }
}
