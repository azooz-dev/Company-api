<?php

namespace App\Exceptions\Handlers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class ModelNotFoundExceptionHandler extends ExceptionHandler
{
    // Return the error response for model not found exception
    public function handle(Throwable $exception) {
        if($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));

            return $this->errorResponse("Does not exists any {$modelName} with the specified identification", 404);
        }

        return Parent::handle($exception);
    }
}
