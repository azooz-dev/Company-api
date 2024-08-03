<?php

namespace App\Exceptions\Handlers;

use App\Traits\ApiResponser;
use Throwable;

abstract class ExceptionHandler implements ExceptionHandlerInterface {

    use ApiResponser;

    private $nextHandler;

    public function setNext(ExceptionHandlerInterface $handler) : ExceptionHandlerInterface 
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(Throwable $exception) {
        if($this->nextHandler) {
            return $this->nextHandler->handle($exception);
        }

        return null;
    }
}