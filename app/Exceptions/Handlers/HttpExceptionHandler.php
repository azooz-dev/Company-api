<?php

namespace App\Exceptions\Handlers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class HttpExceptionHandler extends ExceptionHandler
{
    // Return the error response for http exception
    public function handle(Throwable $exception) {
        if($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        return parent::handle($exception);
    }
}
