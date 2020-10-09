<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\ResponseData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseApiController
{
    /**
     * @param ResponseData $response
     *
     * @return JsonResponse
     */
    protected function baseOkResponse(ResponseData $response, int $responseCode): re
    {
        return new JsonResponse($response->getBody(), $responseCode);
    }

    protected function baseErrResponse(string $errMessage)
    {}
}