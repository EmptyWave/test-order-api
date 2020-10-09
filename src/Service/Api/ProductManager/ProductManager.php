<?php

declare(strict_types=1);

namespace App\Service\Api\ProductManager;


use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductManager
{
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function generateProducts(int $productCount): array
    {
        $products = [];
        for ($i = 1; $i <= $productCount; $i++) {
            $product = new Product();
            $product->setName('test-' . $i);
            $product->setPrice(random_int(10000, 100000)/100);

            $this->productRepository->save($product);

            $products[] = $product;
        }

        return $products;
    }
}