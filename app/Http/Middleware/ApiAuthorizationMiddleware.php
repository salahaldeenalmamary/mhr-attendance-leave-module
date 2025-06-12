<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ApiResponseResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;

use Throwable;

class ApiAuthorizationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
        
            return $next($request);

        } catch (Throwable $exception) {
           
            
            if ($exception instanceof AuthenticationException) {
                return ApiResponseResource::error(null, 'Unauthenticated.')->response()->setStatusCode(401);
            }
            if ($exception instanceof AuthorizationException) {
                return ApiResponseResource::error(null, 'Forbidden.')->response()->setStatusCode(403);
            }
            if ($exception instanceof ValidationException) {
                return ApiResponseResource::error($exception->errors(), 'Validation failed.')->response()->setStatusCode(422);
            }

            // Generic fallback
            $errorMessage = config('app.debug') ? 'Server Error: '.$exception->getMessage() : 'A server error has occurred.';
            return ApiResponseResource::error(null, $errorMessage)->response()->setStatusCode(500);
        }
    }
}

