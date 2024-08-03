<?php

namespace App\Exceptions;

use App\Exceptions\Handlers\AuthenticationExceptionHandler;
use App\Exceptions\Handlers\AuthorizationExceptionHandler;
use App\Exceptions\Handlers\HttpExceptionHandler;
use App\Exceptions\Handlers\MethodNotAllowedHttpExceptionHandler;
use App\Exceptions\Handlers\ModelNotFoundExceptionHandler;
use App\Exceptions\Handlers\NotFoundHttpExceptionHandler;
use App\Exceptions\Handlers\QueryExceptionHandler;
use App\Exceptions\Handlers\ValidationExceptionHandler;
use App\Traits\ApiResponser;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;


class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $exception, $request) {
            $handlerChain = new ValidationExceptionHandler();
            $handlerChain
            ->setNext(new MethodNotAllowedHttpExceptionHandler())
            ->setNext(new AuthenticationExceptionHandler())
            ->setNext(new AuthorizationExceptionHandler())
            ->setNext(new ModelNotFoundExceptionHandler())
            ->setNext(new NotFoundHttpExceptionHandler())
            ->setNext(new QueryExceptionHandler())
            ->setNext(new HttpExceptionHandler());

            $response = $handlerChain->handle($exception);

            if($response) {
                return $response;
            }

            // Return the generic error response for other exceptions
            if (!config('app.debug')) {
                return $this->errorResponse('Something went wrong. Please try again later.', 500);
            }
            
            // Return the default response for the exception if app is in debug mode
            return parent::render($request, $exception);
        });
    }
}
