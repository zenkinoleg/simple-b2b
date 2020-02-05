<?php

namespace App\Domain\Generic\Event;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use App\Domain\Support\ApiResponse;

class ApiExceptionListener
{
    /**
     * No matter what wrong happened we will throw 'Not Found' anyway.
     *
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        //$exception = $event->getThrowable();
        $event->setResponse(
            ApiResponse::notFound()
        );
    }
}
