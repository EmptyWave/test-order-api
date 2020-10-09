<?php

namespace App\Dto\Api;

use App\Dto\DataTransferObject;

class ResponseData extends DataTransferObject
{
    /** @var array $body */
    public $body;

    /** @var int $statusCode */
    public $statusCode;

    /**
     * @return array|null
     */
    public function getBody(): ?array
    {
        return $this->body;
    }

    /**
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }
}