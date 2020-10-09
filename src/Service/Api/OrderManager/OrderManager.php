<?php

declare(strict_types=1);

namespace App\Service\Api\OrderManager;

use App\Dto\Api\ResponseData;
use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\Product;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Service\Api\HttpClient\ApiHttpClient;
use App\Service\Api\HttpClient\Service\Api\ApiRequest;
use Symfony\Component\HttpFoundation\Response;

class OrderManager
{
    private const PAYMENT_URL = 'ya.ru';

    /** @var OrderRepository */
    private OrderRepository $orderRepository;

    /** @var ProductRepository */
    private ProductRepository $productRepository;

    /** @var ApiHttpClient */
    private ApiHttpClient $httpClient;

    public function __construct(
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        ApiHttpClient $httpClient
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->httpClient = $httpClient;
    }

    public function createOrder(array $products): Order
    {
        $productIds = array_filter(
            array_map(
                static function (array $data) {
                    return $data['id'];
                },
                $products
            )
        );

        $products = $this->productRepository->findByIds($productIds);
        if (count($products) < count($productIds)) {
            throw new Exception\CreateOrderException('Didn\'t find some products');
        }

        $cart = new Cart();

        /** @var Product $product */
        foreach ($products as $product) {
            $cart->addProduct($product);
        }

        $cart->setSum($cart->calculateCartPrice());

        $order = new Order();
        $order->setCart($cart);

        $this->orderRepository->save($order);

        return $order;
    }

    public function payOrder(int $orderId, float $payment): ?Order
    {
        /** @var Order|null $order */
        $order = $this->orderRepository->find($orderId);
        if (!$order) {
            throw new Exception\PaymentOrderException('Order not found by id' . $orderId);
        }

        $orderSum = $order->getSum();
        if (($orderSum === $payment) && $order->isNew()) {
            $request = new ApiRequest($payment);
            $data = $this->httpClient->request($request);

            /** @var ResponseData $data */
            if ($data->getStatusCode() === Response::HTTP_OK) {
                $order->setPaid();

                $this->orderRepository->save($order);
            }
        }

        return $order;
    }
}