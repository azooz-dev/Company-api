<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $transformer): Response
    {
        // dd($response->getData());


        $transformInputs = [];
            foreach ($request->all() as $input => $value) {
                $transformInputs[$transformer::originalAttribute($input)] = $value;
            }

            // dd($transformInputs);
            $request->replace($transformInputs);

        $response = $next($request);

        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            $transformErrors = [];
            $data = $response->getData();
            foreach ($data->error as $field => $error) {
                $transformedError = $transformer::transformAttribute($field);

                $transformErrors[$transformedError] = str_replace($field, $transformedError, $error);
            }
            $data->error = $transformErrors;
            $response->setData($data);
        }
        return $response;
    }
}