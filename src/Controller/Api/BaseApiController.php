<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Api\ResponseData;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseApiController extends Controller
{
    /**
     * @param ResponseData $responseData
     * @param string $contentType
     *
     * @return Response
     */
    protected function baseOkResponse(ResponseData $responseData, $contentType = 'application/json'): Response
    {
        $response = new Response();
        $response->setContent(json_encode($responseData->getBody()));
        $response->setStatusCode($responseData->getStatusCode());
        $response->headers->set('Content-Type', $contentType);

        return $response;
    }

    /**
     * @param string $errMessage
     * @param int $responseCode
     *
     * @return Response
     */
    protected function baseErrResponse(string $errMessage, int $responseCode): Response
    {
        $response = new Response();
        $response->setContent($errMessage);
        $response->setStatusCode($responseCode);

        return $response;
    }
}