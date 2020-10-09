<?php

declare(strict_types=1);

namespace App\Service\Factory;

use GuzzleHttp\Client;

class HttpClient
{
    public function getHttpClient()
    {
        return new Client();
    }
}