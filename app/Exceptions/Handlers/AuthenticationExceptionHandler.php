<?php

namespace App\Exceptions\Handlers;

use Illuminate\Auth\AuthenticationException;
use Throwable;

class AuthenticationExceptionHandler extends ExceptionHandler
{
    // Return the error response for authentication exception
    public function handle(Throwable $exception) {
        if($exception instanceof AuthenticationException) {
            return $this->errorResponse('Unauthenticated', 401);
        }

        return Parent::handle($exception);
    }
}
