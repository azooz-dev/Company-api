<?php

namespace App\Exceptions\Handlers;

use Illuminate\Auth\Access\AuthorizationException;
use Throwable;

class AuthorizationExceptionHandler extends ExceptionHandler
{
    // Return the error response for authorization exception
    public function handle(Throwable $exception) {
        if($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessage(), 403);
        }

        return parent::handle($exception);
    }
}
