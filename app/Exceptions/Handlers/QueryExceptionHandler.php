<?php

namespace App\Exceptions\Handlers;

use Illuminate\Database\QueryException;
use Throwable;

class QueryExceptionHandler extends ExceptionHandler
{
    // Return the error response for query exception
    public function handle(Throwable $exception) {
        if($exception instanceof QueryException) {
            $errorCode = $exception->errorInfo[1];
            if($errorCode == 1451) {
                return $this->errorResponse("Can't remove this resource permanently. It is related with any other resource.", 409);
            }

            return parent::handle($exception);
        }
    }
}
