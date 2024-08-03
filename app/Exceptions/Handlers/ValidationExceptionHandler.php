<?php

namespace App\Exceptions\Handlers;

use Illuminate\Validation\ValidationException;
use Throwable;

class ValidationExceptionHandler extends ExceptionHandler
{
    // Customize the validation exception response
    public function handle(Throwable $exception) {
        if($exception instanceof ValidationException) {
            return $this->errorResponse($exception->errors(), 422);
        }

        return Parent::handle($exception);
    }
}
