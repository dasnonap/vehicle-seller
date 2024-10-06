<?php

namespace App\Listeners;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $message = [
            'message' => $exception->getMessage(),
        ];

        $event->setResponse(new Response(json_encode($message), Response::HTTP_INTERNAL_SERVER_ERROR));
    }
}
