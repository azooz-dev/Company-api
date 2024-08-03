<?php

namespace App\Exceptions\Handlers;

use Throwable;

interface ExceptionHandlerInterface {

    public function setNext(ExceptionHandlerInterface $handler): ExceptionHandlerInterface;

    public function handle(Throwable $exception);
}