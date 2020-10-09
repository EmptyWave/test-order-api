<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Service\Api\HttpClient\ApiHttpClient;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    public function testCreateOrder(): void
    {
        $client = new ApiHttpClient(new Client());
    }

    public function testPayOrder(): void
    {

    }
}