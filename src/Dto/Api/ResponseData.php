<?php

namespace App\Dto\Api;

use App\Dto\DataTransferObject;

class ResponseData extends DataTransferObject
{
    public string $body;

    public string $statusCode;

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @return string|null
     */
    public function getStatusCode(): ?string
    {
        return $this->statusCode;
    }
}