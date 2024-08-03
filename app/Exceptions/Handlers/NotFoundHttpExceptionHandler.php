<?php

namespace App\Exceptions\Handlers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class NotFoundHttpExceptionHandler extends ExceptionHandler
{
    // Return the error response for not found exception
    public function handle(Throwable $exception) {
        if($exception instanceof NotFoundHttpException) {
            return $this->errorResponse("The specified URL can't be found.", 404);
        }

        return parent::handle($exception);
    }
}
