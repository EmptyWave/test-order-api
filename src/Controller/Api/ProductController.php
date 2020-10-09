<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\ResponseData;
use App\Service\Api\ProductManager\ProductManager;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends BaseApiController
{
    /** @var ProductManager $productManager */
    private $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    public function generateProductsAction(): Response
    {
        $products = $this->productManager->generateProducts(20);
        $responseData = new ResponseData(['body' => $products, 'statusCode' => Response::HTTP_OK]);

        return $this->baseOkResponse($responseData, Response::HTTP_OK);
    }
}