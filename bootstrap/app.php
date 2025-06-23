<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


use Illuminate\Http\Request;
use App\Http\Resources\ApiResponseResource; 
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
      
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->is('api/*') || $request->expectsJson();
        });

      
        $exceptions->renderable(function (ValidationException $e, Request $request) {
            return ApiResponseResource::error($e->errors(), 'The given data was invalid.')
                ->response()->setStatusCode(422);
        });

        // 401 Unauthenticated
        $exceptions->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return ApiResponseResource::error(null, message: 'Unauthenticated.')
                    ->response()->setStatusCode(401);
            }
        });

        // // 403 Forbidden
        // $exceptions->renderable(function (AuthorizationException $e, Request $request) {
        //     return ApiResponseResource::error(null, 'You are not authorized to perform this action.')
        //         ->response()->setStatusCode(403);
        // });
        
        // // 405 Method Not Allowed
        // $exceptions->renderable(function (MethodNotAllowedHttpException $e, Request $request) {
        //     $allowedMethods = $e->getHeaders()['Allow'];
        //     $message = "The {$request->method()} method is not supported. Supported methods: {$allowedMethods}.";
        //     return ApiResponseResource::error(null, $message)
        //         ->response()->setStatusCode(405)->withHeaders($e->getHeaders());
        // });

        // // 404 Not Found
        // $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
        //     return ApiResponseResource::error(null, 'The requested resource was not found.')
        //         ->response()->setStatusCode(404);
        // });
        
        // // Generic HttpException (for abort calls)
        // $exceptions->renderable(function (HttpException $e, Request $request) {
        //     return ApiResponseResource::error(null, $e->getMessage() ?: 'An HTTP error occurred.')
        //         ->response()->setStatusCode($e->getStatusCode());
        // });

        
      

    })->create();