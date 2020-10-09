<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Service\Api\ProductManager\ProductManager;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiTest extends TestCase
{
    private ProductManager $productManager;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->productManager = new ProductManager();
    }

    public function testCreateOrder(): void
    {
        $httpClient = new Client();

        $products = $this->productManager->generateProducts(20);

        $response = $httpClient->request(
            'POST',
            sprintf("http://localhost/api/product/generate?products=%s", json_encode($products))
        );

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testPayOrder(): void
    {
        $httpClient = new Client();

        $orderId = 1;
        $payment = 0;

        $response = $httpClient->request(
            'POST',
            sprintf(
                "http://localhost/api/order/pay?orderId=%s&payment=%s",
                $orderId,
                $payment
            )
        );

        self::assertEquals(Response::HTTP_PARTIAL_CONTENT, $response->getStatusCode());
    }
}