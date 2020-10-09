<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\ResponseData;
use App\Service\Api\OrderManager\Exception\PaymentOrderException;
use App\Service\Api\OrderManager\OrderManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Api\OrderManager\Exception\CreateOrderException;

class OrderController extends BaseApiController
{
    /** @var OrderManager $orderManager */
    private $orderManager;

    public function __construct(OrderManager $orderManager)
    {
        $this->orderManager = $orderManager;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function createOrderAction(Request $request): Response
    {
        $products = json_decode($request->get('products'));

        try {
            $order = $this->orderManager->createOrder($products);
        } catch (CreateOrderException $exception) {
            return $this->baseErrResponse($exception->getMessage(), Response::HTTP_PARTIAL_CONTENT);
        }

        $responseData = new ResponseData(['body' => $order->toArray(), 'statusCode' => Response::HTTP_OK]);

        return $this->baseOkResponse($responseData);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function payOrderAction(Request $request): Response
    {
        $orderId = (int)$request->get('orderId');
        $payment = (float)$request->get('payment');

        if (!empty($orderId) || !empty($payment)) {
            return $this->baseErrResponse('Wrong order data', Response::HTTP_PARTIAL_CONTENT);
        }

        try {
            $order = $this->orderManager->payOrder($orderId, $payment);
        } catch (PaymentOrderException $exception) {
            return $this->baseErrResponse($exception->getMessage(), Response::HTTP_PARTIAL_CONTENT);
        }

        $responseData = new ResponseData(['body' => $order->toArray(), 'statusCode' => Response::HTTP_OK]);

        return $this->baseOkResponse($responseData);
    }
}