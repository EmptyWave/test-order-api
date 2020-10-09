<?php

declare(strict_types=1);

namespace App\Service\Api\HttpClient\Service\Api;

use App\Dto\Api\ResponseData;
use App\Service\Api\HttpClient\Service\ResponseInterface;

class ApiResponse implements ResponseInterface
{
    /**
     * @var ResponseData
     */
    private ResponseData $responseData;

    /**
     * @param ResponseData $percent
     */
    public function __construct(ResponseData $percent)
    {
        $this->responseData = $percent;
    }

    /**
     * @return ResponseData
     */
    public function getData(): ResponseData
    {
        return $this->responseData;
    }
}
