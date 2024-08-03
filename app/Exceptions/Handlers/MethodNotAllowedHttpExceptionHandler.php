<?php

namespace App\Exceptions\Handlers;

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class MethodNotAllowedHttpExceptionHandler extends ExceptionHandler
{
    // Return the error response for method not allowed exception
    public function handle(Throwable $exception) {
        if($exception instanceof MethodNotAllowedException) {
            return $this->errorResponse('The specified method for the request is invalid', 405);
        }

        return parent::handle($exception);
    }
}
