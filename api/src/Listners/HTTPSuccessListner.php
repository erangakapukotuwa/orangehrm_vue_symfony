<?php

declare(strict_types=1);

namespace App\Listners;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class HTTPSuccessListner
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        
        $response2 = new JsonResponse([
            'data' => null,
            'message' => 'success',
            'status' => 200
        ], Response::HTTP_OK, [], false);
        $event->setResponse($response2);
    }
}